<?
require_once '../inc/model.class.php';

class Address extends Model {

    public $id;
    public $street;
    public $city;
    public $state;
    public $zip;
    public $people_id;

    public function insert(){
        $query = $this->dbc->prepare("INSERT INTO address(street, city, state, zip, people_id)
                                      VALUES(:street, :city, :state, :zip, :people_id)");

        $query->bindValue(':street', $this->street, PDO::PARAM_STR);
        $query->bindValue(':city', $this->city, PDO::PARAM_STR);
        $query->bindValue(':state', $this->state, PDO::PARAM_STR);
        $query->bindValue(':zip', $this->zip, PDO::PARAM_STR);
        $query->bindValue(':people_id', $this->people_id, PDO::PARAM_INT);

        $query->execute();
    }//end insert

    public function delete(){
        $deleted_address = $this->dbc->prepare('DELETE FROM address WHERE id = :id');
        $deleted_address->bindValue(':id', $this->id, PDO::PARAM_INT);
        $deleted_address->execute();
    }//end delete

    public function edit(){
        $edit_address = $this->dbc->prepare("UPDATE address SET

            WHERE id = :id");


    }//end edit
}//end class
