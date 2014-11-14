<?php

class Filestore
{
    public $filename = '';

    function __construct($filename)
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

    /**
     * Writes each element in $array to a new line in $this->filename
     */
    function writeLines($cleanArray)
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
        $filesize = filesize($this->filename);

        if (file_exists($this->filename)) {
            $handle = fopen($this->filename, 'r');

            while(!feof($handle)) {
                $row = fgetcsv($handle);

                if (!empty($row)) {
                    $this->contents[] = $row;
                }
            }

            fclose($handle);
            return $this->contents;
        }
    }

    /**
     * Writes contents of $array to csv $this->filename
     */
    function writeCSV($array)
    {
     //write to csv file
     $handle = fopen($this->filename, 'w');
     foreach ($array as $row) {
         fputcsv($handle, $row);
     }// foreach

     fclose($handle);
     return $array;
    }

}
