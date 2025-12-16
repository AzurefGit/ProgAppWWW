<?php

require_once 'cfg.php';

function PokazKontakt()
{
    $form = '
    <div class="kontakt">
        <h2>Formularz Kontaktowy</h2>
        <form method="post" action="' . $_SERVER['REQUEST_URI'] . '">
            <table>
                <tr>
                    <td><label for="email">Twój email:</label></td>
                    <td><input type="email" name="email" id="email" required /></td>
                </tr>
                <tr>
                    <td><label for="temat">Temat:</label></td>
                    <td><input type="text" name="temat" id="temat" required /></td>
                </tr>
                <tr>
                    <td><label for="tresc">Treść wiadomości:</label></td>
                    <td><textarea name="tresc" id="tresc" rows="5" cols="40" required></textarea></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="wyslij_kontakt" value="Wyślij wiadomość" />
                    </td>
                </tr>
            </table>
        </form>
        <br/>
        <a href="?przypomnij=1">Zapomniałeś hasła?</a>
    </div>
    
    <style>
        .kontakt {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .kontakt table {
            width: 100%;
        }
        .kontakt td {
            padding: 8px;
        }
        .kontakt input[type="text"],
        .kontakt input[type="email"],
        .kontakt textarea {
            width: 100%;
            padding: 5px;
        }
        .kontakt input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .kontakt input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    ';
    
    return $form;
}
function WyslijMailKontakt($odbiorca)
{
    if(empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email']))
    {
        echo '[nie_wypelniles_pola]';
        echo PokazKontakt();
    }

    else
    {
        $mail['subject']    = $_POST['temat'];
        $mail['body']       = $_POST['tresc'];
        $mail['sender']     = $_POST['email'];
        $mail['reciptient'] = $odbiorca;
        $header  = "From: Formularz kontaktowy <". $mail['sender'].">\n";
        $header .= "MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding:";
        $header .= "X-sender: <". $mail['sender'].">\n";
        $header .= "X-Mailer: PRapwww mail 1.2\n";
        $header .= "X-Priority: 3\n";
        $header .= "Return-Path: <". $mail['sender'].">\n";

        mail($mail['reciptient'], $mail['subject'], $mail['body'], $header);

        echo '[wiadomosc_wyslana]';
    }
}
function PrzypomnijHaslo()
{
    global $admin_password, $admin_email;
    
    $form = '
    <div class="kontakt">
        <h2>Przypomnienie Hasła</h2>
        <form method="post" action="' . $_SERVER['REQUEST_URI'] . '">
            <table>
                <tr>
                    <td><label for="email_przypomnienie">Twój email administratora:</label></td>
                    <td><input type="email" name="email_przypomnienie" id="email_przypomnienie" required /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="przypomnij_haslo" value="Przypomnij hasło" />
                    </td>
                </tr>
            </table>
        </form>
        <br/>
        <a href="?">Powrót do formularza kontaktowego</a>
    </div>
    ';

    if(isset($_POST['przypomnij_haslo']))
    {
        if(empty($_POST['email_przypomnienie']))
        {
            echo '[nie_wypelniles_pola]';
        }
        else
        {
            $email_podany = $_POST['email_przypomnienie'];

            if($email_podany == $admin_email)
            {

                $mail['subject']    = "Przypomnienie hasła - Panel Admina";
                $mail['body']       = "Twoje hasło do panelu administratora to: " . $admin_password . "\n\nUWAGA: Zmień hasło po zalogowaniu!";
                $mail['sender']     = "noreply@example.com";
                $mail['reciptient'] = $email_podany;
                
                $header  = "From: System przypominania hasła <". $mail['sender'].">\n";
                $header .= "MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding: 8bit\n";
                $header .= "X-Sender: <". $mail['sender'].">\n";
                $header .= "X-Mailer: PRapwww mail 1.2\n";
                $header .= "X-Priority: 3\n";
                $header .= "Return-Path: <". $mail['sender'].">\n";
                
                mail($mail['reciptient'], $mail['subject'], $mail['body'], $header);
                
                echo '[haslo_wyslane_na_email]';
            }
            else
            {
                echo '[nieprawidlowy_email]';
            }
        }
    }
    
    return $form;
}

if(isset($_GET['przypomnij']))
{
    echo PrzypomnijHaslo();
}
elseif(isset($_POST['wyslij_kontakt']))
{
    WyslijMailKontakt($admin_email);
}
else
{
    echo PokazKontakt();
}
?>