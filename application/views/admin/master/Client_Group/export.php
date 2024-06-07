<?php


		$filename = "Client Group-List-" . date('d-m-Y') . ".xls"; header("Content-Disposition: attachment; filename=\"$filename\""); 

header("Content-Type: application/vnd.ms-excel");
//print_r($customers_list);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Client Group List</title>

</head>



<body>
<?
$colspan = 8;
?>
    <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                                    <thead>
                                    <? if(!empty($start_date) || !empty($end_date) ){ ?>
                                        <tr>
                                            <th  colspan="<?=$colspan?>" style="background-color:#CCC" width="*"><br />

                                            Search Record : 
                                            <? if(!empty($start_date)){ echo "From : ".date('d-m-Y' , strtotime($start_date)); } ?>
                                            
                                            <? if(!empty($end_date)){ echo " &nbsp;&nbsp;&nbsp;&nbsp;	 To : ".date('d-m-Y' , strtotime($end_date)); } ?>
<br />&nbsp;
                                            
                                            </th>
                                            
                                        </tr>
                                        <? } ?>
                                        
                                        <tr >
                                            <th style="background-color:#999" width="*">Sl. No.</th>
                                            <th style="background-color:#999" width="*">Group Name</th>
											<th style="background-color:#999" width="*">Group Description</th>
											<th style="background-color:#999" width="*">Minimum Order Value</th>
											<th style="background-color:#999" width="*">Added On</th>
											<th style="background-color:#999" width="*">Added By</th>
											<th style="background-color:#999" width="*">Updated On</th>
											<th style="background-color:#999" width="*">Updated By</th>
											<th style="background-color:#999" width="*">Status</th>
                                        </tr>
                                      </thead>
                                    <tbody>
									<?php 
                                        $count=0;
                                       // echo "count : ".count($ptype_list)." <br>";
                                        if(!empty($client_group_data))
                                        { //print_r($ptype_list);
                                            foreach($client_group_data as $row)   
                                            {
                                           //if($row->in_hand > 0 || $row->total_purchase > 0 || $row->total_sold > 0 || $row->total_returned > 0 || $row->to_receive > 0 )
										   { 
										   $count++;


                                    ?>
                                        <tr>
                                            <td width="*"><? echo $count;?></td>
											<td width="*"><? echo $row->group_name;?></td>
											<td width="*"><? echo $row->group_description;?></td>
											<td width="*"><? echo $row->minimum_order_value;?></td>
											<td width="*"> <? echo date('d-m-Y h:i:s A' , strtotime($row->added_on));?> &nbsp;</td>
											<td width="*"><? echo $row->added_by_name;?></td>
											<td width="*"> <? if(!empty($row->updated_on)){echo date('d-m-Y h:i:s A' , strtotime($row->updated_on));}?> &nbsp;</td>
                                            <td width="*"><? if(!empty($row->updated_by_name)){echo $row->updated_by_name;}?></td>
                                            <td width="*">
											<? if($row->status==1){ ?> Active
                                                <?}else{ ?>Block
                                                <? }?>	
											</td>
                                            
                                        </tr>
									<?php	}}?>
										
                                       
									<?php }else{ ?>
                                            <tr>
                                                <th colspan="<?=$colspan?>">No records to display...</th>
                                            </tr>
                                            
									<?php } ?>
                                    </tbody>
                                    
                                </table>



</body>

</html>
