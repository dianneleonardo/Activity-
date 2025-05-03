<?php
session_start();
$conn = new mysqli("localhost", "root", "", "dianne");

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM user WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $_SESSION['register_message'] = "<div class='message error'>Email already exists. Please use a different one.</div>";
        header("Location: register.php");
        exit();
    }
    $check->close();

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO user (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        $_SESSION['register_message'] = "<div class='message success'>Registered successfully! Please log in.</div>";
        header("Location: register.php");
        exit();
    } else {
        $_SESSION['register_message'] = "<div class='message error'>Registration failed. Please try again.</div>";
        header("Location: register.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
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
    <h2>Register</h2>
    <?php
    if (isset($_SESSION['register_message'])) {
        echo $_SESSION['register_message'];
        unset($_SESSION['register_message']);
    }
    ?>
    <form method="POST">
      <input type="email" name="email" placeholder="Enter your email" required>
      <input type="password" name="password" placeholder="Enter your password" required>
      <button type="submit" name="register">Register</button>
    </form>
    <p class="link-text">Already have an account? <a href="login.php">Login here</a></p>
  </div>
</div>
</body>
</html>
