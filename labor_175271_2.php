<?php

$nr_indeksu = "175271";
$nrGrupy = '2';
echo 'Łukasz Malinowski '."$nr_indeksu".' grupa '."$nrGrupy".' <br /><br />';
echo 'Zastosowanie metody include() <br />';

include 'plikTest1.php';

echo "Owoc: $color $fruit <br />";

echo "Zastosowanie metody require_once() <br />";

require_once 'plikTest1.php';
echo 'Działa :) <br />';

echo "Zastosowanie if/else i switch:<br />";

$x = 5;
$y = 5;

if ($x < $y) {
    echo "$x < $y <br />";
} elseif ($x > $y) {
    echo "$x > $y <br />";
} else {
    echo "$x = $y <br />";
}

$n = 12;

switch ($n) {
    case 0:
        echo "n = 0";
        break;
    case 1:
        echo "n = 1";
        break;
    case 2:
        echo "n = 2";
        break;
    default:
    echo "n != 0/1/2";
    break;
}

echo "Zastosowanie pętli while, for: <br />";

$i = 0;
while ($i < 6) {
    for($j = 0; $j < 6; $j++){
        echo "$i, $j";
    }
    $i++;
}
echo "<br/>";

echo 'Zastosowanie zmiennych $_GET, $_POST, $_SESSION: <br />';


echo 'Hello ' . htmlspecialchars($_GET["name"]) . '!';
// echo 'Hello ' . htmlspecialchars($_POST["name"]) . '!';
$_SESSION["favcolor"] = "green";
echo "Session variables are set.";
?>