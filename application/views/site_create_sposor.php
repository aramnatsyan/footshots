<?php $this->load->view('elements/header'); ?>
<?php $this->load->view('elements/left_menu') ;
$uri1 = uri_segment('1');
$uri2 = uri_segment('2');
$uri3 = uri_segment('3');
?>

 <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="<?php echo base_url('dashboard');?>">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span> Create Sponsor </span>
                                </li>
                            </ul>
                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title">  </h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        
                        <div class="row">

                            <div class="col-lg-12 col-xs-12 col-sm-12">
                                <?php   if(validation_errors())
                                { ?>
                                <div class="alert alert-danger  "  >
                                                    <button class="close" data-close="alert"></button>
                                                    <?php echo validation_errors(); ?>
                                 </div>
                             <?php }if(!empty($error_value))
                                { ?>
                                <div class="alert alert-danger  "  >
                                                    <button class="close" data-close="alert"></button>
                                                    <?php echo $error_value; ?>
                                 </div>
                             <?php } ?>
                                <!-- BEGIN PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-users font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase"> Create Sponsor </span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>Sponsor/add_sponsor" enctype="multipart/form-data" role="form">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"> First Name <span class="required" aria-required="true"> * </span></label>
                                                    <div class="col-md-5">
                                                        <input type="text" value="<?php echo set_value('first_name'); ?>" required name="first_name" class="form-control" placeholder="Enter first name">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"> Last Name <span class="required" aria-required="true"> * </span></label>
                                                    <div class="col-md-5">
                                                        <input type="text" required  value="<?php echo set_value('last_name'); ?>"  name="last_name" class="form-control" placeholder="Enter last name">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"> Organisation Name <span class="required" aria-required="true"> * </span></label>
                                                    <div class="col-md-5">
                                                        <input type="text" value="<?php echo set_value('organisation_name'); ?>" required name="organisation_name" class="form-control" placeholder="Enter organisation name">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"> Account Validity <span class="required" aria-required="true"> * </span></label>
                                                    <div class="col-md-5">
                                                       <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                            <input required value="<?php echo set_value('account_validity'); ?>" type="text" class="form-control" readonly name="account_validity">
                                                            <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-calendar"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"> Ad Type <span class="required" aria-required="true"> * </span></label>
                                                    <div class="col-md-5">
                                                        <div class="mt-radio-inline">
                                                            <label class="mt-radio">
                                                                <input type="radio" name="optionsRadios" id="optionsRadios25" value="image" checked=""> Image
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio">
                                                                <input type="radio" name="optionsRadios" id="optionsRadios26" value="video"  > Video
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio ">
                                                                <input type="radio" name="optionsRadios" id="optionsRadios27" value="both"  > Both (Image & Video)
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"> Quota of Ads can post </label>
                                                    <div class="col-md-5">
                                                        <input type="text" class="form-control" name="org_quota" placeholder="Enter quota of ads" >
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"> Organisation Address </label>
                                                    <div class="col-md-5">
                                                        <textarea class="form-control"   name="org_address" placeholder="Enter organisation address"><?php echo set_value('org_address'); ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputFile" class="col-md-3 control-label"> Organisation Profile Picture <span class="required" aria-required="true"> * </span></label>
                                                    <div class="col-md-5">
                                                        <input type="file" accept="image/jpeg,image/png,image/jpg" required name="org_profile" id="ff2">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"> Email Address </label>
                                                    <div class="col-md-5">
                                                        <input type="email" value="<?php echo set_value('org_email'); ?>" name="org_email" class="form-control" placeholder="Enter email">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"> Phone Number </label>
                                                    <div class="col-md-5">
                                                        <input type="text" value="<?php echo set_value('org_phone'); ?>" name="org_phone" class="form-control" placeholder="Enter phone number">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-5">
                                                        <button type="submit" class="btn green"> Submit </button>
                                                        <button type="button" class="btn default"> Cancel </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- END PORTLET-->
                            </div>
                        </div>
                        
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
<?php 


 
$this->load->view('elements/footer') ?>
                       
                
           
           