<?php 
session_start();
$_SESSION['punti'];
$_SESSION['playerid=0'];
$lista=file("parole.txt", FILE_IGNORE_NEW_LINES);
$_SESSION["target"]=str_split($lista[mt_rand(0,count($lista)-1)]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>configurazioni</title>
</head>
<body>
    <form method="GET" action=game.php>
        <input type="number" name="roundmax" required>
        <input type="number" name="playercount" required>
        <input type="submit" value="invia" required>
</form>
</body>
</html>