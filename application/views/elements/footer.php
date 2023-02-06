 <div class="modal fade bs-modal-lg" id="basicImage" tabindex="-1" role="basic" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                      
                                                    </div>
                                                    <div class="modal-body"> 

                                                      <img class="img-responsive center-block" src="" id="viewImage"> 
                                                    </div>
                                                    <div class="modal-footer">
                                                        
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>

</div>
<!-- END CONTAINER -->
 <!-- BEGIN FOOTER -->

            <div class="page-footer">
                <div class="page-footer-inner">Copyright  &copy; 2019,  
                    
                    <a href="#"   target="_blank">Footshots Pty. Ltd.</a>
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
            <!-- END FOOTER -->
        </div>
        

	
 
		<script src="<?php echo base_url();?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS --> 
        <script src="<?php echo base_url();?>assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>  
        <!-- END PAGE LEVEL PLUGINS -->

		 
        <!-- END THEME GLOBAL SCRIPTS -->
          <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo base_url();?>assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-table/bootstrap-table.min.js" type="text/javascript"></script> 
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url();?>assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
         <script src="<?php echo base_url();?>assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
           <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
                <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo base_url();?>assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
      
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url();?>assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script> 
		<script src="<?php echo base_url();?>assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>assets/global/plugins/moment.min.js" type="text/javascript"></script>
    
        <script src="<?php echo base_url();?>assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
         <script type="text/javascript">
            
         $(document).on('click','.trrig',function(){

          $('#post_id').val($(this).data('post_id'));
         });

          function setURL(URL)
         {
          $('#videoID').attr('src',URL);
          $('#videoID').load();
         }
         function approve_adv(modelId)
         {
            App.blockUI();   
            var post_id = $('#post_id').val();
            var frequency_of_ads = $('#frequency_of_ads').val();
            if(frequency_of_ads=="")     
            {
                alert("Please select frequency of ad.");
            }
            else
            {



                $.ajax({
                  type: "POST",
                  url: "<?php echo site_url();?>Adds/approveadd/"+post_id+"/"+frequency_of_ads,
                  dataType: "html",
                  success:function(data){
                     
                    $("#adv_post_"+post_id).hide();
                   $('#'+modelId).modal('hide');
                    App.unblockUI();
                  },

                });
             }
         }
         
