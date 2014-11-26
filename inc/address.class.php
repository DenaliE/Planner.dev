<?
require '../inc/modal.class.php';

class Address extends Model{
    $id;
    $street;
    $city;
    $state;
    $zip;
    $people_id;

    public function insert(){
        $query = $this->dbc->prepare("INSERT INTO address(street, city, state, zip)
                                      VALUES(:street, :city, :state, :zip)");

        $query->bindValue(':street', $this->street, PDO::PARAM_STR);
        $query->bindValue(':city', $this->city, PDO::PARAM_STR);
        $query->bindValue(':state', $this->state, PDO::PARAM_STR);
        $query->bindValue(':zip', $this->zip, PDO::PARAM_STR);

        $query->execute();
    }//end insert

    public function delete(){
        $deleted_address = $dbc->prepare('DELETE FROM address WHERE id = :id');
        $deleted_address->bindValue(':id', $_GET['a_id'], PDO::PARAM_INT);
        $deleted_address->execute();
    }//end delete
}//end class
