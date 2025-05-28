<?php

session_start();
include 'config.php';

// معالجة الإرسال فقط عند طلب POST عبر Ajax
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

    include 'config.php';

    // استلام البيانات مع تعقيمها
    $name = isset($_POST['name']) ? trim(htmlspecialchars($_POST['name'])) : '';
    $email = isset($_POST['email']) ? trim(htmlspecialchars($_POST['email'])) : '';
    $message = isset($_POST['message']) ? trim(htmlspecialchars($_POST['message'])) : '';

    // التحقق من صحة البيانات
    if (empty($name) || empty($email) || empty($message)) {
        echo 'جميع الحقول مطلوبة.';
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'يرجى إدخال بريد إلكتروني صالح.';
        exit();
    }

    // حفظ الرسالة في قاعدة البيانات
    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    if (!$stmt) {
        echo 'حدث خطأ في قاعدة البيانات.';
        exit();
    }
    $stmt->bind_param("sss", $name, $email, $message);
    if ($stmt->execute()) {
        echo 'تم إرسال الرسالة بنجاح!';
    } else {
        echo 'فشل إرسال الرسالة. حاول مرة أخرى.';
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact – TAJ RESTAURANT</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* إضافة بعض التنسيقات للرسالة العائمة (Toast) */
        #toastMessage {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: rgba(223, 212, 212, 0.7);
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            font-size: 14px;
            z-index: 9999;
            box-shadow: 0 2px 8px rgba(222, 221, 221, 0.3);
            max-width: 300px;
        }
    </style>
</head>
<body>

<div id="toastMessage"></div>

<section id="contact">
    <div class="container">
        <div class="contact-content">
            <div class="contact-info">
                <div>
                    <h3>ADDRESS</h3>
                    <p><img src="uploads/location.png" alt="location"> JAMAL STREET – TAIZ – YEMEN</p>
                    <p><img src="uploads/call.png" alt="phone"> 00967777777</p>
                    <p><img src="uploads/email.png" alt="email"> tajrestaurant@gmail.com</p>
                </div>
                <div>
                    <h3>WORKING HOURS</h3>
                    <p>8:00 AM to 12:00 AM on Weekdays</p>
                    <p>10:00 AM to 1:00 AM on Weekends</p>
                </div>
                <div>
                    <h3>FOLLOW US ON SOCIAL MEDIA</h3>
                    <a href="#"><img src="uploads/face.png" alt="facebook"></a>
                    <a href="#"><img src="uploads/what.png" alt="whatsapp"></a>
                    <a href="#"><img src="uploads/twi.png" alt="twitter"></a>
                    <a href="#"><img src="uploads/ins.png" alt="instagram"></a>
                </div>
            </div>

            <form id="contactForm" method="POST">
                <input type="text" name="name" placeholder="Full Name" required autocomplete="name">
                <input type="email" name="email" placeholder="Email Address" required autocomplete="email">
                <textarea name="message" placeholder="Message" rows="5" required autocomplete="off"></textarea>
                <button type="submit" class="btn">Send Message</button>
            </form>
            <div id="contactMessage"></div>
        </div>

        <a href="index.php" class="btn btn-secondary"> Home </a>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function showToast(message, duration = 5000) {
    var $toast = $('#toastMessage');
    $toast.stop(true, true); // إيقاف أي تأثيرات سابقة
    $toast.html(message).fadeIn('fast');

    setTimeout(function() {
        $toast.fadeOut('slow');
    }, duration);
}

$('#contactForm').on('submit', function(e) {
    e.preventDefault(); // منع إعادة تحميل الصفحة

    showToast('جاري إرسال الرسالة...', 3000);

    $.ajax({
        url: '', // نفس الصفحة
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            showToast(response, 5000);
            if(response.includes('تم إرسال الرسالة')) {
                $('#contactForm')[0].reset();
            }
        },
        error: function() {
            showToast('<span style="color:#ff6b6b;">حدث خطأ أثناء إرسال الرسالة.</span>', 5000);
        }
    });
});
</script>
 <style>
    /* Contact Section Start */
#contact {
    height: 100vh;
    background: linear-gradient(to right, #f3f4f6, #eaeff3); /* ألوان خلفية لطيفة */
    padding: 5rem 0;
    font-family: Arial, sans-serif;
}

    


#contact .container {
    max-width: 1000px;
    margin: auto;
    text-align: center; /* توسيط المحتوى */
}

#contact .contact-content {
    display: flex;
    flex-wrap: wrap; /* للتجاوب */
    justify-content: space-between;
    align-items: flex-start;
    gap: 30px; /* مسافات بين العناصر */
}

#contact .contact-content .contact-info {
    width: 45%;
    text-align: left;
}

#contact .contact-content .contact-info div {
    margin: 20px 0;
    line-height: 1.8;
    border-left: 4px solid #e4b95b; /* شريط جانبي جذاب */
    padding-left: 15px; /* مسافة بعد الشريط */
}

#contact .contact-content .contact-info h3 {
    font-size: 24px;
    color: #777780;
    margin-bottom: 10px;
    font-weight: bold;
}

#contact .contact-content .contact-info p {
    color: #444; /* لون نص مريح للعين */
    font-size: 1rem;
    margin: 5px 0;
}

#contact .contact-info img {
    width: 20px;
    height: 20px;
    margin-right: 10px;
    vertical-align: middle;
    transition: transform 0.3s ease;
}

#contact .contact-info img:hover {
    transform: scale(1.2); /* تكبير بسيط عند التمرير */
}

#contact .contact-info a img {
    width: 35px;
    height: 35px;
    margin: 5px;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(237, 235, 235, 0.1); /* تأثير الظل */
    transition: all 0.3s ease;
}

#contact .contact-info a img:hover {
    background: #f6f6ea;
    transform: scale(1.2); /* تكبير عند التفاعل */
    filter: brightness(1.5); /* زيادة الإضاءة */
}

/* Form Styling */
#contact form {
    width: 45%;
    display: flex;
    flex-direction: column;
    gap: 20px; /* مسافات بين العناصر */
}
#contactMessage {
    background-color: #ccdcd0; /* لون أخضر */
    color: #fff; /* لون النص أبيض */
    padding: 10px 15px;
    border-radius: 5px;
    position: absolute;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    max-width: 400px;
    text-align: center;
    display: none; /* مخفية في البداية */
    z-index: 9999;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    font-weight: bold;
}

#contact form input,
#contact form textarea {
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    border: 1px solid #f2eaea;
    border-radius: 5px;
    box-shadow: inset 0 1px 3px rgba(128, 128, 128, 0.752);
    
}

#contact form button {
    color: #fff;
    border: none;
    padding: 12px;
    font-size: 1rem;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

#contact form button:hover {
    background-color: #e8dfdf;
    transform: scale(1.05);
}
 </style>
</body>
</html>
