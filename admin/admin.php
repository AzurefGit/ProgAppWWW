<?php
session_start();
require_once '../cfg.php';

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

    public function ListaPodstron()
    {
        global $link;
        $query = "SELECT * FROM page_list";
        if (!$link) die("<b>Przerwano połączenie z bazą danych!</b>");

        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        
        echo "<div class='subpage_list'>
              <h3 class='subpage_list_heading'>Lista podstron</h3>
              <a href='?action=add&id={['id']}' class='btn btn-add'>Dodaj podstronę</a>";
        echo "
            <form method='post' style='text-align:right; margin-bottom: 15px;'>
                <button type='submit' name='wyloguj' class='btn btn-logout'>Wyloguj</button>
            </form>";

        while ($row = mysqli_fetch_array($result)) {
            $status = $row['status'] ? 'AKTYWNA' : 'NIEAKTYWNA';

            echo "<div class='subpage_item'>
                <p>ID: <b>{$row['id']}</b> | Tytuł: <b>{$row['page_title']}</b></p>
                <p>Status: <b>{$status}</b></p>
                <div class='subpage_actions'>
                    <a href='?action=edit&id={$row['id']}' class='btn_edit'>EDYTUJ</a>
                    <a href='?action=delete&id={$row['id']}' class='btn_del'>USUŃ</a>
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
                header("Location: ?msg=edited");
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
                <a href='admin.php' class='btn btn-cancel'>Anuluj</a>
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

            mysqli_query($this->conn, 
                "INSERT INTO page_list (page_title, page_content, status)
                 VALUES ('$title', '$content', $status)"
            );

            header("Location: ?msg=added");
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
                <a href='admin.php' class='btn btn-cancel'>Anuluj</a>
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

        header("Location: ?msg=deleted");
        exit();
    }
}

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
$admin = new Admin($login, $pass, $conn);

$admin->Wyloguj();

if (!empty($_GET['msg'])) {
    echo "<div class='success'>
            Operacja wykonana pomyślnie: {$_GET['msg']}
          </div>";
}

if (isset($_SESSION['zalogowany'])) {
    $action = $_GET['action'] ?? 'list';

    switch ($action) {
        case 'edit': echo $admin->EdytujPodstrone(); break;
        case 'add': echo $admin->DodajNowaPodstrone(); break;
        case 'delete': echo $admin->UsunPodstrone(); break;
        default: $admin->ListaPodstron();
    }
}
else {
    if (isset($_POST['x1_submit'])) {
        if ($admin->SprawdzLogowanie()) {
            echo "<div class='success'>Zalogowano.</div>";
            $admin->ListaPodstron();
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
.btn:hover { background: #0b7dda; }
.btn-del { background: #e53935; }
.btn-edit { background: #4CAF50; }
.btn-save { background: #4CAF50; }
.btn-add { background: #4CAF50; }
.btn-cancel { background: gray; }

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

.admin-panel .input, textarea {
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