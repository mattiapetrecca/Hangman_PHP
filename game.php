<?php session_start(); ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'impiccato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php
    if (isset($_GET["playercount"])) {
        $_SESSION["playercount"] = $_GET["playercount"];
        for ($i = 0; $i < $_SESSION["playercount"]; $i++) {
            $_SESSION["punti"][$i] = 0;
        }
        unset($_GET["playercount"]);
    }
    if (isset($_GET["roundmax"])) {
        $_SESSION["roundmax"] = $_GET["roundmax"];
        unset($_GET["roundmax"]);
    }
    $i = 0;
    $lunghezza = count($_SESSION["target"]);
    //aggiorna il turno basandosi su indici numerici
    if ($_SESSION["playerid"] < $_SESSION["playercount"] - 1) {
        $_SESSION["playerid"]++;
    } else {
        $_SESSION["playerid"] = 0;
    }
    //assegna i punti e fa reroll di una parola
    if (isset($_GET["guess"])) {
        if ($_GET["guess"] != "") {
            if (strtoupper($_GET["guess"]) === implode($_SESSION["target"])) {
                $_SESSION["punti"][$_SESSION["playerid"]]++;
                if ($_SESSION["round"] < $_SESSION["roundmax"]) {
                    $lista = file("parole.txt", FILE_IGNORE_NEW_LINES);
                    $_SESSION["target"] = str_split($lista[rand(0, count($lista) - 1)]);
                    $_SESSION["indovinate"] = [$_SESSION["target"][0]];
                    for ($i = 1; $i < $lunghezza; $i++) {
                        $_SESSION["indovinate"][$i] = "_";
                    }
                }
            } else {
                 $_SESSION["punti"][$_SESSION["playerid"]]--;
            }
            unset($_GET["letter"]);
        }
        unset($_GET["guess"]);
    }
    //controlla che sia stata scelta una lettera e se presente nella parola la inserisce tra le lettere visualizzate
    if (isset($_GET["letter"])) {
        for ($i = 0; $i < $lunghezza; $i++){
            if ($_GET["letter"] === $_SESSION["target"][$i]) {
                $_SESSION["indovinate"][$i] = $_GET["letter"];
            }
        }
        unset($_GET["letter"]);
    }
    ?>    
    <div class="container">
        <div class="row">
            <div class="col">
                <h1><?php
                //visualizza a schermo le lettere
                for ($i = 0; $i < $lunghezza; $i++) {
                    echo $_SESSION["indovinate"][$i]." ";
                }
                ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
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
        </div>
        <div class="row">
            <div class="col">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <?php
                            for ($i = 0; $i < $_SESSION["playercount"]; $i++) {
                                echo "<th>Giocatore ". $i + 1 ."</th>";
                            } 
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php 
                            for ($i = 0; $i < $_SESSION["playercount"]; $i++) {
                                echo "<td>".$_SESSION["punti"][$i]."</td>";
                            }
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>