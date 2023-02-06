<?php $this->load->view('elements/header'); ?>
<?php $this->load->view('elements/left_menu');

 function decodeEmoticons($src) {
    $replaced = preg_replace("/\\\\u([0-9A-F]{1,4})/i", "&#x$1;", $src);
    $result = mb_convert_encoding($replaced, "UTF-16", "HTML-ENTITIES");
    $result = mb_convert_encoding($result, 'utf-8', 'utf-16');
    return $result;
}
 
  ?>


<div class="page-content-wrapper">	
	<div class="page-content">		
		<div class="page-bar">			
			<ul class="page-breadcrumb">				
				<li>					
					<a href="#l">Home</a>					
					<i class="fa fa-circle"></i>				
				</li>				
				<li>					
					<span>Tags List</span>	
                        <i class="fa fa-circle"></i>    			
				</li>	
                <li>                    
                    <span>Tag Detail</span>             
                </li>   		
			</ul>       
			 </div>		
			 <h1 class="page-title">Tag Detail	 	</h1>	
			                  <div class="row">
                             
                            <div class="col-md-12">
                                <!-- BEGIN PROFILE SIDEBAR -->
                                <div class="profile-sidebar">
                                    <!-- PORTLET MAIN -->
                                    <div class="portlet light profile-sidebar-portlet ">
                                        <!-- SIDEBAR USERPIC -->
                                        <div class="profile-userpic">
                                            <img style="height: 150px !important;width: 150px !important;" src="<?php echo $user_detail->profileimage; ?>" class="img-responsive" alt=""> </div>
                                        <!-- END SIDEBAR USERPIC -->
                                        <!-- SIDEBAR USER TITLE -->
                                        <div class="profile-usertitle">
                                            <div class="profile-usertitle-name"> <?php echo $user_detail->fullname; ?> </div>
                                            <div class="profile-usertitle-job"> <?php echo $user_detail->useremail; ?> </div>
                                        </div>
                                        <!-- END SIDEBAR USER TITLE -->
                                        <!-- SIDEBAR BUTTONS -->
                                        <div class="profile-userbuttons">
                                            <button type="button" class="btn btn-circle green btn-sm">Reg. Date <?php echo date("d M, Y",strtotime($user_detail->date_of_creation)); ?></button>
                                            
                                            <?php if($user_detail->is_private=='1'){ ?>
                                            <button type="button" class="btn btn-circle red btn-sm">Is Private</button>
                                            <?php } else
                                            {?>
                                            <button type="button" class="btn btn-circle yellow btn-sm">Public</button>
                                            <?php 
                                            }?>

                                        </div>

                                    </br>
                                        <!-- END SIDEBAR BUTTONS -->
                                        <!-- SIDEBAR MENU -->
                                         
                                        <!-- END MENU -->
                                    </div>
                                    <!-- END PORTLET MAIN -->
                                    <!-- PORTLET MAIN -->
                                    <div class="portlet light ">
                                        <!-- STAT -->
                                        <!-- <div class="row list-separated profile-stat">
                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                <div class="uppercase profile-stat-title"> <?php echo $user_detail->total_post; ?> </div>
                                                <div class="uppercase profile-stat-text"> Total Footshots </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                <div class="uppercase profile-stat-title"> <?php echo $user_detail->FootsFollower; ?>  </div>
                                                <div class="uppercase profile-stat-text">  Total Followers </div>
                                            </div>
                                             
                                        </div> -->
                                         
                                        <!-- END STAT -->
                                         
                                    </div>
                                    <!-- END PORTLET MAIN -->
                                </div>
                                <!-- END BEGIN PROFILE SIDEBAR -->
                                <!-- BEGIN TICKET LIST CONTENT -->
                                <div class="app-ticket app-ticket-list">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="portlet light ">
                                                <div class="portlet-title tabbable-line">
                                                    <div class="caption caption-md">
                                                        <i class="icon-globe theme-font hide"></i>
                                                        <span class="caption-subject font-blue-madison bold uppercase">Footshots List</span>
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                     
                                                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                                        <thead>
                                                            <tr>
                                                                 
                                                                <th> ID   </th>
                                                                <th> Image   </th>
                                                                <th> Title </th>
                                                                
                                                                
                                                                <th> Date/Time </th>
                                                                <th> Total Comment </th>
                                                                <th> Total Likes </th>
                                                                <th> Product Tags </th>
                                                                <th> User Tags </th>
                                                                <th> Action </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 

                                                            $count = 1;
                                                            foreach ($post_list as $key => $value) {
                                                                # code...
                                                          ?>
                                                            <tr class="odd gradeX" id="post_id_<?php echo $value->post_id ?>">
                                                                
                                                                <td>
                                                                   <?php echo $value->post_number;?>
                                                                </td>
                                                                <td >

                                                                     <a  onclick="loadImageURL('<?php echo $value->post_image_url;?>')"  data-toggle="modal" href="#basicImage"> <img  src="<?php echo $value->post_image_url;?>" height ="30" width="30"/> </a>

                                                                     

                                                                     
                                                                </td>
                                                                <td>
                                                                    <?php echo  decodeEmoticons($value->post_caption); ?>
                                                                </td>
                                                                <td class="center">
                                                                    <?php echo date("d M, Y H:i:s",strtotime($value->date_of_creation)); ?>
                                                                </td>
                                                                
                                                                <td class="center">  <?php echo $value->total_comments ?> </td>
                                                                <td class="center">  <?php echo $value->total_foots ?> </td>
                                                                
                                                                <td class="center">  <?php echo $value->total_comments ?> </td>
                                                                <td class="center">  <?php echo $value->total_foots ?> </td>
                                                                <td class="center">  <a onclick="deletepost(<?php echo $value->post_id ?>);" alt="Delete" title="Delete" href="javascript:;" class="btn red btn-xs btn-outline sbold uppercase">
                                                                <i class="fa fa-trash"></i> </a> </td>
                                                                
                                                                
                                                            </tr>
                                                            <?php   $count++; } ?>
                                                               
                                                             
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END PROFILE CONTENT -->
                            </div>
                        </div>

			</diV>
</div>

 
<?php 
 
$this->load->view('elements/footer') ?>
                       
                
           
           