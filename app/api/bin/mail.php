<?php

// Variables accessibles

/*$object = [
    "id" => $row["id"],
    "user_id" => $row["user_id"],
    "email" => $row["email"],
    "token" => $row["token"],
    "start" => new DateTime($row["start"]),
    "endAfter15s" => new DateTime($row["endAfter15s"]),
    "endAfter75s" => new DateTime($row["endAfter75s"])

 $hr_ret_15s
 $hr_start
 $hr_rest_75s
 $ruffier_result
];*/

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
</head>
<body>

<p>
    Mon super email avec mes variables accessible ici
</p>
<p>
    Votre Résultat du <?php echo $object["start"]->format("Y-m-d H:i:s"); ?> est le suivant
</p>
<ul>
    <li>Premier HR : <?php echo $hr_start; ?></li>
    <li>Deuxième HR : <?php echo $hr_rest_15s; ?></li>
    <li>Troisième HR : <?php echo $hr_rest_75s; ?></li>
    <li>Score Ruffier : <?php echo $ruffier_result; ?></li>
</ul>

<p>
    Bye.
</p>
</body>