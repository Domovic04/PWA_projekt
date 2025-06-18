<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'pwa_projekt';

$conn = new mysqli($host, $user, $pass, $dbname,3307);

if ($conn->connect_error) {
    die("Greška pri spajanju na bazu: " . $conn->connect_error);
}

$_POST['naslov'];
$_POST['podnaslov'];
$_FILES['slika'];
$_POST['sadrzaj'];
$_POST['kategorija'];

if (
    isset($_POST['naslov']) &&
    isset($_POST['podnaslov']) &&
    isset($_POST['sadrzaj']) &&
    isset($_POST['kategorija']) &&
    isset($_FILES['slika']) &&
    $_FILES['slika']['error'] === UPLOAD_ERR_OK 
) {
    $title = $_POST['naslov'];
    $second_title = $_POST['podnaslov']; 
    $image = $_FILES['slika']['name']; 
    $content = $_POST['sadrzaj'];
    $category = $_POST['kategorija'];

    $image_name = basename($_FILES['slika']['name']);
    $upload_dir = '../img/';
    $upload_path = $upload_dir . $image_name;

    if (move_uploaded_file($_FILES['slika']['tmp_name'], $upload_path)) {
        $image = $image_name;
    }else {
        echo "Greška prilikom prijenosa slike.";
        exit;
    }
    $datum_objave = date('Y-m-d H:i:s'); 
    $prikaz = 1;
    $sql = "INSERT INTO vijesti (naslov, podnaslov, slika, sadrzaj, kategorija, prikaz, datum) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssis", $title, $second_title, $image, $content, $category, $prikaz, $datum);

    if ($stmt->execute()) {
        echo "Članak je uspješno spremljen.";
    } else {
        echo "Greška prilikom unosa u bazu: " . $conn->error;
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<p>Greška: Nisu poslani svi podaci iz forme.</p>";
    exit;
}


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PWA projekt</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  </head>
  <body style="background-color: rgb(224, 224, 224);">
    <div class="header">
    <nav>
        <div class="container razmak">
            <div class="row">
                <div class="col-lg-3 col-md-12 col-sm-12 text-center">
                    <div class="navigacija">
                        <a href="../index.php">Home</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-sm-12 text-center">
                    <div class="navigacija">
                        <a href="kategorija.php?kategorija=Vozač">Vozači</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-sm-12 text-center">
                    <div class="navigacija">
                        <a href="kategorija.php?kategorija=Formula">Formule</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-sm-12 text-center">  
                    <div class="navigacija">
                        <a href="administracija.php">Administracija</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    </div>
    <main>
        <div class="container razmak">
            <section>
                <div class="row">
                    <div class="col-sm-12">
                        <section>
                            <h1 class="text-center naslov1">
                                <?php 
                                    echo $category; 
                                ?>
                            </h1> 
                            <p class="mini-naslov">OBJAVLJENO: 14.05.2025.</p>
                        </section>                
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <section class="slika">
                            <?php 
                                echo "<img src='../img/$image' alt='$image_name'>"; 
                            ?>
                        </section>
                        
                        <h3 class="text-center razmak vozac_naslov">
                        <?php 
                            echo $title; 
                        ?>
                        </h3>
                        <h4 class="text-center razmak vozac_mini_naslov">
                            <?php 
                                echo $second_title; 
                            ?>
                        </h4>
                        <div class="row">
                            <div class="col-lg-3 col-md-12">

                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <?php 
                                    echo $content; 
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <footer>
        <div class="container razmak podnozje">
            <div class="row">
                <div class="col-sm-12">
                    <section>
                        <h1 class="text-center naslov2">Formula <span>1</span></h1>
                        <p class="text-center"><i>&copy Luka Domović</i></p>
                    </section> 
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>