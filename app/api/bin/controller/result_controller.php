<?php

namespace controller;


use lib\Controller;
use form\SelectResultForm;
use form\InsertResultForm;
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


        $form = new InsertResultForm();
        $form->build();

        if($form->isValid($this)) {

            $query = "INSERT INTO results (id_user_fitbit,thedate,first_hr,second_hr,third_hr) 
                      VALUES (:id_user_fitbit,:thedate,:first_hr,:second_hr,:third_hr);";

            $stmt = $this->getDb()->prepare($query);
            $stmt->execute($form->getValues());

            $result = $form->getValues();

            $result["affected_rows"] = $stmt->rowCount();
            
        } else {
            $result = $form->getErrors();
        }
        

        return $result;
    }


    public function  selectResult() {

        $form = new SelectResultForm();
        $form->build();

        if($form->isValid($this)) {
            $query = "SELECT * FROM results WHERE id_user_fitbit = :id_user_fitbit;";
            $stmt = $this->getDb()->prepare($query);
            $stmt->execute($form->getValues());

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $results = $form->getErrors();
        }


       
        return $results;

    }
}