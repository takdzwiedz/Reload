<?php
include 'Psr4Autoloader.php';

?>

<!DOCTYPE html>
<html>

<head>

    <title>Reload</title>

</head>

<body>
    <form method="post">
        <input name="Test_Delivery_Truck" type="submit" value="Test Delivery Truck" title="Test, random stock load by random quantity of parcels from between 5 and 40 parcels of the weight from between 10 and 20 kg each.">
        <input name="Test_Delivery_Truck_Heavy" type="submit" value="Test Delivery Truck Heavy" title=>
        <hr>
        <input name="Reload" type="submit" value="Reload">
    </form>


</body>


</html>

<?php
if (isset($_POST['Test_Delivery_Truck']))
{

    $test = new \ReloadProject\ReloadNamespace\Test\Test_Delivery_Truck();
    $test->randTestDeliveryBoxWeight();
}

if (isset($_POST['Test_Delivery_Truck_Heavy']))
{

    $test = new \ReloadProject\ReloadNamespace\Test\Test_Delivery_Truck_Heavy();
    $test->insertHeavyItems();
}

if (isset($_POST['Reload']))
{

    $test2 = new \ReloadProject\ReloadNamespace\ReloadClass\Reload();
    $test2->loadStock();
}

?>