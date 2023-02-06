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
                                    <span> View Sponsors </span>
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
                                            <span class="caption-subject bold uppercase"> Sponsor List </span>
                                        </div>
                                        <div class="tools"> <a href="<?php echo base_url('Sponsor/create_sponsor'); ?>" class="btn btn-default btn-sm">
                                                <i class="fa fa-plus"></i> Create  Sponsor</a></div>
                                    </div>
                                    <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                                            <thead>
                                                    <tr>
                                                        <th> # </th>
                                                        <th> Sponsor Name </th>
                                                        <th> Total Live Ads </th>
                                                        <th> Total Published Ads </th>
                                                        <th> Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $count = 1;

                                                          foreach ($allsponose as   $value) {
                                                       ?>
                                                    <tr>
                                                        <td> <?php echo $count; ?> </td>
                                                        <td> <a href="<?php echo base_url('/Sponsor/profile_sponsor/'.$value->user_id)?>"> <?php echo $value->first_name.' '.$value->last_name;?> </a> </td>
                                                        <td> <?php echo $value->liveads;?> </td>
                                                        <td> <?php echo $value->published;?> </td>
                                                         
                                                             <td id="userstatus<?php echo $value->user_id; ?>"> 
                                                       <?php if($value->status=='Active') {?> <button onclick="block_unblock('<?php echo $value->user_id; ?>','Blocked');" class="btn btn-xs btn-success"> Active </button> <?php } ?>   
                                                       <?php   if($value->status=='Blocked') {?> <button onclick="block_unblock('<?php echo $value->user_id; ?>','Active');" class="btn btn-xs btn-danger"> Inactive </button> <?php } ?> 
                                                           
                                                        </td>
                                                    </tr>
                                                    <?php 
                                                    $count++;
                                                    }
                                                    ?>
                                                </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
<?php 


 
$this->load->view('elements/footer') ?>
                       
                
           
           