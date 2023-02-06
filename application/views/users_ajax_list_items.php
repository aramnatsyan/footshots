 
 <table class="table table-striped table-bordered table-hover table-checkable order-column"  id="print">
                                            <thead>
                                                <tr>
                                                    <th  >
                                                        #
                                                    </th>
                                                    <th> Full Name </th>                                                    
                                                    <th> Email </th>
                                                    <th> Total Footshoot </th>
                                                    <th> Total Donation Points </th>
                                                    <th> Last Activity </th>
                                                    <th> Status </th>
                                                    <th> Detail </th>
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody >
                                       
                            <?php 
                            if (isset($result) && !empty($result['result'])) 
                            {
                             ?>
                                <?php
                                    $count=$pperpage;
                                    foreach ($result['result'] as   $value) {
                                        # code...
                                    ?>
                               

                

                                    <tr class="odd gradeX" id="user_id_<?php echo $value->user_id;?>">
                                                    <td>
                                                        <?php echo $count;?>
                                                    </td>
                                                    <td> <?php echo $value->fullname;?> </td>
                                                    
                                                    <td>
                                                        <?php echo $value->useremail;?>   
                                                    </td>
                                                      <td>
                                                        <?php echo $value->total_footshots;?>   
                                                    </td><td>
                                                        <?php echo $value->total_fonation_points;?>   
                                                    </td>
                                                     <td>
                                                        <?php echo date("d M, Y H:i:s",strtotime($value->last_activity));?>   
                                                    </td>
                                                    <td id="userstatus<?php echo $value->user_id; ?>"> 
                                                       <?php if($value->status=='Active') {?> <button onclick="block_unblock('<?php echo $value->user_id; ?>','Blocked');" class="btn btn-xs btn-success"> Active </button> <?php } ?>   
                                                       <?php   if($value->status=='Blocked') {?> <button onclick="block_unblock('<?php echo $value->user_id; ?>','Active');" class="btn btn-xs btn-danger"> Inactive </button> <?php } ?>   
                                                    </td>
                                                     <td>
                                                        <a href="<?php echo base_url(); ?>users/userdetail/<?php echo $value->user_id; ?>" class="btn dark btn-xs btn-outline sbold uppercase">
                                                                <i class="fa fa-share"></i> View </a>
                                                    
                     </td>
                                                    <td>
                     <button onclick="deleteuser('<?php echo $value->user_id; ?>');" class="btn btn-xs btn-danger">Delete</button>
                                                </td>
                                                     
                                                </tr>
                
                 <?php  $count++;
             } ?>
            </tbody>

		 <?php
    } 
	else 
	{ ?>
         
            <tr>
                <td colspan="5" align="center"> <strong>No Result Found </strong></td>
            </tr>
         </tbody>
	<?php } ?>
  </table>
<?php
$paging = custompaging($cur_page, $no_of_paginations, $previous_btn, $next_btn, $first_btn, $last_btn);
echo $paging;
?>