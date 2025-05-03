<?php
session_start();
$conn = new mysqli("localhost", "root", "", "dianne");

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $now = date("Y-m-d H:i:s");

    // Fetch the user from the database based on the email
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    // === If Email Exists ===
    if ($res->num_rows === 1) {
        $user = $res->fetch_assoc();
        $user_id = $user['id'];

        // Check if user is blocked
        if (isset($_SESSION['block_user_id']) && $_SESSION['block_user_id'] == $user_id) {
            if (time() < $_SESSION['block_time']) {
                $_SESSION['message'] = "5 wrong attempts. Try again in " . ceil(($_SESSION['block_time'] - time()) / 60) . " minute(s).";
                header("Location: login.php");
                exit;
            } else {
                // Unblock after timeout
                unset($_SESSION['block_user_id'], $_SESSION['block_time']);
            }
        }

        // Count recent failed attempts (within last 5 minutes)
        $cutoff = date("Y-m-d H:i:s", strtotime("-5 minutes"));
        $stmt = $conn->prepare("SELECT COUNT(*) as fail_count FROM login_attempt WHERE user_id = ? AND attempt = 'failed' AND timestamp >= ?");
        $stmt->bind_param("is", $user_id, $cutoff);
        $stmt->execute();
        $fail = $stmt->get_result()->fetch_assoc()['fail_count'];

        if ($fail >= 5) {
            // Block user
            $_SESSION['block_user_id'] = $user_id;
            $_SESSION['block_time'] = time() + 300; // 5 minutes
            $_SESSION['message'] = "5 wrong attempts. Try again in 5 minutes.";
            header("Location: login.php");
            exit;
        }

        // === Check Password ===
        if (password_verify($password, $user['password'])) {
            // Log success attempt
            $stmt = $conn->prepare("INSERT INTO login_attempt (user_id, attempt, timestamp) VALUES (?, 'success', ?)");
            $stmt->bind_param("is", $user_id, $now);
            $stmt->execute();

            $_SESSION['user_id'] = $user_id;
            $_SESSION['message'] = "Login successful!";
            header("Location: dashboard.php");
            exit;
        } else {
            // Log failed attempt
            $stmt = $conn->prepare("INSERT INTO login_attempt (user_id, attempt, timestamp) VALUES (?, 'failed', ?)");
            $stmt->bind_param("is", $user_id, $now);
            $stmt->execute();

            // Count again after this new failed attempt
            $stmt = $conn->prepare("SELECT COUNT(*) as fail_count FROM login_attempt WHERE user_id = ? AND attempt = 'failed' AND timestamp >= ?");
            $stmt->bind_param("is", $user_id, $cutoff);
            $stmt->execute();
            $fail_now = $stmt->get_result()->fetch_assoc()['fail_count'];

            if ($fail_now >= 5) {
                $_SESSION['block_user_id'] = $user_id;
                $_SESSION['block_time'] = time() + 300;
                $_SESSION['message'] = "5 wrong attempts. Try again in 5 minutes.";
            } else {
                $_SESSION['message'] = "Incorrect password.";
            }

            header("Location: login.php");
            exit;
        }

    } else {
        // === If Email NOT Found ===
        $_SESSION['message'] = "Email not found.";
        header("Location: login.php");
        exit;
    }
}
?>
