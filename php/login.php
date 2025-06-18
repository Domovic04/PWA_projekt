<?php
session_start();
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'pwa_projekt';

$conn = new mysqli($host,$user,$pass,$dbname, 3307);

if ($conn->connect_error) {
    die("Greška pri spajanju na bazu: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $lozinka = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM korisnik WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hash_lozinka,);
    $stmt->fetch();

    if ($stmt->num_rows == 1 && password_verify($lozinka, $hash_lozinka)) {
        $_SESSION['username'] = $username;
    }
    $stmt->close();
    $conn->close();
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
    <style>
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }
    </style>
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
                        <a href="kategorija.php?kategorija=Vozač" >Vozači</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-sm-12 text-center">
                    <div class="navigacija">
                        <a href="kategorija.php?kategorija=Formula">Formule</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-sm-12 text-center">  
                    <div class="navigacija">
                        <a class="activ"  href="administracija.php">Administracija</a>
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
                    <div class="col-12">
                        <h2 class="text-center naslov1">Prijava</h2>
                        <form method="POST" action="" class="forma">
                            <div class="form-group">
                            <label for="username">Korisničko ime:</label><br>
                            <input type="text" name="username" required><br><br>
                               
                            </div>
                            <div class="form-group">
                            <label for="password">Lozinka:</label><br>
                            <input type="password" name="password" required><br><br>    
                            </div>
                            

                            <button type="submit" class="btn-submit">Prijava</button>
                        </form>

                        <h3>Ukoliko nemaš profil registriraj se ovdje:</h3>
                        <a href="registracija.php"><button type="submit" class="btn-submit">Registriraj se</button></a>

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
