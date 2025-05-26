<?php
session_start();
if (!isset($_SESSION['login_count'])) {
    $_SESSION['login_count'] = 1;
} else {
    $_SESSION['login_count']++;
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$username = $_SESSION['username'] ?? 'Unknown';
$email = $_SESSION['email'] ?? 'Unknown';
$role = $_SESSION['role'] ?? 'user'; // Default role
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <style>
    body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    direction: ltr;
    background-color: #f2f2f2;
    color: #f4f4f4;
    margin: 0;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}


        .container {
            max-width: 600px;
            display: center;
            margin: auto;
            background-color: #2b2b2b;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 255, 0, 0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #ffcc00;
            font-size: 25px;
        }

        .info {
            font-size: 20px;
            margin-bottom: 15px;
            color: #f0f0f0;
            margin-top: 10px;
            
        }

        .label {
            color: #ffcc00;
            font-weight: bold;
        }

        .role {
            font-weight: bold;
            color: #f0f0f0;
        }

        .message {
            margin-top: 20px;
            font-style: italic;
            color: #f0f0f0;
    

            
        }

        .btn {
            display: inline-block;
            margin-top: 150px;
            padding: 10px 25px;
            background-color: #ffcc00;
            color: #1a1a1a;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s;
            font-weight: bold;
            margin-left: 1opx;
            margin-right: 10px;
            
        }

        .btn:hover {
            background-color: #e6b800;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>User Profile</h2>

    <div class="info"><span class="label">Username: </span> <?= htmlspecialchars($username) ?></div>
    <div class="info"><span class="label">Email: </span> <?= htmlspecialchars($email) ?></div>
    <div class="info"><span class="label">Role: </span> <span class="role"><?= $role === 'admin' ? 'Admin' : 'User' ?></span></div>

    <div class="message">
        <?= $role === 'admin'
            ? 'Welcome to the restaurant control panel. You have full access to manage content and settings.' 
            : 'Welcome to your account. You can view your orders and update your profile.' ?>
    </div>

<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <a href="dashboard.php" class="btn">Back to Dashboard</a>
<?php endif; ?>

<a class="btn" href="index.php">Back to Home</a>
</div>

</body>
</html>
