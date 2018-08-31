<?php
include 'Psr4Autoloader.php';


try

{

    $database = new \ReloadProject\ReloadNamespace\DB\Connection();

    $db = $database->openConnection();

    // inserting data into create table using prepare statement to prevent from sql injections

    $stm = $db->prepare("INSERT INTO item (weight) VALUES ( :weight)") ;

    // inserting a record

    $stm->execute(array(':weight' => 20));

    echo "New record created successfully";

}

catch (PDOException $e)

{

    echo "There is some problem in connection: " . $e->getMessage();

}

?>

?>