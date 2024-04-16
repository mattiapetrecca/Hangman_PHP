<?php session_start() ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Risultati</title>
</head>
<body>
    <div class="container text-center">
        <div class="row">
            <div class="col gy-5">
                <h1>RISULTATI</h1>
            </div>
        </div>
        <div class="row">
            <div class="col gy-2">
                <table class="table">
                    <thead>
                        <tr>
                            <?php
                            for ($i = 1; $i <= $_SESSION["playercount"]; $i++) {
                                echo "<th>GIOCATORE ".$i."</th>";
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
        <div class="row">
            <div class="col">
                <a href="config.php"><button class="w-25 btn btn-primary">RIAVVIA</button></a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>