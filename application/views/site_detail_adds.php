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
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="dashboard.html">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>  Ad Detail </span>
                                </li>
                            </ul>
                        </div>
                       
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
                                            <span class="caption-subject font-dark sbold uppercase">  <?php echo $value->post_caption; ?> </span>
                                        </div>
                                        <div class="tools">
                                           <!--  <button class="btn btn-circle btn-sm green">  <?php echo ucfirst($value->status_of_add); ?> </button> -->
                                             <?php $sedatas=$this->session->all_userdata();
 
                                                            if($sedatas['userinfo']->app_user_id==0)
                                                                        { 
                                                        if($value->status_of_add=='approved'){?>
                                                            <button    class="btn btn-outline btn-circle btn-xs green trrig"    > Approve </button> <?php } else {?>
                                                         <button  data-post_id="<?php echo $value->post_id; ?>"  class="btn btn-outline btn-circle btn-xs red trrig" data-toggle="modal" data-target="#approved" onclick="approve_adv('approve','<?php echo $value->post_id; ?>'');"> Pending </button>
                                                     <?php } ?>


                                                             
                                                         <?php } else 
                                                         { ?> 

                                                            <span class="badge <?php if($value->status_of_add=='approved') { echo 'badge-success'; } else { echo 'badge-danger'; }?> "> <?php echo ucfirst($value->status_of_add); ?> </span>
                                                    <?php } ?>

                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <ul class="list-inline">
                                                    <!--<li>
                                                        <img src="assets/pages/media/blog/10.jpg" alt="" class="sp_img">
                                                    </li>-->
                                                    <li>
                                                        <div class="video_adetail">
                                                            <?php if($value->media_type=='image')
                                                            {?>
                                                            <img src="<?php echo base_url($value->post_image_url); ?>" alt="" class="sp_img">
                                                            
                                                            
                                                        <?php } 
                                                        else
                                                        {
                                                            ?>
                                                            <img src="<?php echo base_url($value->thumbnail_image); ?>" alt="" class="sp_img">
                                                            <a onclick="setURL('../<?php echo $value->post_image_url; ?>')" data-toggle="modal" data-target="#playvideo" ><i class="fa fa-play-circle-o"></i></a>

                                                            <!--   <video width="200" height="200" controls>
                                                          <source src="../<?php echo $value->post_image_url; ?>" type="video/mp4"> 
                                                        </video> -->

                                                             
                                                            <?php 
                                                        } ?>

                                                            <!-- <img src="<?php echo base_url($value->post_image_url); ?>" alt="" class="sp_img">
                                                            <a href=""><i class="fa fa-play-circle-o"></i></a> -->
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="ad-form">
                                                    <div class="portlet-body form">
                                                        <div class="form-horizontal" role="form">
                                                            <div class="form-body">
                                                                <p> <?php echo $value->post_caption; ?> </p>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <p>Ad type -- <?php echo ucfirst($value->media_type); ?> </p>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <p>  Link -- <a href=""><?php echo ucfirst($value->adv_url); ?></a> </p>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <p>  Overlay Text -- <?php echo ucfirst($value->title); ?> </p>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <p>  Date of Creation --  <?php echo ucfirst($value->date_of_creation); ?> </p>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <p>  Frequency of Ads -- <?php echo ucfirst($value->frequency_of_add); ?>  </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="approved" class="modal fade" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"> Select Frequency of Ads </h4>
                                    </div>
                                    <div class="modal-body">
 
                                            <input type="hidden" name="post_id" id="post_id">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"> Frequency of Ads </label>
                                                    <div class="col-md-5">
                                                        <select class="form-control" name="frequency_of_ads" id="frequency_of_ads">
                                                            <option value=""> --select-- </option>
                                                            <option value="once_in_week"> once a week </option>
                                                            <option value="daily"> daily </option>
                                                            <option value="once_in_month"> once a month </option>
                                                         
                                                        </select>
                                                    </div>
                                                     <div class="col-md-4">
                                                        <button type="button" onclick="approve_adv('approve')" class="btn green"> Submit </button> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-5">
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>

                                        <div id="playvideo" class="modal fade" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">  </h4>
                                    </div>
                                    <div class="modal-body">
  
                                            <div class="form-body">

                                            <video width="500" height="500" controls id="videoID">
                                              <source   type="video/mp4"> </video>  

                                            </div>
                                             
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                                        
                                        
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
                       
                
           
           