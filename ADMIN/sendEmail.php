<?php
include '../CONFIG/config.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';


// Fetch all bookings with user & spot details
$query = "
    SELECT b.*, u.username, u.email, ts.name AS spot_name, d.name AS district_name
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN tourist_spots ts ON b.spot_id = ts.id
    JOIN districts d ON b.district_id = d.id
    ORDER BY b.created_at DESC
";
$bookings = $conn->query($query);

if (isset($_POST['fetch_weather'])) {
    $district = isset($_POST['district_name']) ? urlencode($_POST['district_name']) : '';
    $date = $_POST['visit_date'] ?? '';
    $time = $_POST['visit_time'] ?? '';

    if (!empty($district)) {
        $apiKey = "2f9acd1647dc42725f32b2808ae1fbb3";
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$district},IN&appid={$apiKey}&units=metric";

        $response = @file_get_contents($url);
        if ($response !== false) {
            $weatherData = json_decode($response, true);
            if ($weatherData && isset($weatherData['weather'][0]['description'])) {
    $desc = ucfirst($weatherData['weather'][0]['description']);
    $temp = $weatherData['main']['temp'] ?? 'N/A';  // ✅ Safe fallback
    $weather_report = "🌤️ $desc, $temp" . ($temp !== 'N/A' ? "°C" : "") . " in $district (for $date at $time)";
} else {
    $weather_report = "⚠️ Weather info not available for $district";
}

        } else {
            $weather_report = "⚠️ Failed to fetch weather data.";
        }
    } else {
        $weather_report = "⚠️ No district selected.";
    }

    echo "<script>alert('Weather Report: $weather_report');</script>";
}



// Handle email send
if (isset($_POST['send_email'])) {
    $user_email = $_POST['email'];
    $spot = $_POST['spot_name'];
    $district = $_POST['district_name'] ?? '';  // ✅ get district for email
    $date = $_POST['visit_date'];
    $time = $_POST['visit_time'];

    // Fetch current weather for district
    $weather_report = '';
    if (!empty($district)) {
        $apiKey = "2f9acd1647dc42725f32b2808ae1fbb3";
        $url = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($district) . ",IN&appid={$apiKey}&units=metric";
        $response = @file_get_contents($url);
        if ($response !== false) {
            $weatherData = json_decode($response, true);
            if ($weatherData && isset($weatherData['weather'][0]['description'])) {
                $desc = ucfirst($weatherData['weather'][0]['description']);
                $temp = $weatherData['main']['temp'] ?? 'N/A';
                $weather_report = "🌤️ $desc, $temp" . ($temp !== 'N/A' ? "°C" : "") . " in $district";
            } else {
                $weather_report = "⚠️ Weather info not available for $district";
            }
        } else {
            $weather_report = "⚠️ Failed to fetch weather data.";
        }
    } else {
        $weather_report = "⚠️ No district selected.";
    }

    // Build email body with actual weather
    $subject = " Weather Update for Your Trip to $spot";
    $message = "Hello,\n\nHere is your weather update for your upcoming trip:\n
Spot: $spot\nDistrict: $district\nDate: $date\nTime: $time\n
Weather: $weather_report\n\nKerala Tourism Team";

    // PHPMailer setup remains same...


    // Setup PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // 🔹 Gmail SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'smartkeralatourism@gmail.com'; // 🔹 Replace
        $mail->Password = 'tycmhgsgutyrpvwx';   // 🔹 Use Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('yourgmail@gmail.com', 'Kerala Tourism');
        $mail->addAddress($user_email);

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        echo "<script>alert('✅ Email sent to $user_email successfully!');</script>";
    } catch (Exception $e) {
        echo "<script>alert('❌ Email could not be sent. Error: {$mail->ErrorInfo}');</script>";
    }
}
?>

<?php include 'components/head.php'; ?>
<body>
<?php include 'components/navbar.php'; ?>

<div class="content">
    <div class="pt-4"></div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="px-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage Bookings</li>
        </ol>
    </nav>

    <div class="container-fluid px-3">
        <div class="card shadow-sm p-4 mb-4">
            <h5 class="mb-4">User Bookings</h5>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Spot</th>
                            <th>District</th>
                            <th>Date</th>
                            <th>Time</th>
                            
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $bookings->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= htmlspecialchars($row['username']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= htmlspecialchars($row['spot_name']); ?></td>
                            <td><?= htmlspecialchars($row['district_name']); ?></td>
                            <td><?= htmlspecialchars($row['visit_date']); ?></td>
                            <td><?= htmlspecialchars($row['visit_time']); ?></td>
                            
                            <td>
                               <!-- Weather Button -->
<form method="post" style="display:inline;">
    <input type="hidden" name="district_name" value="<?= $row['district_name']; ?>"> <!-- ✅ Add this -->
    <input type="hidden" name="spot_name" value="<?= $row['spot_name']; ?>">
    <input type="hidden" name="visit_date" value="<?= $row['visit_date']; ?>">
    <input type="hidden" name="visit_time" value="<?= $row['visit_time']; ?>">
    <button type="submit" name="fetch_weather" class="btn btn-info btn-sm">🌦️ Weather</button>
</form>


                                <form method="post" style="display:inline;">
    <input type="hidden" name="email" value="<?= $row['email']; ?>">
    <input type="hidden" name="spot_name" value="<?= $row['spot_name']; ?>">
    <input type="hidden" name="district_name" value="<?= $row['district_name']; ?>"> <!-- ✅ Add this -->
    <input type="hidden" name="visit_date" value="<?= $row['visit_date']; ?>">
    <input type="hidden" name="visit_time" value="<?= $row['visit_time']; ?>">
    <button type="submit" name="send_email" class="btn btn-success btn-sm">✉️ Send Email</button>
</form>

                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
