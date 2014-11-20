<?php

require_once('../inc/filestore.php');

class Todo extends Filestore
{
	// Define a function which will open your default filename, and return an array of items.

	public $items = [];

	//sanitizes input
    //ASK HOW THIS WORKS
	public function sanitize_array(){
		foreach ($this->items as $key => $value) {
			//this echos the contents of the whole object. Why?

			$this->items[$key] = $this->sanitize_string($value);//Overwrite the value
		}

		return $this->items;
	}

	public function sanitize_string($dirty_string){
		$clean_string = htmlspecialchars(strip_tags($dirty_string));//Overwrite the value

		return $clean_string;
	}
}

$ListObj = new Todo('uploads/list.txt');
$ListObj->items = $ListObj->read();
// // Initialize your array by calling your function to open file.

// 	// Check for GET Requests
// If there is a get request; remove the appropriate item.
if (isset($_GET['id'])){
	$id = $_GET['id'];
	unset($ListObj->items[$id]);
	$ListObj->items = array_values($ListObj->items);

	//I need a parameter. Do I use items?
	//Shows up as undefined. Why?
	$ListObj->write($ListObj->items);
}

// Check for POST Requests
// If there is a post request; add the items.
if (isset($_POST['newitem'])) {
	//Assign newitem from the form the $itemToAdd.
    $itemToAdd = $_POST['newitem'];

    $itemToAdd = $ListObj->sanitize_string($itemToAdd);

    try
    {

        if (strlen($_POST['newitem'])== 0) {
            throw new Exception('File is empty.');
        }

        if (strlen($_POST['newitem']) > 240){
            throw new Exception('This item cannot be longer than 240 characters.');
        }

      //Array push that new item onto the existing list.
      //alternate way to do array push
      $ListObj->items[] = $itemToAdd;

      // Save the whole list to file.
      //I need a parameter here, but can I use $items?
      $ListObj->write($ListObj->items);
    } catch (Exception $e){
        $error = $e->getMessage();
    }

}

//to upload files, there needs to be a file with content
// Verify there were uploaded files and no errors
if (count($_FILES) > 0 && $_FILES['new_list']['error'] == UPLOAD_ERR_OK) {
    // Set the destination directory for uploads
    $uploadDir = '/vagrant/sites/planner.dev/public/uploads/';

    // Grab the filename from the uploaded file by using basename
    $filename = basename($_FILES['new_list']['name']);

    // Create the saved filename using the file's original name and our upload directory
    $savedFilename = $uploadDir . $filename;

    // Move the file from the temp location to our uploads directory
    move_uploaded_file($_FILES['new_list']['tmp_name'], $savedFilename);
    $new_items = $ListObj->read("uploads/". $filename);
    $ListObj->items = array_merge($ListObj->items, $new_items);
    $ListObj->write($ListObj->items);

}
?>

<html>
<head>
    <title>TODO App</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <?php if (isset($error)):?> <h2><?=$error;?> Please try again.</h2> <?endif;?>

<h1>Upload File</h1>

    <form method="POST" enctype="multipart/form-data" action="/todo_list.php">
        <p>
            <label for="new_list">File to upload: </label>
            <input type="file" id="new_list" name="new_list">
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
	<input name='newitem' id='newitem' type='text' autofocus>
	<button>Add Item</button>
</form>

</body>
</html>
