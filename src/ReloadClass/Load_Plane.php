<?php


namespace ReloadProject\ReloadNamespace\ReloadClass;

use ReloadProject\ReloadNamespace\DB\Connection;
use ReloadProject\ReloadNamespace\DB\Status_Changer;

class Load_Plane
{
    //Load Airplane
    public function loadPlane()
    {
        $stock_to_load_all = $this->stockToLoadPlane();
        $index_first_parcel = $stock_to_load_all[0]["item_id"];
        $reload = new Reload();
        $cumulativeWeight = $reload->cumulativeWeight($stock_to_load_all);
        $index_last_parcel = $this->searchParcelIndexPlane($cumulativeWeight);
        $change_status = new Status_Changer();
        $change_status->changeStatus("item_heavy", $index_first_parcel, $index_last_parcel);
        $render_table = new Render_Table();
        $render_table->renderTable($reload->printList("item_heavy", $index_first_parcel, $index_last_parcel));
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
    //  Search for the index of the array of parcels filling airplane (200 kg) 3500 kg
    function searchParcelIndexPlane($array)
    {
        foreach ($array as $key => $value)
        {
            if ($value <= Const_Capacity::AIRPLANE)
            {
                $last_key = $key;
            }
        }
        return $last_key;
    }
}