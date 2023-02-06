<?php $this->load->view('elements/header') ?>
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
					<span>Heat Map</span>				
				</li>			
			</ul>       
			 </div>		
			 <h1 class="page-title">Heat Map	 </br><small>This is the map defining the regions where footshots app is being used.</small>   	</h1>	
			 <div class="row">
                            <div class="col-md-8">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="fa fa-map-marker font-dark"></i>
                                            <span class="caption-subject bold uppercase">Heat Map</span>
                                        </div>
                                        

                                    </div>
                                    <div class="portlet-body"> 

                                         <div id="vmap_world" class="vmaps"> </div>
                                    </div>
                                </div>
                                <!-- END EXAMPLE TABLE PORTLET-->
                            </div>
                            <div class="col-md-4">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="fa fa-map-marker font-dark"></i>
                                            <span class="caption-subject bold uppercase">Countries</span>
                                        </div>
                                        

                                    </div>
                                    <div class="portlet-body"> 

                                        <div class="table-scrollable">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th> # </th>
                                                        <th> Country </th>
                                                        <th> Total Footshot </th>
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody>
 
                                                       <?php   $count=1;
// print_r($vectortabledata); die;
                                                       foreach ($vectortabledata as   $value) {
                                                         
                                                       ?>
                                                    <tr>
                                                        <td> <?php echo $count;?> </td>
                                                        <td> <?php echo $value->country_name;?> </td>
                                                        <td> <?php echo $value->numrows;?> </td>
                                                       
                                                        
                                                    </tr>
                                                       <?php   $count++;
                                                   } ?>

                                                    

                                                     
                                                </tbody>
                                            </table>
                                        </div>
                                    


                                     
                                         
                                    </div>
                                </div>
                                <!-- END EXAMPLE TABLE PORTLET-->
                            </div>
                        </div>

			</diV>
</div>

 
<?php 


 
$this->load->view('elements/footervector') ?>
                       
                
           
           