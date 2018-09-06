<?php


namespace ReloadProject\ReloadNamespace\ReloadClass;


use ReloadProject\ReloadNamespace\DB\Connection;
use ReloadProject\ReloadNamespace\DB\Status_Changer;

class Reload
{
    private $index;

    private $cumulative_weight = [];


    public function loadStock()
    {
        $i = 1;
        while($stock_to_load_all = $this->stockToLoad())
         {
             echo "<b>Lorry number $i</b><br>List of parcels to load: ";
             $this->loadLorry();
             $i++;
         }
    }

    public function loadLorry()
    {
//        echo $this->searchParcelIndex($this->cumulativeWeight($this->stockToLoad()));

        $stock_to_load_all = $this->stockToLoad();
        $index_first_parcel = $stock_to_load_all[0]["item_id"];
        $index_last_parcel = $this->searchParcelIndex($this->cumulativeWeight($this->stockToLoad()));
        $change_status = new Status_Changer();
        $this->printList("item",$index_first_parcel, $index_last_parcel);
        $change_status->changeStatus("item",$index_first_parcel, $index_last_parcel);
    }


    // Pobieram wszystkie paczki do załadunku.
    public function stockToLoad()
    {
        try
        {
            $database = new Connection();
            $db = $database->openConnection();
            $sql = "SELECT * FROM  item WHERE status=1";
            $rows = $db->prepare($sql);
            $rows->execute();
            $database->closeConnection();
            $result = $rows->fetchAll();
            if (empty($result))
            {
                echo "That's all for now! Stock cleared!"; die();
            }  else {
                return $result;
            }

        }
        catch (\PDOException $e)
        {
            "There is some problem in connection: " . $e->getMessage();
        }


    }

    // Tworzę tabelę ze skumulowaną wagą paczek o statusie = 1
    public function cumulativeWeight($array)
    {
        $count =  count($array);
        $weight_cumulative = 0;
        $array_cumulative = [];

        for ($i = 0; $i < $count ; $i++)
        {
            $weight_cumulative =  $weight_cumulative + $array[$i]["weight"];
            $array_cumulative[$array[$i]["item_id"]] = $weight_cumulative;

        }
        return $array_cumulative;
    }

    //Znajduję index ostatniej z grupy paczek dającej łączną wagę nie przekraczającą 200 kg
    function searchParcelIndex($array)
    {
        foreach($array as $key => $value)
        {
            if( $value <= 200)
            {
                $last_key = $key;
            }
        }
        return $last_key;
    }
    public function printList($table, $index_min, $index_max)
    {
        try
        {
            $database = new Connection();

            $db = $database->openConnection();

            $sql = "SELECT * FROM `" . $table . "` WHERE `item_id` BETWEEN '" . $index_min . "' AND '" . $index_max . "'";

            $rows = $db->prepare($sql);

            $rows->execute();

            $database->closeConnection();

            $result = $rows->fetchAll();

            $database->closeConnection();
        }
        catch (\PDOException $e)
        {
            echo "There is some problem in connection: " . $e->getMessage();

        }

        echo"<pre>";
        print_r($result);
    }


}
