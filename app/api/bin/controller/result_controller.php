<?php

namespace controller;


use lib\Controller;
use form\SelectResultForm;
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

    public function insertResult() {
        
        $query = "INSERT INTO results (`id_user_fitbit`,`date`,`first_hr`,`second_hr`,`third_hr`) VALUES (?,?,?,?,?);";

        $id = $this->get("id_user_fitbit");
        $firstHR = $this->get("first_hr");
        $second_hr = $this->get("second_hr");
        $third_hr = $this->get("third_hr");
        $date = $this->get("date");

        $stmt = $this->getDb()->prepare($query);
        $stmt->execute(array($id, $date, $firstHR, $second_hr, $third_hr));
        $affected_rows = $stmt->rowCount();
        return ["affected_rows" => $affected_rows];
    }


    public function  selectResult() {

        $form = new SelectResultForm();
        $form->build();

        if($form->isValid($this)) {
            $query = "SELECT * FROM results WHERE `id_user_fitbit` = :id_user_fitbit ;";
            $stmt = $this->getDb()->prepare($query);
            $stmt->execute($form->getValues());

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $results = $form->getErrors();
        }


       
        return $results;

    }
}