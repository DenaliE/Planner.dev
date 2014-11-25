<?
require '../inc/db_connect.php';


if(!empty($_POST)){
    var_dump($_POST);


$query = $dbc->prepare("INSERT INTO people(first_name, last_name, phone)
                        VALUES(:first_name, :last_name, :phone)");

$query->bindValue(':first_name', $_POST['first_name'], PDO::PARAM_STR);
$query->bindValue(':last_name', $_POST['last_name'], PDO::PARAM_STR);
$query->bindValue(':phone', $_POST['phone_number'], PDO::PARAM_STR);

$query->execute();
}


if(isset($_GET['a_id'])){
$deleted_address = $dbc->prepare('DELETE FROM address WHERE id = :id');
$deleted_address->bindValue(':id', $_GET['a_id'], PDO::PARAM_INT);
$deleted_address->execute();
}

if(isset($_GET['id'])){

$deleted_address = $dbc->prepare('DELETE FROM address WHERE people_id = :id');
$deleted_address->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
$deleted_address->execute();

$deleted_person = $dbc->prepare('DELETE FROM people WHERE id = :id');
$deleted_person->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
$deleted_person->execute();
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
            <button id='addperson' type='submit' class="btn btn-success">Add</button>
        </form>
    </div>
</body>
</html>
