<?php
session_start();
include 'components/head.php';
include 'components/navbar.php';
include '../CONFIG/config.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Login First');
            window.location='index.php';
          </script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$stmt = $conn->prepare("SELECT first_name, last_name, email, mobile FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);

    if (!empty($message)) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (user_id, first_name, last_name, email, mobile, message) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $user_id, $user['first_name'], $user['last_name'], $user['email'], $user['mobile'], $message);
        
        if ($stmt->execute()) {
            $success_message = "Your message has been sent successfully!";
        } else {
            $error_message = "Failed to send your message. Please try again.";
        }
        $stmt->close();
    } else {
        $error_message = "Please enter a message.";
    }
}
?>

<body>
<br><br><br><br>

<section id="contact_main_area" class="section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section_heading_center">
                    <h2>Contact Kerala Tourism</h2>
                    <p class="text-muted">We’d love to assist you with your travel plans in Kerala</p>
                </div>
            </div>
        </div>

        <div class="contact_main_form_area_two mt-4">
            <div class="row">
                <!-- Contact Form -->
                <div class="col-lg-8">
                    <div class="contact_left_top_heading mb-3">
                        <h3>Leave us a message</h3>
                        <p>Our team will get back to you as soon as possible</p>
                    </div>

                    <?php if (!empty($success_message)): ?>
                        <div class="alert alert-success"><?= $success_message ?></div>
                    <?php endif; ?>
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger"><?= $error_message ?></div>
                    <?php endif; ?>

                    <div class="contact_form_two">
                        <form method="post" id="contact_form_content">
                            <!-- Hidden fields -->
                            <input type="hidden" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>">
                            <input type="hidden" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>">
                            <input type="hidden" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                            <input type="hidden" name="mobile" value="<?= htmlspecialchars($user['mobile']) ?>">

                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <textarea name="message" class="form-control bg_input" rows="5" placeholder="Your message*" required></textarea>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn_theme btn_md">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Contact Details -->
                <div class="col-lg-4">
                    <div class="contact_two_left_wrapper">
                        <h3>Contact Details</h3>
                        <div class="contact_details_wrapper mt-3">
                            <div class="contact_detais_item mb-3">
                                <h4>Tourism Helpline</h4>
                                <h3><a href="tel:+914712320113">+91 471 2320 113</a></h3>
                                <small class="text-muted">24x7 Kerala Tourism Info Service</small>
                            </div>
                            <div class="contact_detais_item mb-3">
                                <h4>Email Support</h4>
                                <h3><a href="mailto:info@keralatourism.org">info@keralatourism.org</a></h3>
                            </div>
                            <div class="contact_detais_item mb-3">
                                <h4>Office Hours</h4>
                                <h3>Mon – Sat : 9:00 AM – 6:00 PM</h3>
                            </div>
                            <div class="contact_detais_item">
                                <h4>Head Office</h4>
                                <h3>Department of Tourism,<br>
                                Park View, Thiruvananthapuram,<br>
                                Kerala – 695033</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>
