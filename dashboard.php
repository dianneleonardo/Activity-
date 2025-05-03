<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: linear-gradient(to bottom right, #2BC0E4, #EAECC6); /* Match Login Page */
      color: #333;
    }

    .container {
      width: 100%;
      max-width: 500px;
      padding: 20px;
    }

    .card {
      background: #ffffff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      text-align: center;
    }

    h1 {
      color: #0077b6;
      margin-bottom: 20px;
      font-size: 28px;
    }

    p {
      font-size: 18px;
      color: #555;
      margin-bottom: 20px;
    }

    .btn {
      width: 100%;
      padding: 16px;
      background-color: #00b4d8;
      border: none;
      color: white;
      font-size: 18px;
      border-radius: 6px;
      text-decoration: none;
      display: inline-block;
      transition: background-color 0.3s;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #0096c7;
    }
  </style>
  <script>
    function confirmLogout() {
      return confirm("Are you sure you want to log out?");
    }
  </script>
</head>
<body>
  <div class="container">
    <div class="card">
      <h1>Welcome, User!</h1>
      <p>You are now logged in to your dashboard.</p>
      <a href="logout.php" class="btn" onclick="return confirmLogout()">Logout</a>
    </div>
  </div>
</body>
</html>
