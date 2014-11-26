<?
require '../inc/person.class.php';
require '../inc/address.class.php';


if(isset($_GET['id'])) {

    $person = $address_statment->fetchObject("Person");
    $address = $query->fetchObject("Address");

}//end if get set

if(!empty($_POST)){
    $person->insert();
}

if(isset($_GET['a_id'])){
    $address->delete();
}

if(isset($_GET['id'])){
    $person->delete();
}

$people_statement = $dbc->query("SELECT people.id, first_name, last_name, phone, address.id
                        AS a_id, address.street, address.state,address.city, address.zip
                        FROM people
                        LEFT JOIN address
                        ON address.people_id = people.id");

$people = $people_statement->fetchAll(PDO::FETCH_ASSOC);
?>

<html>
<head>
    <title>Address Book</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/addressbook_mysql.css">

</head>
<body class='container'>

    <h1>Address Book</h1>

    <table class='table table-bordered'>
            <tr>
                <th>Person</th>
                <th>Address</th>

            </tr>
        <? foreach($people as $person):?>
            <tr>
                <td>
                    <?= $person['first_name'] ?>

                    <?= $person['last_name'] ?>

                    <?= $person['phone'] ?>
                    <a class='btn' href="?id=<?= $person['id'] ?>">Remove</a>
                </td>
                <td>
                    <?= $person['street'] ?>

                    <?= $person['city'] ?>

                    <?= $person['state'] ?>

                    <?= $person['zip'] ?>
                    <a class='btn btn-danger btn-sm' href="add_address.php?id=<?=$person['id']?>">Add</a>
                    <a class='btn' href="?a_id=<?= $person['a_id'] ?>">Remove</a>
                </td>
            </tr>
        <? endforeach ?>
    </table>

    <div class='row'>
        <form role="form" method= "POST" action="addressbkproject.php">
            <div class="form-group col-md-3">
                <label for='first_name'>First Name</label>
                <input type='text' id='first_name' name='first_name' class="form-control">
            </div>

            <div class="form-group col-md-3">
                <label for='last_name'>Last Name</label>
                <input type='text' id='last_name' name='last_name' class="form-control">
            </div>

            <div class="form-group col-md-3">
                <label for='phone_number'>Phone Number</label>
                <input type='text' id='phone_number' name='phone_number' class="form-control">
            </div>
            <button id='addperson' type='submit' class="btn btn-success">Add Person</button>
        </form>
    </div>
</body>
</html>
