<!-- Construct the box with style you want. Here we are using box-danger -->
<!-- Then add the class direct-chat and choose the direct-chat-* contexual class -->
<!-- The contextual class should match the box, so we are using direct-chat-danger -->

<!-- <button class="btn btn-secondary" style="position:fixed;right:3%;bottom:0;z-index:100;width:20px;">
  <i class="fa fa-comments-o"></i> Chat
</button> -->
<button class="btn btn-secondary btn-sm btn-chat hidden-xs" type="button" id="btnChat"><i class="fa fa-comments-o"></i> Chat</button>

<div class="chat-wrapper row hidden" style="">
  <div class="col-sm-5 no-padding">
    <div class="box box-success" style="margin-bottom:0px">
      <div class="box-header with-border" style="font-size:15px;">
        <div class="pull-left text-bold"><i class="fa fa-users"></i> Kontak</div>
      </div>
      <div class="box-body contacts">
        <ul class="contacts-list">
          <!-- End Contact Item -->
        </ul>
      </div>
      <div class="box-footer">
        <div class="input-group">
          <input type="text" name="message" placeholder="Cari Pengguna ..." class="form-control input-sm">
          <!-- <span class="input-group-btn">
            <button type="button" class="btn btn-danger btn-flat">Send</button>
          </span> -->
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-7 no-padding">
    <div class="box box-success direct-chat direct-chat-success" style="margin-bottom:0px;">
      <div class="box-header with-border">
        <div class="pull-left text-bold" id="receiver_name" style="font-size:15px;"></div>
        <div class="box-tools pull-right">
          <span data-toggle="tooltip" class="badge bg-red"></span>
          <!-- <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> -->
          <!-- In box-tools add this button if you intend to use the contacts pane -->
          <button class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></button>
          <button class="btn btn-box-tool" id="btnTutupChat"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body" style="font-size:13px;">
        <div class="direct-chat-messages" id="chat-messages">
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <form id="form_chat">
        <div class="input-group">
          <input type="text" name="chat_text" id="chat_text" placeholder="Type Message ..." class="form-control input-sm" autocomplete="off">
          <input type="hidden" name="receiver_id" id="receiver_id">
          <input type="hidden" name="id_chat" id="chat_id">

          <span class="input-group-btn">
            <button type="submit" class="btn btn-danger btn-sm btn-flat" id="btnSendChat">Send</button>
          </span>
        </div>
        </form>
      </div>
      <div class="chat-placeholder text-center hidden" style="height:354px;">
        <div style="padding-top:25%">
          <i class="fa fa-comments-o fa-5x"></i>
        </div>
      </div>
      <div class="chat-loader text-center hidden" style="height:354px;">
        <div style="padding-top:25%">
          <i class="fa fa-circle-o-notch fa-spin fa-5x"></i>
        </div>
      </div>
      <!-- /.box-footer-->
    </div>
  </div>
</div>
<!--/.direct-chat -->

</section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.18
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
    reserved.
  </footer> -->
</div>
<!-- ./wrapper -->

