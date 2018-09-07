<?php


namespace ReloadProject\ReloadNamespace\ReloadClass;

use ReloadProject\ReloadNamespace\DB\Connection;
use ReloadProject\ReloadNamespace\DB\Status_Changer;

class Load_Lorry
{
    // Load Lorry
    public function loadLorry()
    {
        $stock_to_load_all = $this->stockToLoad();
        $index_first_parcel = $stock_to_load_all[0]["item_id"];
        $reload = new Reload();
        $cumulativeWeight = $reload->cumulativeWeight($stock_to_load_all);
        $index_last_parcel = $this->searchParcelIndex($cumulativeWeight);
        $change_status = new Status_Changer();
        $change_status->changeStatus("item", $index_first_parcel, $index_last_parcel);
        $render_table = new Render_Table();
        $render_table->renderTable($reload->printList("item", $index_first_parcel, $index_last_parcel));


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
            if (empty($result))
            {
                echo "Well done! Stock clear!";
            } else {
                return $result;
            }

        } catch (\PDOException $e) {
            "There is some problem in connection: " . $e->getMessage();
        }
    }

    // Search for the index of the array of parcels filling lorry (200 kg)
    function searchParcelIndex($array)
    {
        foreach ($array as $key => $value)
        {
            if ($value <= Const_Capacity::LORRY)
            {
                $last_key = $key;
            }
        }
        return $last_key;
    }

}