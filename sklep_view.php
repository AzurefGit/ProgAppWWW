<?php

function pokazProduktySklep($db)
{
    $query = "SELECT * FROM produkty WHERE status_dostepnosci = 1 AND (data_wygasniecia IS NULL OR data_wygasniecia > NOW()) AND ilosc_magazyn > 0 ORDER BY id DESC";
    $result = mysqli_query($db, $query);

    $html = "<div class='sklep-list'>";
    $html .= "<h2>Oferta Sklepu</h2>";
    $html .= "<div style='display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;'>";

    while ($result && $row = mysqli_fetch_assoc($result)) {
        $brutto = $row['cena_netto'] * (1 + $row['podatek_vat'] / 100);
        $img = $row['zdjecie'] ? "<img src='{$row['zdjecie']}' style='max-width:150px;max-height:150px; object-fit:cover;'>" : "<div style='width:150px;height:150px;background:#eee;display:flex;align-items:center;justify-content:center'>Brak zdjęcia</div>";

        $html .= "<div class='produkt-card' style='border:1px solid #ddd; padding:15px; width:250px; text-align:center; border-radius:8px; box-shadow:0 2px 5px rgba(0,0,0,0.1);'>";
        $html .= "<div>$img</div>";
        $html .= "<h3>" . htmlspecialchars($row['tytul']) . "</h3>";
        $html .= "<p style='font-weight:bold; color:green; font-size:1.2em;'>" . number_format($brutto, 2) . " zł</p>";
        $html .= "<p style='font-size:0.9em; color:#777;'>Netto: " . $row['cena_netto'] . " zł + " . $row['podatek_vat'] . "% VAT</p>";

        $html .= "<form method='post' action='index.php?idp=sklep&action=add'>";
        $html .= "<input type='hidden' name='id_prod' value='{$row['id']}'>";
        $html .= "<input type='hidden' name='tytul' value='{$row['tytul']}'>";
        $html .= "<label>Ilość: <input type='number' name='ilosc' value='1' min='1' max='{$row['ilosc_magazyn']}' style='width:50px'></label>";
        $html .= "<br><br>";
        $html .= "<button type='submit' class='btn btn-primary' style='cursor:pointer; padding:5px 15px; background:#007bff; color:white; border:none; border-radius:4px;'>Dodaj do koszyka</button>";
        $html .= "</form>";

        $html .= "</div>";
    }

    $html .= "</div></div>";
    return $html;
}
?>