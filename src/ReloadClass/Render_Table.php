<?php


namespace ReloadProject\ReloadNamespace\ReloadClass;


class Render_Table
{
    public function renderTable($rows)
    {
        echo "
        <table class=\"display compact\">
            <thead>
                <tr>
                    <th>Item ID</th>
                    <th>Weight</th>                    
                    <th>Arrival Date</th>
                    <th>Status</th>
                    <th>Departure Date</th>
                </tr>
            </thead>
            <tbody>
               ";

        for ($i = 0; $i < count($rows); $i++)
        {

            ($rows[$i]["status"]==0)? $status = "READY TO LOAD" : $status = "WRONG";

            echo
                "<tr>
                    <td>".$rows[$i]["item_id"]."</td>
                    <td>".$rows[$i]["weight"]."kg"."</td>
                    <td>". gmdate("Y-m-d H:i:s", $rows[$i]["arrival_date"]) ."</td>
                    <td>". $status ."</td>
                    <td>". gmdate("Y-m-d H:i:s", $rows[$i]["departure_date"]) ."</td>

                </tr>";


        }
        echo
        "            
                </tbody>
            </table>
            ";
    }

}