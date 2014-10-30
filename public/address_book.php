<?php 

if ($_POST) {
	var_dump($_POST);
	//var_dump("phone");
	//var_dump($_POST['phone']);
}

// Create a function to store a new entry. 
// A new entry should have/validate 5 required fields: name, address, city, state, and zip. 
// Display error if each is not filled out.


//change to $addressBook to fopen('address_book.csv', 'a');
$filename = 'address_book.csv';

$handle = fopen($filename, 'r');

$addressBook = [];

while(!feof($handle)) {
    $row = fgetcsv($handle);

    if (!empty($row)) {
        $addressBook[] = $row;
    }
}

fclose($handle);

//check input
if (!empty($_POST)) {
  if (empty($_POST['name']) || empty($_POST['phone']) || empty($_POST['address']) || empty($_POST['city']) || empty($_POST['state']) || empty($_POST['zip'])) {

	$error = "Please enter all fields.";
	var_dump($error);
	
	} // if validation

	else {
		
		if (isset($_POST['name'])){
			$newEntry['name'] = $_POST['name'];
			
		}

		if (isset($_POST['phone'])){
			$newEntry['phone'] = $_POST['phone'];
			
		}

		if (isset($_POST['address'])){
			$newEntry['address'] = $_POST['address'];
			
		}

		if (isset($_POST['city'])){
			$newEntry['city'] = $_POST['city'];
			
		}

		if (isset($_POST['state'])){
			$newEntry['state'] = $_POST['state'];
			
		}
		if (isset($_POST['zip'])){
			$newEntry['zip'] = $_POST['zip'];
			
		}

		var_dump($addressBook);

		$addressBook[] = $newEntry;

		//write to csv file
		$handle = fopen('address_book.csv', 'w');
		foreach ($addressBook as $row) {
		    fputcsv($handle, $row);
		}// foreach

//redirect to keep browser from offering to resubmit form
//add output buffer
//header("Location: http://planner.dev/address_book.php");

	} // elseif 
}// if post not empty
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
		<th>Phone</th>
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
	
	<input id="name" name="name" >
	<input id="phone" name="phone"  >
	<input id="address" name="address" >
	<input id="city" name="city" >
	<input id="state" name="state" >
	<input id="zip" name="zip" >
	
	<button class="btn">Add</button>
</form>
</body>
</html>