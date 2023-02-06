<?php $this->load->view('elements/header'); ?>
<?php $this->load->view('elements/left_menu') ;
$uri1 = uri_segment('1');
$uri2 = uri_segment('2');
$uri3 = uri_segment('3');
$sedatas=$this->session->all_userdata();
$user_id = $sedatas['userinfo']->app_user_id;
    
         $this->db->select('*');        
        $this->db->from('foot_sponsor');
        $this->db->where('user_id',$user_id);
        $query = $this->db->get();
        $sponsorResult = $query->row();
        $type = $sponsorResult->adv_type;

?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/tagcss/jquery.mentionsInput.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/tagcss/jquery.mentionsInput.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/form-upload.css');?>">
  <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="<?php echo base_url(); ?>Sponsor/profile_sponsor/<?php echo $sedatas['userinfo']->app_user_id;?>">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span> Create Ad </span>
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
                                <!-- BEGIN PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-microphone font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase"> Create Ad </span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <form class="form-horizontal" id="imageupload" action="<?php echo base_url('Adds/save_add'); ?>" method="post" enctype="multipart/form-data" role="form">
                                            <div class="form-body">
                                                <input type="hidden" name="user_id" value="<?php echo $user_id;?>">

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"> Description </label>
                                                    <div class="col-md-5">
                                                        <textarea name="add_description" required class="form-control postText mention" placeholder="with @ or # tagging"></textarea>
                                                    </div>
                                                </div>
                                                 
                                    
                                                <?php if($type=='both'){ ?>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"> Rights for Ad </label>
                                                    <div class="col-md-5">
                                                        <div class="mt-radio-inline">
                                                            <label class="mt-radio">
                                                                <input type="radio" name="optionsRadios" id="optionsRadios25" value="image" checked> Image
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio">
                                                                <input type="radio" name="optionsRadios" id="optionsRadios26" value="video"  > Video
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class="form-group" >
                                                    <label for="imageFile" class="col-md-3 imageFile control-label"> Image </label>
                                                    <div class="col-md-5">
                                                        <input type="file" accept="image/jpeg" id="fileUp" class="abup" name="imageFile">
                                                    </div>
                                                </div>
                                                

                                            <?php } else { ?>
                                                <input type="hidden" name="optionsRadios" value="<?php echo $type; ?>">

                                                <div class="form-group">
                                                    <label for="imageFile"   class="col-md-3 control-label"> <?php if($type=='image'){ ?> Image <?php } else { ?>Video (duration: 15 sec max.) <?php } ?> </label>
                                                    <div class="col-md-5">
                                                        <input type="file" <?php if($type=='image'){ ?> accept="image/jpeg" <?php } else { ?> accept="video/mp4" <?php } ?> id="fileUp" name="imageFile">
                                                    </div>
                                                </div>

                                            <?php } ?>
                                               
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"> Link: </label>
                                                    <div class="col-md-5">
                                                        <input type="text" required class="form-control" name="addv_url" placeholder="enter link">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"> Overlay Text: </label>
                                                    <div class="col-md-5">
                                                        <input type="text" required class="form-control" name="overlay_text" placeholder="enter link overlay text">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                <div id="loader" style="display:none;">
                                                <img  src="<?php echo base_url('assets/images/LoaderIcon.gif');?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                 <label class="col-md-3 control-label"> </label>
                                                 <div class="col-md-5">
                                                   <div id="progressbr-container">
                                                        <div  id="progress-bar-status-show">    </div>              
                                                    </div>
                                                    </div>

                                                  </div>
                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-5">
                                                       <input type="submit"  value="Upload Image" class="btn btn-success" />
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

if($type=='video')
{
    ?>
    <script type="text/javascript">
               document.getElementById('fileUp').onchange = setFileInfo;
                
    </script>
<?php }
 
$this->load->view('elements/footeradvs') ?>
                       
                
           
           