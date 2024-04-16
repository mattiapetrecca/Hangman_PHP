<?php 
session_start();
$_SESSION["fase"] = 0;
//fix per far iniziare dal giocatore in posizione 0, dato che in load, la pagina aumenta di uno il playerid
$_SESSION['playerid'] = -1;
$_SESSION['round'] = 1;
//Le lettere vengono poi messe come value di degli input HTML per far sì che il render delle stesse sia dinamico
$_SESSION["lettere"] = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
$lista=file("parole.txt", FILE_IGNORE_NEW_LINES);
$_SESSION["target"]=str_split($lista[mt_rand(0,count($lista)-1)]);
$_SESSION["indovinate"]=[$_SESSION["target"][0]];
for($i = 1; $i < count($_SESSION["target"]); $i++){
    $_SESSION["indovinate"][$i]="_";
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurazioni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container w-50 text-center">
        <div class="row">
            <div class="col gy-5">
                <form method="GET" action=game.php>
                    <div class="row">
                        <div class="col">
                            <input class="form-control" type="number" name="roundmax" placeholder="Numero round" min="1" max="5" required>
                        </div>
                        <div class="col">
                            <input class="form-control" type="number" name="playercount" placeholder="Numero giocatori" min="2" max="4" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col gy-3">
                            <input class="w-25 btn btn-primary" type="submit" value="INVIA">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>