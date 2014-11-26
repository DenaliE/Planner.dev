<?php

require '../inc/model.class.php';

class Person {
    public $id;
    public $first_name;
    public $last_name;
    public $phone;

    public function insert()
    {
        $query = $this->dbc->prepare("INSERT INTO people(first_name, last_name, phone)
                                      VALUES(:first_name, :last_name, :phone)");

        $query->bindValue(':first_name', $this->first_name, PDO::PARAM_STR);
        $query->bindValue(':last_name', $this->last_name, PDO::PARAM_STR);
        $query->bindValue(':phone', $this->phone_number, PDO::PARAM_STR);

        $query->execute();

    }

}//end of class
