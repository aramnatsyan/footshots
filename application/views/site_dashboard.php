<?php $this->load->view('elements/header') ?>
<?php $this->load->view('elements/left_menu') ?>

<style type="text/css">
   .dashboard-stat
   {
    cursor:default !important;
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

<div class="page-content-wrapper">	
	<div class="page-content">		
		<div class="page-bar">			
			<ul class="page-breadcrumb">				
				<li>					
					<a href="#l">Home</a>					
					<i class="fa fa-circle"></i>				
				</li>				
				<li>					
					<span>Dashboard</span>				
				</li>			
			</ul>       
			 </div>		
			 <h1 class="page-title"> Admin Dashboard </h1>	

			  

                           <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                                    <div class="visual">
                                        <i class="fa fa-bar-chart-o"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="<?php echo $total_foots; ?>"><?php echo $total_foots; ?></span>  </div>
                                        <div class="desc"> Total Footshots </div>
                                    </div>
                                </a>
                            </div>
                            <!-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                                    <div class="visual">
                                        <i class="fa fa-comments"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="<?php echo $total_users; ?>"><?php echo $total_users; ?></span>
                                        </div>
                                        <div class="desc"> Total Users </div>
                                    </div>
                                </a>
                            </div> -->
                            
                             
                             <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                                    <div class="visual">
                                        <i class="fa fa-bar-chart-o"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="<?php echo $total_foots; ?>"><?php echo $active_users; ?></span>  </div>
                                        <div class="desc"> Total Active Users </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                                    <div class="visual">
                                        <i class="fa fa-bar-chart-o"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="<?php echo $total_foots; ?>"><?php echo $inactive_users; ?></span>  </div>
                                        <div class="desc"> Total Inactive Users </div>
                                    </div>
                                </a>
                            </div>
                             
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="portlet light portlet-fit bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class=" icon-layers font-green"></i>
                                            <span class="caption-subject font-green bold uppercase">Total User Registered (Monthly)</span>
                                        </div>
                                         
                                    </div>
                                    <div class="portlet-body">
                                        <div id="echarts_bar" style="height:500px;"></div>
                                    </div>
                                </div>
                            </div>
                 
                            <div class="col-md-6">
                                <div class="portlet light portlet-fit bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class=" icon-layers font-green"></i>
                                            <span class="caption-subject font-green bold uppercase">Total Footshots (Monthly)</span>
                                        </div>
                                         
                                    </div>
                                    <div class="portlet-body">
                                        <div id="echarts_bar_post" style="height:500px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

<div class="row" >
                            <div class="col-lg-12 col-xs-12 col-sm-12">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject bold uppercase"> Ads Listing </span>
                                        </div>
                                        <div class="tools">
                                           
                                            <a href="<?php echo base_url('Adds/list_ads'); ?>" class="btn green btn-sm"> View More </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th> # </th>
                                                        <th> Sponsor Name </th>
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
                                                        <td> <a href="<?php echo base_url(); ?>Sponsor/profile_sponsor/<?php echo $value->user_id;?>"> <?php echo $value->fullname; ?></a> </td>
                                                        <td> <a href="<?php echo base_url('Adds/my_add_detail/'.$value->post_id); ?>"> <?php echo ucfirst($value->post_caption); ?>  </a> </td>
                                                        <td> <?php echo ucfirst($value->media_type); ?> </td>
                                                        <td>
                                                            <?php if ($value->media_type=='image') {
                                                                # code...
                                                           ?>
                                                            <img   src="<?php echo $value->post_image_url; ?>" alt="" class="img-responsive ad-img">
                                                        <?php } ?>
                                                        </td>
                                                        <td class="video_adetail"> <?php if ($value->media_type=='video') {
                                                                # code...
                                                           ?>
                                                             <img   src="<?php echo $value->thumbnail_image; ?>" alt="" class="img-responsive ad-img">
                                                               <a onclick="setURL('<?php echo $value->post_image_url; ?>')" data-toggle="modal" data-target="#playvideo" ><i class="fa fa-play-circle-o"></i></a>

                                                         <!--    <video width="200" height="200" controls>
                                                          <source src="../<?php echo $value->post_image_url; ?>" type="video/mp4"> </video> -->
                                                        <?php } ?> </td>
                                                        <td> <?php echo date("d M, Y H:i:s",strtotime($value->date_of_creation));?> </td>
                                                        <td>
                                                            <button  data-post_id="<?php echo $value->post_id; ?>"  class="btn btn-outline btn-circle btn-xs green trrig" data-toggle="modal" data-target="#approve" onclick="approve_adv('approve','<?php echo $value->post_id; ?>'');"> Approve </button>
                                                        </td>
                                                    </tr>
                                                     <?php     # code...
                                                      $count++;
                                                    } ?>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        <div id="playvideo" class="modal fade" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">   </h4>
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
                        <?php //echo print_r($total_users_chart); ?>
                        <?php //echo print_r($total_foots_chart); ?>
                        <!-- <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            	<img src="upload/posts.png">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                            	<img src="upload/users.png">
                            </div>
                             
                             
                        </div> -->



			</diV>
</div>

 
<?php $this->load->view('elements/footerdashboard') ?>
                       
                
           
           