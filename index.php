<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Projekt 1">
    <meta name="keywords" content="HTML5, CSS3, JavaScript">
    <meta name="author" content="Łukasz Malinowski">

    <title> Historia lotów kosmicznych</title>
    <link rel="icon" type="image/x-icon" href="images/ico&cursors/icon.ico">

    
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/kolorujtlo.js"></script>
    <script src="js/timedate.js"></script>
</head>

<body onload="startclock()">

    <div id="container">
        <header>
            <div class="time">
                <table>
                    <tr>
                        <th><div id="zegarek"></div></th>
                    </tr>  
                    <tr>
                        <th><div id="data"></div></th>
                    </tr>   
                </table>
            </div> 
            
            <h1>Historia lotów kosmicznych</h1>
        </header>
       
        <nav>
            <ul>
                <li><img src="img/ico&cursors/rocket_nav.png" alt="rocket_nav" class="rocket"></li>
                <li><a href="index.html">Strona główna</a></li>
                <li><a href="html/galeria.html">Galeria</a></li>
                <li><a href="html/artykuly.html">Artykuły</a></li>
                <li><a href="html/info.html">Informacje</a></li>
                <li><a href="html/kontakt.html">Kontakt</a></li>
                <li><a href="html/jQ.html">jQ</a></li>
            </ul>
        </nav>

        <main>
            
            <section class="intro">
                <h2>Początki ery kosmicznej</h2>
                <p>4 października 1957 roku Związek Radziecki wyniósł na orbitę pierwszego sztucznego satelitę Ziemi "Sputnik 1". To wydarzenie zapoczątkowało wyścig kosmiczny pomiędzy USA a ZSRR, który zdefiniował całe kolejne dekady badań nad lotami w kosmos.</p>
            </section>

            <section class="milestones">
                <h2>Najważniejsze wydarzenia:</h2>
                <ul>
                    <li>1957 - Początek ery kosmicznej: <em>Sputnik 1</em></li>
                    <li>1961 - Pierwszy lot człowieka w kosmos: <em>Jurij Gagarin</em></li>
                    <li>1969 - Lądowanie na Księżycu: <em>Apollo 11</em></li>
                    <li>1971 - Pierwsza stacja kosmiczna: <em>Salut 1</em></li>
                    <li>1998 - Rozpoczęcie budowy <em>Międzynarodowej Stacji Kosmicznej (ISS)</em></li>
                </ul>
            </section>
      
            <section class="color-buttons">
                <h4>Zmiana kolorów strony:</h4>
                <FORM METHOD="POST" NAME="background">
                    <INPUT TYPE="button" VALUE="żółty" ONCLICK="changeBackground('#FFF000')"> 
                    <INPUT TYPE="button" VALUE="czarny" ONCLICK="changeBackground('#000000')">
                    <INPUT TYPE="button" VALUE="biały" ONCLICK="changeBackground('#FFFFFF')">
                    <INPUT TYPE="button" VALUE="zielony" ONCLICK="changeBackground('#00FF00')">
                    <INPUT TYPE="button" VALUE="niebieski" ONCLICK="changeBackground('#0000FF')">
                    <INPUT TYPE="button" VALUE="pomarańczowy" ONCLICK="changeBackground('#FF8000')"> 
                    <INPUT TYPE="button" VALUE="szary" ONCLICK="changeBackground('#c0c0c0')">
                    <INPUT TYPE="button" VALUE="czerwony" ONCLICK="changeBackground('#FF0000')"> 
                </FORM>
            </section>
        </main>

        <footer>
            <p>Historia lotów kosmicznych</p>
        </footer>
    </div>

    <?php
        $nr_indeksu = '175271';
        $nrGrupy = '2';
        echo 'Autor: Łukasz Malinowski '.$nr_indeksu.' grupa '.$nrGrupy.'<br / ><br />';
    ?>
</body>
</html>

