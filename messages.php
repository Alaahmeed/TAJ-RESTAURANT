<?php

include 'config.php';

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM messages WHERE id = $id");
    header("Location: messages.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messages Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            direction: ltr;
            background-color: #f2f2f2;
            color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #f0c040;
            margin-bottom: 30px;
        }


        table {
       width: 100%;
       max-width: 1000px;
       margin: auto;
       border-collapse: collapse;
       background-color: #1e1e1e;
       box-shadow: 0 0 10px rgba(0,0,0,0.5);
}


        td {
    padding: 12px;
    text-align: right;
    border-bottom: 1px solid #333;
    word-wrap: break-word;
    max-width: 250px;
        }

        th {
            background-color: #222;
            color: #f0c040;
        }

        tr:hover {
            background-color: #2a2a2a;
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
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .btn:hover {
            background-color: #e6b800;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<h2> Messages Dashboard</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Message</th>
        <th>Sent At</th>
        <th>Actions</th>
    </tr>

    <?php
    $result = $conn->query("SELECT * FROM messages ORDER BY sent_at DESC");
    if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
    ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
            <td><?= $row['sent_at'] ?></td>
            <td>
                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this message?');">
                    <button class="btn-delete">Delete</button>
                </a>
            </td>
        </tr>
    <?php
        endwhile;
    else:
    ?>
        <tr>
            <td colspan="6" style="text-align: center; color: #ccc;">No messages found.</td>
        </tr>
    <?php endif; ?>
</table>
<div class="back">
        <a href="dashboard.php" class="btn">Back to Dashboard</a>
    </div>

</body>
</html>
