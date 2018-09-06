<?php


namespace ReloadProject\ReloadNamespace\ReloadClass;

use ReloadProject\ReloadNamespace\DB\Connection;
use ReloadProject\ReloadNamespace\DB\Status_Changer;

class Reload
{

    // Load all stuff to lorries and plane
    public function loadStock()
    {
        $i = 1;
        while ($stock_to_load_all = $this->stockToLoad()) {
            echo "<b>Lorry number $i</b><br>List of parcels to load: ";
            $this->loadLorry();
            $i++;
        }
        echo "<hr>";
        $i = 1;
        while ($stock_to_load_all = $this->stockToLoadPlane()) {
            echo "<b>Plane number $i</b><br>List of machinery to load: ";
            $this->loadPlane();
            $i++;
        }
    }

    // Load Lorry
    public function loadLorry()
    {
        $stock_to_load_all = $this->stockToLoad();
        $index_first_parcel = $stock_to_load_all[0]["item_id"];
        $cumulativeWeight = $this->cumulativeWeight($stock_to_load_all);
        $index_last_parcel = $this->searchParcelIndex($cumulativeWeight);
        $change_status = new Status_Changer();
        $this->printList("item", $index_first_parcel, $index_last_parcel);
        $change_status->changeStatus("item", $index_first_parcel, $index_last_parcel);
    }

    //Load Airplane
    public function loadPlane()
    {
        $stock_to_load_all = $this->stockToLoadPlane();
        $index_first_parcel = $stock_to_load_all[0]["item_id"];
        $cumulativeWeight = $this->cumulativeWeight($stock_to_load_all);
        $index_last_parcel = $this->searchParcelIndexPlane($cumulativeWeight);
        $change_status = new Status_Changer();
        $this->printList("item_heavy", $index_first_parcel, $index_last_parcel);
        $change_status->changeStatus("item_heavy", $index_first_parcel, $index_last_parcel);
    }


    // Select all parcels to load on Lorry.
    public function stockToLoad()
    {
        try {
            $database = new Connection();
            $db = $database->openConnection();
            $sql = "SELECT * FROM  item WHERE status=1";
            $rows = $db->prepare($sql);
            $rows->execute();
            $database->closeConnection();
            $result = $rows->fetchAll();
            if (empty($result)) {
                echo "No parcels to load! Stock cleared!";
            } else {
                return $result;
            }

        } catch (\PDOException $e) {
            "There is some problem in connection: " . $e->getMessage();
        }
    }

    // Select all stuff to load airplane
    public function stockToLoadPlane()
    {
        try {
            $database = new Connection();
            $db = $database->openConnection();
            $sql = "SELECT * FROM  item_heavy WHERE status=1";
            $rows = $db->prepare($sql);
            $rows->execute();
            $database->closeConnection();
            $result = $rows->fetchAll();
            if (empty($result)) {
                echo "No agricultural machinery to load! Stock cleared!";
            } else {
                return $result;
            }

        } catch (\PDOException $e) {
            "There is some problem in connection: " . $e->getMessage();
        }
    }

    // Craete table with cumulative sum of stuff weight and status = 1
    public function cumulativeWeight($array)
    {
        $count = count($array);
        $weight_cumulative = 0;
        $array_cumulative = [];

        for ($i = 0; $i < $count; $i++) {
            $weight_cumulative = $weight_cumulative + $array[$i]["weight"];
            $array_cumulative[$array[$i]["item_id"]] = $weight_cumulative;

        }
        return $array_cumulative;
    }

    // Search for the index of the array of parcels filling lorry (200 kg)
    function searchParcelIndex($array)
    {
        foreach ($array as $key => $value) {
            if ($value <= Const_Capacity::LORRY) {
                $last_key = $key;
            }
        }
        return $last_key;
    }

    //  Search for the index of the array of parcels filling airplane (200 kg) 3500 kg
    function searchParcelIndexPlane($array)
    {
        foreach ($array as $key => $value) {
            echo $key;
            if ($value <= Const_Capacity::AIRPLANE) {
                $last_key = $key;
            }
        }
        return $last_key;
    }

    public function printList($table, $index_min, $index_max)
    {
        try {
            $database = new Connection();

            $db = $database->openConnection();

            $sql = "SELECT * FROM `" . $table . "` WHERE `item_id` BETWEEN '" . $index_min . "' AND '" . $index_max . "'";

            $rows = $db->prepare($sql);

            $rows->execute();

            $database->closeConnection();

            $result = $rows->fetchAll();

            $database->closeConnection();

        } catch (\PDOException $e) {

            echo "There is some problem in connection: " . $e->getMessage();

        }

        echo "<pre>";
        print_r($result);
    }


}
