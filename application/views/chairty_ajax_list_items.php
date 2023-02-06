
        <table class="table table-striped table-bordered table-hover table-checkable order-column" >
                                            
                                            
                                        </table>

                                        <table class="table table-bordered" id="print">
                                             <thead>
                                                <tr>
                                                    <th>
                                                        #
                                                    </th>
                                                       <th> Name </th>
                                                       <th> Points   </th>
                                                        <th> Date </th>
                                                         
                                                        <th>   </th>
                                                
                                                </tr>
                                            </thead>
    <?php 
    if (isset($result) && !empty($result['result'])) 
	{
         ?>
            <?php
                $count=1;
                foreach ($result['result'] as   $value) {
                    # code...
                ?>
            <tbody>

                

                <tr class="odd gradeX">
                    <td>
                        <?php echo $count;?>
                    </td>
                    <td> <?php echo $value->fullname;?> </td>
                    <td> <?php echo $value->total_points;?> </td>
                    <td> <?php echo  date("d M, Y H:i:s",strtotime($value->date_of_redeem));?> </td>
                 
                    <td>  
                        <?php
                        if($value->redeem_request=="0")
                        {
                            ?>
                            <a data-toggle="modal" onclick="postforuser(<?php echo $value->user_id;?>,<?php echo $value->redeem_id;?>);" href="#basic" class="btn btn-outline btn-circle btn-xs red">
                             Approve  
                         </a>
                            <?php
                        }
                        else
                        { ?>
                            <a class="btn btn-outline btn-circle btn-xs green" onclick="loadImageURL('<?php echo $value->timelineiamge;?>')"  data-toggle="modal" href="#basicImage"   class="btn btn-outline btn-circle btn-xs red">Approved </a>
                            
                            
                           
                        <?php }
                        ?>
                         

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
 
<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"> Create Chairty Post </h4>
            </div>
            <div class="modal-body"> 
                <form method="post" action="" enctype="multipart/form-data" >
                <input type="hidden" id="user_id" name="user_id" value="">
                <input type="hidden" id="request_id" name="request_id" value="">
                <div class="form-group">
                    <label class="col-md-3 control-label">Post Desrciption</label>
                    <div class="col-md-9">
                        <textarea class="form-control" required name="post_content" rows="3"></textarea>
                    </div>
                    <br/>
                </div>

                <div class="form-group">
                    <label for="exampleInputFile" class="col-md-3 control-label">File input</label>
                    <div class="col-md-9">
                        <input type="file" required name="post_file" accept="image/jpeg" id="exampleInputFile">
                        <p class="help-block"> some help text here. </p>
                    </div>
                </div>
                <br/>
                <button type="submit" name="donationbuttonapprove" class="btn green">Save changes</button>
             </div>
            
        </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="basicdonate" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"> Minimum Donations Threshold </h4>
            </div>
            <div class="modal-body"> 
                <form method="post" action="" enctype="multipart/form-data" >
        
                <div class="form-group">
                    <label class="col-md-3 control-label">Threshold Point</label>
                    <div class="col-md-9">
                         <input type="text" value="<?php echo $donationpoint; ?>" required name="donationpoint"  >
                    </div>
                    <br/>
                </div>

                 
                <br/>
                <button type="submit" name="donationbutton" class="btn green">Save changes</button>
             </div>
            
        </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php
$paging = custompaging($cur_page, $no_of_paginations, $previous_btn, $next_btn, $first_btn, $last_btn);
echo $paging;
?>