<script src="https://www.gstatic.com/firebasejs/7.16.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.16.0/firebase-messaging.js"></script>
<!-- <script src="<?php echo base_url()?>/assets/js/firebase.js"></script> -->
<script>
  var active_chat='';
  var scrolled = false;
  $(document).ready(function () {
    $('.sidebar-menu').tree();

    $('#btnChat').click(function(){
      
      getContacts();

      $('.chat-wrapper').removeClass('hidden');
      $('#btnChat').hide();
    });

    $('#btnTutupChat').click(function(){
      $('.chat-wrapper').addClass('hidden');
      $('#btnChat').show();
    });

    $('body').on('click', '.contact-chat', function(){
      var that = $(this);
      active_chat = $(this).data('id');
      var receiver_name = $(this).data('name');
      var receiver_id = $(this).data('receiver');
      
      getMessages();
      that.siblings().removeClass('active');
      that.addClass('active');
      $('#receiver_name').html(receiver_name);
      $('#chat_id').val(active_chat);
      $('#receiver_id').val(receiver_id);
      
    });

    $('#form_chat').submit(function(e){
      e.preventDefault();
      $.ajax({
        method:"POST",
        url: "<?php echo site_url('chat/send')?>",
        data: $('#form_chat').serializeArray(),
        dataType: "json",
        beforeSend: function(){
          $('#chat_text, #btnSendChat').prop('disabled', true);
        },
        success: function(data) {
          
          html = 
          `<div class="direct-chat-msg right">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name pull-right"></span>
              
            </div>
            <img class="direct-chat-img" src="`+data.sender_picture+`" alt="message user image">
            <div class="direct-chat-text">
            `+data.chat_text+`
              <div class="clearfix">
                <small class="pull-right">23 Jan 2:05 pm</small>
              </div>
            </div>
          </div>`;
          
          $('#chat_text').val('');
          $('.direct-chat-messages').append(html);

          $('#chat_text, #btnSendChat').prop('disabled', false);
        }
      });
    });
  })

  const elem_messages = document.getElementById('chat-messages');
  function scrollToBottom() {
    if(!scrolled){
      elem_messages.scrollTop = elem_messages.scrollHeight;
    }
  }

  $('#chat-messages').on('scroll', function(){
    scrolled = true;
  });

  function getMessages(){
    var html = '';
    // var elem = $("body .contact-chat['data-id'="+active_chat+"]");
    // var receiver_name = elem.data('name');
    $.ajax({
        method:"GET",
        url: "<?php echo site_url('user/get_user_chat_messages')?>",
        data:{id: active_chat},
        dataType: "json",
        /* beforeSend: function(){
          $('.chat-loader').removeClass('hidden');
          $('.chat-placeholder,.direct-chat .box-body,.direct-chat .box-footer').addClass('hidden');
          
        }, */
        success: function(data) {
          // console.log(data); 
          jQuery.each( data, function( i, val ) {
            if(val.sender_id != "<?php echo $this->session->userdata('user_id')?>" ){
              html += 
              `<div class="direct-chat-msg">
                <div class="direct-chat-info clearfix">
                  <span class="direct-chat-name pull-left"></span>
                  
                </div>
                <img class="direct-chat-img" src="`+val.sender_picture+`" alt="message user image">
                <div class="direct-chat-text clearfix">
                  <div>
                  `+val.chat_text+`
                    <div class="clearfix">
                      <small class="pull-right">`+val.chat_datetime+`</small>
                    </div>
                  </div>
                </div>
              </div>`;
            }else{
              html += 
              `<div class="direct-chat-msg right">
                <div class="direct-chat-info clearfix">
                  <span class="direct-chat-name pull-right"></span>
                  
                </div>
                <img class="direct-chat-img" src="`+val.sender_picture+`" alt="message user image">
                <div class="direct-chat-text">
                `+val.chat_text+`
                  <div class="clearfix">
                    <small class="pull-right">`+val.chat_datetime+`</small>
                  </div>
                </div>
              </div>`
            }
          }); 
          
          // $('#receiver_id').val(active_chat);
          $('.direct-chat-messages').html(html);
          scrollToBottom();
          /* $('.chat-placeholder, .chat-loader').hide();
          $('.direct-chat .box-body,.direct-chat .box-footer').removeClass('hidden'); */
          
        }
      });
  }

  function getContacts(){
    var html = '';
    $.ajax({
        method:"GET",
        url: "<?php echo site_url('user/get_user_chat')?>",
        dataType: "json",
        success: function(data) {
          jQuery.each( data, function( i, val ) {
            let msg = '';
            if(val.sender_id == "<?php echo $this->session->userdata('user_id')?>"){
              msg = "Anda : "+val.chat_text
              user_id = val.receiver_id;
              user_name = val.receiver;
              user_picture = val.receiver_picture;
              user_time = val.chat_datetime;
            }else{
              msg = (val.chat_status == 0 ? `<b>`+val.chat_text+`<b>` : val.chat_text);
              user_id = val.sender_id;
              user_name = val.sender;
              user_picture = val.sender_picture;
              user_time = val.chat_datetime;
            }
            let active = (active_chat == val.id_chat) ? 'active' : '';
            html += 
            `<li role="button" class="contact-chat `+active+`" data-id="`+val.id_chat+`" data-receiver="`+user_id+`" data-name="`+user_name+`">
              <a href="#">
                <img class="contacts-list-img" src="`+user_picture+`" alt="Contact Avatar" style="padding-right:5px;">
                <div class="text-success">
                  <span class="contacts-list-name">
                    `+user_name+`
                    <small class="contacts-list-date pull-right">`+user_time+`</small>
                    </span>
                  <span class="contacts-list-msg">`+msg+`</span>
                </div>
            
              </a>
            </li>`;
          }); 
          
          $('.contacts-list').html(html);
        }
      });
  }

  setInterval(function(){ 
    if(active_chat != ''){
      getContacts();
      getMessages();
    }
  }, 5000);

  var id = "<?php echo $this->session->userdata('user_id')?>";
  var firebaseConfig = {
    apiKey: "AIzaSyCrjRRI5C1ZbCfY4E9lBfT41zhMgLsWwuA",
    authDomain: "project-1234554321.firebaseapp.com",
    databaseURL: "https://project-1234554321.firebaseio.com",
    projectId: "project-1234554321",
    storageBucket: "project-1234554321.appspot.com",
    messagingSenderId: "637967445990",
    appId: "1:637967445990:web:172766165590478fc2f027",
    measurementId: "G-L5WN0EPW1X"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  
  const messaging = firebase.messaging();
  messaging.requestPermission()
  .then(function() {
	  console.log('Notification permission granted.');
	  /* if(isTokenSentToServer()) {
	  	console.log('Token already saved.');
	  } else { */
	  	getRegToken();
	  // }

	})
	.catch(function(err) {
	  console.log('Unable to get permission to notify.', err);
	});

  function getRegToken(argument) {
    if(id != ''){

        messaging.getToken()
        .then(function(currentToken) {
          if (currentToken) {
            console.log(currentToken);
            if(window.sessionStorage.getItem('currToken') != currentToken){
              saveToken(currentToken);
              setTokenSentToServer(true);
            }else{
              console.log('Token already saved.');
            }
          } else {
            console.log('No Instance ID token available. Request permission to generate one.');
            setTokenSentToServer(false);
          }
        })
        .catch(function(err) {
          console.log('An error occurred while retrieving token. ', err);
          setTokenSentToServer(false);
        }); 
    }
  }

  function setTokenSentToServer(sent) {
      window.sessionStorage.setItem('sentToServer', sent ? 1 : 0);
  }

  function isTokenSentToServer() {
      return window.sessionStorage.getItem('sentToServer') == 1;
  }

  function saveToken(currentToken) {
      $.ajax({
          url: "<?php echo site_url('user/update_token')?>",
          method: 'post',
          data: {id: id, token: currentToken}
      }).done(function(result){
          // console.log(result.success);
          window.sessionStorage.setItem('currToken', currentToken);
      })
  }

  messaging.onMessage(function(payload) {
    console.log("Message received. ", payload);
    notificationTitle = payload.data.title;
    notificationOptions = {
        body: payload.data.body,
        icon: payload.data.icon,
        image:  payload.data.image
    };
    var notification = new Notification(notificationTitle,notificationOptions);
  });
</script>
</body>
</html>
