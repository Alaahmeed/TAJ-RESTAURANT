<?php
session_start();
include 'config.php';


if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
} elseif (isset($_COOKIE['logged_in'])) {
    
    $userId = intval($_COOKIE['logged_in']);
    $stmt = $conn->prepare("SELECT id, username, role FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($id, $username, $role);
    if ($stmt->fetch()) {
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        $stmt->close();
        header("Location: index.php");
        exit();
    }
    $stmt->close();
    
    setcookie('logged_in', '', time() - 3600, "/");
}

// AJAX TO LOGIN
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';

    if (empty($email) || empty($pass)) {
        echo "Please fill all fields.";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email is not valid.";
        exit();
    }

    $stmt = $conn->prepare("SELECT id, password, username, role FROM users WHERE email = ?");
    if (!$stmt) {
        echo "Database connection error.";
        exit();
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hashed_password, $username, $role);
        $stmt->fetch();

        if (password_verify($pass, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            $_SESSION['login_time'] = time();

            
            setcookie('logged_in', $id, time() + (86400 * 30), "/");

            echo "success";
            exit();
        } else {
            echo "Incorrect password.";
            exit();
        }
    } else {
        echo "Email not found. Please check.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login - TAJ RESTAURANT</title>
    <style>
        body {
            background: linear-gradient(to right, rgb(42, 42, 42), rgb(44, 44, 44));
            font-family: 'Cairo', sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
            direction: rtl;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: rgba(255, 255, 255, 0.05);
            padding: 40px 30px;
            border-radius: 15px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 25px rgba(0,0,0,0.4);
            backdrop-filter: blur(6px);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 28px;
            color: #FFD700;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #f8f8f8;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            margin-bottom: 20px;
            background-color: #f3f3f3;
            color: #333;
            font-size: 16px;
        }
        input:focus {
            outline: none;
            border: 2px solid #FFD700;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #FFD700;
            border: none;
            border-radius: 8px;
            color: #000;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #e5c100;
        }
        .error-message {
            background-color: rgb(12, 12, 12);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
            color: #ff9999;
            display: none;
        }
        p {
            text-align: center;
            margin-top: 20px;
        }
        a {
            color: #FFD700;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <form id="loginForm" method="POST" action="">
        <h2>Login</h2>
        <div id="errorMessage" class="error-message"></div>

        <label for="email">Email</label>
        <input type="text" id="email" name="email" required autocomplete="username">

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required autocomplete="current-password">

        <button type="submit">Login</button>

        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('#loginForm').submit(function(e){
        e.preventDefault();
        $('#errorMessage').hide().text('');

        $.ajax({
            url: '',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response){
                if(response.trim() === 'success'){
                    window.location.href = 'index.php';
                } else {
                    $('#errorMessage').show().text(response);
                }
            },
            error: function(){
                $('#errorMessage').show().text('An error occurred while connecting to the server.');
            }
        });
    });
});
</script>
</body>
</html>
