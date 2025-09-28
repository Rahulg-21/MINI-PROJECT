<?php
// ✅ Only allow logged-in guide
session_start();
if(!isset($_SESSION['admin_id'])){
    echo "<script>alert('Login!'); window.location='login.php';</script>";
    exit;
} ?>


<?php
include '../CONFIG/config.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$weather_reports = [];
$districts_with_bookings = [];

// ✅ Step 1: Get all distinct districts with bookings
$districtQuery = "
    SELECT DISTINCT d.id, d.name AS district_name
    FROM bookings b
    JOIN districts d ON b.district_id = d.id
";
$districts = $conn->query($districtQuery);

// ✅ Step 2: Always fetch weather reports for each district
$apiKey = "2f9acd1647dc42725f32b2808ae1fbb3";
while ($row = $districts->fetch_assoc()) {
    $district = $row['district_name'];

    // spelling fix for Kasargod
    if (strtolower($district) === "kasargod") {
        $district = "Kasaragod";
    }

    $url = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($district) . ",IN&appid={$apiKey}&units=metric";
    $response = @file_get_contents($url);

    if ($response !== false) {
        $weatherData = json_decode($response, true);
        if ($weatherData && isset($weatherData['weather'][0]['description'])) {
            $desc = ucfirst($weatherData['weather'][0]['description']);
            $temp = $weatherData['main']['temp'] ?? 'N/A';
            $weather_reports[$row['district_name']] = "🌤️ $desc, $temp" . ($temp !== 'N/A' ? "°C" : "");
        } else {
            $weather_reports[$row['district_name']] = "⚠️ Weather info not available";
        }
    } else {
        $weather_reports[$row['district_name']] = "⚠️ Failed to fetch weather data.";
    }

    $districts_with_bookings[] = $row;
}

// ✅ Step 3: If "Send Mail" button clicked for a district
if (isset($_POST['send_mail_district'])) {
    $district = $_POST['district_name'];

    // fetch all upcoming bookings for this district
    $stmt = $conn->prepare("
        SELECT b.*, u.username, u.email, ts.name AS spot_name
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN tourist_spots ts ON b.spot_id = ts.id
        JOIN districts d ON b.district_id = d.id
        WHERE d.name = ? AND CONCAT(b.visit_date,' ',b.visit_time) >= NOW()
    ");
    $stmt->bind_param("s", $district);
    $stmt->execute();
    $bookings = $stmt->get_result();

    if ($bookings->num_rows > 0) {
        $weather_report = $weather_reports[$district] ?? "⚠️ Weather not available";

        // setup PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'smartkeralatourism@gmail.com';
            $mail->Password = 'tycmhgsgutyrpvwx'; // app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom('smartkeralatourism@gmail.com', 'Kerala Tourism');

            // send to each user
            while ($row = $bookings->fetch_assoc()) {
                $mail->clearAddresses();
                $mail->addAddress($row['email'], $row['username']);
                $mail->isHTML(false);
                $mail->Subject = "Weather Update for Your Trip to {$row['spot_name']}, {$district}";
                $mail->Body = "Hello {$row['username']},\n\nHere is your weather update for your upcoming trip:\n
Spot: {$row['spot_name']}\nDistrict: $district\nDate: {$row['visit_date']}\nTime: {$row['visit_time']}\n
Weather: $weather_report\n\nKerala Tourism Team";

                $mail->send();
            }

            echo "<script>alert('✅ Emails sent to all users with upcoming bookings in $district');</script>";
        } catch (Exception $e) {
            echo "<script>alert('❌ Mail error: {$mail->ErrorInfo}');</script>";
        }
    } else {
        echo "<script>alert('⚠️ No upcoming bookings for $district');</script>";
    }
}
?>

<?php include 'components/head.php'; ?>
<body>
<?php include 'components/navbar.php'; ?>

<div class="content p-4">
    <h4 class="mb-4">📌 Manage Bookings - District Wise Weather & Email</h4>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>District</th>
                    <th>Weather</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($districts_with_bookings as $district): ?>
                <tr>
                    <td><?= htmlspecialchars($district['district_name']); ?></td>
                    <td><?= $weather_reports[$district['district_name']] ?? "⚠️ Not available"; ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="district_name" value="<?= $district['district_name']; ?>">
                            <button type="submit" name="send_mail_district" class="btn btn-success btn-sm">✉️ Send Mail</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
