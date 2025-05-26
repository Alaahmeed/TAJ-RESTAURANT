<?php

include 'config.php';
include 'auth.php';


$inactive = 1800;
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $inactive) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


$alertMessage = "";
if (isset($_SESSION['alertMessage'])) {
    $alertMessage = $_SESSION['alertMessage'];
    unset($_SESSION['alertMessage']);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        echo "طلب غير صالح (رمز CSRF غير مطابق).";
        exit();
    }



    $tableNumber = intval($_POST['table-number']);
    $guestCount = intval($_POST['guest-count']);
    $reservationTime = $_POST['reservation-time'];

    
    $date = DateTime::createFromFormat('Y-m-d\TH:i', $reservationTime);
    if (!$date) {
        echo "صيغة وقت الحجز غير صحيحة";
        exit();
    }
    $reservationTimeFormatted = $date->format('Y-m-d H:i:00');


    $sql_check = "SELECT COUNT(*) as count FROM reservations WHERE table_number = ? AND reservation_time = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("is", $tableNumber, $reservationTimeFormatted);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    if ($row_check['count'] > 0) {
        echo "عذراً، هذه الطاولة محجوزة في هذا الوقت. يرجى اختيار وقت مختلف.";
        $stmt_check->close();
        $conn->close();
        exit();
    }
    $stmt_check->close();

    $userId = $_SESSION['user_id'];
    $stmt = $conn->prepare("INSERT INTO reservations (user_id, table_number, guest_count, reservation_time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $userId, $tableNumber, $guestCount, $reservationTimeFormatted);

    if ($stmt->execute()) {
        echo "تم حجز الطاولة بنجاح!";
    } else {
        echo "فشل الحجز: " . $stmt->error;
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
    <title>TAJ RESTAURANT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php if (!empty($alertMessage)): ?>
        <script>alert("<?= $alertMessage ?>");</script>
    <?php endif; ?>

    <header>
        <div id="navbar">
            <a href="profile.php">
            <img src="chef.jpg" alt="Profile" class="profile-img">
            </a>

            <nav>
            <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="offers.php">Offers</a></li>
    <li><a href="menu.php">Menu</a></li>
    <li><a href="gallery.php">Gallery</a></li>
    <li><a href="contact.php">contact</a></li>
    <li><a href="avaiable.php">avaiable</a></li>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <li><a href="dashboard.php">Dashboard</a></li>
    <?php endif; ?>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <li><a href="register.php">register</a></li>
        <li><a href="login.php">login</a></li>
    <?php else: ?>
        <li><a href="logout.php">logout</a></li>
    <?php endif; ?>
</ul>
            </nav>
        </div>
        <div class="content">
            <h1>Welcome to <span class="primary-text">TAJ</span> RESTAURANT</h1>
            <p>Here you can find the MOST delicious food in the world</p>
            <button id="openModalBtn">BOOK A TABLE</button>
        </div>
    </header>

    <!-- نموذج الحجز (Modal) -->
    <div id="reservationModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close-btn" id="closeModalBtn">&times;</span>
            <h2>Reserve Your Table</h2>
            
           <form id="reservationForm" class="reservation-form">

                <div class="form-group">
                    <label for="table-number">Choose Table Number:</label>
                    <input list="tableNumbers" id="table-number" name="table-number" required>
                    <datalist id="tableNumbers">
                        <option value="1">
                        <option value="2">
                        <option value="3">
                        <option value="4">
                        <option value="5">
                        <option value="6">
                        <option value="7">
                    </datalist>
                </div>
                <div class="form-group">
                    <label for="guest-count">Number of guests:</label>
                    <input list="guests" id="guest-count" name="guest-count" required>
                    <datalist id="guests">
                        <option value="1"><option value="2"><option value="3">
                        <option value="4"><option value="5"><option value="6">
                        <option value="7"><option value="8">
                    </datalist>
                </div>
                <div class="form-group">
                    <label for="reservation-time">Reservation Time:</label>
                    <input type="datetime-local" id="reservation-time" name="reservation-time" required>
                </div>
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <button type="submit" class="btn btn-primary">Submit Reservation</button>
            </form>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const openModalBtn = document.getElementById('openModalBtn');
    const reservationModal = document.getElementById('reservationModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const reservationForm = document.getElementById('reservationForm');

    // فتح المودال
    if (openModalBtn && reservationModal && closeModalBtn) {
        openModalBtn.addEventListener('click', () => {
            reservationModal.style.display = 'block';
            openModalBtn.setAttribute('aria-expanded', 'true');
            reservationModal.setAttribute('aria-hidden', 'false');
        });

        closeModalBtn.addEventListener('click', () => {
            reservationModal.style.display = 'none';
            openModalBtn.setAttribute('aria-expanded', 'false');
            reservationModal.setAttribute('aria-hidden', 'true');
        });

        window.addEventListener('click', (event) => {
            if (event.target === reservationModal) {
                reservationModal.style.display = 'none';
                openModalBtn.setAttribute('aria-expanded', 'false');
                reservationModal.setAttribute('aria-hidden', 'true');
            }
        });
    }

    
    $('#reservationForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: '',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response);
                if (response.includes('تم حجز')) {
                    $('#reservationModal').hide();
                    $('#reservationForm')[0].reset();
                }
            },
            error: function(xhr, status, error) {
                alert('حدث خطأ أثناء الحجز، حاول مرة أخرى.');
            }
        });
    });
});
</script>

</body>
</html>
