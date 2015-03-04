<?php

//Get new instance of PDO object
$dbc = new PDO('mysql:host=127.0.0.1; dbname=employees', 'codeup', 'password');

//Tell PDO to throw exception on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
