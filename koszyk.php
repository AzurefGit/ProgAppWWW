<?php
class Koszyk
{
    private $db;

    public function __construct($db_link)
    {
        $this->db = $db_link;
    }

    public function addToCart($id_prod, $ile_sztuk, $wielkosc = '')
    {
        if (!isset($_SESSION['count'])) {
            $_SESSION['count'] = 1;
        } else {
            $_SESSION['count']++;
        }

        $nr = $_SESSION['count'];

        $_SESSION[$nr . '_0'] = $nr;
        $_SESSION[$nr . '_1'] = $id_prod;
        $_SESSION[$nr . '_2'] = $ile_sztuk;
        $_SESSION[$nr . '_3'] = $wielkosc;
        $_SESSION[$nr . '_4'] = time();
    }

    public function removeFromCart($nr)
    {
        if (isset($_SESSION[$nr . '_0'])) {
            unset($_SESSION[$nr . '_0']);
            unset($_SESSION[$nr . '_1']);
            unset($_SESSION[$nr . '_2']);
            unset($_SESSION[$nr . '_3']);
            unset($_SESSION[$nr . '_4']);
        }
    }

    public function updateQuantity($nr, $nowa_ilosc)
    {
        if (isset($_SESSION[$nr . '_0'])) {
            if ($nowa_ilosc <= 0) {
                $this->removeFromCart($nr);
            } else {
                $_SESSION[$nr . '_2'] = $nowa_ilosc;
            }
        }
    }

    public function showCart()
    {
        if (!isset($_SESSION['count']) || $_SESSION['count'] == 0) {
            return "<div class='koszyk-empty'>Koszyk jest pusty. <a href='index.php?idp=sklep'>Wróć do sklepu</a></div>";
        }

        $total_value = 0;
        $html = "<div class='koszyk-container'>";
        $html .= "<h2>Twój Koszyk</h2>";
        $html .= "<form method='post' action='index.php?idp=koszyk&action=update'>";
        $html .= "<table class='koszyk-table' style='width:100%; border-collapse:collapse; margin-bottom:20px;' border='1'>";
        $html .= "<tr style='background:#f9f9f9; text-align:left;'>
                    <th style='padding:10px;'>Produkt</th>
                    <th style='padding:10px;'>Cena Netto</th>
                    <th style='padding:10px;'>VAT</th>
                    <th style='padding:10px;'>Cena Brutto</th>
                    <th style='padding:10px;'>Ilość</th>
                    <th style='padding:10px;'>Wartość</th>
                    <th style='padding:10px;'>Akcje</th>
                  </tr>";

        $found_items = false;

        for ($i = 1; $i <= $_SESSION['count']; $i++) {
            if (isset($_SESSION[$i . '_0'])) {
                $found_items = true;
                $id_prod = $_SESSION[$i . '_1'];
                $ilosc = $_SESSION[$i . '_2'];
                $query = "SELECT tytul, cena_netto, podatek_vat FROM produkty WHERE id = " . intval($id_prod) . " LIMIT 1";
                $result = mysqli_query($this->db, $query);

                if ($result && $row = mysqli_fetch_assoc($result)) {
                    $cena_netto = $row['cena_netto'];
                    $vat = $row['podatek_vat'];
                    $cena_brutto = $cena_netto * (1 + $vat / 100);
                    $wartosc_brutto = $cena_brutto * $ilosc;
                    $total_value += $wartosc_brutto;

                    $html .= "<tr>";
                    $html .= "<td style='padding:10px;'>" . htmlspecialchars($row['tytul']) . "</td>";
                    $html .= "<td style='padding:10px;'>" . number_format($cena_netto, 2) . " zł</td>";
                    $html .= "<td style='padding:10px;'>" . $vat . "%</td>";
                    $html .= "<td style='padding:10px;'>" . number_format($cena_brutto, 2) . " zł</td>";
                    $html .= "<td style='padding:10px;'><input type='number' name='ilosc_" . $i . "' value='" . $ilosc . "' min='0' style='width:60px; padding:5px;'></td>";
                    $html .= "<td style='padding:10px;'>" . number_format($wartosc_brutto, 2) . " zł</td>";
                    $html .= "<td style='padding:10px;'><a href='index.php?idp=koszyk&action=remove&id=" . $i . "' style='color:red;'>Usuń</a></td>";
                    $html .= "</tr>";
                } else {
                    $html .= "<tr><td colspan='7'>Produkt o ID $id_prod nie istnieje (usunięty z bazy?). <a href='index.php?idp=koszyk&action=remove&id=" . $i . "'>Usuń z koszyka</a></td></tr>";
                }
            }
        }

        if (!$found_items) {
            return "<div class='koszyk-empty'>Twój koszyk jest pusty (wszystkie usunięte). <a href='index.php?idp=sklep'>Wróć do sklepu</a></div>";
        }

        $html .= "</table>";

        $html .= "<div style='text-align:right; margin-top:10px; font-size:1.2em;'><strong>Razem do zapłaty: " . number_format($total_value, 2) . " zł</strong></div>";
        $html .= "<div style='text-align:right; margin-top:20px;'>
                    <input type='submit' value='Zaktualizuj koszyk' style='padding:10px 20px; background:#17a2b8; color:white; border:none; cursor:pointer;'>
                  </div>";

        $html .= "</form>";
        $html .= "</div>";

        return $html;
    }
}
?>