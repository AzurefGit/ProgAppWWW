<?php
require_once '../cfg.php';
require_once '../kategorie.php';
require_once '../products.php';

session_start();

class Admin
{
    private $login;
    private $pass;
    private $conn;

    public function __construct($login, $pass, $conn)
    {
        $this->login = $login;
        $this->pass = $pass;
        $this->conn = $conn;
    }

    function FormularzLogowania()
    {
        $wynik = "
        <div class='logowanie'>
            <h1 class='heading'>Panel CMS</h1>
            <form action='{$_SERVER["REQUEST_URI"]}' method='post' name='LoginForm'>
                <table class='logowanie'>
                    <tr>
                        <td>login</td>
                        <td><input type='text' name='login_email' class='input'></td>
                    </tr>
                    <tr>
                        <td>haslo</td>
                        <td><input type='password' name='login_pass' class='input'></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type='submit' name='x1_submit' value='Zaloguj' class='btn'></td>
                    </tr>
                </table>
            </form>
        </div>";
        return $wynik;
    }

    public function SprawdzLogowanie()
    {
        if (!isset($_POST['login_email']) || !isset($_POST['login_pass'])) {
            return false;
        }

        $login = trim($_POST['login_email']);
        $password = trim($_POST['login_pass']);

        if ($login === $this->login && $password === $this->pass) {
            $_SESSION['zalogowany'] = true;
            return true;
        }

        return false;
    }

