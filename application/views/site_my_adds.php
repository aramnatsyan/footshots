<?php $this->load->view('elements/header'); ?>
<?php $this->load->view('elements/left_menu') ;
$uri1 = uri_segment('1');
$uri2 = uri_segment('2');
$uri3 = uri_segment('3');
?>
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
                                    <span> My Ads </span>
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
                                            <i class="icon-volume-2 font-dark"></i>
                                            <span class="caption-subject bold uppercase"> My Ads </span>
                                        </div>
                                        <div class="tools"> </div>
                                    </div>
                                    <div class="portlet-body">
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
                                                    foreach ($allsponose as $value) { ?>
                                                    
                                                    <tr>
                                                        <td> <?php echo $count; ?> </td>
                                                        <td> <a href="<?php echo base_url('Adds/my_add_detail/'.$value->post_id); ?>"> <?php echo $value->post_caption; ?> </a> </td>
                                                        <td> <?php echo ucfirst($value->media_type); ?>  </td>
                                                        <td>
                                                            <?php if ($value->media_type=='image') {
                                                                # code...
                                                           ?>
                                                            <img   src="../<?php echo $value->post_image_url; ?>" alt="" class="img-responsive ad-img">
                                                        <?php } ?>
                                                        </td>
                                                        <td class="video_adetail"> <?php if ($value->media_type=='video') {
                                                                # code...
                                                           ?>
                                                              <img   src="<?php echo base_url($value->thumbnail_image); ?>" alt="" class="img-responsive ad-img  ">
                                                         <a onclick="setURL('../<?php echo $value->post_image_url; ?>')" data-toggle="modal" data-target="#playvideo" ><i class="fa fa-play-circle-o"></i></a>

                                                        <!--    <video width="200" height="200" controls>
                                                          <source src="../<?php echo $value->post_image_url; ?>" type="video/mp4"> 
                                                        </video> -->
 
                                                        <?php } ?> </td>
                                                        <td> <?php echo  date("d M, Y H:i:s",strtotime($value->date_of_creation)); ?> </td>
                                                        <td> <?php echo ucfirst($value->frequency_of_add); ?> </td>
                                                        <td> <span class="badge  "> <?php echo ucfirst($value->status_of_add); ?> </span> </td>
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
                    <!-- END CONTENT BODY -->
                </div>
<?php 


 
$this->load->view('elements/footer') ?>
                       
                
           
           