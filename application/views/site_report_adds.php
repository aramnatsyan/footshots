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
                                    <a href="<?php echo base_url('dashboard');?>">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span> All Reported Ads </span>
                                </li>
                            </ul>
                        </div>
                       
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title">  </h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        
                        <div class="row">
                            <div class="col-lg-12 col-xs-12 col-sm-12">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject bold uppercase"> Ads </span>
                                        </div>
                                        <div class="tools"> </div>
                                    </div>
                                    <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                                            <thead>
                                                    <tr>
                                                        <th> # </th>
                                                        <th> Sponsor Name </th>
                                                        <th> Username </th>
                                                        <th> Ad Title </th>
                                                        <th> Ad Type </th>
                                                        <th> Image </th>
                                                        <th> Video </th>
                                                        <th> Date of Creation </th>
                                                         <th> Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                  
                                                     <?php $count =1;
                                                    foreach ($total_advs as $value) { ?>
                                                    <tr id="adv_post_<?php echo $value->post_id; ?>">
                                                        <td> <?php echo $count; ?> </td>
                                                        <td> <a href="<?php echo base_url(); ?>Sponsor/profile_sponsor/<?php echo $value->user_id;?>"> <?php echo $value->fullname; ?></a> </td><td> <a href="<?php echo base_url(); ?>users/userdetail/<?php echo $value->hide_user_id;?>"> <?php echo $value->hide_username; ?></a> </td>
                                                        <td> <a href="<?php echo base_url('Adds/my_add_detail/'.$value->post_id); ?>"> <?php echo ucfirst($value->post_caption); ?>  </a> </td>
                                                        <td> <?php echo ucfirst($value->media_type); ?> </td>
                                                        <td>
                                                            <?php if ($value->media_type=='image') {
                                                                # code...
                                                           ?>
                                                            <img   src="<?php echo base_url($value->post_image_url); ?>" alt="" class="img-responsive ad-img">
                                                        <?php } ?>
                                                        </td>
                                                        <td> <?php if ($value->media_type=='video') {
                                                                # code...
                                                           ?>
                                                             <video width="200" height="200" controls>
                                                          <source src="../<?php echo $value->post_image_url; ?>" type="video/mp4"> 
                                                        </video>
                                                        <?php } ?> </td>
                                                        <td> <?php echo date("d M, Y H:i:s",strtotime($value->date_of_creation));?> </td>
                                                        <td>
                                                            <button onclick="block_unblock_post_ad('<?php echo $value->post_id; ?>','block');" class="btn btn-xs btn-success"> Active </button>
                                                        </td>
                                                          
                                                    </tr>
                                                     <?php     # code...
                                                      $count++;
                                                    } ?>
                                                    
                                                </tbody>
                                        </table>
                                        <div id="approve" class="modal fade" tabindex="-1" aria-hidden="true">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
<?php 


 
$this->load->view('elements/footer') ?>
                       
                
           
           