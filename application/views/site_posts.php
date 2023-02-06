<?php   

$this->load->view('elements/header') ?>
<?php $this->load->view('elements/left_menu') ?>


<div class="page-content-wrapper">	
	<div class="page-content">		
		<div class="page-bar">			
			<ul class="page-breadcrumb">				
				<li>					
					<a href="#l">Home</a>					
					<i class="fa fa-circle"></i>				
				</li>				
				<li>					
					<span>Post List</span>				
				</li>			
			</ul>       
			 </div>		
			 <h1 class="page-title"> Post List		 	</h1>	
			 <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject bold uppercase">Posts List</span>
                                        </div>
                                        

                                    </div>
                                    <div class="portlet-body">
                                         
                                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        #
                                                    </th>
                                                       <th> Post Caption </th>
                                                    <th> Image </th>
                                                    <th> Address </th>
                                                    <th> Date/Time </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            	<?php
                                                $count=1;
                                            	foreach ($post_list as   $value) {
                                            		# code...
                                            	?>

                                                <tr class="odd gradeX">
                                                    <td>
                                                        <?php echo $count;?>
                                                    </td>
                                                    <td> <?php echo $value->post_caption;?> </td>
                                                    <td>
                                                        <a target="_blank" href= " <?php echo base_url().$value->post_image_url;?>"> Image </a>
                                                    </td>
                                                    <td>
                                                        <?php echo $value->address;?>   
                                                    </td>
                                                    <td class="center">  <?php echo date("d M, Y H:i:s",strtotime($value->date_of_creation));?> </td>
                                                     
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
                       
                
           
           