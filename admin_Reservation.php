<?php
include 'config.php';


if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM reservations WHERE id = $id");
    header("Location: admin_reservation.php");
    exit;
}


$result = $conn->query("SELECT * FROM reservations ORDER BY id ASC");

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة تحكم الحجوزات</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            direction: rtl;
            background-color: #f2f2f2;
            color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 50px auto;
            background-color: #2b2b2b;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 255, 0, 0.2);
        }

        h2 {
            text-align: center;
            color: #ffcc00;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #555;
        }

        th {
            background-color: #444;
            color: #ffcc00;
        }

        tr:hover {
            background-color: #3a3a3a;
        }

        .btn {
            padding: 6px 15px;
            background-color: #ffcc00;
            color: #1a1a1a;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s;
            margin: 0 5px;
        }

        .btn:hover {
            background-color: #e6b800;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #b02a37;
        }

        .back {
            text-align: center;
            margin-top: 30px;
        }

        .back a {
            padding: 6px 15px;
            background-color: #ffcc00;
            color: #1a1a1a;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .back a:hover {
            background-color: #e6b800;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Manage Reservations</h2>

    <table>
        <tr> 
            <th></th>
            <th>User ID</th>
            <th>Created At</th>
            <th>Reservation Time</th>
            <th>Guest</th>
            <th>Table Number</th>
            <th>ID</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Are sure you want todelete this reservation؟')">DELETE</a>
                    </td>
                     <td><?= htmlspecialchars($row['user_id']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                     <td><?= htmlspecialchars($row['reservation_time']) ?></td>
                     <td><?= htmlspecialchars($row['guest_count']) ?></td>
                     <td><?= htmlspecialchars($row['table_number']) ?></td>
                    <td><?= $row['id'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="color: #ccc;">لا توجد حجوزات حالياً</td>
            </tr>
        <?php endif; ?>
    </table>

    <div class="back">
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</div>

</body>
</html>
