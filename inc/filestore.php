<?php

 class Filestore
 {
     public $filename = '';

     function __construct($filename = '../public/list.txt')
     {
         // Sets $this->filename

       $this->filename = $filename;
    }


     /**
      * Returns array of lines in $this->filename
      */
     function readLines()
     {
        $filesize = filesize($this->filename);

        $contents = [];

        if (file_exists($this->filename) && $filesize > 0) {
          $handle = fopen($this->filename, 'r');
          $contents = trim(fread($handle, $filesize));
          $contents = explode("\n", $contents);

          fclose($handle);
        }

        return $contents;

      }

      //sanitizes input
      public function sanitize_array(){
        foreach ($this->items as $key => $value) {
          //this echos the contents of the whole object. Why?

          $this->items[$key] = htmlspecialchars(strip_tags($value));//Overwrite the value
          //var_dump($value); //clean
        }

        return $this->items;

      }

     /**
      * Writes each element in $array to a new line in $this->filename
      */
     function writeLines()
     {
        $cleanArray = $this->sanitize_array();
        $handle = fopen($this->filename, 'w');
        $string = implode("\n", $cleanArray);
        fwrite($handle, $string);
        fclose($handle);
     }

     /**
      * Reads contents of csv $this->filename, returns an array
      */
     function readCSV()
     {

     }

     /**
      * Writes contents of $array to csv $this->filename
      */
     function writeCSV($array)
     {

     }
 }
