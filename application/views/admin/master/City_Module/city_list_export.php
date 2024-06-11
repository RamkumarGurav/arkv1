<?php
// Generate a filename for the Excel file with the current date
$filename = "City-List-" . date('d-m-Y') . ".xls";

// Set headers to force download of the file as an Excel spreadsheet
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

// Opening PHP tag to start the HTML content
?>

<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>City List</title>
</head>

<body>
    <?
    $colspan = 8; // Set the colspan value for table header
    ?>
    <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
        <thead>
            <? if (!empty($start_date) || !empty($end_date)) { ?>
                <tr>
                    <th colspan="<?= $colspan ?>" style="background-color:#CCC" width="*"><br />
                        Search Record:
                        <? if (!empty($start_date)) {
                            echo "From: " . date('d-m-Y', strtotime($start_date));
                        } ?>
                        <? if (!empty($end_date)) {
                            echo " &nbsp;&nbsp;&nbsp;&nbsp; To: " . date('d-m-Y', strtotime($end_date));
                        } ?>
                        <br />&nbsp;
                    </th>
                </tr>
            <? } ?>

            <tr>
                <th style="background-color:#999" width="*">Sl. No.</th>
                <th style="background-color:#999" width="*">City</th>
                <th style="background-color:#999" width="*">State</th>
                <th style="background-color:#999" width="*">Country</th>
                <th style="background-color:#999" width="*">City Code</th>
                <th style="background-color:#999" width="*">Is Display</th>
                <th style="background-color:#999" width="*">Added On</th>
                <th style="background-color:#999" width="*">Added By</th>
                <th style="background-color:#999" width="*">Updated On</th>
                <th style="background-color:#999" width="*">Updated By</th>
                <th style="background-color:#999" width="*">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 0;

            // Check if the city_data array is not empty
            if (!empty($city_data)) {
                // Loop through each city in the city_data array
                foreach ($city_data as $row) {
                    $count++;
                    ?>
                    <tr>
                        <td width="*"><? echo $count; ?></td>
                        <td width="*"><? echo $row->city_name; ?></td>
                        <td width="*"><? echo $row->state_name; ?></td>
                        <td width="*"><? echo $row->country_name; ?></td>
                        <td width="*"><? echo $row->city_code; ?></td>
                        <td width="*">
                            <? if ($row->status == 1) { ?> Yes
                            <? } else { ?> No
                            <? } ?>                 </td>
                        <td width="*"> <? echo date('d-m-Y h:i:s A', strtotime($row->added_on)); ?> &nbsp;</td>
                        <td width="*"><? echo $row->added_by_name; ?></td>
                        <td width="*">
                            <? if (!empty($row->updated_on)) {
                                echo date('d-m-Y h:i:s A', strtotime($row->updated_on));
                            } ?>
                            &nbsp;
                        </td>
                        <td width="*"><? if (!empty($row->updated_by_name)) {
                            echo $row->updated_by_name;
                        } ?></td>
                        <td width="*">
                            <? if ($row->status == 1) { ?> Active
                            <? } else { ?> Block
                            <? } ?>                 </td>
                    </tr>
                    <?php
                } // End of foreach loop
            } else { ?>
                <tr>
                    <th colspan="<?= $colspan ?>">No records to display...</th>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>