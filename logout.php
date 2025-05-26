<?php
session_start();

$duration = 0;
if (isset($_SESSION['login_time'])) {
    $duration = time() - $_SESSION['login_time'];
}


if (isset($_COOKIE['remember_email'])) {
    setcookie('remember_email', '', time() - 3600, "/");
}
if (isset($_COOKIE['logged_in'])) {
    setcookie('logged_in', '', time() - 3600, "/");
}


session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <title>تسجيل خروج - TAJ RESTAURANT</title>
    <meta http-equiv="refresh" content="5;url=login.php" />
    <style>
        
        body {
            background: linear-gradient(135deg,rgb(58, 57, 59),rgb(61, 61, 61));
            font-family: 'Cairo', sans-serif;
            color: #fff;
            margin: 0; padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            direction: rtl;
        }
        .container {
            background: rgba(100, 96, 96, 0.1);
            padding: 40px 50px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(42, 41, 41, 0.3);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }
        h2 {
            color: #FFD700;
            margin-bottom: 25px;
            font-size: 30px;
        }
        p {
            font-size: 18px;
            margin: 15px 0;
            line-height: 1.5;
        }
        .duration {
            font-weight: bold;
            color:rgb(16, 17, 17);
            font-size: 22px;
        }
        .redirect {
            margin-top: 20px;
            font-size: 16px;
            color: #ccc;
        }
        p, h2 {
            text-shadow: 0 0 5px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>You have successfully logged out</h2>
        <p>Your session duration was:</p>
        <p class="duration"><?= gmdate("H:i:s", $duration) ?></p>
        <p class="redirect">You will be redirected to the login page in 5 seconds...</p>
    </div>
</body>

</html>
