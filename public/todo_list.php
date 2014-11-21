<?php

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'todo_db');
define('DB_USER', 'todo_user');
define('DB_PASS', 'password');

require_once('../inc/dbconnect.php');

class Todo
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

if(!empty($_POST)){
    $query = $dbc->prepare("INSERT INTO items(content, due_date, priority)
                       VALUES(:content, :due_date, :priority)");

    $query->bindValue(':content', $_POST['newitem'], PDO::PARAM_STR);
    $query->bindValue(':due_date', $_POST['due_date'], PDO::PARAM_STR);
    $query->bindValue(':priority', $_POST['priority'], PDO::PARAM_STR);

    $query->execute();

//$_POST = [];
}


$ListObj = new Todo($query);

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
?>

<html>
<head>
    <title>TODO App</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <?php if (isset($error)):?> <h2><?=$error;?> Please try again.</h2> <?endif;?>

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

    <label for='due_date'>Due date: </label>
    <input name='due_date' id='due_date'>

    <label for='priority'>Priority Level: </label>
    <input name='priority' id='priority'>

    <button>Add Item</button>
</form>

</body>
</html>
