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
					<span>Reported Abuse</span>				
				</li>			
			</ul>       
			 </div>		
			 <h1 class="page-title"> Reported Abuse </br><small>These are the footshots which are marked abused by the app users.</h1>	
			 <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="fa fa-ban font-dark"></i>
                                            <span class="caption-subject bold uppercase">Reported Abuse List</span>
                                        </div>
                                        

                                    </div>
                                    <div class="portlet-body"> 




                                         <?php echo form_open('', 'method="post"'); ?>
                                         <div class="row">
                                    <div class="col-md-6">
                                        <div class="pull-left">Show</div>
                                        <div class="col-md-3">
                                            <select class="form-control" id="perpage" name="perpage">
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                                <option value="1">All</option>
                                            </select>
                                        </div>
                                        <div class="pull-left">Rows</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-5 pull-right">
                                        <input type="text" name="search" id="search" class="form-control" placeholder="Search" /> </div>
                                    </div>
                                </div>
                                        <?php echo form_close();  ?>

                                        <div class="row margin-top-20">  
                                        <div class="col-md-12">
                                            <div class="table-responsive confirms margin-sm-top" id="gridlisting">
                                                <!-- async hit comes here -->
                                            </div>
                                        </div>
                                    </div>  
                                    
                                    
                                    </div>
                                </div>
                                <!-- END EXAMPLE TABLE PORTLET-->
                            </div>
                        </div>
			</diV>
</div>

 
<?php 

$this->load->view('elements/footer') ?>
                       
                
           
           