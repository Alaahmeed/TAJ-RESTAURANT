<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'config.php';

// حذف عنصر
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $stmt = $conn->prepare("DELETE FROM menu_items WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
}

// تعديل عنصر
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $id = intval($_POST['edit_id']);
    $name = $_POST['item_name'];
    $price = $_POST['item_price'];
    $desc = $_POST['description'];
    $image_path = $_POST['old_image'];

    // رفع صورة جديدة إن وُجدت
    if (!empty($_FILES['new_image']['name'])) {
        $image_name = basename($_FILES['new_image']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $image_name;
        if (move_uploaded_file($_FILES['new_image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        }
    }

    $stmt = $conn->prepare("UPDATE menu_items SET name=?, price=?, description=?, image=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $price, $desc, $image_path, $id);
    $stmt->execute();
    $stmt->close();
}

// جلب كل العناصر
$result = $conn->query("SELECT * FROM menu_items ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدارة عناصر المنيو</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #1e1e1e;
            color: #fff;
            margin: 0;
            padding: 0;
            direction: rtl;
        }
        .container {
            max-width: 1100px;
            margin: 50px auto;
            background-color: #2b2b2b;
            padding: 30px;
            border-radius: 10px;
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
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #555;
            text-align: center;
        }
        th {
            background-color: #444;
            color: #ffcc00;
        }
        img {
            width: 70px;
            border-radius: 8px;
        }
        .btn, button {
            padding: 6px 12px;
            margin: 4px;
            font-weight: bold;
            border-radius: 6px;
            border: none;
            cursor: pointer;
        }
        .edit-btn {
            background-color: #ffcc00;
            color: black;
        }
        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }
        form.inline {
            display: inline;
        }
        .edit-form {
            background-color: #444;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 10px;
        }
        input, textarea {
            padding: 7px;
            margin-bottom: 10px;
            width: 100%;
            border-radius: 6px;
            border: none;
        }
        input[type="file"] {
            background-color: #fff;
            color: #000;
        }
        .back {
            text-align: center;
            margin-top: 20px;
        }
        .back a {
            background-color: #ffcc00;
            color: black;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>إدارة عناصر المنيو</h2>

    <?php if (isset($_GET['edit'])):
        $edit_id = intval($_GET['edit']);
        $edit_result = $conn->query("SELECT * FROM menu_items WHERE id = $edit_id");
        $item = $edit_result->fetch_assoc();
    ?>
        <form class="edit-form" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="edit_id" value="<?= $item['id'] ?>">
            <input type="hidden" name="old_image" value="<?= $item['image'] ?>">
            <label>الاسم:</label>
            <input type="text" name="item_name" value="<?= htmlspecialchars($item['name']) ?>" required>
            <label>السعر:</label>
            <input type="text" name="item_price" value="<?= htmlspecialchars($item['price']) ?>" required>
            <label>الوصف:</label>
            <textarea name="description" required><?= htmlspecialchars($item['description']) ?></textarea>
            <label>تغيير الصورة:</label>
            <input type="file" name="new_image">
            <button type="submit" class="edit-btn">حفظ التغييرات</button>
        </form>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>الاسم</th>
                <th>السعر</th>
                <th>الوصف</th>
                <th>الصورة</th>
                <th>التحكم</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['price']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><img src="<?= htmlspecialchars($row['image']) ?>" alt="menu"></td>
                    <td>
                        <a href="?edit=<?= $row['id'] ?>"><button class="edit-btn">تعديل</button></a>
                        <form method="POST" class="inline" onsubmit="return confirm('هل تريد حذف هذا العنصر؟');">
                            <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                            <button type="submit" class="delete-btn">حذف</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">لا توجد عناصر في المنيو حالياً.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="back">
        <a href="dashboard.php">العودة للوحة التحكم</a>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>
