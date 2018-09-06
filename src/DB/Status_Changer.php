<?php


namespace ReloadProject\ReloadNamespace\DB;


// Tu może być destruct i construct

class Status_Changer

{
    public function changeStatus ($table, $index_min, $index_max)
    {

        try
        {
            $database = new Connection();

            $db = $database->openConnection();

            $departure_date = time();

            $sql = "UPDATE `" . $table . "` SET `status` = '0', `departure_date` = " . $departure_date . " WHERE `item_id` BETWEEN '" . $index_min . "' AND '" . $index_max . "'";

            $db->exec($sql);

            $database->closeConnection();
        }
        catch (\PDOException $e)
        {
            echo "There is some problem in connection: " . $e->getMessage();

        }

    }

}