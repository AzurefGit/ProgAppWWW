<?php
class ZarzadzajProduktami
{
    private $db;

    public function __construct($conn)
    {
        $this->db = $conn;
    }

    public function StworzTabele()
    {
        $query = "CREATE TABLE IF NOT EXISTS produkty (
            id INT AUTO_INCREMENT PRIMARY KEY,
            tytul VARCHAR(255) NOT NULL,
            opis TEXT,
            data_utworzenia DATETIME DEFAULT CURRENT_TIMESTAMP,
            data_modyfikacji DATETIME ON UPDATE CURRENT_TIMESTAMP,
            data_wygasniecia DATETIME,
            cena_netto DECIMAL(10,2) NOT NULL,
            podatek_vat DECIMAL(5,2) DEFAULT 23.00,
            ilosc_magazyn INT DEFAULT 0,
            status_dostepnosci INT DEFAULT 1,
            kategoria INT,
            gabaryt VARCHAR(50),
            zdjecie VARCHAR(255)
        )";

        if (mysqli_query($this->db, $query)) {
            return "Tabela 'produkty' została utworzona (lub już istniała).";
        } else {
            return "Błąd tworzenia tabeli: " . mysqli_error($this->db);
        }
    }

    public function DodajProdukt($tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc_magazyn, $status_dostepnosci, $kategoria, $gabaryt, $zdjecie)
    {
        $tytul = mysqli_real_escape_string($this->db, $tytul);
        $opis = mysqli_real_escape_string($this->db, $opis);
        $gabaryt = mysqli_real_escape_string($this->db, $gabaryt);
        $zdjecie = mysqli_real_escape_string($this->db, $zdjecie);

        $data_wygasniecia_sql = $data_wygasniecia ? "'$data_wygasniecia'" : "NULL";

        $query = "INSERT INTO produkty (tytul, opis, data_utworzenia, data_wygasniecia, cena_netto, podatek_vat, ilosc_magazyn, status_dostepnosci, kategoria, gabaryt, zdjecie) 
                  VALUES ('$tytul', '$opis', NOW(), $data_wygasniecia_sql, '$cena_netto', '$podatek_vat', '$ilosc_magazyn', '$status_dostepnosci', '$kategoria', '$gabaryt', '$zdjecie')";

        if (mysqli_query($this->db, $query)) {
            return "Produkt dodany pomyślnie.";
        } else {
            return "Błąd dodawania produktu: " . mysqli_error($this->db);
        }
    }

    public function UsunProdukt($id)
    {
        $id = (int) $id;
        $query = "DELETE FROM produkty WHERE id = $id LIMIT 1";

        if (mysqli_query($this->db, $query)) {
            return "Produkt usunięty.";
        } else {
            return "Błąd usuwania: " . mysqli_error($this->db);
        }
    }

    public function EdytujProdukt($id, $tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc_magazyn, $status_dostepnosci, $kategoria, $gabaryt, $zdjecie)
    {
        $id = (int) $id;
        $tytul = mysqli_real_escape_string($this->db, $tytul);
        $opis = mysqli_real_escape_string($this->db, $opis);
        $gabaryt = mysqli_real_escape_string($this->db, $gabaryt);
        $zdjecie = mysqli_real_escape_string($this->db, $zdjecie);

        $data_wygasniecia_sql = $data_wygasniecia ? "'$data_wygasniecia'" : "NULL";

        $query = "UPDATE produkty SET 
                  tytul='$tytul', 
                  opis='$opis', 
                  data_modyfikacji=NOW(), 
                  data_wygasniecia=$data_wygasniecia_sql, 
                  cena_netto='$cena_netto', 
                  podatek_vat='$podatek_vat', 
                  ilosc_magazyn='$ilosc_magazyn', 
                  status_dostepnosci='$status_dostepnosci', 
                  kategoria='$kategoria', 
                  gabaryt='$gabaryt', 
                  zdjecie='$zdjecie' 
                  WHERE id=$id LIMIT 1";

        if (mysqli_query($this->db, $query)) {
            return "Produkt zaktualizowany.";
        } else {
            return "Błąd aktualizacji: " . mysqli_error($this->db);
        }
    }

    public function PokazProdukty()
    {
        $query = "SELECT * FROM produkty ORDER BY id DESC";
        $result = mysqli_query($this->db, $query);

        $html = "<div class='produkty-list'>";
        $html .= "<h3>Lista Produktów</h3>";
        $html .= "<a href='?modul=produkty&action=add' class='btn btn-add'>Dodaj Produkt</a>";
        $html .= "<table border='1' cellpadding='5' cellspacing='0' style='width:100%; margin-top:10px; border-collapse:collapse;'>
                    <tr style='background:#ddd;'>
                        <th>ID</th>
                        <th>Zdjęcie</th>
                        <th>Tytuł</th>
                        <th>Kategoria</th>
                        <th>Cena Netto</th>
                        <th>Cena Brutto</th>
                        <th>Magazyn</th>
                        <th>Dostępność</th>
                        <th>Status</th>
                        <th>Akcje</th>
                    </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            $brutto = $row['cena_netto'] * (1 + $row['podatek_vat'] / 100);
            $img = $row['zdjecie'] ? "<img src='{$row['zdjecie']}' style='max-width:50px;max-height:50px;'>" : "brak";

            $dostepnosc_status = "Dostępny";
            $color = "green";

            if ($row['status_dostepnosci'] == 0) {
                $dostepnosc_status = "Wyłączony";
                $color = "gray";
            } elseif ($row['ilosc_magazyn'] <= 0) {
                $dostepnosc_status = "Brak w mag.";
                $color = "red";
            } elseif ($row['data_wygasniecia'] && strtotime($row['data_wygasniecia']) < time()) {
                $dostepnosc_status = "Wygasł";
                $color = "orange";
            }

            $html .= "<tr>
                        <td>{$row['id']}</td>
                        <td>$img</td>
                        <td>{$row['tytul']}</td>
                        <td>{$row['kategoria']}</td>
                        <td>{$row['cena_netto']}</td>
                        <td>" . number_format($brutto, 2) . "</td>
                        <td>{$row['ilosc_magazyn']}</td>
                        <td>" . ($row['status_dostepnosci'] ? 'Aktywny' : 'Nieaktywny') . "</td>
                        <td style='color:$color; font-weight:bold;'>$dostepnosc_status</td>
                        <td>
                            <a href='?modul=produkty&action=edit&id={$row['id']}' class='btn btn-edit'>Edytuj</a>
                            <a href='?modul=produkty&action=delete&id={$row['id']}' class='btn btn-del' onclick='return confirm(\"Czy na pewno?\")'>Usuń</a>
                        </td>
                      </tr>";
        }
        $html .= "</table></div>";
        return $html;
    }

    public function PobierzProdukt($id)
    {
        $id = (int) $id;
        $query = "SELECT * FROM produkty WHERE id = $id LIMIT 1";
        $result = mysqli_query($this->db, $query);
        return mysqli_fetch_assoc($result);
    }
}
?>