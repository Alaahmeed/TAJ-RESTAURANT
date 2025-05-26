<?php
include 'config.php';


$sql = "SELECT image_path, alt_text FROM gallery_images";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gallery – TAJ RESTAURANT</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section id="gallery">
        <div class="container">
            <h2> OUR FOOD GALLERY </h2>
            <div class="img-gallery">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<img src="' . $row['image_path'] . '" alt="' . $row['alt_text'] . '">';
                    }
                } else {
                    echo "<p>لا توجد صور حالياً.</p>";
                }
                ?>
            </div>
            <a href="index.php" class="btn btn-secondary"> Home </a>
        </div>
        <style>
            #gallery {
    background: #fff;
    padding: 8rem 0 6rem;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

#gallery h2 {
    color: #383848;
    text-align: center;
    font-size: 32px;
    font-weight: 600;
    margin-bottom: 60px;
}

#gallery .img-gallery {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 50px;
}

#gallery .img-gallery img {
    width: 300px;
    height: 160px;
    border-radius: 15px;
    opacity: 0.85;
    transition: transform 0.3s ease, opacity 0.3s ease; 
}

#gallery .img-gallery img:hover {
    opacity: 1;
    transform: scale(1.1);
}
</style>
    </section>
</body>
</html>
