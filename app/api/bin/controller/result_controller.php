<?php

namespace controller;


use lib\Controller;
use PDO;

class result_controller extends Controller
{

    public function __construct($post, $db)
    {
        parent::__construct($post, $db);
    }

    public function run($action)
    {
        return $this->$action();
    }

    public function insertResult()
    {
        $id = $this->getPost()["id_user_fitbit"];
        $firstHR = $this->getPost()["first_hr"];
        $second_hr = $this->getPost()["second_hr"];
        $third_hr = $this->getPost()["third_hr"];
        $date = $this->getPost()["date"];

        $query = "INSERT INTO results (`id_user_fitbit`,`date`,`first_hr`,`second_hr`,`third_hr`) VALUES (?,?,?,?,?);";
        var_dump($this->getDb());
        $stmt = $this->getDb()->prepare($query);
        $stmt->execute(array($id, $date, $firstHR, $second_hr, $third_hr));
        $affected_rows = $stmt->rowCount();
        return $affected_rows;
    }
}