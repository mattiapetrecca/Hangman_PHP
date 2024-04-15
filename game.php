<?php session_start(); 
$presente = false;
$lunghezza = count($_SESSION["target"]);
$ultimaLettera = array_key_last($_SESSION["lettere"]);
function reroll()  {
    if ($_SESSION["round"] < $_SESSION["roundmax"]) {
        //Si, fare un ciclo di immissione con gli ASCII sarebbe stato più veloce e semplice, ma deve essere comprensibile anche agli altri :)
        $_SESSION["lettere"] = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
        $_SESSION["fase"] = 0;
        $lista = file("parole.txt", FILE_IGNORE_NEW_LINES);
        $_SESSION["target"] = str_split($lista[mt_rand(0, count($lista) - 1)]);
        $lunghezza = count($_SESSION["target"]);
        $_SESSION["indovinate"][0] = $_SESSION["target"][0];
        for($i = 1; $i < $lunghezza; $i++){
            $_SESSION["indovinate"][$i]="_";
        }
        $_SESSION["round"]++;
        header("Refresh:0");
    } else {
        header("location: /risultati.php");
    }
}
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
//assegna i punti e fa reroll di una parola
if (isset($_GET["guess"])) {
    if ($_GET["guess"] != "") {
        if (strtoupper($_GET["guess"]) === implode($_SESSION["target"])) {
            $_SESSION["punti"][$_SESSION["playerid"]]++;
            reroll();
        } else {
             $_SESSION["punti"][$_SESSION["playerid"]]--;
             if ($_SESSION["fase"] === 5) {
                reroll();
             } else {
                $_SESSION["fase"]++;
             }
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
            $presente = true;
        }
    }
    //Se era l'unica lettera mancante per indovinare la parola, aggiunge un punto al giocatore che l'ha premuta e avanza alla prossima parola
    if ($_SESSION["target"] === $_SESSION["indovinate"]) {
        $_SESSION["punti"][$_SESSION["playerid"]]++;
        reroll();
    }
    if (!$presente) {
        if ($_SESSION["fase"] === 5) {
            reroll();
        } else {
            $_SESSION["fase"]++;
        }
    }
    //rimuove la lettere dall'array di lettere in maniera che al prossimo rerender esso non includa la lettera già provata
    unset($_SESSION["lettere"][array_search($_GET["letter"], $_SESSION["lettere"])]);
    unset($_GET["letter"]);
}
//aggiorna il turno basandosi su indici numerici che vanno da 0 al valore impostato su config.php
if ($_SESSION["playerid"] < $_SESSION["playercount"] - 1) {
    $_SESSION["playerid"]++;
} else {
    $_SESSION["playerid"] = 0;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'impiccato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="text-center">
    <div class="container">
        <div class="row">
            <div class="col gy-5">
                <h1><?php
                //visualizza a schermo le lettere già indovinate o un trattino basso se non ancora
                for ($i = 0; $i < $lunghezza; $i++) {
                    echo $_SESSION["indovinate"][$i]." ";
                }
                ?></h1>
            </div>
            <div class="col gy-5">
                <img src=<?php echo "\"img/impiccato".$_SESSION["fase"].".png\""?> alt=<?php echo "\"Errori: ".$_SESSION["fase"]." su 6\""?>>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h2>Tocca al giocatore <?php echo $_SESSION["playerid"]+1?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="#" method="GET">
                    <div class="row">
                        <div class="col gy-3">
                            <?php 
                            //Ciclo di render delle lettere, l'if serve a "tappare" i buchi nell'array dato che rimuovendo le lettere con unset l'array non si ridimensiona dinamicamente e shiftare tutti gli elementi per poi ridimensionarlo andrebbe a impattare sulle performance più di questo semplice if
                            for ($i = 0; $i < $ultimaLettera + 1; $i++) {
                                echo "<script>console.log(\"Indice: ".$i."\")</script>";
                                if (isset($_SESSION["lettere"][$i])) {
                                    echo "<input type=\"submit\" class=\"btn btn-secondary m-1\" name=\"letter\" value=\"".$_SESSION["lettere"][$i]."\">";
                                }
                            }
                            ?>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col gy-3">
                            <input type="text" class="form-control" name="guess" value="" placeholder="Inserire parola..."/>
                        </div>
                        <div class="col gy-3">
                            <input type="submit" class="form-control btn btn-primary" value="INVIA"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table">
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