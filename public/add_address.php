<?
require '../inc/db_connect.php';


class Person {
    public $id;
    public $first_name;
    public $last_name;
    public $phone;

    public function add_address()
    {
        return sprintf('<a href="/add_address.php/%s">%s</a>',$this->id);
    }//end of function

}//end of class

    // $deleted_person = $dbc->prepare('DELETE FROM people WHERE id = :id');
    // $deleted_person->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    // $deleted_person->execute();

if(isset($_GET['id'])) {
    $address_statment = $dbc->prepare('SELECT id, first_name, last_name, phone FROM people WHERE id =:id');
    $address_statment->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $address_statment->execute();

    $result = $address_statment->fetchObject("Person");
    var_dump($result);
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
<body class='container'>

    <h1>Add Address</h1>

        <form role='form' method= "POST" action="add_address.php" id='border' class='img-rounded'>
            <div class = 'row'>
                <div class="form-group">
                    <label class="col-md-5" for='address'>
                        Address:
                        <input  type='text' class="form-control" id='address' name='address'>
                    </label>
                </div>
            </div>

            <div class = 'row'>
                <div class="form-group">
                    <label class="col-md-3" for='city'>
                        City:
                        <input  type='text' class="form-control" id='city' name='city'>
                    </label>
                 <div class="col-lg-1 col-md-1 col-sm-1 col-xs-6">
                    <label>
                        State:
                    </label>
                        <br/>
                            <select name="state" class="form-control">
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
                    <label class="col-md-2" for='zip'>
                        Zip:
                        <input type='number' class="form-control" id='zip' name='zip' >
                    </label>
                </div>
            </div>

            <div class = 'row'>
               <a href="?id=<?/* $result */ ?>" class="btn btn-default">Add Address</a>

        </form>
    </div>
</body>
</html>
