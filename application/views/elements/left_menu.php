<?php 
$uri1 = uri_segment('1');
$uri2 = uri_segment('2');
$uri3 = uri_segment('3');
?>
<?php $sedatas=$this->session->all_userdata();
 
?>
<div class="clearfix"> </div>
    <div class="page-container">
		<div class="page-sidebar-wrapper">
            <div class="page-sidebar navbar-collapse collapse">
				<ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
					 
					<?php if($sedatas['userinfo']->app_user_id==0)
 						{ ?>
					<li class="nav-item start ">
						<a href="<?php echo base_url();  ?>dashboard" class="nav-link nav-toggle">
							 <img src="<?php echo base_url();?>assets/logo.png" alt="logo" class="logo-default center-block" /> </a>
					 
						</a>
					</li>
					<li class="nav-item start <?php if ($uri1 == 'dashboard') { echo 'active open'; } ?> ">
						<a href="<?php echo base_url();  ?>dashboard" class="nav-link nav-toggle">
							<i class="icon-home"></i>
							<span class="title">Dashboard</span>
							<span class="selected"></span>
					 
						</a>
					</li>
					<!-- <li class="nav-item start <?php if ($uri1 == 'users' &&   $uri2 == '') { echo 'active open'; } ?> ">
						<a href="<?php echo base_url();  ?>users" class="nav-link nav-toggle">
							<i class="icon-users"></i>
							<span class="title">Users</span>
							<span class="selected"></span>
					 
						</a>
					</li> -->
					<li class="nav-item start <?php if ($uri1 == 'users' && $uri2 == 'topusers' ) { echo 'active open'; } ?> ">
						<a href="<?php echo base_url();  ?>users/topusers" class="nav-link nav-toggle">
							<i class="icon-users"></i>
							<span class="title">Top Users</span>
							<span class="selected"></span>
					 
						</a>
					</li>

					<li class="nav-item start <?php if ($uri1 == 'users' && $uri2 == 'activeusers' ) { echo 'active open'; } ?> ">
						<a href="<?php echo base_url();  ?>users/activeusers" class="nav-link nav-toggle">
							<i class="icon-users"></i>
							<span class="title">Active Users</span>
							<span class="selected"></span>
					 
						</a>
					</li>
					
					<li class="nav-item start <?php if ($uri1 == 'posts' && $uri2 == 'monthsfoots') { echo 'active open'; } ?> ">
						<a href="<?php echo base_url();  ?>posts/monthsfoots" class="nav-link nav-toggle">
							<i class="fa fa-bars"></i>
							<span class="title">Footshots of Month</span>
							<span class="selected"></span>
					 
						</a>
					</li>
					<li class="nav-item start <?php if  ($uri1 == 'charity'  ) { echo 'active open'; } ?> ">
						<a href="<?php echo base_url();  ?>charity" class="nav-link nav-toggle">
							<i class="fa fa-bars"></i>
							<span class="title">Charity</span>
							<span class="selected"></span>
					 
						</a>
					</li>

					<li class="nav-item start <?php if  ($uri1 == 'vectormap'  ) { echo 'active open'; } ?> ">
						<a href="<?php echo base_url();  ?>vectormap" class="nav-link nav-toggle">
							<i class="icon-users"></i>
							<span class="title">Heat Map</span>
							<span class="selected"></span>
					 
						</a>
					</li>

					

					<li class="nav-item start <?php if ($uri1 == 'reportabouse' &&   $uri2 == '') { echo 'active open'; } ?> ">
						<a href="<?php echo base_url();  ?>reportabouse" class="nav-link nav-toggle">
							<i class="fa fa-bars"></i>
							<span class="title">Reported Abuse</span>
							<span class="selected"></span>
					 
						</a>
					</li>
				 
					<li class="nav-item start <?php if ($uri1 == 'users' && $uri2 == 'inactiveusers' ) { echo 'active open'; } ?> ">
						<a href="<?php echo base_url();  ?>users/inactiveusers" class="nav-link nav-toggle">
							<i class="icon-users"></i>
							<span class="title">Inactive Users</span>
							<span class="selected"></span>
					 
						</a>
					</li>
					

				

					<li class="nav-item start <?php if ($uri1 == 'tags' ) { echo 'active open'; } ?> ">
						<a href="<?php echo base_url();  ?>tags" class="nav-link nav-toggle">
							<i class="fa fa-tags"></i>
							<span class="title">Product Tags</span>
							<span class="selected"></span>
					 
						</a>
					</li>

					<li class="nav-item start <?php if ($uri1 == 'hashtags' ) { echo 'active open'; } ?> ">
						<a href="<?php echo base_url();  ?>hashtags" class="nav-link nav-toggle">
							<i class="fa fa-tags"></i>
							<span class="title">Hash Tags</span>
							<span class="selected"></span>
					 
						</a>
					</li>
					 
					

					<li class="nav-item start <?php if ($uri1 == 'Blockwords' ) { echo 'active open'; } ?> ">
						<a href="<?php echo base_url();  ?>Blockwords" class="nav-link nav-toggle">
							<i class="fa fa-tags"></i>
							<span class="title">Block Words</span>
							<span class="selected"></span>
					 
						</a>
					</li>
					<li class="nav-item start <?php if ($uri1 == 'Sponsor' &&   $uri2 == '') { echo 'active open'; } ?> ">
						<a href="<?php echo base_url();  ?>Sponsor/list_sponsors" class="nav-link nav-toggle">
							<i class="icon-users"></i>
							<span class="title">Sponsor</span>
							<span class="selected"></span>
					 
						</a>
					</li>
					 <li class="nav-item">
                        <a href="<?php echo base_url(); ?>Adds/list_report_ads" class="nav-link nav-toggle">
                            <i class="icon-volume-2"></i>
                            <span class="title"> Report Ads </span>
                            <span class="selected"></span>
                        </a>
                    </li>
                     <li class="nav-item">
                        <a href="<?php echo base_url(); ?>Adds/list_hide_ads" class="nav-link nav-toggle">
                            <i class="icon-volume-2"></i>
                            <span class="title"> Hidden Ads </span>
                            <span class="selected"></span>
                        </a>
                    </li>
					<?php } else if($sedatas['userinfo']->app_user_id!=0){?>
						 
                            <li class="nav-item start">
                                <a href="<?php echo base_url(); ?>Sponsor/profile_sponsor/<?php echo $sedatas['userinfo']->app_user_id;?>" class="nav-link nav-toggle">
                                    <i class="icon-users"></i>
                                    <span class="title"> Profile </span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url(); ?>Adds/my_add" class="nav-link nav-toggle">
                                    <i class="icon-volume-2"></i>
                                    <span class="title"> My Ads </span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            <li class="nav-item">
                            	<?php 
                            	
                            	
                            	$user_id = $sedatas['userinfo']->app_user_id;
    
						         $this->db->select('*');        
						        $this->db->from('foot_sponsor');
						        $this->db->where('user_id',$user_id);
						        $query = $this->db->get();
						        $sponsorResult = $query->row();
						        $validity = $sponsorResult->validity;
						        if($validity>=date("Y-m-d"))
						        {
						        	 $this->db->select('*');        
							        $this->db->from('foot_app_users');
							        $this->db->where('user_id',$user_id);
							        $queryappuse = $this->db->get();
							        $appuserResult = $queryappuse->row();
							        if($appuserResult->status=='Active')
							        { 
							    ?>	
							    <a href="<?php echo base_url(); ?>Adds/create_add" class="nav-link nav-toggle">
                                    <i class="icon-microphone"></i>
                                    <span class="title"> Create Ad </span>
                                    <span class="selected"></span>
                                </a>
							     <?php 
							  		}
							  		else if($appuserResult->status=='Blocked')
							        {
							        	?>
							        		<a href="#" onclick="AlertonCreeatpost('Your account has been blocked by admin. Please contact admin for create post.');" class="nav-link nav-toggle">
		                                    <i class="icon-microphone"></i>
		                                    <span class="title"> Create Ad </span>
		                                    <span class="selected"></span>
		                                </a>
							        <?php }
							      ?>
							 
 

                                
                            <?php } else  {?>
                           		
                           		 <a href="#" onclick="AlertonCreeatpost('Your account validity has been expired. Please contact admin for create post.');" class="nav-link nav-toggle">
		                                    <i class="icon-microphone"></i>
		                                    <span class="title"> Create Ad </span>
		                                    <span class="selected"></span>
		                                </a>
                            <?php } ?>
                            </li>

                            <?php } ?>
					
				 
					 
				</ul>
			</div>
        </div>
        <!-- END SIDEBAR -->