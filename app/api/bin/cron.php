<?php
require __DIR__ . '/../vendor/autoload.php';

$configs = include(__DIR__ . "/../config.inc.php");
$db = new PDO("mysql:host=" . $configs["db_host"] . "; dbname=" . $configs["db_name"], $configs["db_user"], $configs["db_password"],
    array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => $configs["db_debug"], PDO::ERRMODE_EXCEPTION => $configs["db_debug"]));


function getAllCron(PDO $db)
{
    $query = "SELECT * FROM cron;";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$rows = getAllCron($db);
if (count($rows) <= 0) {
    echo "No data to process\n";
    exit(0);
}

// 2 - For each result, check that end time + Xmin is ok
foreach ($rows as $row) {

    $object = [
        "id" => $row["id"],
        "user_id" => $row["user_id"],
        "email" => $row["email"],
        "token" => $row["token"],
        "start" => new DateTime($row["start"]),
        "endAfter15s" => new DateTime($row["endAfter15s"]),
        "endAfter75s" => new DateTime($row["endAfter75s"])
    ];

    $twelve_min_after_test_ended = new DateTime();
    $twelve_min_after_test_ended->setTimestamp($object["endAfter75s"]->getTimestamp() + (60 * $configs["minutes_cron"]));

    $now = new DateTime();
    if (intval($twelve_min_after_test_ended->getTimestamp()) - intval($now->getTimestamp()) > 0) {
        echo "No reach limit yet, do not process it\n<br/>";
    } else {
        echo "Process going on !\n<br/>";
        process_item($object, $configs, $db);
    }
}

function process_item($object, $configs, PDO $db)
{
    $hr_start = query_date($object["start"], $configs, $object["token"]);
    $hr_rest_15s = query_date($object["endAfter15s"], $configs, $object["token"]);
    $hr_rest_75s = query_date($object["endAfter75s"], $configs, $object["token"]);

    $query = "INSERT INTO results (`id_user_fitbit`,`date`,`first_hr`,`second_hr`,`third_hr`) VALUES (?,?,?,?,?);";
    $stmt = $db->prepare($query);
    $stmt->execute(array($object["user_id"], $object["start"]->format("Y-m-d H:i:s"), $hr_start, $hr_rest_15s, $hr_rest_75s));
    $affected_rows = $stmt->rowCount();

    if ($affected_rows != 0) {
        $query = "DELETE FROM cron WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute(array($object["id"]));
        $affected_rows = $stmt->rowCount();

        if ($affected_rows != 0) {
            $ruffier_result = calculRuffier($hr_start, $hr_rest_15s, $hr_rest_75s);
            $mail_content = include("mail.php");
            print_r($mail_content);
            return sendMail($object, $configs, $mail_content);
        }
    }

    echo "Error while process item<br/>\n";
    return false;
}

/**
 * This me
 * @param $object
 * @param $configs
 * @param
 * $mail_content
 * @return bool
 */
function sendMail($object, $configs, $mail_content)
{
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPDebug = $configs["mail_debug"];
    $mail->Debugoutput = 'html';
    $mail->Host = $configs["mail_host"];
    $mail->Port = $configs["mail_port_smtp"];
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = $configs["mail_user"];
    $mail->Password = $configs["mail_password"];
    $mail->setFrom($configs["mail_from"], $configs["mail_from_name"]);
    $mail->addAddress($object["email"]);
    $mail->Subject = 'Vos résultats !';
    $mail->msgHTML($mail_content);
    $mail->AltBody = $mail_content;
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        return false;
    }
    echo "Message sent!";
    return true;
}

function calculRuffier($start, $end, $after_rest)
{
    return (intval($start) + intval($end) + intval($after_rest) - 200) / 10;
}

function query_date(DateTime $date_o, $configs, $token)
{
    list($date, $time) = explode(' ', $date_o->format("Y-m-d H:i:s"));
    list($hour, $min, $sec) = explode(':', $time);

    $hourNext = $hour;
    $minNext = $min + 1;
    if ($minNext >= 60) {
        $hourNext += 1;
        $minNext = 0;
    }

    $hr_url = $configs["api_base_url"] . "1/user/-/activities/heart/date/today/1d/1sec/time/";
    $hr_date_url = $hr_url . $hour . ":" . $min . "/" . $hourNext . ":" . $minNext . ".json";

    $result = json_decode(query($hr_date_url, $token), true);

    $second_objective = intval($min * 60 + $sec);
    $secDiff = 3600;
    $value = "";
    $dataset = $result["activities-heart-intraday"]["dataset"];
    foreach ($dataset as $item) {
        $tmp = explode(":", $item["time"]);
        $tmp_sec = intval($tmp[1]) * 60 + intval($tmp[2]);

        if ($tmp_sec > $second_objective) {
            if ($tmp_sec - $second_objective < $secDiff) {
                $value = $item["time"];
                $secDiff = $tmp_sec - $second_objective;
            }
        } else {
            if ($second_objective - $tmp_sec < $secDiff) {
                $secDiff = $second_objective - $tmp_sec;
                $value = $item["time"];
            }
        }
    }

    $key = array_search($value, array_column($dataset, 'time'));
    return $dataset[$key]["value"];

}

/**
 * Return the result of a query to an URL with an user token
 * @param $url
 * @param $token
 * @return mixed
 */
function query($url, $token)
{
    $cURL = curl_init();

    curl_setopt($cURL, CURLOPT_URL, $url);
    curl_setopt($cURL, CURLOPT_HTTPGET, true);
    curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
        //'Content-Type: application/json',
        //'Accept: application/json',
        'Authorization: ' . 'Bearer ' . $token
    ));

    $result = curl_exec($cURL);
    curl_close($cURL);
    return $result;
}