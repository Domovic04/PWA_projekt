<?php
$kategorija = isset($_GET['kategorija']) ? $_GET['kategorija'] : '';
if ($kategorija !== 'Vozač' && $kategorija !== 'Formula') {
    die('Nepostojeća kategorija!');
}

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'pwa_projekt';

$conn = new mysqli($host, $user, $pass, $dbname,3307);
if ($conn->connect_error) {
    die("Greška prilikom povezivanja s bazom: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT id, naslov, podnaslov, slika, sadrzaj FROM vijesti WHERE kategorija = ?");
$stmt->bind_param("s", $kategorija);
$stmt->execute();
$result = $stmt->get_result();

$aktivnaKategorija = $kategorija;
?>

<!doctype html>
<html lang="hr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($kategorija) ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <a  href="kategorija.php?kategorija=Vozač"  class="<?php if ($aktivnaKategorija === 'Vozač') echo 'activ'; ?>">Vozači</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 text-center">
                <div class="navigacija">
                    <a href="kategorija.php?kategorija=Formula" class="<?php if ($aktivnaKategorija === 'Formula') echo 'activ'; ?>">Formule</a>
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
        <h1 class="text-center naslov1"><?= htmlspecialchars($kategorija) ?></h1>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-lg-4 md-6 sm-12 mb-4">
                    <div class="card h-100">
                        <?php if (!empty($row['slika'])): ?>
                            <img src="../img/<?= htmlspecialchars($row['slika']) ?>" class="card-img-top" alt="Slika">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title vozac_mini_naslov"><?= htmlspecialchars($row['naslov']) ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted vozac_mini_naslov"><?= htmlspecialchars($row['podnaslov']) ?></h6>
                            <p class="card-text"><?= substr(htmlspecialchars($row['sadrzaj']), 0, 150) ?>...</p>
                            <a href="clanak.php?id=<?= $row['id'] ?>" class="btn btn-primary">Pročitaj više</a>
                        </div>
                    </div>
                </div>
                
            <?php endwhile; ?>
            <?php if ($result->num_rows == 0): ?>
                <p class="text-center">Nema objavljenih vijesti u ovoj kategoriji.</p>
            <?php endif; ?>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
