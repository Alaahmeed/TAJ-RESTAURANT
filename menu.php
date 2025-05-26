<?php

include 'config.php';


$sql = "SELECT * FROM menu_items";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menu – TAJ RESTAURANT</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<section id="menu">
    <div class="container">
        <div class="title">
            <h2> MENU </h2>
            <p> ORDER TWO AND GET THIRD FOR FREE </p>
        </div>
        <div class="menu-items">
            <?php
            if ($result->num_rows > 0) {
                // نقسم العناصر للنصفين (يسار ويمين) حسب عدد العناصر
                $items = [];
                while ($row = $result->fetch_assoc()) {
                    $items[] = $row;
                }
                $half = ceil(count($items) / 2);

                echo '<div class="menu-items-left">';
                for ($i = 0; $i < $half; $i++) {
                    echo '<div class="menu-item">';
                    echo '<img src="' . $items[$i]['image'] . '" alt="' . htmlspecialchars($items[$i]['name']) . '">';
                    echo '<div>';
                    echo '<h3>' . htmlspecialchars($items[$i]['name']) . '<span class="primary-text">$' . $items[$i]['price'] . '</span></h3>';
                    echo '<p>' . htmlspecialchars($items[$i]['description']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';

                echo '<div class="menu-items-right">';
                for ($i = $half; $i < count($items); $i++) {
                    echo '<div class="menu-item">';
                    echo '<img src="' . $items[$i]['image'] . '" alt="' . htmlspecialchars($items[$i]['name']) . '">';
                    echo '<div>';
                    echo '<h3>' . htmlspecialchars($items[$i]['name']) . '<span class="primary-text">$' . $items[$i]['price'] . '</span></h3>';
                    echo '<p>' . htmlspecialchars($items[$i]['description']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo "<p>لا توجد أصناف حالياً.</p>";
            }
            ?>
        </div>
        <a href="index.php" class="btn btn-secondary"> Home </a>
    </div>
    <style>
        #menu{
	height:100vh;
	background: #f4f4f4;
	padding: 5rem 0;
}

#menu .menu-items{
	display: flex;
	justify-content: center;
	align-items: center;

}

#menu .menu-items .menu-item{
	display: flex;
	justify-content: center;
	align-items: center;
	margin: 40px;
}
 
#menu .menu-items .menu-item img{
	width: 80px;
	height: 80px;
    border-radius: 50%;
    background-size: contain;
    margin-right: 20px;
 }
 
#menu .menu-items .menu-item h3{
	color:#383848;
	border-bottom: 1px dashed #c2bdbd;
	padding-bottom: 10px;
	position: relative;
}
#menu .menu-items .menu-item span{
	position: absolute;
	top: 0px;
	right: 0px;
	color: red;
}
#menu .menu-items .menu-item p{
	margin-top: 10px;
}
    </style>
</section>
</body>
</html>
