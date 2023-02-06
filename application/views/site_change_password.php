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
                    <span>Change Password</span>             
                </li>           
            </ul>       
             </div>     
             <h1 class="page-title">Change Password  </h1>   
             <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="icon-lock font-dark"></i>
                                            <span class="caption-subject bold uppercase">Change Password</span>
                                        </div>
                                        

                                    </div>
                                    <div class="portlet-body"> 

                                        <?php if($status!="")
                                        {?>
                                        <div class="alert alert-<?php echo $status; ?> " >
                                                    <button class="close" data-close="alert"></button> <?php echo $msg; ?></div>
                                                <?php } ?>

                                        <form class="form-horizontal" action="" method="post" role="form">
                            <div class="form-group">
                                <label for="old-password" class="col-md-2 control-label">Old Password <span class="required">*</span></label>
                                <div class="col-md-4">
                                    <div class="input-icon">
                                        <input type="password" class="form-control" name="old_password" onkeyup="change_pass()" required id="old_pass" placeholder=""> 
                                        <span class="error" id="error_old_pass">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="new-password" class="col-md-2 control-label">New Password <span class="required">*</span></label>
                                <div class="col-md-4">
                                    <div class="input-icon">
                                        <input type="password" class="form-control"  name="new_password"  onkeyup="change_pass()" required id="new_pass" placeholder=""> 
                                        <span class="error" id="error_new_pass">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm-password" class="col-md-2 control-label">Confirm Password <span class="required">*</span></label>
                                <div class="col-md-4">
                                    <div class="input-icon">
                                        <input type="password" class="form-control"  name="confirm_password"  onkeyup="change_pass()" required id="c_pass" placeholder=""> 
                                        <span class="error" id="error_c_pass">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-10">
                                    <button type="submit" id="subbtn" class="btn green">Submit</button>
                                </div>
                            </div>
                        </form>

                                    </div>
                                </div>
                                <!-- END EXAMPLE TABLE PORTLET-->
                            </div>
                        </div>

            </diV>
</div>

 
<?php 


 
$this->load->view('elements/footer') ?>
                       
                
           
           