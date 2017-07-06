<?php

namespace controller;


use form\AddToCronForm;
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
        $form = new AddToCronForm();
        $form->build();

        if($form->isValid($this)) {

            $result = $form->getValues();

            $date = date_create_from_format("H:i:s", $result['endTime']);
            $result['startTime'] =  date_create_from_format("H:i:s", $result['endTime'])->format("Y-m-d H:i:s");
            $result['endAfter15s'] = $date->add(new \DateInterval('PT15S'))->format("Y-m-d H:i:s");
            $result['endAfter75s'] = $date->add(new \DateInterval('PT75S'))->format("Y-m-d H:i:s");

            unset($result['endTime']);

            $query = "INSERT INTO cron (user_id,email,start,endAfter15s,endAfter75s,token) 
                      VALUES (:userID,:email,:startTime,:endAfter15s,:endAfter75s,:token);";

            $stmt = $this->getDb()->prepare($query);
            $stmt->execute($result);
            $result['affected_rows'] = $stmt->rowCount();

        } else {
            $result = $form->getErrors();
        }
        
        return $result;
    }
}