-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sty 20, 2026 at 06:32 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moja_strona`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `id` int(11) NOT NULL,
  `matka` int(11) DEFAULT 0,
  `nazwa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategorie`
--

INSERT INTO `kategorie` (`id`, `matka`, `nazwa`) VALUES
(1, 0, 'Elektronika'),
(2, 0, 'Odzież'),
(3, 0, 'Dom i Ogród'),
(4, 0, 'Sport'),
(5, 1, 'Smartfony'),
(6, 1, 'Laptopy'),
(7, 1, 'Telewizory'),
(8, 2, 'Ubrania męskie'),
(9, 2, 'Ubrania damskie'),
(10, 2, 'Ubrania dziecięce'),
(11, 3, 'Meble'),
(12, 3, 'Narzędzia'),
(13, 4, 'Piłka nożna'),
(14, 4, 'Siłownia'),
(17, 0, 'test'),
(19, 0, 'gsdfgds'),
(20, 19, 'asdgsd');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `page_list`
--

CREATE TABLE `page_list` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `page_content` text DEFAULT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page_list`
--

INSERT INTO `page_list` (`id`, `page_title`, `page_content`, `status`) VALUES
(1, 'glowna', '<section class=\"intro\">\r\n    <h2>Początki ery kosmicznej</h2>\r\n    <p>4 października 1957 roku Związek Radziecki wyniósł na orbitę pierwszego sztucznego satelitę Ziemi \"Sputnik 1\". To wydarzenie zapoczątkowało wyścig kosmiczny pomiędzy USA a ZSRR, który zdefiniował całe kolejne dekady badań nad lotami w kosmos.</p>\r\n</section>\r\n\r\n<section class=\"milestones\">\r\n    <h2>Najważniejsze wydarzenia:</h2>\r\n    <ul>\r\n        <li>1957 - Początek ery kosmicznej: <em>Sputnik 1</em></li>\r\n        <li>1961 - Pierwszy lot człowieka w kosmos: <em>Jurij Gagarin</em></li>\r\n        <li>1969 - Lądowanie na Księżycu: <em>Apollo 11</em></li>\r\n        <li>1971 - Pierwsza stacja kosmiczna: <em>Salut 1</em></li>\r\n        <li>1998 - Rozpoczęcie budowy <em>Międzynarodowej Stacji Kosmicznej (ISS)</em></li>\r\n    </ul>\r\n</section>\r\n\r\n<section class=\"color-buttons\">\r\n    <h4>Zmiana kolorów strony:</h4>\r\n    <FORM METHOD=\"POST\" NAME=\"background\">\r\n        <INPUT TYPE=\"button\" VALUE=\"żółty\" ONCLICK=\"changeBackground(\'#FFF000\')\"> \r\n        <INPUT TYPE=\"button\" VALUE=\"czarny\" ONCLICK=\"changeBackground(\'#000000\')\">\r\n        <INPUT TYPE=\"button\" VALUE=\"biały\" ONCLICK=\"changeBackground(\'#FFFFFF\')\">\r\n        <INPUT TYPE=\"button\" VALUE=\"zielony\" ONCLICK=\"changeBackground(\'#00FF00\')\">\r\n        <INPUT TYPE=\"button\" VALUE=\"niebieski\" ONCLICK=\"changeBackground(\'#0000FF\')\">\r\n        <INPUT TYPE=\"button\" VALUE=\"pomarańczowy\" ONCLICK=\"changeBackground(\'#FF8000\')\"> \r\n        <INPUT TYPE=\"button\" VALUE=\"szary\" ONCLICK=\"changeBackground(\'#c0c0c0\')\">\r\n        <INPUT TYPE=\"button\" VALUE=\"czerwony\" ONCLICK=\"changeBackground(\'#FF0000\')\"> \r\n    </FORM>\r\n</section>', 1),
(2, 'artukuly', '<section class=\"intro\">\r\n    <h2>Kronika historii kosmonautyki</h2>\r\n    <p>Od pierwszego satelity po współczesne misje - poznaj kluczowe momenty eksploracji kosmosu</p>\r\n</section>\r\n\r\n<article>\r\n    <div class=\"article-date\">4 października 1957</div>\r\n    <h3>Sputnik 1 - Początek ery kosmicznej</h3>\r\n    <p>4 października 1957 roku Związek Radziecki wyniósł na orbitę pierwszego sztucznego satelitę Ziemi. Sputnik 1 to niewielkie urządzenie, ważące zaledwie 83,6 kg i mierzące 58 cm średnicy, zrewolucjonizowało ludzką historię. Sputnik krążył wokół Ziemi wysyłając charakterystyczny sygnał radiowy, który mógł być odbierany przez radioamatorów na całym świecie.</p>\r\n    <p>Start Sputnika zapoczątkował wyścig kosmiczny między Stanami Zjednoczonymi a Związkiem Radzieckim. Wydarzenie to wywołało szok w USA, gdzie uznano, że Ameryka straciła przewagę technologiczną. W odpowiedzi prezydent Eisenhower utworzył NASA (National Aeronautics and Space Administration) w 1958 roku, co było bezpośrednią reakcją na sukces radzieckiego programu kosmicznego.</p>\r\n    <p>Misja Sputnika 1 trwała zaledwie 22 dni, po czym wyczerpały się baterie satelity. Sam satelita pozostał na orbicie przez trzy miesiące, po czym spłonął w atmosferze. Mimo krótkiego czasu działania, Sputnik na zawsze zmienił bieg historii, otwierając przed ludzkością nową erę eksploracji kosmosu.</p>\r\n</article>\r\n\r\n<article>\r\n    <div class=\"article-date\">12 kwietnia 1961</div>\r\n    <h3>Jurij Aleksiejewicz Gagarin - Pierwszy człowiek w kosmosie</h3>\r\n    <p>12 kwietnia 1961 roku radziecki kosmonauta Jurij Gagarin stał się pierwszym człowiekiem w historii, który odbył lot w przestrzeń kosmiczną. Na pokładzie statku Wostok 1 Gagarin wykonał jeden pełny okrążenie wokół Ziemi w ciągu 108 minut. Start nastąpił z kosmodromu Bajkonur w Kazachstanie, a słynne słowa Gagarina przed startem \"Pojechali!\" przeszły do historii.</p>\r\n    <p>Lot Gagarina był niesamowitym osiągnięciem technicznym i odważnym przedsięwzięciem. W tamtym czasie niewiele było wiadomo o wpływie stanu nieważkości na organizm człowieka, a samo lądowanie było niezwykle ryzykowne. Gagarin katapultował się z kapsuły na wysokości około 7000 metrów i wylądował na spadochronie, podczas gdy kapsuła osobno opadła na ziemię.</p>\r\n    <p>Po powrocie na Ziemię Gagarin został bohaterem narodowym i symbolem radzieckiego sukcesu technologicznego. Jego lot zainspirował miliony ludzi na całym świecie i pokazał, że człowiek może przetrwać w kosmosie. Niestety, Gagarin zginął w katastrofie samolotu w 1968 roku podczas rutynowego lotu treningowego, mając zaledwie 34 lata.</p>\r\n</article>\r\n\r\n<article>\r\n    <div class=\"article-date\">20 lipca 1969</div>\r\n    <h3>Apollo 11 - Lądowanie na Księżycu</h3>\r\n    <p>20 lipca 1969 roku amerykańscy astronauci Neil Armstrong i Edwin \"Buzz\" Aldrin jako pierwsi ludzie w historii wylądowali na Księżycu w ramach misji Apollo 11. Armstrong, jako pierwszy człowiek, który postawił stopę na powierzchni Księżyca, wypowiedział słynne słowa: \"To mały krok dla człowieka, ale wielki skok dla ludzkości.\"</p>\r\n    <p>Misja Apollo 11 była kulminacją amerykańskiego programu Apollo, który miał na celu spełnienie obietnicy prezydenta Johna F. Kennedyego z 1961 roku, że Ameryka wyśle człowieka na Księżyc przed końcem dekady. Program ten był odpowiedzią na radzieckie sukcesy w wyścigu kosmicznym i wymagał ogromnych nakładów finansowych. Szacuje się, że cały program Apollo kosztował około 25 miliardów dolarów (w wartości z lat 60.).</p>\r\n    <p>Armstrong i Aldrin spędzili na powierzchni Księżyca około 21 godzin, w tym 2,5 godziny poza modułem księżycowym, zbierając próbki skał i wykonując eksperymenty naukowe. Trzeci członek załogi, Michael Collins, pozostał na orbicie księżycowej w module dowodzenia. Misja Apollo 11 zakończyła się sukcesem, wszyscy trzej astronauci bezpiecznie wrócili na Ziemię 24 lipca 1969 roku.</p>\r\n</article>\r\n\r\n<article>\r\n    <div class=\"article-date\">19 kwietnia 1971</div>\r\n    <h3>Salut 1 - Pierwsza stacja kosmiczna</h3>\r\n    <p>19 kwietnia 1971 roku Związek Radziecki wynióst na orbitę Salut 1, czyli pierwszą załogową stację kosmiczną w historii. Stacja była długa na 13 metrów i miała maksymalną średnicę 4 metry. Jej budowa była odpowiedzią na amerykański program księżycowy i miała zademonstrować możliwości długotrwałego przebywania człowieka w przestrzeni kosmicznej.</p>\r\n    <p>Pierwsza załoga, która próbowała dotrzeć do stacji (Sojuz 10), nie zdołała pomyślnie zadokować. Dopiero druga załoga (Sojuz 11) w składzie Gieorgij Dobrowolski, Władysław Wołkow i Wiktor Pacajew, która dotarła na stację 7 czerwca 1971 roku, zdołała pomyślnie przeprowadzić manewry dokowania. Kosmonauci spędzili na stacji 23 dni, ustanawiając nowy rekord czasu przebywania w kosmosie.</p>\r\n    <p>Niestety, misja zakończyła się tragedią. Podczas powrotu na Ziemię doszło do rozszczelnienia kapsuły Sojuz 11, co spowodowało śmierć całej trójki kosmonautów. Była to pierwsza i jedyna do tej pory śmierć ludzi w otwartej przestrzeni kosmicznej. Po tej tragedii wprowadzono obowiązkowe noszenie skafandrów ciśnieniowych podczas startu i lądowania.</p>\r\n</article>\r\n\r\n<article>\r\n    <div class=\"article-date\">20 listopada 1998</div>\r\n    <h3>ISS - Międzynarodowa Stacja Kosmiczna</h3>\r\n    <p>20 listopada 1998 roku rozpoczęto budowę największego obiektu stworzonego przez człowieka w przestrzeni kosmicznej. ISS jest owocem współpracy między pięcioma agencjami kosmicznymi: NASA (USA), Roskosmos (Rosja), ESA (Europa), JAXA (Japonia) i CSA (Kanada).</p>\r\n    <p>Budowa stacji trwała ponad 10 lat i wymagała ponad 40 misji montażowych. Pierwszy stały załoga przybyła na stację 2 listopada 2000 roku. Od tego czasu ISS jest nieustannie zamieszkana. Na pokładzie zawsze przebywa od trzech do siedmiu astronautów z różnych krajów. Stacja krąży wokół Ziemi na wysokości około 400 km, wykonując pełne okrążenie co około 90 minut.</p>\r\n    <p>ISS służy jako laboratorium naukowe, gdzie przeprowadza się eksperymenty niemożliwe do wykonania na Ziemi. Badania prowadzone na stacji dotyczą biologii, fizyki, astronomii, meteorologii i wielu innych dziedzin. Stacja jest także miejscem testowania technologii potrzebnych do przyszłych misji na Marsa. ISS stanowi symbol międzynarodowej współpracy i pokazuje, że nawet w czasach napięć politycznych, ludzkość potrafi wspólnie pracować nad podbojom kosmosu.</p>\r\n</article>', 1),
(3, 'galeria', '<section class=\"intro\">\r\n    <h2>Kolekcja historycznych momentów</h2>\r\n</section>\r\n\r\n<section class=\"gallery\">\r\n    <div class=\"gallery-item\">\r\n        <div class=\"gallery-description\">\r\n            <h3>Sputnik 1 - Pierwszy sztuczny satelita</h3>\r\n        </div>\r\n        <img src=\"img/gallery/sputnik.jpg\">\r\n    </div>\r\n    <div class=\"gallery-item\">\r\n        <div class=\"gallery-description\">\r\n            <h3>Jurij Gagarin - Pierwszy człowiek w kosmosie</h3>\r\n        </div>\r\n        <img src=\"img/gallery/Yuri_Gagarin.jpg\">\r\n    </div>\r\n    <div class=\"gallery-item\">\r\n        <div class=\"gallery-description\">\r\n            <h3>Apollo 11 - Pierwszy człowiek na Księżycu</h3>\r\n        </div>\r\n        <img src=\"img/gallery/Apollo11.jpg\">\r\n    </div>\r\n    <div class=\"gallery-item\">\r\n        <div class=\"gallery-description\">\r\n            <h3>Salut 1 - Pierwsza stacja kosmiczna</h3>\r\n        </div>\r\n        <img src=\"img/gallery/Salyut_1.jpg\">\r\n    </div>\r\n    <div class=\"gallery-item\">\r\n        <div class=\"gallery-description\">\r\n            <h3>ISS - Międzynarodowa stacja kosmiczna</h3>\r\n        </div>\r\n        <img src=\"img/gallery/iss.jpg\">\r\n    </div>\r\n    <div class=\"gallery-item\">\r\n        <div class=\"gallery-description\">\r\n            <h3>Teleskop Hubblea</h3>\r\n        </div>\r\n        <img src=\"img/gallery/hubble.jpeg\">\r\n    </div>\r\n    <div class=\"gallery-item\">\r\n        <div class=\"gallery-description\">\r\n            <h3>Makieta Wostok 1 - pierwszego załogowego statku kosmicznego</h3>\r\n        </div>\r\n        <img src=\"img/gallery/Vostok-1.jpg\">\r\n    </div>\r\n    <div class=\"gallery-item\">\r\n        <div class=\"gallery-description\">\r\n            <h3>Saturn V - rakieta wkorzystywana do misii Apollo</h3>\r\n        </div>\r\n        <img src=\"img/gallery/Apollo_4_Saturn_V.jpg\">\r\n    </div>\r\n    <div class=\"gallery-item\">\r\n        <div class=\"gallery-description\">\r\n            <h3>Proton - rakieta wynoszenia na orbitę\r\n                moduły</h3>\r\n        </div>\r\n        <img src=\"img/gallery/Proton.jpg\">\r\n    </div>\r\n    <div class=\"gallery-item\">\r\n        <div class=\"gallery-description\">\r\n            <h3>Teleskop Jamesa Webba</h3>\r\n        </div>\r\n        <img src=\"img/gallery/James_Webb_Space_Telescope.jpg\">\r\n    </div>\r\n</section>', 1),
(4, 'info', '<section class=\"about-section\">\r\n    <h2>Cel projektu</h2>\r\n    <p>Projekt został stworzony w celu poszerzanie świadomości ludzi na temat lotów kosmicznych oraz ukazanie fascynującej historii podboju kosmosu. Od momentu wyniesienia pierwszego satelity na orbitę, przez pierwsze kroki człowieka na Księżycu, po współczesne misje badawcze</p>\r\n    \r\n    <p>Ta witryna ma na celu przybliżyć wszystkim zainteresowanym najbardziej znaczące momenty w historii lotów kosmicznych oraz pokazać, jak te osiągnięcia wpłynęły na rozwój naszej cywilizacji.</p>\r\n</section>\r\n\r\n<section class=\"about-section\">\r\n    <h2>Co znajdziesz tej stronie?</h2>\r\n    <p>Witryna została stworzona z myślą o wszystkich miłośnikach kosmosu zarówno tych, którzy dopiero zaczynają swoją przygodę z astronautyką, jak i tych, którzy chcą poszerzyć swoją wiedzę o szczegóły poszczególnych misji.</p>\r\n    \r\n    <div class=\"info-grid\">\r\n        <div class=\"info-box\">\r\n            <h3>Artykuły</h3>\r\n            <p>Szczegółowe opisy najważniejszych wydarzeń z historii lotów kosmicznych.</p>\r\n        </div>\r\n        \r\n        <div class=\"info-box\">\r\n            <h3>Galeria</h3>\r\n            <p>Kolekcja historycznych zdjęć przedstawiających kluczowe momenty eksploracji kosmosu wraz z opisami.</p>\r\n        </div>\r\n    </div>\r\n</section>', 1),
(5, 'kontakt', '<section class=\"intro\">\r\n    <h2>Formularz kontaktowy</h2>\r\n    <p>Wypełnij poniższy formularz, a my odpowiemy na Twoje pytania tak szybko, jak to możliwe</p>\r\n</section>\r\n\r\n<section class=\"contact-section\">\r\n    <form class=\"contact-form\" action=\"#\" method=\"post\">\r\n        <div class=\"form-group\">\r\n            <label for=\"name\">Imię i nazwisko:</label>\r\n            <input type=\"text\" id=\"name\" name=\"name\" placeholder=\"Podaj swoje imię i nazwisko\">\r\n            <label for=\"email\">Adres e-mail: </label>\r\n            <input type=\"email\" id=\"email\" name=\"email\" placeholder=\"twoj@email.com\">\r\n            <label for=\"subject\">Temat wiadomości:</label>\r\n            <select id=\"subject\" name=\"subject\">\r\n                <option value=\"\">-- Wybierz temat --</option>\r\n                <option value=\"pytanie\">Pytanie ogólne</option>\r\n                <option value=\"sugestia\">Sugestia dotycząca strony</option>\r\n                <option value=\"blad\">Zgłoszenie błędu</option>\r\n                <option value=\"wspolpraca\">Propozycja współpracy</option>\r\n                <option value=\"inne\">Inne</option>\r\n            </select>\r\n            <label for=\"message\">Twoja wiadomość:</label>\r\n            <textarea id=\"message\" name=\"message\" placeholder=\"Opisz swoją sprawę...\"></textarea>\r\n        </div>\r\n        <div class=\"form-buttons\">\r\n            <button type=\"submit\" class=\"btn-submit\">Wyślij wiadomość</button>\r\n            <button type=\"reset\" class=\"btn-reset\">Wyczyść formularz</button>\r\n        </div>\r\n    </form>\r\n</section>\r\n\r\n<section class=\"contact-info\">\r\n    <h2>Inne sposoby kontaktu</h2>\r\n    <div class=\"contact-grid\">\r\n        <div class=\"contact-box\">\r\n            <h3>E-mail</h3>\r\n            <p><a>kontakt@historiakosmonautyki.pl</a></p>\r\n        </div>\r\n        <div class=\"contact-box\">\r\n            <h3>Social Media</h3>\r\n            <p>Facebook: HistoriaKosmonautyki<br>\r\n            Twitter: @HistoriaKosmos<br>\r\n        </div>\r\n    </div>\r\n</section>', 1),
(6, 'jQuery', '<section>\r\n    <div id=\"animacjaTestowa1\" class=\"test-block\">text++</div>\r\n    <script>\r\n        $(\"#animacjaTestowa1\").on(\"click\", function(){\r\n            $(this).animate({\r\n                width: \"500px\",\r\n                opacity: 0.4,\r\n                fontsize: \"3em\",\r\n                borderwidth: \"10px\"\r\n            }, 1500);\r\n        });\r\n    </script>\r\n    \r\n    <div id=\"animacjaTestowa2\" class=\"test-block\"> Najedź kursorem, a się powiększe</div>\r\n        <script>\r\n            $(\"#animacjaTestowa2\").on({\r\n                \"mouseover\" : function() {\r\n                    $(this).animate({ \r\n                        width: 300\r\n                    }, 800);\r\n                },\r\n                \"mouseout\" : function() {\r\n                    $(this).animate({\r\n                        width: 200\r\n                    }, 800);\r\n                }\r\n            });\r\n        </script>\r\n    \r\n    <div id=\"animacjaTestowa3\" class=\"test-block\"> Klikaj, abym urósł</div>\r\n    <script>\r\n        $(\"#animacjaTestowa3\").on(\"click\", function(){\r\n            if (!$(this).is(\":animated\")) {\r\n                    $(this).animate({ \r\n                    width: \"+=\" + 999,\r\n                    height: \"+=\" + 99,\r\n                    // opacity: \"-=\" + 0.1,\r\n                    duration: 3000\r\n                });\r\n            }\r\n        });\r\n    </script>\r\n</section>', 1),
(7, 'filmy', '<section class=\"intro\">\r\n    <h2>Filmy o historii lotów kosmicznych</h2>\r\n    <p>Poznaj fascynującą historię eksploracji kosmosu poprzez filmy dokumentalne i archiwalne nagrania</p>\r\n</section>\r\n\r\n<section>\r\n    <article>\r\n        <h3>Start Sputnika 1 - Początek ery kosmicznej</h3>\r\n            <iframe width=\"560\" height=\"320\" src=\"https://www.youtube.com/embed/DTDb3eKpPiw\" allowfullscreen>\r\n            </iframe>\r\n        <p>Archiwalne nagrania z historycznego startu pierwszego sztucznego satelity Ziemi w 1957 roku.</p>\r\n    </article>\r\n\r\n    <article>\r\n        <h3>Jurij Gagarin - Pierwszy człowiek w kosmosie</h3>\r\n            <iframe width=\"560\" height=\"320\" src=\"https://www.youtube.com/embed/JGMvpP2gGy8\" allowfullscreen>\r\n            </iframe>\r\n        <p>Nagranie historycznego lotu Jurij Gagarina w 1961 roku.</p>\r\n    </article>\r\n\r\n    <article>\r\n        <h3>Apollo 11 - Lądowanie na Księżycu</h3>\r\n            <iframe width=\"560\" height=\"320\" src=\"https://www.youtube.com/embed/cwZb2mqId0A\" allowfullscreen>\r\n            </iframe>\r\n        <p>Oryginalne nagrania z misji Apollo 11 i pierwszych kroków człowieka na Księżycu w 1969 roku.</p>\r\n    </article>\r\n</section>', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `id` int(11) NOT NULL,
  `tytul` varchar(255) NOT NULL,
  `opis` text DEFAULT NULL,
  `data_utworzenia` datetime DEFAULT current_timestamp(),
  `data_modyfikacji` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `data_wygasniecia` datetime DEFAULT NULL,
  `cena_netto` decimal(10,2) NOT NULL,
  `podatek_vat` decimal(5,2) DEFAULT 23.00,
  `ilosc_magazyn` int(11) DEFAULT 0,
  `status_dostepnosci` int(11) DEFAULT 1,
  `kategoria` int(11) DEFAULT NULL,
  `gabaryt` varchar(50) DEFAULT NULL,
  `zdjecie` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produkty`
--

INSERT INTO `produkty` (`id`, `tytul`, `opis`, `data_utworzenia`, `data_modyfikacji`, `data_wygasniecia`, `cena_netto`, `podatek_vat`, `ilosc_magazyn`, `status_dostepnosci`, `kategoria`, `gabaryt`, `zdjecie`) VALUES
(1, 'Kosmiczny laptop', 'Szybki laptop stylizowany', '2026-01-10 21:59:39', '2026-01-20 18:29:40', '2027-01-01 11:01:00', 2173.00, 67.00, 421, 1, 1, 'tak', 'https://i.etsystatic.com/23416300/r/il/a93942/2533826544/il_1080xN.2533826544_gn5k.jpg'),
(3, 'Szampon kosmiczny', 'Do włosów przetłuszczających się.', '2026-01-10 22:13:42', '2026-01-20 18:27:21', '2026-06-30 00:00:00', 25.00, 23.00, 121, 1, 3, 'nie', 'https://ecsmedia.pl/c/stars-from-the-stars-szampon-oczyszczajacy-do-glowy-400-ml-b-iext127972775.jpg'),
(5, 'Koszula kosmos', 'Odzież kosmiczna', '2026-01-19 20:07:39', '2026-01-20 18:25:28', '2024-01-19 11:11:00', 11.00, 23.00, 100000, 1, 2, 'nie', 'https://a.allegroimg.com/original/110cda/07866abc43a0b6628df7d844b456/MESKI-T-SHIRT-KOSZULKA-RAKIETA-KOSMOS-TSHIRT-PLANETY-XS'),
(6, 'test', 'test', '2026-01-19 21:13:55', '2026-01-20 18:24:02', '2026-01-30 11:11:00', 22.00, 23.00, 0, 1, 17, 'nie', 'https://d8iqbmvu05s9c.cloudfront.net/aiqpo1f3jbzpd0silc6b0qqot9ao'),
(7, 'Rakieta NASA Apollo Saturn V LEGO', 'Rakieta NASA Apollo Saturn-V', '2026-01-19 21:14:27', '2026-01-20 18:24:15', '2026-01-30 11:11:00', 391.00, 23.00, 999, 1, 17, 'nie', 'https://image.ceneostatic.pl/data/products/98831561/i-lego-ideas-92176-rakieta-nasa-apollo-saturn-v.jpg'),
(8, 'Model statku kosmicznego', 'Model statku kosmicznego', '2026-01-20 17:21:45', '2026-01-20 18:19:52', '2027-01-27 11:11:00', 21.33, 23.00, 50, 1, 17, 'nie', 'https://a.allegroimg.com/original/11d972/c5a1a0cb48c697d64f4ed7fc7d6f/1-400-Profesjonalne-prezenty-urodzinowe-Kolekcja-Model-statku-kosmicznego-Model-kosmiczny');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_matka` (`matka`);

--
-- Indeksy dla tabeli `page_list`
--
ALTER TABLE `page_list`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `page_list`
--
ALTER TABLE `page_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
