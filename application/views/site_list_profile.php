<?php $this->load->view('elements/header'); ?>
<?php $this->load->view('elements/left_menu') ;
$uri1 = uri_segment('1');
$uri2 = uri_segment('2');
$uri3 = uri_segment('3');
?>
<style type="text/css">
    .profile-userpic img {
    width: 180px;
    height: 180px;
}

</style>
<style type="text/css">
    .video_adetail i {
    position: absolute;
    top: 32px;
    left: 23px;
    color: 
    #fff;
    font-size: 3.3rem;
}
</style>
<?php $sedatas=$this->session->all_userdata();
 
?>
  <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="<?php echo base_url('dashboard'); ?>">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span> Sponsor Profile</span>
                                </li>
                            </ul>
                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title"> Sponsor Profile </h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->

                        <div class="row">
                             <?php echo get_flashdata() ;?>
                            <div class="col-md-12">
                                <!-- BEGIN PROFILE SIDEBAR -->
                                <div class="profile-sidebar">
                                    <!-- PORTLET MAIN -->
                                    <div class="portlet light profile-sidebar-portlet ">
                                        <!-- SIDEBAR USERPIC -->
                                        <div class="profile-userpic">
                                            <img src="<?php echo $allsponose->profileimage;?>" class="img-responsive" alt=""> </div>
                                        <!-- END SIDEBAR USERPIC -->
                                        <!-- SIDEBAR USER TITLE -->
                                        <div class="profile-usertitle">
                                            <div class="profile-usertitle-name"> <?php echo $allsponose->first_name.' '.$allsponose->last_name; ?> </div>
                                            <div class="profile-usertitle-job"> <?php echo $allsponose->fullname;?> </div>
                                        </div>
                                        <!-- END SIDEBAR USER TITLE -->
                                        <div class="user-info">
                                            <div class="margin-top-20 profile-desc-link">
                                                <i class="fa fa-clock-o"></i>

                                             
                                                <?php if($sedatas['userinfo']->app_user_id==0)
                                                 { ?>

                                                <a data-toggle="modal" data-target="#approve" title="Account Validity"> <?php echo $allsponose->validity;?> </a>
                                            <?php } else { ?>

                                                   <span  title="Account Validity"> <?php echo $allsponose->validity;?> </span> 

                                            <?php } ?>

                                        <div id="approve" class="modal fade" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                             <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>Sponsor/updatevadity" enctype="multipart/form-data" role="form">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h4 class="modal-title"> Change the Validity </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="user_id" value="<?php echo $allsponose->user_id;?>">
                 
                                                            
                                                            <div class="form-body">
                                                                <div class="form-group">
                                                                    <label class="col-md-3 control-label"> Validity </label>
                                                                    <div class="col-md-5"> 
                                                                        <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                            <input required value="<?php echo $allsponose->validity;?>" type="text" class="form-control" readonly name="account_validity">
                                                            <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-calendar"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-actions">
                                                                <div class="row">
                                                                    <div class="col-md-offset-3 col-md-5">
                                                                        <button type="submit"  class="btn green"> Submit </button> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                       
                                                    </div>
                                                </div>
                                            </form>
                                            </div>
                                        </div>

                                            </div>
                                            <div class="margin-top-20 profile-desc-link">
                                                <i class="fa fa-location-arrow"></i>
                                                <span  title="Organisation Address"> <?php echo $allsponose->address;?> </span>
                                            </div>
                                            <div class="margin-top-20 profile-desc-link">
                                                <i class="fa fa-envelope"></i>
                                                <span title="Email"> <?php echo $allsponose->useremail;?> </span>
                                            </div>
                                            <div class="margin-top-20 profile-desc-link">
                                                <i class="fa fa-mobile"></i>
                                                <span   title="Phone Number"> <?php echo $allsponose->phone;?> </span>
                                            </div>
                                            <div class="profile-userbuttons">
                                                 <a data-toggle="modal" data-target="#edit_profile"  class="btn btn-circle red btn-sm btn-block">Edit Profile </a>
                                                     <?php if($sedatas['userinfo']->app_user_id==0)
                                                 { ?>

                                                <a data-toggle="modal" data-target="#approvebutton"  class="btn btn-circle blue btn-sm btn-block"><?php echo ucfirst($allsponose->adv_type);?> </a>

                                                <a data-toggle="modal" data-target="#approvebutton"  class="btn btn-circle blue btn-sm btn-block"> Quota of Ads -- <?php echo $allsponose->total_ads;?> </a>
                                            <?php } else { ?>
                                                            <button  class="btn btn-circle blue btn-sm btn-block"><?php echo ucfirst($allsponose->adv_type);?> </button>

                                                <button   class="btn btn-circle blue btn-sm btn-block"> Quota of Ads -- <?php echo $allsponose->total_ads;?> </button>

                                            <?php } ?>

                                            </div>
                                            <div id="approvebutton" class="modal fade" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                              <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>Sponsor/updatetype" enctype="multipart/form-data" role="form">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h4 class="modal-title"> Change Detail </h4>
                                                    </div>
                                                    <div class="modal-body">
                 
                                                            <input type="hidden" name="user_id" value="<?php echo $allsponose->user_id;?>">
                                                            <div class="form-body">
                                                                <div class="form-group">
                                                                <label class="col-md-3 control-label"> Ad Type </label>
                                                                <div class="col-md-9">
                                                                    <div class="mt-radio-inline">
                                                                        <label class="mt-radio">
                                                                            <input type="radio" name="optionsRadios" id="optionsRadios25" value="image" <?php if($allsponose->adv_type=='image') echo "checked" ?> > Image
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio">
                                                                            <input type="radio" name="optionsRadios" id="optionsRadios26" value="video" <?php if($allsponose->adv_type=='video') echo "checked" ?>   > Video
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio ">
                                                                            <input type="radio" name="optionsRadios" id="optionsRadios27" value="both" <?php if($allsponose->adv_type=='both') echo "checked" ?>  > Both (Image & Video)
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                    <label class="col-md-3 control-label"> Quota of Ads can post </label>
                                                    <div class="col-md-5">
                                                        <input type="number" min="0" class="form-control" name="org_quota" placeholder="Enter quota of ads" value="<?php echo $allsponose->total_ads ?>" >
                                                    </div>
                                                </div>
                                                            </div>
                                                            <div class="form-actions">
                                                                <div class="row">
                                                                    <div class="col-md-offset-3 col-md-5">
                                                                        <button type="submit"  class="btn green"> Submit </button> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                       
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>

                                        </div>
                                        
                                        
                                    </div>
                                    <!-- END PORTLET MAIN -->
                                </div>
                                <!-- END BEGIN PROFILE SIDEBAR -->
                                <!-- BEGIN PROFILE CONTENT -->
                                <div class="profile-content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="portlet light ">
                                                <div class="portlet-title tabbable-line">
                                                    <div class="caption caption-md">
                                                        <i class="icon-globe theme-font hide"></i>
                                                        <span class="caption-subject font-blue-madison bold uppercase"> Ads Listing </span>
                                                    </div>
                                                    <ul class="nav nav-tabs">
                                                        <li class="active">
                                                            <a href="#tab_1_1" data-toggle="tab"> All Ads </a>
                                                        </li>
                                                        <li>
                                                            <a href="#tab_1_2" data-toggle="tab"> Published Ads </a>
                                                        </li>
                                                        <li>
                                                            <a href="#tab_1_3" data-toggle="tab"> Unpublished Ads </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="tab-content">
                                                        <!-- all TAB -->
                                                        <div class="tab-pane active" id="tab_1_1">
                                                            <table class="table table-striped table-bordered table-hover" id="sample_1">
                                                                <thead>
                                                                        <tr>
                                                                            <th> # </th>
                                                                            <th> Ad Title </th>
                                                                            <th> Ad Type </th>
                                                                            <th> Image </th>
                                                                            <th> Video </th>
                                                                            <th> Date of Creation </th>
                                                                            <th> Frequency of Ads </th>
                                                                            <th> Status </th>
                                                                        </tr>
                                                                    </thead>
                                                                  <tbody>
                                                    <?php $count =1;
                                                    foreach ($resultadsall as $value) { ?>
                                                    
                                                    <tr id="adv_post_<?php echo $value->post_id; ?>">
                                                        <td> <?php echo $count; ?> </td>
                                                        <td> <a href="<?php echo base_url('Adds/my_add_detail/'.$value->post_id); ?>"> <?php echo ucfirst($value->post_caption); ?>  </a> </td>
                                                        <td> <?php echo ucfirst($value->media_type); ?>  </td>
                                                        <td>
                                                            <?php if ($value->media_type=='image') {
                                                                # code...
                                                           ?>
                                                            <img   src="<?php echo base_url($value->post_image_url); ?>" alt="" class="img-responsive ad-img">
                                                        <?php } ?>
                                                        </td>
                                                        <td class="video_adetail"> <?php if ($value->media_type=='video') {
                                                                # code...
                                                           ?>
                                                             <img   src="<?php echo base_url($value->thumbnail_image); ?>" alt="" class="img-responsive ad-img  ">
                                                           <a onclick="setURL('../../<?php echo $value->post_image_url; ?>')" data-toggle="modal" data-target="#playvideo" ><i class="fa fa-play-circle-o"></i></a>

                                                          <!--  <video width="100" height="100" controls>
                                                          <source src="../<?php echo $value->post_image_url; ?>" type="video/mp4"> 
                                                        </video> -->
 
                                                        <?php } ?> </td>
                                                        <td><?php echo date("d M, Y H:i:s",strtotime($value->date_of_creation)); ?></td>
                                                        <td> <?php echo ucfirst($value->frequency_of_add); ?> </td>
                                                        <td>   
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
                                                    <?php } ?>  </td>
                                                    </tr>
                                                      <?php     # code...
                                                      $count++;
                                                    } ?>
                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- END all TAB -->
                                                        <!-- unpublished TAB -->
                                                        <div class="tab-pane" id="tab_1_2">
                                                            <table class="table table-striped table-bordered table-hover" id="sample_3">
                                                                <thead>
                                                                        <tr>
                                                                            <th> # </th>
                                                                            <th> Ad Title </th>
                                                                            <th> Ad Type </th>
                                                                            <th> Image </th>
                                                                            <th> Video </th>
                                                                            <th> Date of Creation </th>
                                                                            <th> Frequency of Ads </th>
                                                                            <th> Status </th>
                                                                        </tr>
                                                                    </thead>
                                                                   <tbody>
                                                    <?php $count =1;
                                                    foreach ($resultads as $value) { ?>
                                                    
                                                    <tr>
                                                        <td> <?php echo $count; ?> </td>
                                                        <td> <a href="<?php echo base_url('Adds/my_add_detail/'.$value->post_id); ?>"> <?php echo ucfirst($value->post_caption); ?>  </a> </td>
                                                        <td> <?php echo ucfirst($value->media_type); ?>  </td>
                                                        <td>
                                                            <?php if ($value->media_type=='image') {
                                                                # code...
                                                           ?>
                                                            <img   src="<?php echo base_url($value->post_image_url); ?>" alt="" class="img-responsive ad-img">
                                                        <?php } ?>
                                                        </td>
                                                        <td class="video_adetail"> <?php if ($value->media_type=='video') {
                                                                # code...
                                                           ?>
                                                                <img   src="<?php echo base_url($value->thumbnail_image); ?>" alt="" class="img-responsive ad-img  ">
                                                         <a onclick="setURL('../../<?php echo $value->post_image_url; ?>')" data-toggle="modal" data-target="#playvideo" ><i class="fa fa-play-circle-o"></i></a>
                                                           <!-- <video width="100" height="100" controls>
                                                          <source src="../<?php echo $value->post_image_url; ?>" type="video/mp4"> 
                                                        </video> -->
 
                                                        <?php } ?> </td>
                                                        <td> <?php echo date("d M, Y H:i:s",strtotime($value->date_of_creation)); ?> </td>
                                                        <td> <?php echo ucfirst($value->frequency_of_add); ?> </td>
                                                        <td> <span class="badge <?php if($value->status_of_add=='approved') { echo 'badge-success'; } else { echo 'badge-danger'; }?> "> <?php echo ucfirst($value->status_of_add); ?> </span> </td>
                                                    </tr>
                                                      <?php     # code...
                                                      $count++;
                                                    } ?>
                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- END unpublished TAB -->
                                                        <!-- published TAB -->
                                                        <div class="tab-pane" id="tab_1_3">
                                                            <table class="table table-striped table-bordered table-hover" id="sample_1_2">
                                                                <thead>
                                                                        <tr>
                                                                            <th> # </th>
                                                                            <th> Ad Title </th>
                                                                            <th> Ad Type </th>
                                                                            <th> Image </th>
                                                                            <th> Video </th>
                                                                            <th> Date of Creation </th>
                                                                            <th> Frequency of Ads </th>
                                                                            <th> Status </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                    <?php $count =1;
                                                    foreach ($resultadspending as $value) { ?>
                                                    
                                                    <tr id="adv_post_<?php echo $value->post_id; ?>">
                                                        <td> <?php echo $count; ?> </td>
                                                        <td> <a href="<?php echo base_url('Adds/my_add_detail/'.$value->post_id); ?>"> <?php echo ucfirst($value->post_caption); ?>  </a> </td>
                                                        <td> <?php echo ucfirst($value->media_type); ?>  </td>
                                                        <td>
                                                            <?php if ($value->media_type=='image') {
                                                                # code...
                                                           ?>
                                                            <img   src="<?php echo base_url($value->post_image_url); ?>" alt="" class="img-responsive ad-img">
                                                        <?php } ?>
                                                        </td>
                                                        <td class="video_adetail"> <?php if ($value->media_type=='video') {
                                                                # code...
                                                           ?>
                                                                <img   src="<?php echo base_url($value->thumbnail_image); ?>" alt="" class="img-responsive ad-img   ">
                                                           <a onclick="setURL('../../<?php echo $value->post_image_url; ?>')" data-toggle="modal" data-target="#playvideo" ><i class="fa fa-play-circle-o"></i></a>
                                                           <!-- <video width="100" height="100" controls>
                                                          <source src="../<?php echo $value->post_image_url; ?>" type="video/mp4"> 
                                                        </video> -->
 
                                                        <?php } ?> </td>
                                                        <td> <?php echo date("d M, Y H:i:s",strtotime($value->date_of_creation)); ?> </td>
                                                        <td> <?php echo ucfirst($value->frequency_of_add); ?> </td>
                                                        <td>  <?php $sedatas=$this->session->all_userdata();
 
                                                            if($sedatas['userinfo']->app_user_id==0)
                                                                        { 
                                                        if($value->status_of_add=='approved'){?>
                                                            <button    class="btn btn-outline btn-circle btn-xs green trrig"    > Approve </button> <?php } else {?>
                                                         <button  data-post_id="<?php echo $value->post_id; ?>"  class="btn btn-outline btn-circle btn-xs red trrig" data-toggle="modal" data-target="#approved" onclick="approve_adv('approve','<?php echo $value->post_id; ?>'');"> Pending </button>
                                                     <?php } ?>


                                                             
                                                         <?php } else 
                                                         { ?>


                                                            <span class="badge <?php if($value->status_of_add=='approved') { echo 'badge-success'; } else { echo 'badge-danger'; }?> "> <?php echo ucfirst($value->status_of_add); ?> </span>
                                                    <?php } ?>  </td>
                                                    </tr>
                                                      <?php     # code...
                                                      $count++;
                                                    } ?>
                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- END published TAB -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="edit_profile" class="modal fade" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>Sponsor/update_sponsor" enctype="multipart/form-data" role="form">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"> Edit Profile </h4>
                                    </div>
                                    <div class="modal-body">
                                            
                                            <input type="hidden" name="sponsor_id" id="sponsor_id" value="<?php echo $allsponose->user_id;?>">
                                            <div class="form-body">
                                                 <div class="form-group  row">
                                                    <label class="col-md-3 control-label"> First Name <span class="required" aria-required="true"> * </span></label>
                                                    <div class="col-md-8">
                                                        <input type="text" value="<?php echo $allsponose->first_name;?>" required name="first_name" class="form-control" placeholder="Enter first name">
                                                    </div>
                                                </div>
                                                <div class="form-group  row">
                                                    <label class="col-md-3 control-label"> Last Name <span class="required" aria-required="true"> * </span></label>
                                                    <div class="col-md-8">
                                                        <input type="text" required  value="<?php echo $allsponose->last_name;?>"  name="last_name" class="form-control" placeholder="Enter last name">
                                                    </div>
                                                </div>
                                                <div class="form-group  row">
                                                    <label class="col-md-3 control-label"> Organisation Address </label>
                                                    <div class="col-md-8">
                                                        <textarea class="form-control"  name="org_address" placeholder="Enter organisation address"><?php echo $allsponose->address;?></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-3 control-label"> Phone Number </label>
                                                    <div class="col-md-8">
                                                        <input type="text" value="<?php echo $allsponose->phone;?>"  name="org_phone" class="form-control" placeholder="Enter phone number">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="exampleInputFile" class="col-md-3 control-label"> Organisation Profile Picture <span class="required" aria-required="true"> * </span></label>
                                                    <div class="col-md-4">
                                                        <input type="file" accept="image/jpeg,image/png,image/jpg"   name="org_profile" id="ff2">
                                                    </div>
                                                    <div class="col-md-4">
                                                         <img src="<?php echo $allsponose->profileimage;?>" class="img-responsive" alt=""> 
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-5">
                                                        <button type="submit" class="btn green"> Submit </button> 
                                                    </div>
                                                </div>
                                            </div>
                                       
                                    </div>
                                </div>
                            </form>
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
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-5">
                                                        <button type="button" onclick="approve_adv('approve')" class="btn green"> Submit </button> 
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
                                <!-- END PROFILE CONTENT -->
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
<?php 


 
$this->load->view('elements/footer') ?>
                       
                
           
           