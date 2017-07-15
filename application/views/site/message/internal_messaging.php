<div id="main" class="site-main container">
    <div class="row-gray-lightest">
        <div class="container">

            <div class="row">
                <div class="col-md-2"></div>
                <div id="sidebar" class="col-md-3 well margin-top-lg margin-bottom-lg">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 style="text-align: center;"><b><?php echo $title; ?></b></h5><hr/>     
                        </div>
                    </div>

                    <div class="row border-area">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-lg-12 search-area">
                                    <form action="" method="post">
                                        <div class="input-group">
                                            <input type="text" name="name" class="search_name form-control" placeholder="Search by first or last name...">
                                            <span class="input-group-btn">
                                                <button id="search" class="btn btn-default" type="button">Go!</button>
                                            </span>
                                        </div><!-- /input-group -->
                                    </form>
                                </div><!-- /.col-lg-6 -->
                            </div><!-- /.row --> 
                        </div>
                    </div>
                    <!--Sidebar area start-->
                    <div class="row">
                        <!--Search area start-->
                        <div id="recipient-ajax">
                            <div class="recipient-name"></div>
                            <div class="recipient-image"></div>
                        </div>
                        <!--Search area end-->

                        <div id="recipient-msg" class="col-md-12"></div>
                        <div id="recipient-list" class="col-md-12">
                            <?php
                            if (isset($msg_sender_info)) {
                                foreach ($msg_sender_info as $info) {
                                    if ($info['user_id'] != get_userid()) {
                                        ?>
                                        <div class="row border-area">

                                            <?php if ($info['profile_image']) { ?>
                                                <div class="col-md-6">
                                                    <a href="<?php echo base_url('internal_messaging/' . $info['user_id']) ?>"><img src="<?php echo base_url() . 'images/profile_image/' . $info['profile_image']; ?>" class="profile-img"/></a>
                                                </div>
                                            <?php } else { ?>
                                                <div class="col-md-6">
                                                    <a href="<?php echo base_url('internal_messaging/' . $info['user_id']) ?>"><img src="<?php echo base_url() . 'images/fund_request.png'; ?>" class="profile-img" /></a>
                                                </div>
                                            <?php } ?>
                                            <div class="col-md-6 name-col">
                                                <div class="row">
                                                <div class="col-md-8" style="float:left">
                                                <?php $unread_msg = $this->message_model->get_unread_message_by_id($info['user_id']);?>
                                                <a class="profile-name" href="<?php echo base_url('internal_messaging/' . $info['user_id']) ?>"><?php echo $info['first_name']; ?>&nbsp;<?php echo $info['last_name']; ?></a>
                                                </div>
                                                <?php if(isset($unread_msg) && $unread_msg>0){?>
                                                <div class="col-md-4">
                                                <p style="color:red; float:right" class="unread_msg_count">(<?php echo $unread_msg;?>)</p>
                                                </div>
                                                <?php }?>    
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                            ?> 
                        </div>
                    </div>
                    <!--sidebar end-->
                </div>
                <div id="main-form" class="col-md-6 col-md-offset-1 col-lg-6 col-lg-offset-2 well margin-top-lg margin-bottom-lg" >
                     <a href="<?php echo base_url('profile/' . get_userid()) ?>">  <h4><< Go Back</h4></a> 
                    <div class="receiver">
                        
                                        <div class="row">
                                            <div class="col-md-4 rcv-img">

                                                <?php if ($row->user_id != get_userid()) { ?> 
                                                    <?php if ($row->profile_image) { ?>
                                                        <a href="<?php echo base_url('profile/' . $row->user_id) ?>"><img src="<?php echo base_url() . 'images/profile_image/' . $row->profile_image; ?>" style="width:50px;height:50px; border-radius:100%; margin-top: 6px; margin-left: 15px;"/></a>
                                                    <?php } else { ?>
                                                        <a href="<?php echo base_url('profile/' . $row->user_id) ?>"><img src="<?php echo base_url() . 'images/fund_request.png'; ?>" style="width:50px;height:50px; border-radius:100%; margin-top: 6px; margin-left: 15px;"/></a>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-md-8 rcv-name">
                                                    <a href="<?php echo base_url('profile/' . $row->user_id) ?>"><h4><?php echo $row->first_name; ?>&nbsp;<?php echo $row->last_name; ?></h4></a>
                                                <?php } //else { ?>                
                                                    <!--<input id="group-msg" placeholder="" style="">-->
                                                   <!-- <h3>Message/W</h3>-->
                                                <?php // } ?>
                                            </div>
                                        </div>                
                                    </div>
                    
                    
                    <div class="row">  
                        <div class="col-md-12">
                            <!-- Showing Session Data -->
                            <?php //show_flashdata(); ?>
                            <!--<div class="success-msg"></div>-->
                             
                            <div class="my-message-form">
                                <div class="my-msg-form-design">
                                    <div class="row messaging">
                                        <div class="col-md-12">
                                            <?php if ($count2 != 0) { ?> 
                                                <?php
                                                if ($row->user_id != get_userid()) {
                                                    if (isset($messages)) {
                                                        foreach ($messages as $msg) {
                                                            //if($msg['msg_delete_person'] != $msg['msg_from'] || $msg['msg_delete_person'] !=$msg['msg_to']){
                                                            ?>
                                                            <div class="row">
                                                                <?php if ($msg['msg_from'] == get_userid()) { ?>
                                                                    <div class="col-md-6"></div>
                                                                    <div class="col-md-6" style=" float:right;text-align: left;">
                                                                        
                                                                        <?php if (isset($msg['message']) && $msg['message'] != null) { ?>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <p class="p-msg"><?php echo $msg['message']; ?></p>
                                                                            </div>
                                                                        </div>
                                                                        <?php } ?>
                                                                        <?php if (isset($msg['msg_image']) && $msg['msg_image'] != null) { ?>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <a href="<?php echo base_url() . 'images/msg_image/' . $msg['msg_image']; ?>"><img class="img-responsive msg-img" src="<?php echo base_url() . 'images/msg_image/' . $msg['msg_image']; ?>"/></a>       
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if (isset($msg['msg_attach']) && $msg['msg_attach'] != null) { ?>
                                                                            <div class="row attachment-row-cls">
                                                                                <div class="col-md-12 attachment">
                                                                                    <a  href="<?php echo base_url() . 'images/msg_attach/' . $msg['msg_attach']; ?>"><?php echo $msg['msg_attach']; ?></a>       
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if (($msg['message'] != null) || ($msg['msg_image'] != null) || ($msg['msg_attach'] != null)) { ?>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <p class="p-date"><?php
                                                                                    $msg_time = date("h:i A", strtotime($msg['msg_date']));
                                                                                    $msg_date = date("Y:m:d", strtotime($msg['msg_date']));
                                                                                    $today = date("Y:m:d");
                                                                                    //echo $msg_time;
                                                                                    if ($today != $msg_date) {
                                                                                        echo $msg_date;
                                                                                    } else {
                                                                                        echo $msg_time;  //today
                                                                                    }
                                                                                    ?></p>
                                                                            </div>
                                                                        </div>
                                                                        <?php }?>
                                                                    </div>


                                                                <?php } else { ?>

                                                                    <div class="col-md-6">
                                                                        <?php if (isset($msg['message']) && $msg['message'] != null) { ?>
                                                                            <div class="row">
                                                                                <div class="col-md-12 send_mesg">
                                                                                    <p class="p-msg2"><?php echo $msg['message']; ?></p>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if (isset($msg['msg_image']) && $msg['msg_image'] != null) { ?>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <a href="<?php echo base_url() . 'images/msg_image/' . $msg['msg_image']; ?>"><img class="img-responsive msg-img2" src="<?php echo base_url() . 'images/msg_image/' . $msg['msg_image']; ?>"/></a>      
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if (isset($msg['msg_attach']) && $msg['msg_attach'] != null) { ?>
                                                                            <div class="row attachment-row-cls">
                                                                                <div class="col-md-12 attachment">
                                                                                    <a href="<?php echo base_url() . 'images/msg_attach/' . $msg['msg_attach']; ?>"><?php echo $msg['msg_attach']; ?></a>       
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if (($msg['message'] != null) || ($msg['msg_image'] != null) || ($msg['msg_attach'] != null)) { ?>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <p class="p-date2"><?php
                                                                                    $msg_time = date("h:i A", strtotime($msg['msg_date']));
                                                                                    $msg_date = date("Y:m:d", strtotime($msg['msg_date']));
                                                                                    $today = date("Y:m:d");
                                                                                    //echo $msg_time;
                                                                                    if ($today != $msg_date) {
                                                                                        echo $msg_date;
                                                                                    } else {
                                                                                        echo $msg_time;  //today
                                                                                    }
                                                                                    ?></p>
                                                                            </div>
                                                                        </div>
                                                                        <?php }?>
                                                                    </div>
                                                                    <div class="col-md-6"></div>

                                                                <?php } ?>
                                                            </div>
                                                        <?php
                                                      // }
                                                        }
                                                    }
                                                }
                                            } else {
                                                ?>
                                                <h4 class="no-conversation">No conversation with this person!!!</h4>
<?php } ?>
                                        </div> <!--col-md-12-->
                                    </div>  <!--row-->
                                </div> <!--my-msg-form-design-->

                                <!--send message form start-->

                                <form class="form compose-message-form msg-form" role="form" id="userForm" method="post" action="" enctype="multipart/form-data" data-bv-enabled>
                                    <input type="hidden" name="msg_to" value="<?php echo $this->uri->segment(2);?>">
                                    <div class="full-area"> 
                                        <div id="compose-textarea-region"> 
                                            <div id="compose-textarea">
                                                <textarea id="msg" class="compose-area mousetrap text-box" name="message" id="compose-message" placeholder="Write your message…"></textarea>
                                            </div>
                                        </div>
                                        <div class="attachment-name">
                                            <div class="row">
                                                <div class="col-md-12 file-name-display"></div>                     
                                            </div>
                                        </div>
                                        <div class="compose-action-bar">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="image-upload">
                                                        <label for="file-input">
                                                            <i class="fa fa-camera img-display" title="Send Image"></i>
                                                        </label>
                                                        <input id="file-input" name="msg_image[]" type="file" accept="image/*" multiple onchange="chooseFile();">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="attachment-upload">
                                                        <label for="attachment-input">
                                                            <i class="fa fa-paperclip attachment-display" title="Send Attachment"></i>
                                                        </label>
                                                        <input id="attachment-input" name="msg_attach[]" type="file" multiple onchange="chooseFile();">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="delete-icon" style="margin-left: -38px;">
                                                        <a href="<?php echo base_url('delete-conversation/' . $this->uri->segment(2))?>" class="del-request"><i class="fa fa-trash-o" title="Delete conversation"></i></a>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="checkbox-icon">
                                                        <input type="checkbox" name="send_msg" value="" id="checkMeOut" title="Check to press enter to send">
                                                        <label class="text-msg">Check to press enter to send</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="image-name"></div>
                                                    <div id="file-name"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-8"></div>
                                        <div class="col-md-4">
                                            <input  type="submit" name="btnSubmit" id="btnSubmit" value="Send message" class="btn btn-xl btn-success btn-block" />
                                        </div>    
                                    </div>
                                </form>
                                <!--send message form end-->
                            </div>
                            <div class="col-md-2"></div>	
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>
    
    
<!--Start  messaging-->
 <script type="text/javascript">
        $(document).ready(function () {
             var id = "<?php echo $this->uri->segment(2);?>";  
             var uid = "<?php echo get_userid();?>"; 
             var baseurl = '<?php echo base_url(); ?>';  
             
             if(id  != uid ){
                 
                     $.ajax({
                    type: "POST",
                    url: baseurl + 'makeunread',
                    data: {id : id , uid : uid},
                    dataType: "json",
                    success: function (data) {
                             if(data.success == 1){
                                $('.unread_msg_count').hide();
                             }
                    }
                });
             }
             
        });
</script> 

<script type="text/javascript">
  $(document).ready(function() {
                    var url='<?php echo base_url()?>'+'search_user';
                   // alert(url);
                    $("#group-msg").autocomplete({
                        source: url ,
                        minLength: 1 //search after 1 character
                    });
                }); 
</script>
<!--End group messaging-->

    <!--Search start--> 
    <script type="text/javascript">
  $(document).ready(function () {
     $('#btnSubmit').on('click', function(event){
         $('#btnSubmit').hide();
     });
     
            $('#search').on('click', function (e) {     //button id
                e.preventDefault();
                var confirm = $('.search_name').val();  //input class name
               
                var baseurl = '<?php echo base_url(); ?>';
                var imgurl = '<?php echo base_url() . 'images/profile_image/'; ?>';
                var defaultimgurl = '<?php echo base_url() . 'images/fund_request.png'; ?>';
                var userurl = '<?php echo base_url() . 'internal_messaging/'; ?>';
                //console.log(baseurl);
                $.ajax({
                    type: "POST",
                    url: baseurl + 'find',
                    async: false,
                    data: {confirm: confirm},
                    dataType: "json",
                    success: function (data) {
                      
                        $('#recipient-list').hide();
                        if (data.failed == 'failed') {

                            $('.recipient-image').html('');
                            $('.recipient-name').html('');
                            $('#recipient-msg').html('<p>' + data.message + '</p>');

                        }
                        else {

                            var src = imgurl + data.image;
                            var uid = userurl + data.id;
                            $('#recipient-msg').html('');
                        
                       
                            if (data.image == 0) {
                              
                                $('.recipient-image').html('<img class="profile-img-ajax" src = ' + defaultimgurl + ' / >');
                            } else {
                                $('.recipient-image').html('<img class="profile-img-ajax" src = ' + src + ' / >');
                            }
                            $('.recipient-name').html('<a href="' + uid + '" class="profile-name-ajax">' + data.name + '</a>');
                        }

                    }
                });
            });
        });
    </script>
<!--Search end--> 

<!--start send message using keypress-->
<script type="text/javascript">
$(".text-box").keypress(function(event) {
    if (event.which == 13) {
        //alert('You pressed a "enter" key in textbox');
        if($('#checkMeOut').prop('checked')) {
            //alert('check box checked!!!');
             $('form#userForm').submit();
        }
    }
	
});
</script>
<!--end send message using keypress-->

    <!--message send start-->
    <script type="text/javascript">
        $(document).ready(function () {
            $("form#userForm").submit(function (event) {
                event.preventDefault();
                var formData = new FormData($(this)[0]);
                var baseurl = '<?php echo base_url(); ?>';
                var imageurl = '<?php echo base_url() . 'images/msg_image/'; ?>';
                var attachurl = '<?php echo base_url() . 'images/msg_attach/'; ?>';
                $('#image-name').hide();
                $('#file-name').hide();
                $('.compose-area').val('');
                $('.no-conversation').hide();
                $('#file-input').val('');
                $('#attachment-input').val('');
                
                $.ajax({
                    url: baseurl + 'send_message',
                    type: 'POST',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                         
                        $('#btnSubmit').show();
                       
                        var msg = $.parseJSON(result);
                        var image = imageurl + msg.msg_image;
                        var attach = attachurl + msg.msg_attach;
                       
                      
                    if (msg.message) {
                      $('.messaging').append('<div class="row"><div class="col-md-12"><div class="row"><div class="col-md-6"></div><div class="col-md-6 msg-ajax"><div class="row"><div class="col-md-12 msg-ajax1"><p class="p-msg-ajax">' + msg.message + '</p></div></div></div></div></div></div>');
                     } 
                     if (msg.msg_image) {
                      $('.messaging').append('<div class="row"><div class="col-md-12"><div class="row"><div class="col-md-6"></div><div class="col-md-6 msg-ajax"><div class="row"><div class="col-md-12 msg-ajax1"><img class="img-responsive send_msg_rs" src= '+ image +'></img></div></div></div></div></div></div>');
                    }   
                     if (msg.msg_attach) {
                      $('.messaging').append('<div class="row"><div class="col-md-12"><div class="row"><div class="col-md-6"></div><div class="col-md-6 msg-ajax"><div class="row attachment-row-cls-ajax"><div class="col-md-12 attachment"><a href= '+ attach +'>' + msg.msg_attach + '</a></div></div></div></div></div></div>');
                    }
                    if((typeof msg.message != "undefined" ) || (typeof msg.msg_image != "undefined") || (typeof msg.msg_attach != "undefined")){
                        $('.messaging').append('<div class="row"><div class="col-md-12"><div class="row"><div class="col-md-6"></div><div class="col-md-6 msg-ajax"><div class="row"><div class="col-md-12 msg-ajax1"><p class="p-date">' + msg.time + '</p></div></div></div></div></div></div>');
                    }  
                   $(".my-msg-form-design").scrollTop($(".my-msg-form-design")[0].scrollHeight);
                    }
                    
                });

                return false;
            });
        });
    </script>    
 <!--message send end-->

  <!--Start Check message-->
  <script type="text/javascript"> 
   setInterval(function(){ 
             
             var baseurl = '<?php echo base_url(); ?>';
             var id = '<?php  echo get_segment(2);?>';
             var imageurl = '<?php echo base_url() . 'images/msg_image/'; ?>';
             var attachurl = '<?php echo base_url() . 'images/msg_attach/'; ?>';
             var confirm = id;
             
            
                $.ajax({
                    type: "POST",
                    url: baseurl + 'check_messages',
                    async: false,
                    data: {confirm: confirm},
                    dataType: "json",
                    success: function (result) {
                        $('.no-conversation').hide();
                     
                       if(result.success == 'success'){
                  
                        var image = imageurl + result.msg_image;
                        var attach = attachurl + result.msg_attach;
                        
                      if (result.message) {
                      $('.messaging').append('<div class="row"><div class="col-md-12"><div class="row"><div class="col-md-6"><div class="row"><div class="col-md-12 msg-p-ajax2"><p class="p-msg2">' + result.message + '</p></div></div></div><div class="col-md-6 msg-ajax2"></div></div></div></div>');
                     } 
                     if (result.msg_image) {
                      $('.messaging').append('<div class="row"><div class="col-md-12"><div class="row"><div class="col-md-6"><div class="row"><div class="col-md-12"><img class="img-responsive rs_img_rcv" src= '+ image +'></img></div></div></div><div class="col-md-6"></div></div></div></div>');
                    }   
                     if (result.msg_attach) {
                      $('.messaging').append('<div class="row"><div class="col-md-12"><div class="row"><div class="col-md-6"><div class="row attachment-row-cls-ajax-2"><div class="col-md-12 attachment"><a href= '+ attach +'>' + result.msg_attach + '</a></div></div></div><div class="col-md-6 msg-ajax2"></div></div></div></div>');
                    }
                    
                      $('.messaging').append('<div class="row"><div class="col-md-12"><div class="row"><div class="col-md-6"><div class="row"><div class="col-md-12"><p class="p-date2-ajax">' + result.time + '</p></div></div></div><div class="col-md-6 msg-ajax2"></div></div></div></div>');
                       }
                        
                    }
                });
      }, 3000);
  </script>
  <!--End Check message--> 
    <script>
         
        // Delete Confirmation Sweet Alert Popup
    jQuery('body').delegate('.del-request', 'click', function() {

        var $thisLayoutBtn = jQuery(this);
        var $href = jQuery(this).attr('href');
        var makeChange = true;


        if (makeChange) {
            swal({
                title: "Delete conversation",
                text: "Are you sure you would like to delete this conversation?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location.href = $href;
                } else {

                }
            });
        }

        return false;
    });

        $('#change_pass').hide();


        $('.summernote').summernote({
            height: 150, //set editable area's height
            codemirror: {// codemirror options
                //theme: 'monokai'
                theme: 'ambiance'
            }
        });
        
        function chooseFile() {
              var image = $("#file-input").val();
              var file = $('#attachment-input').val();
              $('#image-name').html(image);
              $('#file-name').html(file);
              $('.full-area').css('height','120px');
       }
       $(".my-msg-form-design").scrollTop($(".my-msg-form-design")[0].scrollHeight);
    </script>