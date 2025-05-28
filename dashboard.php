<?php
session_start();
include 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}


if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['username'] ?? 'المستخدم';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #111;
            color: #ffc107;
            padding: 20px 0;
            text-align: center;
        }

        .top-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }

        .btn {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s;
            margin-bottom: 30px;
            margin-top: 30px;
        }

        .btn:hover {
            background-color: #ffc107;
            color: #000;
        }

        .welcome {
            text-align: center;
            font-size: 20px;
            color: #333;
            margin-bottom: 30px;
            margin-top: 30px;
        }

        .stats {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 30px;
            padding: 0 20px;
        }

        .stat-box {
            background-color: #fff;
            padding: 20px;
            flex: 1 1 250px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-box h3 {
            font-size: 22px;
            color: #333;
            margin-bottom: 10px;
        }

        .stat-box p {
            font-size: 18px;
            color: #666;
        }

        table {
            width: 90%;
            margin: 0 auto 40px auto;
            background-color: #fff;
            border-collapse: collapse;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        caption {
            caption-side: top;
            font-size: 22px;
            font-weight: bold;
            margin: 15px 0;
            color: #111;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #222;
            color: #fff;
        }

        tr:hover td {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<header>
    <h1>TAJ RESTAURANT - Admin Dashboard</h1>
</header>

<div class="welcome">
    Welcome, <?= htmlspecialchars($username) ?>!
</div>

<div class="top-buttons">
    <a class="btn" href="users.php">Manage Users</a>
    <a class="btn" href="orders.php">Manage orders</a>
     <a class="btn" href="admin_reservation.php">Manage Reservations</a>
    <a class="btn" href="messages.php">Manage Messages</a>
      <a class="btn" href="menu_control.php">Manage Menu</a>
    <a href="profile.php" class="btn">Profile</a>
    <a href="index.php" class="btn">Home</a>

</div>


<div class="stats">
    <div class="stat-box">
        <h3>Total Users</h3>
        <p id="total_users">...</p>
    </div>
    <div class="stat-box">
        <h3>Total Orders</h3>
        <p id="total_orders">...</p>
    </div>
    <div class="stat-box">
        <h3>Total Reservations</h3>
        <p id="total_reservations">...</p>
    </div>

</div>



<script>
function loadStats() {
    fetch("fetch_stats.php")
        .then(res => res.json())
        .then(data => {
            document.getElementById("total_users").textContent = data.total_users;
            document.getElementById("total_orders").textContent = data.total_orders;
            document.getElementById("total_reservations").textContent = data.total_reservations;
        })
        .catch(err => {
            console.error("Failed to load stats:", err);
        });
}


loadStats();
</script>

</body>
</html>
