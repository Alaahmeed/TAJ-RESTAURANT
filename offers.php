<?php
session_start();

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
        <h2>Our Offers</h2>
        <p>Speical Dishes</p>
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


        <!-- نافذة تأكيد الطلب -->
        <div class="modal1" id="orderModal">
            <div class="modal1-content">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <h2>Order Details</h2>
                <p>Please confirm your order:</p>
                <p id="order-item"></p>
                <button class="btn-primary" onclick="confirmOrder()">Confirm</button>
            </div>
        </div>

        <!-- نافذة "تم الطلب وشكرًا" -->
        <div class="modal2" id="thankYouModal">
            <div class="modal2-content">
                <span class="close-btn" onclick="closeThankYouModal()">&times;</span>
                <h2>Your order has been placed!</h2>
                <p>Thank you for your purchase.</p>
                <button class="btn-primary" onclick="closeThankYouModal()">OK</button>
            </div>
        </div>

        <!-- رابط العودة -->
        <a href="index.php" class="back-link">Back to Home</a>
    </section>

     <style>
    /* offers start */
#offers {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5)), 
                url("ee.jpg") center center / cover no-repeat fixed;
    flex-direction: column;
    padding: 20px;
    text-align: center;
    width: 100%;
}

#messageBox {
    position: fixed;
    top: 10px;
    right: 20px;
    background-color:rgb(11, 12, 11);
    color: #000;
    padding: 6px 12px;
    font-size: 13px;
    border-radius: 5px;
    display: none; /* مخفي مبدئيًا */
    z-index: 9999;
}

#offers h2 {
    font-size: 48px;
    color: #ffcc00; 
    margin-bottom: 20px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8); 
}

#offers p {
    color:rgb(255, 253, 253); 
    margin-bottom: 30px;
    font-size: 25px; /* حجم نص أكبر */
}

#offers .offers-items {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    justify-content: center;
    align-items: stretch; 
}

.offer-box {
    flex: 0 1 calc(33.33% - 20px); /* 3 عناصر في الصف */
    box-sizing: border-box;
    background-color: rgba(0, 0, 0, 0.6); /* خلفية لصندوق العرض */
    border-radius: 15px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* توزيع المحتوى داخليًا */
    align-items: center;
    min-height: 380px; /* اجعل كل صندوق بطول ثابت */
    text-align: center;
}


#offers .offers-items img {
    width: 100px; /* زيادة حجم الصورة */
    max-width: 200px;
    height: auto;
    border-radius: 15px; /* زوايا دائرية أكبر */
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* تأثيرات عند التمرير */
}

#offers .offers-items img:hover {
    transform: scale(1.1); /* تكبير الصورة */
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5); /* ظل عند التمرير */
}

#offers .offers-items h3 {
    font-size: 28px; /* حجم عنوان أكبر */
    margin: 10px 0;
    color: #ffcc00; /* لون ذهبي */
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.6); /* ظل للنص */
}

#offers .offers-items p {
    font-size: 16px; /* حجم نص أكبر */
    padding: 0 10px;
    font-weight: 300;
    margin-bottom: 15px;
    color: rgba(255, 255, 255, 0.9); /* لون نص مريح */
}

#offers .offers-items span {
    font-size: 22px; /* زيادة حجم السعر */
    color: #ff5733; /* لون مميز للسعر */
    font-weight: bold;
    margin-left: 5px;
}
.order-btn {
    display: inline-block;
    background-color: #e4b95b; /* لون الخلفية */
    color: #fff; /* لون النص */
    font-size: 16px; /* حجم النص */
    font-weight: bold; /* جعل النص عريضًا */
    padding: 10px 20px; /* الحواف الداخلية */
    border: none; /* إزالة الحدود */
    border-radius: 25px; /* جعل الزر دائريًا */
    cursor: pointer; /* تغيير المؤشر عند التحويم */
    transition: all 0.3s ease; /* تأثيرات التحويم */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* ظل خفيف */
}

.order-btn:hover {
    background-color: #383848; /* لون الخلفية عند التحويم */
    color: #e4b95b; /* لون النص عند التحويم */
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2); /* تعزيز الظل عند التحويم */
    transform: translateY(-5px); /* حركة خفيفة للأعلى */
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
        url: '',  // نفس الصفحة أو رابط المعالجة
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
            messageBox.style.display = 'block'; // عرض الرسالة
            messageBox.style.color = '#fff';    // لون أبيض
        },
        error: function() {
            alert('حدث خطأ أثناء إرسال الطلب.');
        }
    });
}

function closeThankYouModal() {
    thankYouModal.style.display = 'none';
    messageBox.style.display = 'none'; // إخفاء الرسالة بعد ضغط OK
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
