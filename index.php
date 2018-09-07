<?php
include 'Psr4Autoloader.php';

?>

<!DOCTYPE html>
<html>

<head>

    <title>Reload</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>


    <script>
        $(document).ready( function () {
            $('table.display').DataTable();
        } );
    </script>


</head>

<body>
    <form method="post">
        <input name="Test_Delivery_Truck" type="submit" value="Test Delivery Truck" title="Test, random stock load by random quantity of parcels from between 5 and 40 parcels of the weight from between 10 and 20 kg each.">
        <input name="Test_Delivery_Truck_Heavy" type="submit" value="Test Delivery Truck Heavy" title="Test, random stock load by 2 agricultural machinery of weight 1 500 kg and 2000 kg per set.">
        <hr>
        <input name="Reload" type="submit" value="Reload">
    </form>


</body>


</html>

<?php
if (isset($_POST['Test_Delivery_Truck']))
{
    new \ReloadProject\ReloadNamespace\Test\Test_Delivery_Truck();
}

if (isset($_POST['Test_Delivery_Truck_Heavy']))
{
    new \ReloadProject\ReloadNamespace\Test\Test_Delivery_Truck_Heavy();
}

if (isset($_POST['Reload']))
{
    $load = new \ReloadProject\ReloadNamespace\ReloadClass\Reload();
    $load->loadStock();
}


?>

