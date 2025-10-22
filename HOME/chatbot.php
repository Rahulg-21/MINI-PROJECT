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
$stmt = $conn->prepare("SELECT first_name FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<body>
<br><br><br><br>

<section id="chatbot_main_area" class="section_padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="chat-container shadow-lg rounded-3">
                    <div class="chat-header bg-success text-white p-3 rounded-top-3 d-flex align-items-center">
                        <i class="fab fa-whatsapp me-2 fs-4"></i>
                        <h4 class="m-0">Kerala Tourism Assistant</h4>
                    </div>

                    <div id="chat-box" class="chat-box p-3 bg-light" style="height: 500px; overflow-y: auto;">
                        <div class="bot-message mb-3">
                            <div class="message bg-white p-2 rounded shadow-sm d-inline-block">
                                👋 Hello <?= htmlspecialchars($user['first_name']) ?>! I'm your Kerala Tourism Chat Assistant.  
                                Ask me about destinations, travel plans, or anything about Kerala.
                            </div>
                        </div>
                    </div>

                    <form id="chat-form" class="chat-input-area p-3 border-top bg-white">
                        <div class="input-group">
                            <input type="text" id="user-input" class="form-control" placeholder="Type a message..." required>
                            <button class="btn btn-success" type="submit"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.chat-container {
    border-radius: 15px;
    background: #e5ddd5;
}
.user-message {
    text-align: right;
}
.user-message .message {
    background-color: #dcf8c6;
}
.bot-message .message {
    background-color: #fff;
}
.message {
    max-width: 75%;
    padding: 10px 15px;
    border-radius: 15px;
    display: inline-block;
    word-wrap: break-word;
}
</style>

<script>
document.getElementById('chat-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const input = document.getElementById('user-input');
    const chatBox = document.getElementById('chat-box');
    const userMsg = input.value.trim();
    if (!userMsg) return;

    // Append user message
    chatBox.innerHTML += `
        <div class="user-message mb-3">
            <div class="message">${userMsg}</div>
        </div>
    `;
    chatBox.scrollTop = chatBox.scrollHeight;
    input.value = '';

    // Append loading message
    const loadingMsg = document.createElement('div');
    loadingMsg.classList.add('bot-message', 'mb-3');
    loadingMsg.innerHTML = `<div class="message">⏳ Typing...</div>`;
    chatBox.appendChild(loadingMsg);
    chatBox.scrollTop = chatBox.scrollHeight;

    try {
        const response = await fetch('chatbot_api.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ message: userMsg })
        });
        const data = await response.json();

        loadingMsg.remove();

        chatBox.innerHTML += `
            <div class="bot-message mb-3">
                <div class="message">${data.reply}</div>
            </div>
        `;
        chatBox.scrollTop = chatBox.scrollHeight;
    } catch (err) {
        loadingMsg.innerHTML = `<div class="message text-danger">⚠️ Error: Unable to get response.</div>`;
    }
});
</script>

<?php include 'components/footer.php'; ?>
