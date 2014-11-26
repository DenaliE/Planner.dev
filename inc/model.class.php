<?php

require 'db_connect.php';

class Model {

function __construct($dbc){
    $dbc = $this->dbc;
}//end construct

function abstract insert(){};
function abstract delete(){};
}//end class
