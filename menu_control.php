<?php
include 'config.php';

// Save or update item
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $id = $_POST['id'] ?? null;

    if (!empty($_FILES['image']['name'])) {
        $imagePath = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    } else {
        $imagePath = $_POST['old_image'] ?? '';
    }

    if ($id) {
        $stmt = $conn->prepare("UPDATE menu_items SET name=?, description=?, price=?, image=? WHERE id=?");
        $stmt->bind_param("ssdsi", $name, $desc, $price, $imagePath, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO menu_items (name, description, price, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $name, $desc, $price, $imagePath);
    }

    $stmt->execute();
    $stmt->close();
    header("Location: menu_control.php");
    exit();
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM menu_items WHERE id = $id");
    header("Location: menu_control.php");
    exit();
}

// Edit item
$edit_item = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM menu_items WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $edit_item = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Fetch all items
$result = $conn->query("SELECT * FROM menu_items ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu Management</title>
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

        .form-box, .table-box {
            background-color: #2b2b2b;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            flex: 1;}
     

         h2 {
            text-align: center;
            color: #ffcc00;
            margin-bottom: 30px;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            padding: 10px 20px;
            border: none;
            background-color: #28a745;
            color: white;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
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

        img {
            width: 50px;
            height: 50px;
            border-radius: 8px;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-size: 0.9rem;
        }

        .edit {
            background-color: #ffc107;
        }

        .delete {
            background-color: #dc3545;
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
            margin-top: 15px;
            margin-bottom: 15px;
        
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Right: Form -->
    <div class="form-box">
        <h2><?= $edit_item ? "Update Menu Item" : "Add New Menu Item" ?></h2>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $edit_item['id'] ?? '' ?>">
            <input type="hidden" name="old_image" value="<?= $edit_item['image'] ?? '' ?>">

            <label>Name:</label>
            <input type="text" name="name" required value="<?= htmlspecialchars($edit_item['name'] ?? '') ?>">

            <label>Description:</label>
            <textarea name="description" required><?= htmlspecialchars($edit_item['description'] ?? '') ?></textarea>

            <label>Price ($):</label>
            <input type="number" name="price" step="0.01" required value="<?= $edit_item['price'] ?? '' ?>">

            <label>Image:</label>
            <?php if ($edit_item): ?>
                <img src="<?= $edit_item['image'] ?>" alt="Current Image"><br>
            <?php endif; ?>
            <input type="file" name="image">

            <button type="submit" name="save"><?= $edit_item ? "Update" : "Add Item" ?></button>
        </form>
    </div>

    <!-- Left: Table -->
    <div class="table-box">
        <h2>Menu Items List</h2>
        <table>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?= $row['image'] ?>"></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= $row['price'] ?></td>
                    <td>
                        <a href="?edit=<?= $row['id'] ?>" class="btn edit">Edit</a>
                        <a href="?delete=<?= $row['id'] ?>" class="btn delete" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<div class="back">
    <a href="dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
