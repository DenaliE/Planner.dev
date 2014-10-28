<?php
 
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


 
/* This function accepts a filename, and returns an array of list items. */
 
// Define a function which will save your list to file.

function save($array, $filename = 'list.txt'){

	$handle = fopen($filename, 'w');
	$string = implode("\n", $array);
	fwrite($handle, $string);
	fclose($handle);
}
 
/* This function accepts an array, saves it to file, and returns nothing. */
 
// Initialize your array by calling your function to open file.
 
$items = open();


// Check for GET Requests
    // If there is a get request; remove the appropriate item.
if (isset($_GET['id'])){
	$id = $_GET['id'];
	unset($items[$id]);
	save($items);
}
 
// Check for POST Requests
    // If there is a post request; add the items.
//$_POST['nameOfInput']
if (isset($_POST['newitem'])) {
	//Assign newitem from the form the $itemToAdd.
	$itemToAdd = $_POST['newitem'];
	var_dump($itemToAdd);
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
</head>
<body>
<ol>
<!-- Echo Out the List Items -->
<?php foreach ($items as $key => $item) {
	echo "<li>"."<a href=\"?id=$key\">X</a>". $item."</li>";
	
}?>
</ol>
 
<!-- Create a Form to Accept New Items -->

<form method="POST" name='add-form' action="todo_list.php">
	<label for='newitem'>Add a new item: </label>
	<input name='newitem' id='newitem' type='text'>
	<button>Add Item</button>
</form>
 
</body>
</html>