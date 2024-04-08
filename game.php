<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'impiccato</title>
</head>
<body>
    <?php
    session_start();
    //inizializza tutte le variabili
    $i = 0;
    $round = $_SESSION["round"];
    $target = $_SESSION["target"];
    $parola = explode("", $target);
    $lunghezza = count($parola);
    $lettera = $_GET["letter"];
    $guess = $_GET["guess"];
    //aggiorna il turno basandosi su indici numerici
    if ($_SESSION["playerid"] < $_SESSION["playercount"] - 1) {
        $_SESSION["playerid"]++;
    } else {
        $_SESSION["playerid"] = 0;
    }
    //assegna i punti e fa reroll di una parola
    if ($guess != "") {
        if ($guess === $target) {
            $_SESSION["punti"][$_SESSION["playerid"]]++;
            if ($round > $_SESSION["curr_round"]) {

                $parole = file("parole.txt");
                $_SESSION["target"] = $parole[rand(0, count($parole))];
                $parola = explode("", $_SESSION["target"]);
                $_SESSION["indovinate"] = [$parola[0]];
                for ($i = 1; $i < $lunghezza; $i++) {
                    $_SESSION["indovinate"][$i] = "_";
                }
            }
        } else {
            $_SESSION["punti"][$_SESSION["playerid"]]--;
        }
    }
    //controlla che sia stata scelta una lettera e se presente nella parola la inserisce tra le lettere visualizzate
    if ($lettera != "") {
        for ($i = 0; $i < $lunghezza; $i++){
            if ($lettera === $target[$i]) {
                $_SESSION["indovinate"][$i] = $lettera;
            }
        }
    }
    ?>    
    <div class="container">
        <h1><?php
        //visualizza a schermo le lettere
        echo $parola[0];
        for ($i = 0; $i < $lunghezza; $i++) {
            echo $indovinate[$i];
        }
        ?></h1>
        <form action="#" method="GET">
            <input type="submit" name="letter" value="A">
            <input type="submit" name="letter" value="B">
            <input type="submit" name="letter" value="C">
            <input type="submit" name="letter" value="D">
            <input type="submit" name="letter" value="E">
            <input type="submit" name="letter" value="F">
            <input type="submit" name="letter" value="G">
            <input type="submit" name="letter" value="H">
            <input type="submit" name="letter" value="I">
            <input type="submit" name="letter" value="J">
            <input type="submit" name="letter" value="K">
            <input type="submit" name="letter" value="L">
            <input type="submit" name="letter" value="M">
            <input type="submit" name="letter" value="N">
            <input type="submit" name="letter" value="O">
            <input type="submit" name="letter" value="P">
            <input type="submit" name="letter" value="Q">
            <input type="submit" name="letter" value="R">
            <input type="submit" name="letter" value="S">
            <input type="submit" name="letter" value="T">
            <input type="submit" name="letter" value="U">
            <input type="submit" name="letter" value="V">
            <input type="submit" name="letter" value="W">
            <input type="submit" name="letter" value="X">
            <input type="submit" name="letter" value="Y">
            <input type="submit" name="letter" value="Z">
            <br/>
            <input type="text" name="guess" value="" placeholder="Inserire parola..."/>
            <input type="submit" value="INVIA"/>
        </form>
    </div>
</body>
<?php session_abort() ?>
</html>