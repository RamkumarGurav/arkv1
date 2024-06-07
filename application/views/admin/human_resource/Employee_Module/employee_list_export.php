<?php


	$filename = "Employee-List-" . date('d-m-Y') . ".xls"; header("Content-Disposition: attachment; filename=\"$filename\""); 

header("Content-Type: application/vnd.ms-excel");
//print_r($employee_data);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Employee List</title>

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
                                            <th style="background-color:#999" width="*">Employee Name</th>
											<th style="background-color:#999" width="*" colspan="3">Role</th>
											<th style="background-color:#999" width="*">Designation</th>
											<th style="background-color:#999" width="*">Email Id</th>
											<th style="background-color:#999" width="*">Mobile No</th>
											<th style="background-color:#999" width="*">Alt Mobile No</th>
											<th style="background-color:#999" width="*">Fax No</th>
											<th style="background-color:#999" width="*">Address 1</th>
											<th style="background-color:#999" width="*">Address 2</th>
											<th style="background-color:#999" width="*">Address 3</th>
											<th style="background-color:#999" width="*">Pincode</th>
											<th style="background-color:#999" width="*">City</th>
											<th style="background-color:#999" width="*">State</th>
											<th style="background-color:#999" width="*">Country</th>
											<th style="background-color:#999" width="*">Country Dial Code</th>
											<th style="background-color:#999" width="*">Data View</th>
											<th style="background-color:#999" width="*">Data View</th>
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
                                        if(!empty($employee_data))
                                        { //print_r($ptype_list);
                                            foreach($employee_data as $row)   
                                            {
                                           //if($row->in_hand > 0 || $row->total_purchase > 0 || $row->total_sold > 0 || $row->total_returned > 0 || $row->to_receive > 0 )
										   { 
										   $count++;


                                    ?>
                                        <tr>
                                            <td width="*"><? echo $count;?></td>
											<td width="*"><? echo $row->name;?></td>
											<td width="*" colspan="3">
											<? if(!empty($row->roles)){ ?>
												<table border="1" align="center" cellpadding="0" cellspacing="0" style="width:90%">
												<thead>
													<tr>
													<th style="width: 10px">#</th>
													<th>Company</th>
													<th>Role </th>
													</tr>
												</thead>
												<tbody>
												<? $c_count=0;foreach($row->roles as $role){$c_count++; ?>
													<tr>
													<td><?=$c_count?>.</td>
													<td><?=$role->company_unique_name?></td>
													<td><?=$role->user_role_name?></td>
													</tr>
												<? } ?>
												</tbody>
												</table><? //echo $row->role;?>
												<? } ?>
											</td>
											<td width="*"><? echo $row->designation_name;?></td>
											
											
											
											
											<td width="*"><? echo $row->email;?></td>
											<td width="*"><? echo $row->mobile_no;?></td>
											<td width="*"><? echo $row->alt_mobile_no;?></td>
											<td width="*"><? echo $row->fax_no;?></td>
											<td width="*"><? echo $row->address1;?></td>
											<td width="*"><? echo $row->address2;?></td>
											<td width="*"><? echo $row->address3;?></td>
											<td width="*"><? echo $row->pincode;?></td>
											<td width="*"><? echo $row->city_name;?></td>
											<td width="*"><? echo $row->state_name;?></td>
											<td width="*"><? echo $row->country_name;?></td>
											<td width="*"><? echo $row->dial_code;?></td>
											<td width="*">
											<? if($row->data_view==1){ ?> Yes
                                                <?}else{ ?>No
                                                <? }?>	
											</td>
											<td width="*">
											<? if($row->approval_access==1){ ?> Yes
                                                <?}else{ ?>No
                                                <? }?>	
											</td>
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
