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


if(isset($_GET['id'])){
    $deleted = $dbc->prepare('DELETE FROM items WHERE id = :id');
    $deleted->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $deleted->execute();
}

if(!empty($_POST)){
    $query = $dbc->prepare("INSERT INTO items(content, due_date, priority)
                            VALUES(:content, :due_date, :priority)");

    $query->bindValue(':content', $_POST['newitem'], PDO::PARAM_STR);
    $query->bindValue(':due_date', $_POST['due_date'], PDO::PARAM_STR);
    $query->bindValue(':priority', $_POST['priority'], PDO::PARAM_STR);

    $query->execute();
}

$items = $dbc->query('SELECT * FROM items')->fetchAll(PDO::FETCH_ASSOC);

//if GET['id'] is set delete from table name where id = GET['id']
//if GET['id'] is set delete from table name where content = row number
?>
<html>
<head>
    <title>TODO App</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <?php if (isset($error)):?> <h2><?=$error;?> Please try again.</h2> <?endif;?>

<table>
<? foreach ($items as $item): ?>
    <tr>
        <td>
            <a href="?id=<?=$item['id']?>">X&nbsp;&nbsp;&nbsp;</a>

        </td>
        <td>
		<?= $item['content']; ?>
    </td>
    </tr>
<? endforeach ?>
</table>
<?php /*
<? foreach ($rows as $row): ?>
    <tr>
        <td><?= $row['name']; ?></td>
        <td><?= $row['location']; ?></td>
        <td><?= date('F j, Y', strtotime($row['date_established'])); ?></td>
        <td><?= $row['area_in_acres']; ?></td>
        <td><?= $row['description']; ?></td>
        </tr>
<? endforeach ?>
*/ ?>
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
