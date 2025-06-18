<?php
session_start();
$conn = new mysqli("localhost", "root", "", "pwa_projekt",3307);
$conn->set_charset("utf8");

if (!isset($_GET['id'])) {
    header('Location: administracija.php');
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM vijesti WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$rezultat = $stmt->get_result();
$editVijest = $rezultat->fetch_assoc();

if (!$editVijest) {
    echo "Vijest ne postoji.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naslov = $_POST['naslov'];
    $podnaslov = $_POST['podnaslov'];
    $sadrzaj = $_POST['sadrzaj'];
    $kategorija = $_POST['kategorija'];
    $prikaz = isset($_POST['prikaz']) ? 1 : 0;

    if (isset($_FILES['slika']) && $_FILES['slika']['error'] == 0) {
        $slika = $_FILES['slika']['name'];
        move_uploaded_file($_FILES['slika']['tmp_name'], 'images/' . $slika);
    } else {
        $slika = $editVijest['slika'];
    }

    $stmt = $conn->prepare("UPDATE vijesti SET naslov=?, podnaslov=?, sadrzaj=?, kategorija=?, slika=?, prikaz=? WHERE id=?");
    $stmt->bind_param("ssssssi", $naslov, $podnaslov, $sadrzaj, $kategorija, $slika, $prikaz, $id);
    $stmt->execute();

    header('Location: administracija.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Uredi vijest</title>
</head>
<body>
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
                        <a class="activ" href="administracija.php">Administracija</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    </div>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <br><br>
                     <h1 class="text-center">Uredi vijest</h1>
                <form action="uredi.php?id=<?php echo $editVijest['id']; ?>" method="post" enctype="multipart/form-data" class="forma">
                    <div class="form-group">
                        <label for="naslov">Naslov:</label>
                        <input type="text" name="naslov" id="naslov" required autofocus value="<?php echo htmlspecialchars($editVijest['naslov']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="podnaslov">Podnaslov:</label>
                        <input type="text" name="podnaslov" id="podnaslov" required value="<?php echo htmlspecialchars($editVijest['podnaslov']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="sadrzaj">Sadržaj:</label>
                        <textarea name="sadrzaj" id="sadrzaj" rows="5" required><?php echo htmlspecialchars($editVijest['sadrzaj']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                    <label for="kategorija">Kategorija:</label>
                        <select name="kategorija" id="kategorija" required>
                            <option value="Vozač" <?php if ($editVijest['kategorija'] == 'Vozač') echo 'selected'; ?>>Vozač</option>
                            <option value="Formula" <?php if ($editVijest['kategorija'] == 'Fromula') echo 'selected'; ?>>Formula</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="slika">Slika:</label>
                            <input type="file" name="slika" id="slika">
                            <?php if (!empty($editVijest['slika'])): ?>
                                <p>Trenutna slika: <img src="../img/<?php echo $editVijest['slika']; ?>" width="100"></p>
                            <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="prikaz">Prikaži na stranici:</label>
                        <input type="checkbox" name="prikaz" id="prikaz" <?php if ($editVijest['prikaz']) echo 'checked'; ?>>
                    </div>
                    
                    <div class="form-group ">
                        <button type="submit" class="btn-submit">Ažuriraj vijest</button>
                    </div>
                    
                </form>
                <br><br><br>
                </div>
            </div>
           
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

</body>
</html>
