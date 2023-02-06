
        <table class="table table-striped table-bordered table-hover table-checkable order-column" >
                                            
                                            
                                        </table>

                                        <table class="table table-bordered" id="print">
                                             <thead>
                                                <tr>
                                                    <th>
                                                        #
                                                    </th>
                                                       <th> Product Tags </th>
                                                       <th> Date/Time </th>
                                                       <th> No. of Times Tag used </th>
                                                     <th> Action </th>
                                                
                                                </tr>
                                            </thead>
    <?php 
    if (isset($result) && !empty($result['result'])) 
	{
         ?>
            <?php
                   $count=$pperpage;
                foreach ($result['result'] as   $value) {
                    # code...
                ?>
            <tbody>

                

                <tr class="odd gradeX">
                    <td>
                        <?php echo $count;?>
                    </td>
                    <td> <?php echo $value->product_name;?> </td>
                    <td> <?php echo date("d M, Y H:i:s",strtotime($value->last_update));?> </td>
                    <td> <?php echo $value->total_tags;?> </td>
                    <td> <a href="<?php echo base_url(); ?>posts/productposts/<?php echo $value->product_id; ?>" class="btn dark btn-xs btn-outline sbold uppercase">
                                                                <i class="fa fa-share"></i> View </a> </td>
                     
                     
                </tr>
                
                 <?php  $count++;
             } ?>
            </tbody>

		 <?php
    } 
	else 
	{ ?>
        <tbody>
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