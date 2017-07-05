<?php

namespace controller;


use lib\Controller;

class email_controller extends Controller
{

    public function __construct($post, $db)
    {
        parent::__construct($post, $db);
    }

    public function run($action)
    {
        return $this->$action();
    }

    public function addToCron()
    {
        $email = $this->get("email");
        $str_startDate = $this->get("startTime");
        $str_endTime = $this->get("endTime");
        $token = $this->get("token");

        $startDate = new \DateTime($str_startDate);
        $endDate = new \DateTime($str_endTime);

        $endDate_plus_15 = new \DateTime();
        $endDate_plus_15->setTimestamp($endDate->getTimestamp() + 15);

        $endDate_plus_75 = new \DateTime();
        $endDate_plus_75->setTimestamp($endDate->getTimestamp() + 75);

        $userId = $this->get("userID");

        $query = "INSERT INTO cron (`user_id`,`email`,`start`,`endAfter15s`,`endAfter75s`,`token`) VALUES (?,?,?,?,?,?);";
        $stmt = $this->getDb()->prepare($query);
        $stmt->execute(array($userId, $email, $startDate->format("Y-m-d H:i:s"), $endDate_plus_15->format("Y-m-d H:i:s"), $endDate_plus_75->format("Y-m-d H:i:s"), $token));
        $affected_rows = $stmt->rowCount();
        return ["affected_rows" => $affected_rows];
    }
}