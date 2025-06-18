<?php
$conn = new mysqli("localhost", "root", "", "pwa_projekt",3307);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Greška spajanja na bazu: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['username']) && isset($_POST['password']) && !isset($_POST['naslov'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT ID, password FROM korisnik WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hash);
        $stmt->fetch();

        if (password_verify($password, $hash)) {
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
        } else {
            $poruka = "Pogrešna lozinka.";
        }
    } else {
        $poruka = "Korisnik ne postoji. <a href='registracija.php'>Registriraj se</a>";
    }

    $stmt->close();
}


if (!isset($_SESSION['id'])) {
    include 'login.php'; 
    exit;
}


if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM vijesti WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: administracija.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['naslov'])) {
    $naslov = $_POST['naslov'];
    $podnaslov = $_POST['podnaslov'];
    $sadrzaj = $_POST['sadrzaj'];
    $kategorija = $_POST['kategorija'];
    $prikaz = isset($_POST['prikaz']) ? 1 : 0;

    $slika = basename($_FILES['slika']['name']);
    $target = "images/" . $slika;
    if (move_uploaded_file($_FILES['slika']['tmp_name'], $target)) {
        $stmt = $conn->prepare("INSERT INTO vijesti (naslov, podnaslov, slika, sadrzaj, kategorija, prikaz) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $naslov, $podnaslov, $slika, $sadrzaj, $kategorija, $prikaz);
        $stmt->execute();
        header("Location: administracija.php");
        exit;
    } else {
        $greska = "Greška kod prijenosa slike.";
    }
}


$result = $conn->query("SELECT * FROM vijesti ORDER BY datum DESC");
$vijesti = [];
while ($row = $result->fetch_assoc()) {
    $vijesti[] = $row;
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
                        <a class="activ" href="administracija.php">Administracija</a>
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
                            <h1 class="text-center naslov1">Unos članka</h1>
                            <p class="mini-naslov"></p>
                        </section>
                        <section>
                            <div class="row">
                                <div class="col-lg-3 col-md-12 col-sm-12">

                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    
                                    <form action="skripta.php" method="post" enctype="multipart/form-data" class="forma">

                                        <div class="form-group">
                                            <label for="naslov">Unesite naslov:</label>
                                            <input type="text" name="naslov" id="naslov" required autofocus>
                                        </div>

                                        <div class="form-group">
                                            <label for="podnaslov">Unesite podnaslov:</label>
                                            <input type="text" name="podnaslov" id="podnaslov" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="slika">Unesite sliku:</label>
                                            <input type="file" name="slika" id="slika" accept="image/*">
                                        </div>

                                        <div class="form-group">
                                            <label for="sadrzaj">Tekst članka:</label>
                                            <textarea name="sadrzaj" id="sadrzaj" rows="6" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="kategorija">Izaberite kategoriju:</label>
                                            <select name="kategorija" id="kategorija" required>
                                                <option value="" disabled selected hidden>Odaberi ovdje</option>
                                                <option value="Vozač">Vozač</option>
                                                <option value="Formula">Formula</option>
                                            </select>
                                        </div>

                                        <div class="form-group checkbox-group">
                                            <input type="checkbox" name="prikaz" id="prikaz">
                                            <label for="prikaz">Želite li da se obavijest prikaže na stranici?</label>
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" value="Pošalji" class="btn-submit">
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </section>                
                    </div>
                </div>
            </section>
            <section>
                <div class="row">
                <div class="col-12">
                    <h3>Popis svih vijesti</h3>
                    <?php if (count($vijesti) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Naslov</th>
                                        <th>Kategorija</th>
                                        <th>Datum</th>
                                        <th>Prikaz</th>
                                        <th>Akcije</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($vijesti as $v): ?>
                                        <tr>
                                            <td><?php echo $v['id']; ?></td>
                                            <td><?php echo htmlspecialchars($v['naslov']); ?></td>
                                            <td><?php echo htmlspecialchars($v['kategorija']); ?></td>
                                            <td><?php echo date("d.m.Y.", strtotime($v['datum'])); ?></td>
                                            <td><?php echo $v['prikaz'] ? 'DA' : 'NE'; ?></td>
                                            <td>
                                                <a href="uredi.php?id=<?php echo $v['id']; ?>" class="btn btn-primary btn-sm">Uredi</a>
                                                <a href="administracija.php?delete=<?php echo $v['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Jeste li sigurni da želite obrisati članak?');">Obriši</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p>Nema dostupnih vijesti.</p>
                    <?php endif; ?>
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
