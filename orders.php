<?php
session_start();
if (!isset($_SESSION['login_count'])) {
    $_SESSION['login_count'] = 1;
} else {
    $_SESSION['login_count']++;
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
}


$result = $conn->query("SELECT * FROM orders ORDER BY order_time DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Orders</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            direction: ltr;
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
            background-color: #3a3a3a;
            color: #fff;
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

        .btn {
            padding: 6px 15px;
            background-color: #ffcc00;
            color: #1a1a1a;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s;
            margin: 5px 5px;
        }

        .btn:hover {
            background-color: #e6b800;
        }

        .actions {
            display: flex;
            justify-content: center;
        }

        button {
            padding: 5px 10px;
            margin-top: 15px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin: 5px 5px;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }

        form.inline {
            display: inline;
        }

        .back {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Manage Orders</h2>

    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Order Name</th>
                <th>Order Price</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['user_id']) ?></td>
                        <td><?= htmlspecialchars($row['item_name']) ?></td>
                        <td><?= htmlspecialchars($row['item_price']) ?></td>
                        <td><?= htmlspecialchars($row['order_time']) ?></td>
                        <td class="actions">
                            <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">No orders found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="back">
        <a href="dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>
