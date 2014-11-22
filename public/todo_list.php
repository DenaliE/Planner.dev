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

//deletes items
if(isset($_GET['id'])){
    $deleted = $dbc->prepare('DELETE FROM items WHERE id = :id');
    $deleted->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $deleted->execute();
}

//after page loads, insert into db
if(!empty($_POST)){
    $query = $dbc->prepare("INSERT INTO items(content, due_date, priority)
                            VALUES(:content, STR_TO_DATE(:due_date, '%m/%d/%Y'), :priority)");

    $query->bindValue(':content', $_POST['newitem'], PDO::PARAM_STR);

    if (!empty($_POST['due_date'])) {
        $query->bindValue(':due_date', $_POST['due_date'], PDO::PARAM_STR);
    } else {
        $query->bindValue(':due_date', null, PDO::PARAM_NULL);
    }

    if (!empty($_POST['priority'])) {
        $query->bindValue(':priority', $_POST['priority'], PDO::PARAM_STR);
    } else {
        $query->bindValue(':priority', null, PDO::PARAM_NULL);
    }

    $query->execute();
}

//pagination. Limit 4 per page.
if(isset($_GET['page']) && $_GET['page'] >= 1){

    $pg = $_GET['page'];

} else {
    $pg = 1;
}

$num = $pg - 1;

$limit = 4;

$offset = $num * $limit;

$prev = $pg - 1;

$next = $pg + 1;

$stmt = $dbc->prepare("SELECT * FROM items LIMIT :limit OFFSET :offset");
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->bindValue('limit', $limit, PDO::PARAM_INT);
$stmt->execute();

$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

//count number of items with mySQL to determine last page
$all_items = $dbc->query("SELECT * FROM items");
$count = $all_items->rowCount();

$last = ceil($count/4);

?>

<html>
<head>
    <title>TODO App</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

    <link rel="stylesheet" type="text/css" href="css/style.css">

    <link rel="stylesheet" href="js/time/jquery-ui.min.css">
    <style type="text/css">
        table {
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- if there is an error, echo it out here -->
    <?php if (isset($error)):?> <h2><?=$error;?> Please try again.</h2> <?endif;?>

    <table class="table table-bordered table-striped">
    <? foreach ($items as $item): ?>
        <tr>
            <td>
                <a href="?id=<?=$item['id']?>">X&nbsp;&nbsp;&nbsp;</a>
            </td>
            <td>
        		<?= $item['content']; ?>
            </td>
            <td>
                <?= date('F j, Y', strtotime($item['due_date'])); ?>
            </td>
            <td>
                <?= $item['priority']; ?>
            </td>
        </tr>
    <? endforeach ?>
    </table>

    <!-- Create a Form to Accept New Items -->

    <form method="POST" name='add-form' action="todo_list.php">

        <label for='newitem'>Add a new item: </label>
    	<input name='newitem' id='newitem' type='text' autofocus>

        <label for='due_date'>Due date: </label>
        <input name='due_date' id='due_date'>

        <label for='priority'>Priority Level: </label>
        <input name='priority' id='priority'>

        <button type="submit">Add Item</button>
    </form>

    <!-- previous shows up on pages greater than one-->
     <? if ($pg > 1) :?>

                <a rel='prev' href="?page=<?= $prev; ?>">
                    <button class ="btn">Previous </button>
                </a>

        <? endif; ?>

         <!-- next does not show up on last page-->

        <? if ($pg < $last) :?>

                 <a rel='next' href="?page=<?= $next; ?>">
                    <button class ="btn">Next</button>
                </a>

        <? endif; ?>

</div>
 <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>


<script type="text/javascript"src="js/time/jquery-ui.js"></script>

<script>
       $(document).ready(

  /* This is the function that will get executed after the DOM is fully loaded */
  function () {
    $("#due_date").datepicker({
        changeYear: true, //this option for allowing user to select from year range
        changeMonth: true,//this option for allowing user to select month
        dateFormat: "mm/dd/yy" // See format options on parseDate
    });
  }
);
</script>

</body>
</html>
