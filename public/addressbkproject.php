<?
require_once '../inc/person.class.php';
require_once '../inc/address.class.php';

//adds new person
if(!empty($_POST)){

    //create a new object to hold the user's values, which pairs with the class's properties
    $person = new Person($dbc);

    //capture user input
    $person->first_name = $_POST['first_name'];
    $person->last_name = $_POST['last_name'];
    $person->phone = $_POST['phone'];

    $person->insert();
}

//deletes an adddress
if(isset($_GET['a_id'])){

    //Fetches address
    $address_statement = $dbc->prepare('SELECT * FROM address WHERE id = :id');
    $address_statement->bindValue(':id', $_GET['a_id'], PDO::PARAM_INT);
    $address_statement->execute();

    $address = $address_statement->fetchObject("Address", [$dbc]);

    //deletes
    $address->delete();
}

//deletes a person
if(isset($_GET['id'])){

    //Fetches person from db
    $person_statment = $dbc->prepare('SELECT id, first_name, last_name, phone FROM people WHERE id = :id');
    $person_statment->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $person_statment->execute();

    $person = $person_statment->fetchObject("Person", [$dbc]);

    //deletes
    $person->delete();
}

//fetches all information associated with each person
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

<!-- <link rel="stylesheet" type="text/css" href="css/addressbook_mysql.css"> -->
<style type="text/css">

a {
    float: right;
    margin-left: 5px;
}

button {
    margin-top: 25px;
}
</style>
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
    <!-- Does not display button or comma if all fields weren't entered -->
    <? if (!empty($person['first_name']) ||
           !empty($person['last_name'])  ||
           !empty($person['phone'])):?>
                <td col>
                    <?= $person['first_name'] ?>

                    <?= $person['last_name'] . ', '?>

                    <?= $person['phone'] ?>
                    <a class='btn btn-danger btn-sm' href="?id=<?= $person['id'] ?>">Remove</a>
                    <a class='btn btn-success btn-sm' href="add_address.php?id=<?=$person['id']?>">Add Address</a>
                </td>
    <? endif; ?>

    <!-- Does not display button or commas if all fields weren't entered -->
    <? if (!empty($person['street']) ||
           !empty($person['city'])  ||
           !empty($person['state']) ||
           !empty($person['zip'])):?>
                <td>
                    <?= $person['street'] . ', ' ?>

                    <?= $person['city'] . ', ' ?>

                    <?= $person['state']. ', ' ?>

                    <?= $person['zip'] ?>

                    <!-- Add an edit button that follows the same format -->
    <? endif; ?>
                    <? if ($person['a_id']) :?>
                        <!-- If null, don't display link. -->
                        <a class='btn btn-danger btn-sm' href="?a_id=<?= $person['a_id'] ?>">Remove</a>
                        <a class='btn btn-danger btn-sm' href="edit_address.php?a_id=<?= $person['a_id'] ?>">Edit</a>
                    <? endif; ?>
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
                <input type='text' id='phone_number' name='phone' class="form-control">
            </div>
            <button id='addperson' type='submit' class="btn btn-success">Add Person</button>
        </form>
    </div>
</body>
</html>
