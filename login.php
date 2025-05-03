<?php
session_start();
$conn = new mysqli("localhost", "root", "", "dianne");

$show_form = true;
$custom_message = '';

// Check if the user is blocked
if (isset($_SESSION['block_user_id'], $_SESSION['block_time'])) {
    $user_id = $_SESSION['block_user_id'];
    if (time() < $_SESSION['block_time']) {
        // Calculate the remaining block time
        $remaining = $_SESSION['block_time'] - time();
        $custom_message = "5 wrong attempts. Try again in " . ceil($remaining / 60) . " minute(s).";
        $show_form = false;
    } else {
        unset($_SESSION['block_user_id'], $_SESSION['block_time']);
    }
}

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
body {
  font-family: 'Segoe UI', sans-serif;
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: linear-gradient(to bottom right, #2BC0E4, #EAECC6); /* Ocean Blue Theme */
  color: #333;
}

.container {
  width: 100%;
  max-width: 450px;
  padding: 20px;
}

.form-box {
  background: #ffffff;
  padding: 40px;
  border-radius: 12px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
  text-align: center;
}

h2 {
  color: #0077b6;
  margin-bottom: 30px;
  font-size: 28px;
}

input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 14px;
  margin: 12px 0;
  border: 1px solid #ccc;
  border-radius: 6px;
  box-sizing: border-box;
  background-color: #f1f9fc;
  font-size: 16px;
}

button {
  width: 100%;
  padding: 16px;
  background-color: #00b4d8;
  border: none;
  color: white;
  font-size: 18px;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s;
}

button:hover {
  background-color: #0096c7;
}

.message {
  padding: 14px;
  margin-bottom: 25px;
  border-radius: 6px;
  font-size: 16px;
  text-align: center;
}

.success {
  background-color: #d1f7ec;
  color: #056c59;
  border: 1px solid #a0e9d0;
}

.error {
  background-color: #ffe6e6;
  color: #a33a3a;
  border: 1px solid #f5bcbc;
}

.link-text {
  margin-top: 20px;
  font-size: 16px;
}

a {
  text-decoration: none;
  color: #0077b6;
}

a:hover {
  text-decoration: underline;
}

  </style>
</head>
<body>
<div class="container">
  <div class="form-box">
    <h2>Login</h2>

    <?php if ($message): ?>
        <div class="message error"><?php echo $message; ?></div>
    <?php endif; ?>

    <?php if ($custom_message): ?>
        <div class="message error"><?php echo $custom_message; ?></div>
    <?php endif; ?>

    <?php if ($show_form): ?>
        <form action="process_login.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
    <?php endif; ?>

    <p class="link-text">Don't have an account? <a href="register.php">Register here</a></p>
  </div>
</div>
</body>
</html>
