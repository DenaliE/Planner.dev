<?php
 
// Initialize your array by calling your function to open file.
 
$items = open();


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

    //check for test file
    if ($_FILES['file1']['type'] == 'text/plain'){
    $newItems = open($savedFilename);
	$items = array_merge($items, $newItems);
	save($items);
 	}
}

// Check if we saved a file
if (isset($savedFilename)) {
    // If we did, show a link to the uploaded file
    echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
}





// Define a function which will open your default filename, and return an array of items.

function open($filename = 'list.txt'){

	if (file_exists($filename) && (filesize($filename)) > 0){
		$filesize = filesize($filename);
		$handle = fopen($filename, 'r');
		$contents = trim(fread($handle, $filesize));
		$contentArray = explode("\n", $contents);

		fclose($handle);
	}

	else {
		$contentArray = [];
	}

	return $contentArray;

}

//sanitizes input
function sanitize($array){
	foreach ($array as $key => $value) {
		//echo $value; dirty
		$array[$key] = htmlspecialchars(strip_tags($value));//Overwrite the value
		//echo $value; clean
	}
	
	return $array;
	
}
 
/* This function accepts a filename, and returns an array of list items. */
 
// Define a function which will save your list to file.

function save($array, $filename = 'list.txt'){
	//var_dump($array);
	//sanitize($array);
	//var_dump($array);
	$array = sanitize($array);
	$handle = fopen($filename, 'w');
	$string = implode("\n", $array);
	fwrite($handle, $string);
	fclose($handle);
}
 
/* This function accepts an array, saves it to file, and returns nothing. */
 


// Check for GET Requests
    // If there is a get request; remove the appropriate item.
if (isset($_GET['id'])){
	$id = $_GET['id'];
	$items = array_values($items);
	unset($items[$id]);

	save($items);
}
 
// Check for POST Requests
    // If there is a post request; add the items.
//$_POST['nameOfInput']
if (isset($_POST['newitem'])) {
	//Assign newitem from the form the $itemToAdd.
	$itemToAdd = $_POST['newitem'];
	//Array push that new item onto the existing list.
	//alternate way to do array push
	$items[] = $itemToAdd;
	// Save the whole list to file.
	save($items);
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

<? foreach ($items as $key => $item): ?>
	<li>
		<a href="?id=<?=$key?>">X</a>
		<?= htmlspecialchars(strip_tags($item)); ?>
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