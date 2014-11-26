<?
require_once '../inc/person.class.php';
require_once '../inc/address.class.php';

if(!empty($_POST)){

    //create a new object to hold the user's values, which pairs with the classes properties
    $address = new Address($dbc);

    //capture user input
    $address->street = $_POST['street'];
    $address->city = $_POST['city'];
    $address->state = $_POST['state'];
    $address->zip = $_POST['zip'];
    $address->people_id = $_GET['id'];

    $address->insert();
}

?>
<html>
<head>
    <title>Add Address</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="css/addressbook_mysql.css">
</head>
<body>
<div class='container'>
    <h1>Add Address to <?= $person->first_name ?> <?= $person->last_name ?></h1>

    <form role='form' method= "POST" action="add_address.php?id=<?=$_GET['id']?>">
        <div class="form-group">
            <label for='street'>Address:</label>
            <input  type='text' class="form-control" id='street' name='street'>
        </div>

        <div class="form-group">
            <label for='city'>City:</label>
            <input  type='text' class="form-control" id='city' name='city'>
        </div>
        <div class="form-group">
            <label for="state">State:</label>
            <select id="state" name="state" class="form-control">
                <option value="AL">AL</option>
                <option value="AK">AK</option>
                <option value="AZ">AZ</option>
                <option value="AR">AR</option>
                <option value="CA">CA</option>
                <option value="CO">CO</option>
                <option value="CT">CT</option>
                <option value="DE">DE</option>
                <option value="DC">DC</option>
                <option value="FL">FL</option>
                <option value="GA">GA</option>
                <option value="HI">HI</option>
                <option value="ID">ID</option>
                <option value="IL">IL</option>
                <option value="IN">IN</option>
                <option value="IA">IA</option>
                <option value="KS">KS</option>
                <option value="KY">KY</option>
                <option value="LA">LA</option>
                <option value="ME">ME</option>
                <option value="MD">MD</option>
                <option value="MA">MA</option>
                <option value="MI">MI</option>
                <option value="MN">MN</option>
                <option value="MS">MS</option>
                <option value="MO">MO</option>
                <option value="MT">MT</option>
                <option value="NE">NE</option>
                <option value="NV">NV</option>
                <option value="NH">NH</option>
                <option value="NJ">NJ</option>
                <option value="NM">NM</option>
                <option value="NY">NY</option>
                <option value="NC">NC</option>
                <option value="ND">ND</option>
                <option value="OH">OH</option>
                <option value="OK">OK</option>
                <option value="OR">OR</option>
                <option value="PA">PA</option>
                <option value="RI">RI</option>
                <option value="SC">SC</option>
                <option value="SD">SD</option>
                <option value="TN">TN</option>
                <option value="TX">TX</option>
                <option value="UT">UT</option>
                <option value="VT">VT</option>
                <option value="VA">VA</option>
                <option value="WA">WA</option>
                <option value="WV">WV</option>
                <option value="WI">WI</option>
                <option value="WY">WY</option>
            </select>
        </div>
        <div class="form-group">
            <label for='zip'>Zip:</label>
            <input type='number' class="form-control" id='zip' name='zip'>
        </div>

        <div class='form-group'>
           <button type='submit' class="btn btn-default">Add</button>
        </div>
    </form>
</div>
</body>
</html>
