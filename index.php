<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PWA projekt</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <style>
  a.clanak-link,
  a.clanak-link:hover,
  a.clanak-link:visited {
    text-decoration: none !important;
    color: inherit !important;
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
                        <a class="activ" href="index.php">Home</a>
                    </div>
                </div>
                <div class="col-lg-3  col-md-12 col-sm-12 text-center">
                    <div class="navigacija">
                        <a href="php/kategorija.php?kategorija=Vozač">Vozači</a>
                    </div>
                </div>
                <div class="col-lg-3  col-md-12 col-sm-12 text-center">
                    <div class="navigacija">
                        <a href="php/kategorija.php?kategorija=Formula">Formule</a>
                    </div>
                </div>
                <div class="col-lg-3   col-md-12col-sm-12 text-center">  
                    <div class="navigacija">
                        <a href="php/administracija.php">Administracija</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    </div>
    <main>
        <div class="container razmak">
            <?php
                $conn = new mysqli("localhost", "root", "", "pwa_projekt", 3307);
                mysqli_set_charset($conn, "utf8");

                define("UPLPATH", "img/");
                $kategorije = ["Vozač", "Formula"];

                foreach ($kategorije as $kategorija) {
                    echo "<div class='row'> 
                    <div class='col-lg-3 md-4 col-sm-12'>
                    <article>
                        <hr class='linija'>
                        <h4 class='vozac_mini_naslov'>$kategorija</h4>
                    </article>
                    </div>";
                    $query = "SELECT * FROM vijesti WHERE prikaz=1 AND kategorija='$kategorija' ORDER BY datum DESC LIMIT 3";
                    $result = $conn->query($query);

                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='col-lg-3 md-4 sm-12 sijena'>";
                        echo "<a class='clanak-link' href='php/clanak.php?id={$row['id']}'>";
                        echo "<img src='img/{$row['slika']}' width='100%'>";
                        echo "<h4>{$row['naslov']}</h4>";
                        echo "<h6 class='vozac_mini_naslov'>{$row['podnaslov']}</h6>";
                        echo "<p>" . (substr($row['sadrzaj'], 0, 100) . '...') . "</p>";
                        echo "</a>";
                        echo "</div>";
                    }

                    echo "</div><hr>";
                }
                $conn->close();
            ?>
            <br>
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