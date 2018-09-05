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
        <input name="Test_Delivery_Truck" type="submit" value="Test Delivery Truck">
        <input name="Test_Delivery_Truck_Heavy" type="submit" value="Test Delivery Truck Heavy">
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

$test2 = new \ReloadProject\ReloadNamespace\ReloadClass\Reload();
$test2->loadLorry();

?>