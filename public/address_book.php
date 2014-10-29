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

//capture input
if (isset($_POST)) {
	
	//Assign newitem from the form the $itemToAdd.
	//make an array from the input
	
	$newArray = $_POST;
	//Array push that new item onto the existing list.
	//alternate way to do array push
	
	
}


//add input array to $addressBook array
	$addressBook[] = $newArray;
// Save the whole list to file.

//write to csv file
$handle = fopen('address_book.csv', 'w');
foreach ($addressBook as $row) {
    fputcsv($handle, $row);
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