<?php

include 'config.php';



$sql = "SELECT * FROM available_times ORDER BY id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Times – TAJ RESTAURANT</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section id="time">
        <div class="container">
            <div class="time-items">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="time-item">';
                        echo '<img src="'.htmlspecialchars($row['image']).'" alt="'.htmlspecialchars($row['meal']).'">';
                        echo '<h3>'.htmlspecialchars($row['meal']).'</h3>';
                        echo '<p>'.$row['start_time'].' to '.$row['end_time'].'</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>لا توجد بيانات مواعيد متاحة حالياً.</p>';
                }
                ?>
            </div>
            <a href="index.php" class="btn btn-secondary"> Home </a>
        </div>
        <style>
            
#time {
    height: 100vh;
    background: linear-gradient(to bottom right, #111, #333);
    color: #fff;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
}

#time .time-items {
    display: flex;
    justify-content:space-evenly;
    align-items: center;
    width: 90%;
    height: 50vh;
    gap: 40px;
}

#time .time-items .time-item {
    background-color: rgba(34, 34, 34, 0.8);
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    width: 30%;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
    transition: all 0.3s ease;
}

#time .time-items .time-item:hover {
    background-color: #e4b95b;
    transform: translateY(-10px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.5);
}

#time .time-items img {
    width: 130px;
    height: 120px;
    border-radius: 50%;
    margin-bottom: 15px;
    transition: transform 0.3s ease;
}

#time .time-items img:hover {
    transform: scale(1.1);
}
#time .time-items h3 {
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    position: relative;
    transform: translateX(-2px);
    margin: 0;
}


#time .time-items p {
    font-weight: 400;
    font-size: 18px;
    color: #ddd;
}

        </style>
    </section>
</body>
</html>
