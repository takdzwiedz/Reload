<?php


namespace ReloadProject\ReloadNamespace\Test;

use ReloadProject\ReloadNamespace\DB\Connection;

class Test_Delivery_Truck_Heavy

{

    public function insertHeavyItems()
    {

        try

        {

            $database = new Connection();
            $arrival_date = time();
            $status = "1";

            $db = $database->openConnection();

            $weight_1 = 1500;

            $sql = "INSERT INTO item_heavy (weight, arrival_date, status) VALUES ( :weight, :arrival_date, :status)";

            $stm = $db->prepare($sql) ;

            $stm->execute(array(
                ':weight' => $weight_1,
                ':arrival_date' => $arrival_date,
                ':status' => $status
            ));

            $weight_2 = 2000;

            $sql = "INSERT INTO item_heavy (weight, arrival_date, status) VALUES ( :weight, :arrival_date, :status)";

            $stm = $db->prepare($sql) ;

            $stm->execute(array(
                ':weight' => $weight_2,
                ':arrival_date' => $arrival_date,
                ':status' => $status
            ));


            $database->closeConnection();

        }

        catch (PDOException $e)

        {

            echo "There is some problem in connection: " . $e->getMessage();

        }

    }

}