    public function Wyloguj()
    {
        if (isset($_POST['wyloguj'])) {
            session_destroy();
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }

    public function MenuGlowne()
    {
        echo "
        <div class='main-menu'>
            <h1>Panel Administracyjny - Menu Główne</h1>
            <form method='post' style='text-align:right; margin-bottom: 15px;'>
                <button type='submit' name='wyloguj' class='btn btn-logout'>Wyloguj</button>
            </form>
            <div class='menu-grid'>
                <a href='?modul=podstrony' class='menu-card'>
                    <h3>Zarządzanie Podstronami</h3>
                    <p>Dodawaj, edytuj i usuwaj podstrony CMS</p>
                </a>
                <a href='?modul=kategorie' class='menu-card'>
                    <h3>Zarządzanie Kategoriami</h3>
                    <p>Kategorie i podkategorie produktów</p>
                </a>
                <a href='?modul=produkty' class='menu-card'>
                    <h3>Zarządzanie Produktami</h3>
                    <p>Dodawaj, edytuj i usuwaj produkty</p>
                </a>
            </div>
        </div>";
    }

    public function ListaPodstron()
    {
        global $link;
        $query = "SELECT * FROM page_list";
        if (!$link)
            die("<b>Przerwano połączenie z bazą danych!</b>");

        $result = mysqli_query($link, $query) or die(mysqli_error($link));

        echo "<div class='subpage_list'>
              <h3 class='subpage_list_heading'>Lista podstron</h3>
              <a href='?modul=podstrony&action=add' class='btn btn-add'>Dodaj podstronę</a>";
        echo "
            <div style='display:flex; justify-content:space-between; margin-bottom: 20px;'>
                 <form method='post' style='margin:0;'>
                    <button type='submit' name='wyloguj' class='btn btn-logout'>Wyloguj</button>
                 </form>
            </div>";
        echo '<div class="action-bar"><a href="admin.php" class="btn btn-back">← Powrót do menu</a></div>';

        while ($row = mysqli_fetch_array($result)) {
            $status = $row['status'] ? 'AKTYWNA' : 'NIEAKTYWNA';

            echo "<div class='subpage_item'>
                <p>ID: <b>{$row['id']}</b> | Tytuł: <b>{$row['page_title']}</b></p>
                <p>Status: <b>{$status}</b></p>
                <div class='subpage_actions'>
                    <a href='?modul=podstrony&action=edit&id={$row['id']}' class='btn_edit'>EDYTUJ</a>
                    <a href='?modul=podstrony&action=delete&id={$row['id']}' class='btn_del'>USUŃ</a>
                </div>
            </div>";
        }
        echo "</div>";
    }

    public function EdytujPodstrone()
    {
        if (!isset($_SESSION['zalogowany'])) {
            return $this->FormularzLogowania();
        }

        if (!isset($_GET['id'])) {
            return "<div class='error'>Brak ID.</div>";
        }

        $id = intval($_GET['id']);

        if (isset($_POST['save_edit'])) {
            $title = mysqli_real_escape_string($this->conn, $_POST['page_title']);
            $content = mysqli_real_escape_string($this->conn, $_POST['page_content']);
            $status = isset($_POST['status']) ? 1 : 0;

            $query = "UPDATE page_list SET 
                      page_title='$title', 
                      page_content='$content', 
                      status=$status 
                      WHERE id=$id LIMIT 1";

            if (mysqli_query($this->conn, $query)) {
                header("Location: ?modul=podstrony&msg=edited");
                exit();
            } else {
                return "<div class='error'>Błąd: " . mysqli_error($this->conn) . "</div>";
            }
        }

        $result = mysqli_query($this->conn, "SELECT * FROM page_list WHERE id=$id LIMIT 1");

        if (mysqli_num_rows($result) == 0)
            return "<div class='error'>Nie znaleziono podstrony.</div>";

        $row = mysqli_fetch_assoc($result);
        $checked = $row['status'] == 1 ? "checked" : "";

        return "
        <div class='admin-panel'>
            <h2>Edycja podstrony</h2>
            <form method='post'>
                <label>Tytuł:</label>
                <input type='text' name='page_title' value='" . htmlspecialchars($row['page_title']) . "' class='input'>

                <label>Treść:</label>
                <textarea name='page_content' rows='10' class='input'>" . htmlspecialchars($row['page_content']) . "</textarea>

                <label><input type='checkbox' name='status' $checked> Aktywna</label>

                <button type='submit' name='save_edit' class='btn btn-save'>Zapisz</button>
                <a href='?modul=podstrony' class='btn btn-cancel'>Anuluj</a>
            </form>
        </div>";
    }

    public function DodajNowaPodstrone()
    {
        if (!isset($_SESSION['zalogowany'])) {
            return $this->FormularzLogowania();
        }

        if (isset($_POST['save_new'])) {
            $title = mysqli_real_escape_string($this->conn, $_POST['page_title']);
            $content = mysqli_real_escape_string($this->conn, $_POST['page_content']);
            $status = isset($_POST['status']) ? 1 : 0;

            mysqli_query(
                $this->conn,
                "INSERT INTO page_list (page_title, page_content, status)
                 VALUES ('$title', '$content', $status)"
            );

            header("Location: ?modul=podstrony&msg=added");
            exit();
        }

        return "
        <div class='admin-panel'>
            <h2>Nowa podstrona</h2>
            <form method='post'>
                <label>Tytuł:</label>
                <input type='text' name='page_title' class='input' required>

                <label>Treść:</label>
                <textarea name='page_content' rows='10' class='input' required></textarea>

                <label><input type='checkbox' name='status' checked> Aktywna</label>

                <button type='submit' name='save_new' class='btn btn-save'>Dodaj</button>
                <a href='?modul=podstrony' class='btn btn-cancel'>Anuluj</a>
            </form>
        </div>";
    }

    public function UsunPodstrone()
    {
        if (!isset($_SESSION['zalogowany'])) {
            return $this->FormularzLogowania();
        }

        if (!isset($_GET['id'])) {
            return "<div class='error'>Brak ID.</div>";
        }

        $id = intval($_GET['id']);

        mysqli_query($this->conn, "DELETE FROM page_list WHERE id=$id LIMIT 1");

        header("Location: ?modul=podstrony&msg=deleted");
        exit();
    }
}

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
$admin = new Admin($login, $pass, $conn);
$kategorie_manager = new ZarzadzajKategoriami($conn);
$produkt_manager = new ZarzadzajProduktami($conn);

$admin->Wyloguj();

if (!empty($_GET['msg'])) {
    echo "<div class='success'>
            Operacja wykonana pomyślnie: {$_GET['msg']}
          </div>";
}

if (isset($_SESSION['zalogowany'])) {
    $modul = $_GET['modul'] ?? 'menu';

    switch ($modul) {
        case 'podstrony':
            $action = $_GET['action'] ?? 'list';
            switch ($action) {
                case 'edit':
                    echo $admin->EdytujPodstrone();
                    break;
                case 'add':
                    echo $admin->DodajNowaPodstrone();
                    break;
                case 'delete':
                    echo $admin->UsunPodstrone();
                    break;
                default:
                    $admin->ListaPodstron();
            }
            break;


        case 'kategorie':

            $komunikat = '';
            $akcja = $_GET['akcja'] ?? '';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['dodaj'])) {
                    $komunikat = $kategorie_manager->DodajKategorie($_POST['nazwa'], $_POST['matka']);
                } elseif (isset($_POST['edytuj'])) {
                    $komunikat = $kategorie_manager->EdytujKategorie($_POST['id'], $_POST['nazwa'], $_POST['matka']);
                }
            }

            if ($akcja == 'usun' && isset($_GET['id'])) {
                $komunikat = $kategorie_manager->UsunKategorie($_GET['id']);
            }

            $kategoria_edytowana = null;
            if ($akcja == 'edytuj' && isset($_GET['id'])) {
                $kategoria_edytowana = $kategorie_manager->PobierzKategorie($_GET['id']);
            }

            echo '<div class="container">';
            echo '<h1>Zarządzanie kategoriami produktów</h1>';
            echo '<div class="action-bar"><a href="admin.php" class="btn btn-back">← Powrót do menu</a></div>';

            if ($komunikat) {
                echo "<div class='komunikat'>$komunikat</div>";
            }

            echo '<div class="formularz">';
            echo '<h2>' . ($kategoria_edytowana ? 'Edytuj kategorię' : 'Dodaj nową kategorię') . '</h2>';
            echo '<form method="POST" action="">';

            if ($kategoria_edytowana) {
                echo '<input type="hidden" name="id" value="' . $kategoria_edytowana['id'] . '">';
            }

            echo '<div class="form-group">';
            echo '<label>Nazwa kategorii:</label>';
            echo '<input type="text" name="nazwa" required value="' . ($kategoria_edytowana ? htmlspecialchars($kategoria_edytowana['nazwa']) : '') . '">';
            echo '</div>';

            echo '<div class="form-group">';
            echo '<label>Kategoria nadrzędna (matka):</label>';
            echo '<select name="matka">';
            echo $kategorie_manager->GenerujSelectKategorii($kategoria_edytowana ? $kategoria_edytowana['matka'] : 0);
            echo '</select>';
            echo '</div>';

            echo '<button type="submit" name="' . ($kategoria_edytowana ? 'edytuj' : 'dodaj') . '">';
            echo ($kategoria_edytowana ? 'Zapisz zmiany' : 'Dodaj kategorię');
            echo '</button>';

            if ($kategoria_edytowana) {
                echo '<a href="?modul=kategorie"><button type="button" class="btn-anuluj">Anuluj</button></a>';
            }

            echo '</form>';
            echo '</div>';

            echo $kategorie_manager->PokazKategorie();
            echo '</div>';
            break;

        case 'produkty':
            $produkt_manager->StworzTabele();

            $action = $_GET['action'] ?? 'list';
            $msg = '';

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['save_product'])) {
                    $id = $_POST['id'] ?? null;
                    $tytul = $_POST['tytul'];
                    $opis = $_POST['opis'];
                    $data_wygasniecia = !empty($_POST['data_wygasniecia']) ? $_POST['data_wygasniecia'] : null;
                    $cena_netto = $_POST['cena_netto'];
                    $podatek_vat = $_POST['podatek_vat'];
                    $ilosc_magazyn = $_POST['ilosc_magazyn'];
                    $status_dostepnosci = isset($_POST['status_dostepnosci']) ? 1 : 0;
                    $kategoria = $_POST['kategoria'];
                    $gabaryt = $_POST['gabaryt'];
                    $zdjecie = $_POST['zdjecie'];

                    if ($id) {
                        $msg = $produkt_manager->EdytujProdukt($id, $tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc_magazyn, $status_dostepnosci, $kategoria, $gabaryt, $zdjecie);
                    } else {
                        $msg = $produkt_manager->DodajProdukt($tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc_magazyn, $status_dostepnosci, $kategoria, $gabaryt, $zdjecie);
                    }
                    echo "<div class='success'>$msg</div>";
                    $action = 'list';
                }
            }

            if ($action == 'delete' && isset($_GET['id'])) {
                $msg = $produkt_manager->UsunProdukt($_GET['id']);
                echo "<div class='success'>$msg</div>";
                $action = 'list';
            }

            if ($action == 'list') {
                echo $produkt_manager->PokazProdukty();
                echo '<div class="action-bar" style="margin-top:20px;"><a href="admin.php" class="btn btn-back">← Powrót do menu</a></div>';
            } elseif ($action == 'add' || $action == 'edit') {
                $product = null;
                if ($action == 'edit' && isset($_GET['id'])) {
                    $product = $produkt_manager->PobierzProdukt($_GET['id']);
                }

                $tytul = $product ? $product['tytul'] : '';
                $opis = $product ? $product['opis'] : '';
                $data_wyg = $product ? $product['data_wygasniecia'] : '';
                $cena = $product ? $product['cena_netto'] : '';
                $vat = $product ? $product['podatek_vat'] : '23.00';
                $ilosc = $product ? $product['ilosc_magazyn'] : '0';
                $status = ($product && $product['status_dostepnosci'] == 1) ? 'checked' : '';
                if (!$product)
                    $status = 'checked';
                $kat_id = $product ? $product['kategoria'] : 0;
                $gabaryt = $product ? $product['gabaryt'] : '';
                $zdjecie = $product ? $product['zdjecie'] : '';
                $id_val = $product ? $product['id'] : '';

                echo "<div class='admin-panel'>
                    <h2>" . ($product ? 'Edytuj Produkt' : 'Dodaj Produkt') . "</h2>
                    <form method='post'>
                        " . ($product ? "<input type='hidden' name='id' value='$id_val'>" : "") . "
                        
                        <label>Tytuł:</label>
                        <input type='text' name='tytul' value='" . htmlspecialchars($tytul) . "' required class='input'>

                        <label>Opis:</label>
                        <textarea name='opis' rows='5' class='input'>" . htmlspecialchars($opis) . "</textarea>

                        <div style='display:flex; gap:10px;'>
                            <div style='flex:1'>
                                <label>Cena Netto:</label>
                                <input type='number' step='0.01' name='cena_netto' value='$cena' required class='input'>
                            </div>
                            <div style='flex:1'>
                                <label>VAT (%):</label>
                                <input type='number' step='0.01' name='podatek_vat' value='$vat' class='input'>
                            </div>
                        </div>

                        <div style='display:flex; gap:10px;'>
                            <div style='flex:1'>
                                <label>Ilość w magazynie:</label>
                                <input type='number' name='ilosc_magazyn' value='$ilosc' class='input'>
                            </div>
                             <div style='flex:1'>
                                <label>Data wygaśnięcia:</label>
                                <input type='datetime-local' name='data_wygasniecia' value='$data_wyg' class='input'>
                            </div>
                        </div>

                        <label>Kategoria:</label>
                        <select name='kategoria' class='input'>
                            " . $kategorie_manager->GenerujSelectKategorii($kat_id) . "
                        </select>

                        <label>Gabaryt:</label>
                        <input type='text' name='gabaryt' value='" . htmlspecialchars($gabaryt) . "' class='input'>

                        <label>Link do zdjęcia:</label>
                        <input type='text' name='zdjecie' value='" . htmlspecialchars($zdjecie) . "' class='input'>

                        <label><input type='checkbox' name='status_dostepnosci' $status> Produkt dostępny (status)</label>

                        <button type='submit' name='save_product' class='btn btn-save'>Zapisz</button>
                        <a href='?modul=produkty' class='btn btn-cancel'>Anuluj</a>
                    </form>
                </div>";
            }
            break;

        default:
            $admin->MenuGlowne();
    }
} else {
    if (isset($_POST['x1_submit'])) {
        if ($admin->SprawdzLogowanie()) {
            echo "<div class='success'>Zalogowano pomyślnie!</div>";
            $admin->MenuGlowne();
        } else {
            echo "<div class='error'>Błędne dane logowania.</div>";
            echo $admin->FormularzLogowania();
        }
    } else {
        echo $admin->FormularzLogowania();
    }
}

