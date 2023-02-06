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
                    <span>Add Abuse Word</span>               
                </li>           
            </ul>       
             </div>     
             <h1 class="page-title">Add Abuse Word    
           <!--   </br>
                <small>This is the list of all block words tagged while creating the footshot.</small> -->  
            </h1>   
             <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <!-- <i class="icon-settings font-dark"></i> -->
                                            <!-- <span class="caption-subject bold uppercase">Block Words List</span> -->
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                         <?php foreach ($result as $value) {?>
                           <form action="<?php echo base_url()?>/Blockwords/update/<?php echo $value->id;?>" method="post">
                              <div class="row">
                                    <div class="col-md-6">
                                         
                                    </div>
                                    <div class="col-md-6">
                                </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label txt-color">Abuse Word<em class="required">*</em></label>
                                        <div class="col-md-3">
                                            <input required type="text" name="abuse_word" id="abuse_word"  class="form-control" placeholder="Enter text" value="<?php echo $value->word; ?>">
                                            <span id="" class="error"></span>
                                        </div>
                                     </div>                            
                                    <div class="form-group">
                                        <div class="col-md-2">
                                            <input type="submit" name="submit" class="btn btn-bold red pull-right" id="btnExport1" value="Update"/>
                                            <!-- <a href="<?php echo base_url()?>/Blockwords/update/<?php echo $value->id; ?>" id="sample_editable_1_new" class="btn sbold green">Submit
                                            </a> -->
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                </form>
                                        <!-- <?php echo form_close();  ?> -->
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
            </div>
    </div>

 

<?php 

$this->load->view('elements/footer') ?>
                    