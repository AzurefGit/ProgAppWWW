<?php
session_start();
include 'cfg.php';
include 'showpage.php';
include 'koszyk.php';
include 'sklep_view.php';
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$koszyk = new Koszyk($link);


if (isset($_GET['action'])) {
    if ($_GET['action'] == 'add' && isset($_POST['id_prod'])) {
        $koszyk->addToCart($_POST['id_prod'], $_POST['ilosc']);
        header("Location: index.php?idp=koszyk");
        exit();
    }
    if ($_GET['action'] == 'remove' && isset($_GET['id'])) {
        $koszyk->removeFromCart($_GET['id']);
        header("Location: index.php?idp=koszyk");
        exit();
    }
    if ($_GET['action'] == 'update') {
        foreach ($_POST as $key => $val) {
            if (strpos($key, 'ilosc_') === 0) {
                $nr = substr($key, 6);
                $koszyk->updateQuantity($nr, $val);
            }
        }
        header("Location: index.php?idp=koszyk");
        exit();
    }
}

$witryna = pokazHTML(id: 1);

if ($_GET['idp'] == '')
    $witryna = pokazHTML(id: 1);
if ($_GET['idp'] == 'glowna')
    $witryna = pokazHTML(id: 1);
if ($_GET['idp'] == 'artykuly')
    $witryna = pokazHTML(id: 2);
if ($_GET['idp'] == 'galeria')
    $witryna = pokazHTML(id: 3);
if ($_GET['idp'] == 'info')
    $witryna = pokazHTML(id: 4);
if ($_GET['idp'] == 'kontakt')
    $witryna = pokazHTML(id: 5);
if ($_GET['idp'] == 'jQ')
    $witryna = pokazHTML(id: 6);
if ($_GET['idp'] == 'filmy')
    $witryna = pokazHTML(id: 7);
if ($_GET['idp'] == 'sklep')
    $witryna = pokazProduktySklep($link);
if ($_GET['idp'] == 'koszyk') {
    if (!isset($witryna) || empty($witryna) || substr($witryna, 0, 4) != '<div')
        $witryna = $koszyk->showCart();
}

?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Projekt 1">
    <meta name="keywords" content="HTML5, CSS3, JavaScript">
    <meta name="author" content="Łukasz Malinowski">

    <title>Historia lotów kosmicznych</title>
    <link rel="icon" type="image/x-icon" href="img/ico&cursors/icon.ico">

    <link rel="stylesheet" href="css/styles.css">
    <script src="js/kolorujtlo.js"></script>
    <script src="js/timedate.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body onload="startclock()">

    <div id="container">
        <header>
            <div class="time">
                <table>
                    <tr>
                        <th>
                            <div id="zegarek"></div>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <div id="data"></div>
                        </th>
                    </tr>
                </table>
            </div>

            <h1>Historia lotów kosmicznych</h1>
        </header>

        <nav>
            <ul>
                <li><img src="img/ico&cursors/rocket_nav.png" alt="rocket_nav" class="rocket"></li>
                <li><a href="index.php?idp=glowna">Strona główna</a></li>
                <li><a href="index.php?idp=galeria">Galeria</a></li>
                <li><a href="index.php?idp=artykuly">Artykuły</a></li>
                <li><a href="index.php?idp=info">Informacje</a></li>
                <li><a href="index.php?idp=kontakt">Kontakt</a></li>
                <li><a href="index.php?idp=jQ">jQ</a></li>
                <li><a href="index.php?idp=filmy">Filmy</a></li>
                <li><a href="index.php?idp=sklep">Sklep</a></li>
                <li><a href="index.php?idp=koszyk">Koszyk</a></li>
            </ul>
        </nav>

        <main>
            <?php echo $witryna ?>
        </main>

        <footer>
            <p>Historia lotów kosmicznych</p>
        </footer>
    </div>

    <?php
    $nr_indeksu = '175271';
    $nrGrupy = '2';
    echo 'Autor: Łukasz Malinowski ' . $nr_indeksu . ' grupa ' . $nrGrupy . '<br /><br />';
    ?>
</body>