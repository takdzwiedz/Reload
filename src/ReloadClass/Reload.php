<?php


namespace ReloadProject\ReloadNamespace\ReloadClass;

use ReloadProject\ReloadNamespace\DB\Connection;


class Reload
{

    // Load all stuff to lorries and plane
    public function loadStock()
    {
        $load_lorry = new Load_Lorry();
        $i = 1;
        while ($stock_to_load_all = $load_lorry->stockToLoad()) {
            echo "<b>LORRY NUMBER $i</b><br>List of parcels to load: ";
            $load_lorry->loadLorry();
            $i++;
        }
        echo "<hr>";
        $i = 1;
        $load_plane = new Load_Plane();
        while ($stock_to_load_all = $load_plane->stockToLoadPlane()) {
            echo "<b>PLANE NUMBER $i</b><br>List of machinery to load: ";
            $load_plane->loadPlane();
            $i++;
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

        return $result;

    }


}
