<?php

//named address_data_store.php in curriculum
class AddressBook extends Filestore
{

    public $filename = '';
    public $contents = [];

        public function sanitize_array($array){
            foreach ($array as $value) {

                    $clean_array[] = htmlspecialchars(strip_tags($value));//Overwrite the value

            }


            return $clean_array;

        }


}//closes class

