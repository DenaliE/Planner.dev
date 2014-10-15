<?php 
var_dump($_GET);
var_dump($_POST);


?>

<!DOCTYPE html>
<html>
<head>
	<title>TODO List</title>
	<link rel="stylesheet" type="text/css" href="/css/style.css" href="http://fonts.googleapis.com/css?family=Droid+Sans">
</head>
<body>
<h1 id="a">TODO List</h1>
<ol>
	<li>Be happy</li>
	<li>Be calm</li>
	<li>Tame cat</li>
</ol>
<h2>Add item</h2>
<form method="POST" action="/todo_list.php">
<label><input type="text" name="input" id="todo"></input></label>	
<button type="submit">Add item</button>
</form>
</body>
</html>