function deleteuser(user_id)
{
   var va = confirm("Are you sure you want to delete this user ?");
                      if( va==true )
                      { 
                      // App.blockUI();        

                         $.ajax({
                                  type: "POST",
                                  url: "<?php echo site_url();?>users/deleteuser/"+user_id,
                                  dataType: "html",
                                  success:function(data){
                                     console.log(data);
                                    $("#user_id_"+user_id).hide();
                                    // App.unblockUI();
                                  },

                                });
                        }
}

        </script>
         
        <!-- <script src="<?php echo base_url();?>assets/pages/scripts/profile.min.js" type="text/javascript"></script> -->       
        
        <script type="text/javascript">
            
         var myVideos = [];

        window.URL = window.URL || window.webkitURL;

         document.getElementById('fileUp').onchange = setFileInfo;
         

        function setFileInfo() {
          var files = this.files;
          myVideos.push(files[0]);
          var video = document.createElement('video');
          video.preload = 'metadata';

          video.onloadedmetadata = function() {
            window.URL.revokeObjectURL(video.src);
            var duration = video.duration;
            myVideos[myVideos.length - 1].duration = duration;
            updateInfos();
          }

          video.src = URL.createObjectURL(files[0]);;
        }


        function updateInfos() {
         // var infos = document.getElementById('infos');
        //  infos.textContent = "";
          for (var i = 0; i < myVideos.length; i++) {
            var videoDuration = myVideos[i].duration;
          }
          if(videoDuration>15)
          {
            alert("Please select maximum duration: 15 sec");
             document.getElementById("fileUp").value = null;  
           }
        }
        function AlertonCreeatpost(alertmsg) {
          alert(alertmsg);
        }

        </script>

        <script type="text/javascript">

          

          $(document).ready(function() {
          $('#optionsRadios25').click(function(){
                    $(".imageFile").html('Image');
                     $(".abup").attr('id', 'imageFile'); 
                        $(".abup").attr('accept', 'image/jpeg');  
                 
            }); $('#optionsRadios26').click(function(){
                  $(".imageFile").html('Video (duration: 15 sec max.)');
                   $(".abup").attr('id', 'fileUp'); 
                   $(".abup").attr('accept', 'video/mp4');
                        document.getElementById('fileUp').onchange = setFileInfo;  
                 
            });
        });     
              
              function block_unblock(userid,blockstatus)
              {       


                    if(blockstatus=='Active')
                    {
                      var showtxt = 'Active';
                    }
                    else
                    {
                      var showtxt = 'Inactive';
                    }

                          var va = confirm("Are you sure you want to "+showtxt+" this user ?");
                      if( va==true )
                      { App.blockUI();        

                         $.ajax({
                                  type: "POST",
                                  url: "<?php echo site_url();?>users/block_unblock/"+blockstatus+"/"+userid,
                                  dataType: "html",
                                  success:function(data){
                                     
                                    $("#userstatus"+userid).html(data);
                                    App.unblockUI();
                                  },

                                });
                        }
                }

                 function block_unblock_post(postid,blockstatus)
              {       
                
                          var va = confirm("Are you sure you want to "+blockstatus+" this post ?");
                      if( va==true )
                      { App.blockUI();        

                         $.ajax({
                                  type: "POST",
                                  url: "<?php echo site_url();?>reportabouse/block_unblock_post/"+blockstatus+"/"+postid,
                                  dataType: "html",
                                  success:function(data){
                                     
                                    $("#block_userpost"+postid).html(data);
                                    App.unblockUI();
                                  },

                                });
                        }
                }
                function block_unblock_post_abuse(postid,blockstatus)
              {       
                
                          var va = confirm("Are you sure you want to "+blockstatus+" this post ?");
                      if( va==true )
                      { App.blockUI();        

                         $.ajax({
                                  type: "POST",
                                  url: "<?php echo site_url();?>reportabouse/block_unblock_abuse_post/"+blockstatus+"/"+postid,
                                  dataType: "html",
                                  success:function(data){
                                     
                                    $("#userstatus"+postid).html(data);
                                    App.unblockUI();
                                  },

                                });
                        }
                }

                function block_unblock_post_ad(postid,blockstatus)
              {       
                
                          var va = confirm("Are you sure you want to "+blockstatus+" this ad ?");
                      if( va==true )
                      { App.blockUI();        

                         $.ajax({
                                  type: "POST",
                                  url: "<?php echo site_url();?>reportabouse/block_unblock_abuse_post/"+blockstatus+"/"+postid,
                                  dataType: "html",
                                  success:function(data){
                                     
                                    $("#adv_post_"+postid).hide();
                                    App.unblockUI();
                                  },

                                });
                        }
                }

                function loadImageURL(load_image)
{
  $('#viewImage').attr('src',load_image);

}

        </script>
        <script>
          function deletepost(post_id)
{
   var va = confirm("Are you sure you want to delete this post ?");
                      if( va==true )
                      { App.blockUI();        

                         $.ajax({
                                  type: "POST",
                                  url: "<?php echo site_url();?>posts/deletepost/"+post_id,
                                  dataType: "html",
                                  success:function(data){
                                     
                                    $("#post_id_"+post_id).hide();
                                    App.unblockUI();
                                  },

                                });
                        }
}
function change_pass()
{
 $('.error').text('');
 var old_pass=$('#old_pass').val();
 var new_pass=$('#new_pass').val();
 var c_pass=$('#c_pass').val();
 if(new_pass != c_pass)
 {
  $('#error_c_pass').text('Please Enter Same Password');
  z = false;
 }else{
  $('#btnsubmit').show();
 }
 if(old_pass == new_pass)
 {
  $('#error_new_pass').text('Please Enter Different Password');
  z = false;
 }else{
  $('#btnsubmit').show();
 }
 if(old_pass =='')
 {
  $('#error_old_pass').text('This Field Is Required');
  z = false;
 }
 if(new_pass =='')
 {
  $('#error_new_pass').text('This Field Is Required');
  z = false;
 }
 if(c_pass =='')
 {
  $('#error_c_pass').text('This Field Is Required');
  z = false;
 }
}
</script>

 <script src="<?php echo base_url(); ?>assets/table2excel.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $("#btnExport").click(function () {
                $("#print").table2excel({
                    filename: "Table.xls"
                });
            });
        });
    </script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script type="text/javascript">
        $("body").on("click", "#btnExport1", function () {
            html2canvas($('#print')[0], {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("Table.pdf");
                }
            });
        });
    </script>


        <script>

 
 
//  Delete multiple records close................

  $(document).ready(function() {
    gridloader('<?php echo $pageno; ?>');
 
    //==========Page click==========//
    $('#gridlisting').on('click','li.page_active,li.previous,li.next',function(){
        var page = $(this).attr('p');
        $("html, body").animate({ scrollTop: 0 }, "slow");
        gridloader(page);
    });
    //==========Close Page click==========//
    //==========Change Per Page==========//
    $('#perpage').change(function () {
        gridloader(1);
    });
    //==========Close Change Per Page==========//
    //==========On Search Load Grid============//
    $('#gridsearch').click(function(){
        gridloader(1);
    });
    $("#search").keyup(function(){
        gridloader(1);
    });
    //=========Close On Search Load Grid======//
});
function gridloader(page)
{
    var perpage = $("#perpage").val();
    var search = $("#search").val();
          App.blockUI(); 
    $.ajax
    ({
        
        type: "POST",
        url: '<?php echo $posturl;?>',
        data: "&page=" + page + "&perpage=" + perpage + "&search="+search,
   
        success: function(response)
        { 
           $("#gridlisting").html(response);
        }
     
    }); 
        App.unblockUI();
}



</script>

<script type="text/javascript">
    
    function postforuser(userid,redeemid)
    {
      $("#user_id").val(userid);
      $("#request_id").val(redeemid);
    }

    $('#ff2').change(
                function () {
                    var fileExtension = ['jpeg', 'jpg', 'png'];
                    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                        alert("Only '.jpeg','.jpg','.png' formats are allowed.");
                        $('#ff2').val('');
                        return false; }
});

</script>

    </body>

</html>