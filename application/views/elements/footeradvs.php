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
                     $(".abup").attr('id', 'fileUp'); 
                        $(".abup").attr('accept', 'image/jpeg');  
                 
            }); $('#optionsRadios26').click(function(){
                  $(".imageFile").html('Video (duration: 15 sec max.)');
                   $(".abup").attr('id', 'fileUp'); 
                   $(".abup").attr('accept', 'video/mp4');
                        document.getElementById('fileUp').onchange = setFileInfo;  
                 
            });
        });     
              
               

        </script>
         

  <script src='https://cdn.rawgit.com/jashkenas/underscore/1.8.3/underscore-min.js' type='text/javascript'></script>
  <script src='<?php echo base_url();?>assets/tagjs/lib/jquery.elastic.js' type='text/javascript'></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/tagjs/jquery.mentionsInput.js"></script>
         

<script type="text/javascript">
$(document).ready(function(){
  $('textarea').on('click', function(e) {
      e.stopPropagation();
  });
  $(document).on('click', function (e) {
      $("#status-overlay").hide();
      $("#highlight-textarea").css('z-index','1');
      $("#highlight-textarea").css('position', '');
  });
});
function highlight()
{
  $("#status-overlay").show();
  $("#highlight-textarea").css('z-index','9999999');
  $("#highlight-textarea").css('position', 'relative');
}


$(document).ready(function(){

$('.postMention').click(function() {
    $('textarea.mention').mentionsInput('val', function(text) {
      var post_text = text;
      if(post_text != '')
      {
        //post text in jquery ajax
      var post_data = "text="+encodeURIComponent(post_text);  
      $.ajax({
            type: "POST",
            data: post_data,
            url: 'ajax/post.php',
            success: function(msg) {
             if(msg.error== 1)
             {
              alert('Something Went Wrong!');
             } else {
              
              $("#post_updates").prepend(msg);
              //reset the textarea after successful update
              $("textarea.mention").mentionsInput('reset');

             }
            }
      });

      } else {
        alert("Post cannot be empty!");
      }

    });
  });

//used for get users from database while typing @..
  $('textarea.mention').mentionsInput({
    onDataRequest:function (mode, query, callback) {
      $.getJSON('<?php echo base_url(); ?>Adds/my_userall_detail', function(responseData) {
        responseData = _.filter(responseData, function(item) { return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1 });
        callback.call(this, responseData);
      });
    }
  });

});
</script>
      
 <script src="<?php echo base_url('assets/file_upload.js'); ?>"></script>
 <script type="text/javascript">
    $(document).ready(function() { 
       $('#imageupload').submit(function(e) { 

        if($('#fileUp').val()) {
          e.preventDefault();

          $("#progress-bar-status-show").width('0%');
          var file_details    =   document.getElementById("fileUp").files[0];
          var extension       =   file_details['name'].split(".");
          
          var allowed_extension   =   ["jpg", "jpeg", "mp4"];
          var check_for_valid_ext =   allowed_extension.indexOf(extension[1]);

          

           if(check_for_valid_ext == -1)
          {
            alert('upload valid image file');
            return false;
          }
          else
          { 
            if(check_for_valid_ext != -1)
            {
             // $('#loader').show();
              App.blockUI(); 
              $(this).ajaxSubmit({ 
                target:   '#toshow', 
                beforeSubmit: function() {
                  $("#progress-bar-status-show").width('0%');
                },
                uploadProgress: function (event, position, total, percentComplete){ 
                  $("#progress-bar-status-show").width(percentComplete + '%');
                  $("#progress-bar-status-show").html('<div id="progress-percent">' + percentComplete +' %</div>');
                  
                },
                success:function(obj){
                  //App.unblockUI();

                 // $('#loader').hide();
                //  $('#imageDiv').show();
               //  App.unblockUI();
                  /*var url = $('#toshow').text();
                  var img = document.createElement("IMG");
                  img.src = url;
                  img.height = '100';
                  img.width  = '150';*/
                  //document.getElementById('imageDiv').appendChild(img);  
                //  window.location.href="<?php echo base_url('Adds/my_add'); ?>";     

                },

                 error: function(obj) {
     // App.unblockUI();
                 console.log(obj);

                 },
                 complete: function(obj) {
                   App.unblockUI();
                   window.location.href="<?php echo base_url('Adds/my_add'); ?>"; 
                

                 },
                resetForm: true 
              }); 
              return false;
            }   
          }    
        }
      });
    }); 
    </script>
    

    </body>

</html>