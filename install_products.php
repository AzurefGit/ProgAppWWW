<?php
require_once 'cfg.php';
require_once 'products.php';

// Connect using cfg.php credentials
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$pm = new ZarzadzajProduktami($conn);

// 1. Create Table
echo "Tworzenie tabeli...<br>";
echo $pm->StworzTabele() . "<br><br>";

// 2. Insert Sample Data
echo "Dodawanie przykładowych produktów...<br>";

$sample_products = [
    [
        'tytul' => 'Mydło Naturalne',
        'opis' => 'Ręcznie robione mydło z lawendą.',
        'data_wygasniecia' => '2026-12-31 23:59:59',
        'cena_netto' => 15.00,
        'podatek_vat' => 23.00,
        'ilosc_magazyn' => 100,
        'status_dostepnosci' => 1,
        'kategoria' => 1,
        'gabaryt' => 'mały',
        'zdjecie' => 'img/mydlo.jpg'
    ],
    [
        'tytul' => 'Szampon Ziołowy',
        'opis' => 'Do włosów przetłuszczających się.',
        'data_wygasniecia' => '2025-06-30 00:00:00',
        'cena_netto' => 25.00,
        'podatek_vat' => 23.00,
        'ilosc_magazyn' => 0, // Out of stock test
        'status_dostepnosci' => 1,
        'kategoria' => 1,
        'gabaryt' => 'średni',
        'zdjecie' => ''
    ],
    [
        'tytul' => 'Krem do Twarzy (Wygasły)',
        'opis' => 'Produkt po terminie.',
        'data_wygasniecia' => '2022-01-01 00:00:00', // Expired test
        'cena_netto' => 50.00,
        'podatek_vat' => 8.00,
        'ilosc_magazyn' => 10,
        'status_dostepnosci' => 1,
        'kategoria' => 2,
        'gabaryt' => 'mały',
        'zdjecie' => ''
    ]
];

foreach ($sample_products as $p) {
    echo $pm->DodajProdukt(
        $p['tytul'],
        $p['opis'],
        $p['data_wygasniecia'],
        $p['cena_netto'],
        $p['podatek_vat'],
        $p['ilosc_magazyn'],
        $p['status_dostepnosci'],
        $p['kategoria'],
        $p['gabaryt'],
        $p['zdjecie']
    ) . "<br>";
}

echo "<br>Zakończono instalację.";
?>