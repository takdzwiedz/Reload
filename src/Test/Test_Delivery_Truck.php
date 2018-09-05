<?php


namespace ReloadProject\ReloadNamespace\Test;

use ReloadProject\ReloadNamespace\DB\Connection;

class Test_Delivery_Truck

{
    public $box_quantity;

    public $box_row;

    public $array_of_boxes;

    public function randTestDeliveryQuantity ()
    {
        $box_quantity = rand(5,40);

        return $box_quantity;

    }

    public function randTestDeliveryBoxWeight()
    {

        try

        {

            $database = new Connection();
            $arrival_date = time();
            $status = "1";

            $db = $database->openConnection();

            for ($i = 0; $i < $this->randTestDeliveryQuantity(); $i++)
            {

                $weight = rand(10,20);

                $sql = "INSERT INTO item (weight, arrival_date, status) VALUES ( :weight, :arrival_date, :status)";

                $stm = $db->prepare($sql) ;

                $stm->execute(array(
                    ':weight' => $weight,
                    ':arrival_date' => $arrival_date,
                    ':status' => $status
                ));

            }

            $database->closeConnection();

        }

        catch (PDOException $e)

        {

            echo "There is some problem in connection: " . $e->getMessage();

        }

    }

}

