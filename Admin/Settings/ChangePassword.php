<?php
include('template.html');
?>
<html>
<head>
<link rel="stylesheet" href="css/stylesForSettings.css"/>
<link rel="stylesheet" href="css/ionicons.min.css"/ >
 <link rel="stylesheet" href="css/font-awesome.min.css" />
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
function updatePassword(){
	$("p").remove("#error_show");
	$("p").remove("#success");
	var passwordPattern = new RegExp(/^.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1}).*$/g);
	var oldPass = document.getElementById("my-password").value;
	var newPass = document.getElementById("newpassword").value;
	var confirmPass = document.getElementById("confirmpassword").value;
	if(oldPass == "" || newPass == "" || confirmPass == "") {
		$('#errorMsg').append('<p id="error_show"><i class="icon ion-arrow-down-b"></i> &nbsp; All fields are mandatory!</p>');
	} else if(!(passwordPattern.test(newPass))) {			
		$('#errorMsg').append('<p id="error_show"><i class="icon ion-arrow-down-b"></i> &nbsp; Password should consist of atleast 8 characters and must contain one uppercase letter, one numeric value and one special character.</p>');
	}else if(newPass != confirmPass) {
		$('#errorMsg').append('<p id="error_show"><i class="icon ion-arrow-down-b"></i> &nbsp; The new passwords did not match.Try again!</p>');
	} else {
		$.ajax({
		 url:'DBInsert.php',
         method:'POST',
        data:{
           old_password:oldPass,
		   new_password:newPass,
           confirm_password:confirmPass,
		   changePassword:true
         },
          success:function(data){
			  console.log(data);
			if(data == "true"){
				$('#errorMsg').append('<p id="success">Password updated successfully &nbsp;<i class="icon ion-information"></i></p>');
			} else{
				$('#errorMsg').append('<p id="error_show"><i class="icon ion-arrow-down-b"></i> &nbsp; data</p>');
			}
         }
		});

	}
}
</script>
</head>
<body>
	<div id="page-contents">
	<div class="container">
	<div class="row">
	<div class="col-md-3 static">
            <ul class="nav-news-feed">
              <li><div><i class="icon ion-wrench"></i>&nbsp;<a href="settings.php">Basic Information</a></div></li>
              <li class="active"><div><i class="icon ion-android-people"></i>&nbsp;<a href="ChangePassword.php">Edit Password</a></div></li>
  		   <li><div><i class="ion-ios-person"></i>&nbsp;<a href="UpdateProfilePicture.php">Update Picture</a></div></li>
            </ul><!--news-feed links ends-->
			
    </div>
	<div class="col-md-7">	
		 <div class="edit-profile-container">
                <div class="block-title">
                  <h4 class="grey"><i class="icon ion-android-people"></i>&nbsp;Change Password</h4>                
                </div>
				<div id="errorMsg">
					
				</div>
                <div class="edit-block">
                  <form name="update-pass"  class="form-inline" method="POST">
                    <div class="row">
                      <div class="form-group col-md-12">
                        <div class="form-group col-md-3"><label for="my-password">Old password</label></div>
                        <div class="form-group col-md-9"><input id="my-password" class="form-control input-group-lg" type="password" placeholder="Old password"	/></div>
                      </div>
                    
                      <div class="form-group col-md-12">
                        <div class="form-group col-md-3"><label>New password</label></div>
                        <div class="form-group col-md-9"><input class="form-control input-group-lg" type="password" id="newpassword" placeholder="New password"/></div>
                      </div>
                      <div class="form-group col-md-12">
                        <div class="form-group col-md-3"><label>Confirm password</label></div>
                        <div class="form-group col-md-9"><input class="form-control input-group-lg" type="password"  id="confirmpassword" placeholder="Confirm password"/></div>
                      </div>
                    </div>
					<div class="form-group col-md-12">
						<button class="btn btn-primary" type="button" onclick="updatePassword()">Update Password</button>
					</div>
                  </form>
                </div>
              </div>
            </div>
     
    </div>
	
	<div class="col-md-2 static">
		
	</div>
	</div>
	</div>
 
</body>
</html>