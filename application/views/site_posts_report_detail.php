<?php   

$this->load->view('elements/header') ?>
<?php $this->load->view('elements/left_menu') ?>
<?php function decodeEmoticons($src) {
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
					<span>Reported Abuse Footshot Detail with Users List</span>				
				</li>			
			</ul>    
            <div class="page-toolbar" id="block_userpost<?php echo $post_detail->post_id; ?>">                                 
                                 <?php if($post_detail->post_status=='active')
                {?>
                            <a href="javascript:;" onclick="block_unblock_post('<?php echo $post_detail->post_id; ?>','block')" class="btn pull-right green  btn-default btn-sm">Block Footshot</a>
                      <?php } if($post_detail->post_status=='block')
                {?>        
                            <a href="javascript:;" onclick="block_unblock_post('<?php echo $post_detail->post_id; ?>','active')" class="btn pull-right red  btn-default btn-sm">Active Footshot</a>

                    <?php }  ?> 
                            </div>

			 </div>		
			 <h1 class="page-title"> Reported Abuse Footshot Detail with Users List </h1>
             
			 <div class="row">
                
                                <div class="col-md-6">
                                    <div class="blog-single-content bordered blog-container">
                                        <div class="blog-single-head">
                                            <h1 class="blog-single-head-title">  <?php echo decodeEmoticons($post_detail->post_caption);?> </h1>
                                            <div class="blog-single-head-date">
                                                <i class="icon-calendar font-blue"></i>
                                                <a href="javascript:;"><?php echo date("d M, Y H:i",strtotime($post_detail->date_of_creation)); ?></a>
                                            </div>
                                            <div class="blog-single-desc">
                                            <p> <?php echo $post_detail->address; ?> </p>
                                            
                                        </div>
                                        </div>
                                        <div class="blog-single-img">
 
                                            <img height="500" src="<?php echo base_url(); ?><?php echo $post_detail->post_image_url; ?>" /> </div>
                                        
                                         
                                         
                                    </div>
                                </div>
                                 
                          
                            <div class="col-md-6">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="fa fa-ban font-dark"></i>
                                            <span class="caption-subject bold uppercase">Users List who marked abuse</span>
                                        </div>
                                        

                                    </div>
                                    <div class="portlet-body">
                                         
                                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        #
                                                    </th>
                                                     <th>User Image </th>
                                                       <th>User Name </th>
                                                    <th>Report Date/Time </th>
                                                     
                                                </tr>
                                            </thead>
                                            <tbody>

                                            	<?php
                                                $count=1;
                                            	foreach ($users_list as   $value) {
                                            		# code...
                                            	?>

                                                <tr class="odd gradeX">
                                                    <td>
                                                        <?php echo $count;?>
                                                    </td>
                                                    <td><img src="<?php echo $value->profileimage;?>" height="50"/> </td>
                                                    <td> <?php echo $value->fullname;?> </td>
                                                    <td>
                                                         <?php echo date("d M, Y H:i:s",strtotime($value->date_of_creation));?> 
                                                    </td>
                                                   
                                                    
                                                     
                                                </tr>
                                                
                                                 <?php  $count++;
                                             } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- END EXAMPLE TABLE PORTLET-->
                            </div>
                        </div>
			</diV>
</div>

 
<?php 

$this->load->view('elements/footer') ?>
                       
                
           
           