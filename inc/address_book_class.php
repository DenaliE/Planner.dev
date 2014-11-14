<?php
require_once('../inc/filestore.php');
//named address_data_store.php in curriculum
class AddressBook extends Filestore
{
    public $contents = [];

    function __construct($filename)
    {
          parent::__construct($filename);
          $filename = strtolower($filename);

          return $filename;
   }

    public function sanitize_array($array){
        foreach ($array as $value) {

                $clean_array[] = htmlspecialchars(strip_tags($value));//Overwrite the value

        }


        return $clean_array;

    }


}//closes class

