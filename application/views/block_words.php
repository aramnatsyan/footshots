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
					<span>Blocked Words List</span>				
				</li>			
			</ul>       
			 </div>		
			 <h1 class="page-title">Blocked Words List	</br><small>This is the list of all blocked words tagged while creating the footshot.</small> 	 	</h1>	
			 <?php echo get_flashdata() ;?>
			 <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject bold uppercase">Blocked Words List</span>
                                        </div>                 
                                    </div>
                                    <div class="portlet-body">
                                         <?php echo form_open('', 'method="post"'); ?>
                                </div>

                                   <div class="portlet-body">
                                        <div class="table-toolbar">
                                            <div class="row">
                                                <div class="col-md-6"></div>
                                                <div class="col-md-6">
                                                    <div class="text-right">
                                                        <div class="btn-group">
                                                        <a href="<?php echo base_url()?>/Blockwords/add_words" id="sample_editable_1_new" class="btn sbold green"> Add New
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                          <a  href="<?php echo base_url()?>/Blockwords/upload_words" id="sample_editable_1_new" class="btn sbold red
                                                          "> Upload csv
                                                            <i class="fa fa-upload"></i>
                                                        </a>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h4 class="modal-title">Upload CSV</h4>
                                                    </div>
                                                    <form class="form-horizontal" action="<?php echo base_url(); ?>/Blockwords" method="post" enctype="multipart/form-data">
                                                        <div class="modal-body"> <div class="form-group">
                                                    <label for="exampleInputFile" class="col-md-3 control-label">File input</label>
                                                    <div class="col-md-9">
                                                        <input required type="file" id="exampleInputFile" name="file">
                                                        <p class="help-block"> some help text here. </p>
                                                    </div>
                                                </div>  </div>
                                                        <div class="modal-footer">
                                               
                                                            <button type="submit" name="submit" value="submit" class="btn green">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                            <thead>
                                                <tr>
                                                    <th> # </th>
                                                    <th> Blocked Words </th>
                                                    <!-- <th> Date Of Creation </th> -->
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
						                    <?php 
						                      $count = 1;
						                           foreach($result  as $data){
						                           	// print_r($data);
						                           	?>

                                                <tr class="odd gradeX">
                                                    <td> <?php echo $count++; ?> </td>
                                                    <td> <?php echo $data->word ?></td>
                                            <!--         <td> <?php echo $data->date_of_creation ?> </td> -->
                                                    <!-- <td> <?php echo $data->word ?> </td> -->
                                                	<td>

<a class="btn btn-success btn-xs" title="Edit" alt="Edit" href="<?php echo base_url(); ?>/Blockwords/edit/<?php echo $data->id; ?>">
																<i class="icon-pencil"></i></a>
<a class="btn btn-danger btn-xs"  title="Delete" alt="Delete" href="<?php echo base_url(); ?>/Blockwords/delete/<?php echo $data->id; ?>">
																<i class="fa fa-trash-o" style="font-size:15px;" ></i></a>

                                                </td>
                                                </tr>

                                                <?php } ?> 
                                            </tbody>
                                        </table>
                                    </div>


                                        <?php echo form_close();  
                                    
                                        ?>

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
                       
                
           
           