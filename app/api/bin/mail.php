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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width"/>

    <!-- For development, pass document through inliner -->
    <!-- <link rel="stylesheet" href="../../styles/simple.css"> -->

    <style type="text/css">

    /* Your custom styles go here */

    </style>
</head>
<body>
<table style="width: 100% !important;
                height: 100%;
                background: #efefef;
                -webkit-font-smoothing: antialiased;
                -webkit-text-size-adjust: none;">
    <tr>
        <td style="display: block !important;
                     clear: both !important;
                     margin: 0 auto !important;
                     max-width: 580px !important;">

            <!-- Message start -->
            <table style="width: 100% !important;
                              border-collapse: collapse;">
                <tr>
                    <td align="center" style="padding: 80px 0;
                                                  background: #337ab7;
                                                  color: white;">

                        <h1 style="font-size: 32px;  margin: 0 auto !important;
                                                          max-width: 90%;
                                                          text-transform: uppercase;">Dawin & Fitbit</h1>

                    </td>
                </tr>
                <tr>
                    <td style="background: white;
                                   padding: 30px 35px;">

                        <h2 style="font-size: 28px;">Bonjour,</h2>

                        <p style="font-size: 16px;
                                    font-weight: normal;
                                    margin-bottom: 20px;">Merci d'avoir passé le test de Ruffier sur notre site.<br>
                        Pour votre test passé le <?php echo $object["start"]->format("Y-m-d H:i:s"); ?> , votre résultat est :
                      </p>
                      <ul style="font-size: 16px;
                                   font-weight: normal;
                                   margin-bottom: 20px;">
                        <li>Premier HR : <?php echo $hr_start; ?></li>
                        <li>Deuxième HR : <?php echo $hr_rest_15s; ?></li>
                        <li>Troisième HR : <?php echo $hr_rest_75s; ?></li>
                        <li>Score Ruffier : <?php echo $ruffier_result; ?></li>
                      </ul>

                      <p style="font-size: 16px;
                                  font-weight: normal;
                                  margin-bottom: 20px;"> Rappel sur les résultats au test de Ruffier (pour un adulte) : </p>

                      <ul style="font-size: 16px;
                                   font-weight: normal;
                                   margin-bottom: 20px;">
                        <li>Indice compris entre 0 et 5 : très bon</li>
                        <li>Indice compris entre 5 et 10 : bon</li>
                        <li>Indice compris entre 10 et 15 : moyen</li>
                        <li>Indice compris entre 15 et 20 : faible (N'hésitez pas à aller voir un profesisonnel de santé)</li>
                      </ul>

                      <p style="font-size: 16px;
                                  font-weight: normal;
                                  margin-bottom: 20px;">En vous souhaitant une très bonne journée</p>

                      <p style="font-size: 16px;
                                  font-weight: normal;
                                  margin-bottom: 20px;"><em>– L'équipe Dawin & Fitbit</em></p>

                        <table>
                            <tr>
                                <td align="center">
                                    <p style = "font-size: 16px;
                                                 font-weight: normal;
                                                 margin-bottom: 20px;">
                                        <a href="https://dawin.sylvainmetayer.fr" style="display: inline-block;
                                                                                           color: white;
                                                                                           background: #337ab7;
                                                                                           border: solid #337ab7;
                                                                                           border-width: 10px 20px 8px;
                                                                                           font-weight: bold;"> Se rendre sur notre site</a>
                                    </p>
                                </td>
                            </tr>
                        </table>



                    </td>
                </tr>
            </table>

        </td>
    </tr>
    <tr>
        <td class="container">

            <!-- Message start -->
            <table style="width: 100% !important;
                              border-collapse: collapse;">
                <tr>
                    <td style="background: none;" align="center">
                        <p style="margin-bottom: 0;
                                          color: #888;
                                          text-align: center;
                                          font-size: 14px;">Envoyé par <a href="#" style=" color: #888;
                                                                                                  text-decoration: none;
                                                                                                  font-weight: bold;"> Dawin & Fitbit</a>, Départemet Informatique, IUT de Bordeaux, Rue du Naudet, 33170, Gradignan</p>

                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</body>
</html>
