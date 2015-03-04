<?php

require_once('../inc/filestore.php');
require_once('../inc/address_book_class.php');
define('FILE', 'address_book.csv');


// Display error if each is not filled out.

$addressBook = new AddressBook(FILE);

$addressBook->contents = $addressBook->read();

//check input
if (!empty($_POST))
{
	try
	{
	  	if (empty($_POST['name']) || empty($_POST['phone']) || empty($_POST['address']) || empty($_POST['city']) || empty($_POST['state']) || empty($_POST['zip'])) {

			$error = "Please enter all fields.";
			throw new Exception('One or more fields are empty.');
		}
		elseif (strlen($_POST['name']) > 125 || strlen($_POST['phone']) > 125 || strlen($_POST['address']) > 125 || strlen($_POST['city']) > 125 || strlen($_POST['state']) > 125 || strlen($_POST['zip']) > 125){

			throw new Exception('Individual entries cannot be over 125 characters.');
		}
		$newEntry['name']    = $_POST['name'];
		$newEntry['phone']   = $_POST['phone'];
		$newEntry['address'] = $_POST['address'];
		$newEntry['city']    = $_POST['city'];
		$newEntry['state']   = $_POST['state'];
		$newEntry['zip']     = $_POST['zip'];


		$cleanArray = $addressBook->sanitize_array($newEntry);
		$addressBook->contents[] = $cleanArray;
		$addressBook->write($addressBook->contents);
    }
	catch (Exception $e)
	{
		$error = $e->getMessage();
	}

}// if post not empty



if (isset($_GET['id'])){
	$id = $_GET['id'];
    unset($addressBook->contents[$id]);
    //this needs a parameter, but I do I want to rewrite my whole array?
    $addressBook->write($addressBook->contents);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Address Book</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
</head>
<body>
	<?php if (isset($error)):?>
    <h2><?=$error;?> Please try again.</h2>
    <?php endif;?>
<h1>Contacts</h1>
<table class=" table table-bordered table-striped">
	<tr>
		<th>Name</th>
		<th>Phone</th>
		<th>Address</th>
		<th>City</th>
		<th>State</th>
		<th>Zip</th>
		<th>   </th>
	</tr>
		<? if (!is_null($addressBook->contents)) { ?>
			<?  foreach ($addressBook->contents as $key => $address): ?>
			<tr>
					<?foreach ($address as $value): ?>

						<!-- insert each in table row -->
						<td>
							<?=$value?>
						</td>
					<? endforeach; ?>
				<td>
					<a href="?id=<?=$key?>">  x  </a><!-- targets key of each line, second level array-->
				</td>
			</tr>
		<? endforeach; ?>
		<? }; ?>
</table>
<form id = "form" role = "form" class="form-inline" method="POST" action="address_book.php">

	<input id="name" name="name" autofocus>
	<input id="phone" name="phone"  >
	<input id="address" name="address" >
	<input id="city" name="city" >
	<input id="state" name="state" >
	<input id="zip" name="zip" >

	<button class="btn">Add</button>
</form>
</body>
</html>
