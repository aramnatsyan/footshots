<?php function decodeEmoticons($src) {
    $replaced = preg_replace("/\\\\u([0-9A-F]{1,4})/i", "&#x$1;", $src);
    $result = mb_convert_encoding($replaced, "UTF-16", "HTML-ENTITIES");
    $result = mb_convert_encoding($result, 'utf-8', 'utf-16');
    return $result;
}
  ?>
        <table class="table table-striped table-bordered table-hover table-checkable order-column" >
                                            
                                            
                                        </table>

                                       <table class="table table-striped table-bordered table-hover table-checkable order-column"  >
                                            <thead>
                                                <tr>
                                                     <th>
                                                        #
                                                    </th> <th>
                                                        Footshot Owner
                                                    </th>
                                                    <th>
                                                        Footshot #
                                                    </th>
                                                   
                                                       <th> Footshot Caption </th> 
                                                       <th> Footshot Thumbnail </th>
                                                    <th> Total Reports </th>
                                                    
                                                    <th>Set Status </th>
                                                    <th>Detail </th>
                                                    <th>Date/Time </th>
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
                                                        <?php echo  $count;?>
                                                    </td>      <td>
                                                        <?php echo $value->fullname;?>
                                                    </td>
                                                    <td>
                                                        <?php echo $value->fullname. '-'.$value->post_number;?>
                                                    </td>
                                                    <td> <?php echo decodeEmoticons($value->post_caption);?> </td>
                                                    <td>  <a  onclick="loadImageURL('<?php echo $value->post_image_url;?>')" data-toggle="modal" href="#basicImage"> <img  src="<?php echo $value->post_image_url;?>" height ="30" width="30"/> </a> </td>
                                                    <td>
                                                         <?php echo $value->total_report;?> 
                                                    </td>
                                                  
                                                     <td id="userstatus<?php echo $value->post_id; ?>"> 
                                                       <?php if($value->post_status=='active') {?> <button onclick="block_unblock_post_abuse('<?php echo $value->post_id; ?>','block');" class="btn btn-xs btn-success"> Active </button> <?php } ?>   
                                                       <?php   if($value->post_status=='block') {?> <button onclick="block_unblock_post_abuse('<?php echo $value->post_id; ?>','active');" class="btn btn-xs btn-danger"> Blocked </button> <?php } ?>  <?php   if($value->post_status=='delete') {?> <button   class="btn btn-xs btn-info"> Deleted </button> <?php } ?>   
                                                    </td>
                                                     <td>
                                                        <a href="<?php echo base_url(); ?>reportabouse/reportabousedetail/<?php echo $value->post_id; ?>" class="btn dark btn-xs btn-outline sbold uppercase">
                                                                <i class="fa fa-share"></i> View </a>
                                                    </td>
                                                    <td>
                                                      <?php echo date("d M, Y H:i:s",strtotime($value->date_of_repo));?> 
                                                    </td>
                                                     
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