<?php

require_once('../inc/filestore.php');

class Todo extends Filestore
{
	// Define a function which will open your default filename, and return an array of items.

	public $items = [];


	//sanitizes input
	public function sanitize_array(){
		foreach ($this->items as $key => $value) {
			//this echos the contents of the whole object. Why?

			$this->items[$key] = htmlspecialchars(strip_tags($value));//Overwrite the value
			//var_dump($value); //clean
		}

		return $this->items;

	}

	public function sanitize_string($dirty_string){

		$clean_string = htmlspecialchars(strip_tags($dirty_string));//Overwrite the value

		return $clean_string;

	}


}

// // Initialize your array by calling your function to open file.

$ListObj = new Todo();
$ListObj->items = $ListObj->readLines();
//var_dump($ListObj->items);

// 	// Check if we saved a file
	if (isset($savedFilename)) {
	    // If we did, show a link to the uploaded file
	    echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
	}


// 	// Check for GET Requests
	    // If there is a get request; remove the appropriate item.
	if (isset($_GET['id'])){
		$id = $_GET['id'];
		$ListObj->items = array_values($ListObj->items);
		unset($ListObj->items[$id]);
		$ListObj->writeLines();
	}

	// Check for POST Requests
	    // If there is a post request; add the items.
	//$_POST['nameOfInput']
	if (isset($_POST['newitem'])) {
		//Assign newitem from the form the $itemToAdd.
		$itemToAdd = $_POST['newitem'];
		var_dump($itemToAdd);


		$itemToAdd = $ListObj->sanitize_string($itemToAdd);

		//Array push that new item onto the existing list.
		//alternate way to do array push
		$ListObj->items[] = $itemToAdd;

		// Save the whole list to file.
		$ListObj->writeLines();
	}

	//to upload files, there needs to be a file with content
	// Verify there were uploaded files and no errors
	if (count($_FILES) > 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) {

	    // Set the destination directory for uploads
	    $uploadDir = '/vagrant/sites/planner.dev/public/uploads/';

	    // Grab the filename from the uploaded file by using basename
	    $filename = basename($_FILES['file1']['name']);



	    // Create the saved filename using the file's original name and our upload directory
	    $savedFilename = $uploadDir . $filename;


	    // Move the file from the temp location to our uploads directory
	    move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);

	    //make new object. pass it the user entered $filename
	    $NewListObj = new Todo($filename);

	    //open the object to access the file contents. When it opens, it looks for the file's content (items)
	    //Save the file contents to the object's items.
	    $NewListObj->items = $NewListObj->readLines();


	    //merge the file's items (contents) to the original objects items
	    $ListObj->items = array_merge($ListObj->items, $NewListObj->items);

	    //save it
	    $ListObj->writeLines();

	 }

?>

<html>
<head>
    <title>TODO App</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<h1>Upload File</h1>

    <form method="POST" enctype="multipart/form-data" action="/todo_list.php">
        <p>
            <label for="file1">File to upload: </label>
            <input type="file" id="file1" name="file1">
        </p>
        <p>
            <input type="submit" value="Upload">
        </p>
    </form>
<ol>

<? foreach ($ListObj->items as $key => $item): ?>
	<li>
		<a href="?id=<?=$key?>">X</a>
		<?= $item; ?>
	</li>
<? endforeach ?>

</ol>

<!-- Create a Form to Accept New Items -->

<form method="POST" name='add-form' action="todo_list.php">
	<label for='newitem'>Add a new item: </label>
	<input name='newitem' id='newitem' type='text'>
	<button>Add Item</button>
</form>

</body>
</html>
