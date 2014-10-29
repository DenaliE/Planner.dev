<?php 

if ($_POST) {
	var_dump($_POST);
}

// Create a function to store a new entry. 
// A new entry should have/validate 5 required fields: name, address, city, state, and zip. 
// Display error if each is not filled out.

$addressBook = [
    ['The White House', '1600 Pennsylvania Avenue NW', 'Washington', 'DC', '20500'],
    ['Marvel Comics', 'P.O. Box 1527', 'Long Island City', 'NY', '11101'],
    ['LucasArts', 'P.O. Box 29901', 'San Francisco', 'CA', '94129-0901']
];


if (isset($_POST['name'])) {
	//Assign newitem from the form the $itemToAdd.
	//make an array from the input
	
	$name = $_POST['name'];
	//Array push that new item onto the existing list.
	//alternate way to do array push
	$addressBook[] = $name;
	// Save the whole list to file.
	
}

if (isset($_POST['address'])) {
	//Assign newitem from the form the $itemToAdd.
	//make an array from the input
	
	$address = $_POST['address'];
	//Array push that new item onto the existing list.
	//alternate way to do array push
	$addressBook[] = $address;
	// Save the whole list to file.
	
}

if (isset($_POST['city'])) {
	//Assign newitem from the form the $itemToAdd.
	//make an array from the input
	
	$city = $_POST['city'];
	//Array push that new item onto the existing list.
	//alternate way to do array push
	$addressBook[] = $city;
	// Save the whole list to file.
	
}

if (isset($_POST['state'])) {
	//Assign newitem from the form the $itemToAdd.
	//make an array from the input
	
	$state = $_POST['state'];
	//Array push that new item onto the existing list.
	//alternate way to do array push
	$addressBook[] = $state;
	// Save the whole list to file.
	
}

if (isset($_POST['zip'])) {
	//Assign newitem from the form the $itemToAdd.
	//make an array from the input
	
	$zip = $_POST['zip'];
	//Array push that new item onto the existing list.
	//alternate way to do array push
	$addressBook[] = $zip;
	// Save the whole list to file.
	
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Address Book</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
</head>
<body>
<h1>Contacts</h1>
<table class=" table table-bordered table-striped">
	<tr>
		<th>Name</th>
		<th>Address</th>
		<th>City</th>
		<th>State</th>
		<th>Zip</th>
	</tr>
		
		<?  foreach ($addressBook as $key => $address): ?>
			<tr>	
			<?foreach ($address as $key => $value): ?>
				<!--var_dump($value);-->
				<!-- insert each in table row -->
				<td><?=$value?></td>
			<? endforeach; ?>
			</tr>	
		<? endforeach; ?>
	<!--Make a new row for the new record-->
	<tr>
	<? foreach ($form as $key => $value): ?>
		<td><?=$value?></td>
	<?endforeach;?>
	
		<!-- <td><?=$name?></td>
		<td><?=$address?></td>
		<td><?=$city?></td>
		<td><?=$state?></td>
		<td><?=$zip?></td> -->
	</tr>
			
				
</table>
<form id = "form" role = "form" class="form-inline" method="POST" action="address_book.php">
	
	<input id="name" name="name">
	<input id="address" name="address">
	<input id="city" name="city">
	<input id="state" name="state">
	<input id="zip" name="zip">
	<button class="btn">Add</button>



</form>
</body>
</html>