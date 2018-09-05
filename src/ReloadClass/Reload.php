<?php


namespace ReloadProject\ReloadNamespace\ReloadClass;


use ReloadProject\ReloadNamespace\DB\Connection;
use ReloadProject\ReloadNamespace\DB\Status_Changer;

class Reload
{
    private $index;

    private $cumulative_weight = [];

    public function loadLorry()
    {
//        echo $this->searchParcelIndex($this->cumulativeWeight($this->stockToLoad()));

        $stock_to_load_all = $this->stockToLoad();
        $index_first_parcel = $stock_to_load_all[0]["item_id"];
        $index_last_parcel = $this->searchParcelIndex($this->cumulativeWeight($this->stockToLoad()));
//        echo $index_last_parcel;
//        print_r($stock_to_load_all);

        $change_status = new Status_Changer();
        $change_status->changeStatus("item",$index_first_parcel, $index_last_parcel);
    }


    // Pobieram wszystkie paczki do załadunku.
    public function stockToLoad()
    {
        $database = new Connection();
        $db = $database->openConnection();
        $sql = "SELECT * FROM  item WHERE status=1";
        $rows = $db->prepare($sql);
        $rows->execute();
        $database->closeConnection();
        $result = $rows->fetchAll();

        return $result;
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
    public function printList()
    {


    }


}
