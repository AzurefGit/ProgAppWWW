<?php
class ZarzadzajKategoriami
{
    private $db;

    public function __construct($conn)
    {
        $this->db = $conn;
    }

    public function StworzTabele()
    {
        $query = "CREATE TABLE IF NOT EXISTS kategorie (
            id INT AUTO_INCREMENT PRIMARY KEY,
            matka INT DEFAULT 0,
            nazwa VARCHAR(255) NOT NULL,
            INDEX idx_matka (matka)
        )";

        if (mysqli_query($this->db, $query)) {
            return "Tabela kategorii została utworzona pomyślnie.";
        } else {
            return "Błąd tworzenia tabeli: " . mysqli_error($this->db);
        }
    }

    public function DodajKategorie($nazwa, $matka = 0)
    {
        $nazwa = mysqli_real_escape_string($this->db, $nazwa);
        $matka = (int) $matka;

        $query = "INSERT INTO kategorie (nazwa, matka) VALUES ('$nazwa', $matka)";

        if (mysqli_query($this->db, $query)) {
            return "Kategoria została dodana pomyślnie.";
        } else {
            return "Błąd dodawania kategorii: " . mysqli_error($this->db);
        }
    }

    public function UsunKategorie($id)
    {
        $id = (int) $id;

        $check = "SELECT COUNT(*) as liczba FROM kategorie WHERE matka = $id LIMIT 1";
        $result = mysqli_query($this->db, $check);
        $row = mysqli_fetch_assoc($result);

        if ($row['liczba'] > 0) {
            return "Nie można usunąć kategorii, która posiada podkategorie!";
        }

        $query = "DELETE FROM kategorie WHERE id = $id LIMIT 1";

        if (mysqli_query($this->db, $query)) {
            return "Kategoria została usunięta pomyślnie.";
        } else {
            return "Błąd usuwania kategorii: " . mysqli_error($this->db);
        }
    }

    public function EdytujKategorie($id, $nazwa, $matka = 0)
    {
        $id = (int) $id;
        $nazwa = mysqli_real_escape_string($this->db, $nazwa);
        $matka = (int) $matka;

        if ($id == $matka) {
            return "Kategoria nie może być swoją własną matką!";
        }

        $query = "UPDATE kategorie SET nazwa = '$nazwa', matka = $matka WHERE id = $id LIMIT 1";

        if (mysqli_query($this->db, $query)) {
            return "Kategoria została zaktualizowana pomyślnie.";
        } else {
            return "Błąd edycji kategorii: " . mysqli_error($this->db);
        }
    }

    public function PobierzKategorieGlowne()
    {
        $query = "SELECT * FROM kategorie WHERE matka = 0 ORDER BY nazwa LIMIT 100";
        $result = mysqli_query($this->db, $query);

        $kategorie = array();
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $kategorie[] = $row;
            }
        }

        return $kategorie;
    }

    public function PobierzPodkategorie($id_matki)
    {
        $id_matki = (int) $id_matki;
        $query = "SELECT * FROM kategorie WHERE matka = $id_matki ORDER BY nazwa LIMIT 100";
        $result = mysqli_query($this->db, $query);

        $podkategorie = array();
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $podkategorie[] = $row;
            }
        }

        return $podkategorie;
    }

    public function PobierzKategorie($id)
    {
        $id = (int) $id;
        $query = "SELECT * FROM kategorie WHERE id = $id LIMIT 1";
        $result = mysqli_query($this->db, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }

        return null;
    }

    public function PokazKategorie()
    {
        $html = '<div class="drzewo-kategorii">';
        $html .= '<h2>Drzewo kategorii</h2>';

        $kategorie_glowne = $this->PobierzKategorieGlowne();
        $licznik = 0;

        foreach ($kategorie_glowne as $matka) {
            $licznik++;
            if ($licznik > 100)
                break;

            $html .= '<div class="kategoria-glowna">';
            $html .= '<strong>' . htmlspecialchars($matka['nazwa']) . '</strong>';
            $html .= ' <span class="akcje">';
            $html .= '[<a href="?modul=kategorie&akcja=edytuj&id=' . $matka['id'] . '">Edytuj</a>] ';
            $html .= '[<a href="?modul=kategorie&akcja=usun&id=' . $matka['id'] . '" onclick="return confirm(\'Czy na pewno usunąć?\')">Usuń</a>]';
            $html .= '</span>';

            $podkategorie = $this->PobierzPodkategorie($matka['id']);
            $licznik_pod = 0;

            if (count($podkategorie) > 0) {
                $html .= '<ul class="podkategorie">';

                foreach ($podkategorie as $dziecko) {
                    $licznik_pod++;
                    if ($licznik_pod > 100)
                        break;

                    $html .= '<li>';
                    $html .= htmlspecialchars($dziecko['nazwa']);
                    $html .= ' <span class="akcje">';
                    $html .= '[<a href="?modul=kategorie&akcja=edytuj&id=' . $dziecko['id'] . '">Edytuj</a>] ';
                    $html .= '[<a href="?modul=kategorie&akcja=usun&id=' . $dziecko['id'] . '" onclick="return confirm(\'Czy na pewno usunąć?\')">Usuń</a>]';
                    $html .= '</span>';
                    $html .= '</li>';
                }

                $html .= '</ul>';
            }

            $html .= '</div>';
        }

        $html .= '</div>';
        return $html;
    }

    public function GenerujSelectKategorii($wybrana = 0)
    {
        $html = '<option value="0">-- Kategoria główna --</option>';

        $kategorie = $this->PobierzKategorieGlowne();
        foreach ($kategorie as $kat) {
            $selected = ($kat['id'] == $wybrana) ? 'selected' : '';
            $html .= '<option value="' . $kat['id'] . '" ' . $selected . '>';
            $html .= htmlspecialchars($kat['nazwa']);
            $html .= '</option>';
        }

        return $html;
    }
}
?>