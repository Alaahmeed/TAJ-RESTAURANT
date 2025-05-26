<?php

include 'config.php';


$sql = "SELECT * FROM about_info LIMIT 1";
$result = $conn->query($sql);
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About – TAJ RESTAURANT</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<section id="about">
<div class="container">
    <div class="title">
        <h2><?= $data['title'] ?></h2>
        <p><?= $data['subtitle'] ?></p>
    </div>
    <div class="about-content">
        <div>
            <p><?= $data['paragraph1'] ?></p>
            <p><?= $data['paragraph2'] ?></p>
            <a href="index.php" class="btn btn-secondary"> Home </a>
        </div>
        <img src="<?= $data['image'] ?>" alt="about image">
    </div>
</div>

<style>
    #about{
	height: 100vh;
	display: flex;
	justify-content: center;
	align-items: center;
    background: #f4f4f4;
}

#about .title,
#offers .title,
#menu .title{
	text-align: center;
	margin-bottom: 2rem;
}

#about h2,
#offers h2,
#menu h2,
#gallery h2 {
    font-size: 40px;
    margin-bottom: 20px;
    text-align: center;
}
#about h2,
#menu h2,
#offers h2{
	color: #383848;
}


#about .title p,
#menu .title p,
#offers .title p{
	font-size: 14px;
	color: #9a9a9a;
	font-weight: 500;
}

#about .about-content{
	display: flex;
	justify-content: space-between;
}

#about .about-content img{
width: 450px;
height: 350px;
}

#about .about-content p{
	color: #9a9a9a;
	margin-left:7rem;
	font-weight: 500;
	line-height: 1.6;
}
</style>
</section>
</body>
</html>