mysqli_close($conn);
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background: #f2f2f2;
        margin: 0;
        padding: 20px;
    }

    .logowanie {
        background: white;
        padding: 20px;
        margin: 40px auto;
        width: 350px;
        border-radius: 8px;
        box-shadow: 0 0 10px #ccc;
    }

    .logowanie .input {
        width: 100%;
        padding: 8px;
        margin: 5px 0;
    }

    .btn {
        display: inline-block;
        padding: 8px 14px;
        border: none;
        background: #2196F3;
        color: white;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
    }

    .btn:hover {
        background: #0b7dda;
    }

    .btn-del {
        background: #e53935;
    }

    .btn-edit {
        background: #4CAF50;
    }

    .btn-save {
        background: #4CAF50;
    }

    .btn-add {
        background: #4CAF50;
    }

    .btn-cancel {
        background: gray;
    }

    .subpage_list {
        margin: 20px auto;
        width: 800px;
    }

    .subpage_item {
        background: white;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 6px;
        box-shadow: 0 0 5px #bbb;
    }

    .subpage_actions a {
        margin-right: 10px;
    }

    .admin-panel {
        background: white;
        width: 800px;
        padding: 20px;
        margin: 20px auto;
        border-radius: 6px;
        box-shadow: 0 0 10px #bbb;
    }

    .admin-panel .input,
    textarea {
        width: 100%;
        padding: 8px;
        margin: 8px 0;
    }

    .success {
        background: #4CAF50;
        padding: 10px;
        color: white;
        text-align: center;
        border-radius: 4px;
        width: 400px;
        margin: 10px auto;
    }

    .error {
        background: #e53935;
        padding: 10px;
        color: white;
        text-align: center;
        border-radius: 4px;
        width: 400px;
        margin: 10px auto;
    }
</style>