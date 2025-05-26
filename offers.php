<?php
session_start();
if (!isset($_SESSION['login_count'])) {
    $_SESSION['login_count'] = 1;
} else {
    $_SESSION['login_count']++;
}
$message = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item'])) {

    include 'config.php';

    $item = $conn->real_escape_string(trim($_POST['item']));
    $description = $conn->real_escape_string(trim($_POST['description'] ?? ''));
    $price = floatval($_POST['price'] ?? 0);

    $user_id = $_SESSION['user_id'] ?? null;

        if (!$user_id) {
            $message = "يجب تسجيل الدخول لإضافة طلب";
        } elseif (empty($item)) {
            $message = "اسم الصنف مطلوب";
        } else {
            $stmt = $conn->prepare("INSERT INTO orders (item_name, item_description, item_price, user_id) VALUES (?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("ssdi", $item, $description, $price, $user_id);

                if ($stmt->execute()) {
                    $message = "تم استلام طلبك: $item";
                } else {
                    $message = "حدث خطأ أثناء معالجة الطلب: " . $stmt->error;
                }

                $stmt->close();
            } else {
                $message = "فشل تحضير الاستعلام: " . $conn->error;
            }
        }

        $conn->close();
    }

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        echo $message;
        exit;
    }
?>


<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>عروض TAJ RESTAURANT</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<section id="offers">
    <div class="container">
        <h2>عروضنا الخاصة</h2>
        <p>أشهى الأطباق</p>
        <div class="offers-items">
            <?php
            $conn = new mysqli("localhost", "root", "", "taj_restaurant");
            $result = $conn->query("SELECT * FROM menu_items");
            while ($row = $result->fetch_assoc()):
            ?>
                <div class="offer-box">
                    <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                    <h3><?= htmlspecialchars($row['name']) ?></h3>
                    <p><?= htmlspecialchars($row['description']) ?></p>
                    <p><span class="primary-text">$<?= number_format($row['price'], 2) ?></span></p>
                   <button class="order-btn"
                    data-item="<?= htmlspecialchars($row['name']) ?>"
                    data-description="<?= htmlspecialchars($row['description']) ?>"
                    data-price="<?= $row['price'] ?>">
                     اطلب الآن
                    </button>

                </div>
            <?php endwhile; $conn->close(); ?>
        </div>
    </div>

    <div id="messageBox" style="margin:10px 0; font-weight:bold;"></div>


        
        <div class="modal1" id="orderModal">
            <div class="modal1-content">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <h2>Order Details</h2>
                <p>Please confirm your order:</p>
                <p id="order-item"></p>
                <button class="btn-primary" onclick="confirmOrder()">Confirm</button>
            </div>
        </div>

    
        <div class="modal2" id="thankYouModal">
            <div class="modal2-content">
                <span class="close-btn" onclick="closeThankYouModal()">&times;</span>
                <h2>Your order has been placed!</h2>
                <p>Thank you for your purchase.</p>
                <button class="btn-primary" onclick="closeThankYouModal()">OK</button>
            </div>
        </div>

        
        <a href="index.php" class="back-link">Back to Home</a>
    </section>

<style>

#offers {
    
    display: flex;
    justify-content: center;
    align-items: flex-start;
    background: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5)), url("ee.jpg") center center/cover fixed;
    flex-direction: column;
    padding: 20px;
    text-align: center;
    min-height: 100vh;
    box-sizing: border-box;
    overflow: visible;

#messageBox {
    position: fixed;
    top: 10px;
    right: 20px;
    background-color: rgba(0, 0, 0, 0.7);
    color: #fff;
    padding: 6px 12px;
    font-size: 13px;
    border-radius: 5px;
    display: none;
    z-index: 9999;
}

#offers h2 {
    font-size: 48px;
    color: #ffcc00;
    margin-bottom: 20px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
}

#offers p {
    color: rgb(255, 253, 253);
    margin-bottom: 30px;
    font-size: 25px;
}

html, body {
    margin: 0;
    padding: 0;
    
    height: auto;
    overflow-y: auto;
    font-family: Arial, sans-serif;
}
#offers .offers-items {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    justify-content: center;
    align-items: stretch;
    padding-right: 10px;
    box-sizing: border-box;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

.offer-box {
    flex: 0 1 calc(33.33% - 20px);
    box-sizing: border-box;
    background-color: rgba(0, 0, 0, 0.6);
    border-radius: 15px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    min-height: 380px;
    text-align: center;
    color: #fff;
    transition: background-color 0.3s ease;
}

.offer-box:hover {
    background-color: rgba(0, 0, 0, 0.8);
}

#offers .offers-items img {
    width: 100px;
    max-width: 200px;
    height: auto;
    border-radius: 15px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

#offers .offers-items img:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
}

#offers .offers-items h3 {
    font-size: 28px;
    margin: 10px 0;
    color: #ffcc00;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.6);
}

#offers .offers-items p {
    font-size: 16px;
    padding: 0 10px;
    font-weight: 300;
    margin-bottom: 15px;
    color: rgba(255, 255, 255, 0.9);
}

#offers .offers-items span {
    font-size: 22px;
    color: #ff5733;
    font-weight: bold;
    margin-left: 5px;
}

.order-btn {
    display: inline-block;
    background-color: #e4b95b;
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    padding: 10px 20px;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.order-btn:hover {
    background-color: #383848;
    color: #e4b95b;
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
    transform: translateY(-5px);
}

</style>

<script>
    const orderModal = document.getElementById('orderModal');
    const thankYouModal = document.getElementById('thankYouModal');
    const orderItemElem = document.getElementById('order-item');
    const messageBox = document.getElementById('messageBox');
    let currentItem = '';
    let currentDescription = '';
    let currentPrice = '';

    document.querySelectorAll('.order-btn').forEach(button => {
        button.addEventListener('click', () => {
            currentItem = button.getAttribute('data-item');
            currentDescription = button.getAttribute('data-description');
            currentPrice = button.getAttribute('data-price');
            orderItemElem.textContent = `${currentItem} - $${currentPrice}`;
            orderModal.style.display = 'flex';
        });
    });

    function closeModal() {
        orderModal.style.display = 'none';
    }

function confirmOrder() {
    $.ajax({
        url: '',
        type: 'POST',
        data: {
            item: currentItem,
            description: currentDescription,
            price: currentPrice
        },
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(data) {
            closeModal();
            thankYouModal.style.display = 'flex';
            messageBox.textContent = data;
            messageBox.style.display = 'block';
            messageBox.style.color = '#fff';
        },
        error: function() {
            alert('حدث خطأ أثناء إرسال الطلب.');
        }
    });
}

function closeThankYouModal() {
    thankYouModal.style.display = 'none';
    messageBox.style.display = 'none';
}

    document.querySelectorAll('.close-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            closeModal();
            closeThankYouModal();
        });
    });

    window.addEventListener('click', (event) => {
        if (event.target === orderModal) closeModal();
        if (event.target === thankYouModal) closeThankYouModal();
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>
