<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width"/>
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
                                    margin-bottom: 20px;">Merci d'avoir passe le test de Ruffier sur notre site.<br>
                            Pour votre test passe le <?php echo $object["start"]->format("Y-m-d H:i:s"); ?> , votre
                            resultat est :
                        </p>
                        <ul style="font-size: 16px;
                                   font-weight: normal;
                                   margin-bottom: 20px;">
                            <li>Premier HR : <?php echo $hr_start; ?></li>
                            <li>Deuxieme HR : <?php echo $hr_rest_15s; ?></li>
                            <li>Troisieme HR : <?php echo $hr_rest_75s; ?></li>
                            <li>Score Ruffier : <?php echo $ruffier_result; ?></li>
                        </ul>

                        <p style="font-size: 16px;
                                  font-weight: normal;
                                  margin-bottom: 20px;">
                            Rappel sur les resultats au test de Ruffier (pour un adulte):
                        </p>
                        <ul style="font-size: 16px;
                                   font-weight: normal;
                                   margin-bottom: 20px;">
                            <li>Indice compris entre 0 et 5 : tres bon</li>
                            <li>Indice compris entre 5 et 10 : bon</li>
                            <li>Indice compris entre 10 et 15 : moyen</li>
                            <li>Indice compris entre 15 et 20 : faible (N'hesitez pas a aller voir un professionnel de
                                sante)
                            </li>
                        </ul>
                        <p style="font-size: 16px;
                                  font-weight: normal;
                                  margin-bottom: 20px;">En vous souhaitant une tres bonne journee</p>
                        <p style="font-size: 16px;
                                  font-weight: normal;
                                  margin-bottom: 20px;">L'equipe Dawin & Fitbit</p>
                        <table>
                            <tr>
                                <td align="center">
                                    <p style="font-size: 16px;
                                                 font-weight: normal;
                                                 margin-bottom: 20px;">
                                        <a href="https://dawin.sylvainmetayer.fr" style="display: inline-block;
                                                                                           color: white;
                                                                                           background: #337ab7;
                                                                                           border: solid #337ab7;
                                                                                           border-width: 10px 20px 8px;
                                                                                           font-weight: bold;">Se rendre
                                            sur notre site</a>
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
            <table style="width: 100% !important;
                              border-collapse: collapse;">
                <tr>
                    <td style="background: none;" align="center">
                        <p style="margin-bottom: 0;
                                          color: #888;
                                          text-align: center;
                                          font-size: 14px;">Envoye par <a href="mailto:dev@sylvainmetayer.fr" style=" color: #888;
                                                                                                  text-decoration: none;
                                                                                                  font-weight: bold;">
                                Dawin & Fitbit</a>, Departement Informatique, IUT de Bordeaux, Rue du Naudet, 33170,
                            Gradignan</p>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
