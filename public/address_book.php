<?php 



class addressBook {

	public $filename = '';
	public $contents = [];

	function __construct($filename = 'address_book.csv')
    {
       $this->filename = $filename; 
    }
	
    public function open_csv() {
    	
    	$filesize = filesize($this->filename);

    	if (file_exists($this->filename) && $filesize > 0){
    			$handle = fopen($this->filename, 'r');

    			while(!feof($handle)) {
    			    $row = fgetcsv($handle);

    			    if (!empty($row)) {
    			        $contents[] = $row;
    			    }
    			}

    			fclose($handle);
    			return $contents;
    		}


    	}
    	
		public function save_csv(){

		//write to csv file
		$handle = fopen($this->filename, 'w');
		foreach ($this->contents as $row) {
		    fputcsv($handle, $row);
		}// foreach

		fclose($handle);


		}
   
}//closes class

if ($_POST) {
	var_dump($_POST);
	//var_dump("phone");
	//var_dump($_POST['phone']);
}

// Display error if each is not filled out.

$addressBook = new addressBook();
$addressBook->contents = $addressBook->open_csv();
var_dump($addressBook->contents);




//rewrite for object
// $handle = fopen($filename, 'r');

// $addressBook = [];

// while(!feof($handle)) {
//     $row = fgetcsv($handle);

//     if (!empty($row)) {
//         $addressBook[] = $row;
//     }//if
// }//while

// fclose($handle);

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
			
		}//else

		var_dump($addressBook);

		$addressBook->contents[] = $newEntry;
		
		$addressBook->save_csv();

//redirect to keep browser from offering to resubmit form
//add output buffer
//header("Location: http://planner.dev/address_book.php");

	} // elseif 
}// if post not empty

if (isset($_GET['id'])){
	$id = $_GET['id'];
	unset($addressBook->contents[$id]);
    
	$addressBook->save_csv();
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
		<th>Phone</th>
		<th>Address</th>
		<th>City</th>
		<th>State</th>
		<th>Zip</th>
		<th>   </th>
	</tr>
		
		<?  foreach ($addressBook->contents as $key => $address): ?>
			<tr>	
					<?foreach ($address as $value): ?>
						<!-- var_dump($address);
						var_dump($value); -->
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