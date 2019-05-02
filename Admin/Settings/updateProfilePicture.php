<?php
include('template.html');
$servername = 'localhost';
$username = 'root';
$password = '';
session_start();
$userInSession=$_SESSION['user_id'];
error_reporting(0);
// Create connection
$con = new mysqli($servername, $username, $password, "website");
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} 		
?>
<?php
if( isset($_POST['file']) && ($_POST['file']=='Update Picture'))
	{
		if(isset($_POST['file']) && $_FILES['file']['size'] > 0)
		{
			$path = "../users/".$userInSession."/Profile/";
			$img_name=$_FILES['file']['name'];
			$img_tmp_name=$_FILES['file']['tmp_name'];
			$prod_img_path=$img_name;
			move_uploaded_file($img_tmp_name,$path.$prod_img_path);
			mysqli_query($con,"UPDATE user_profile_pic SET image='$img_name' WHERE user_id='$userInSession';");
		}
		
		
	}
?>
<html>
<head>
<link rel="stylesheet" href="css/stylesForSettings.css"/>
<link rel="stylesheet" href="css/ionicons.min.css"/ >
 <link rel="stylesheet" href="css/font-awesome.min.css" />
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
function preview_2(obj)
{
	var outImage ="userImage";
	if (FileReader)
	{
		var reader = new FileReader();
		reader.readAsDataURL(obj.files[0]);
		reader.onload = function (e) {
		var image=new Image();
		image.src=e.target.result;
		image.onload = function () {
			document.getElementById(outImage).src=image.src;
		};
		}
	}
	else
	{
		    // Not supported
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
              <li><div><i class="icon ion-android-people"></i>&nbsp;<a href="ChangePassword.php">Edit Password</a></div></li>
 			   <li class="active"><div><i class="ion-ios-person"></i>&nbsp;<a href="UpdateProfilePicture.php">Update Picture</a></div></li>
            </ul><!--news-feed links ends-->
			
    </div>
	<div class="col-md-7">	
		 <div class="edit-profile-container">
                <div class="block-title">
                  <h4 class="grey"><i class="icon ion-ios-person"></i>&nbsp;Update Profile Picture</h4>                
                </div>
				<div id="errorMsg">
					
				</div>
                <div class="edit-block">
					 <form name="update-profilePic" method="post" class="form-inline" enctype="multipart/form-data">
					 <div class="form-group col-md-12"><input id="post_img" type="file" name ="file" accept="image/png, image/jpeg" onChange="preview_2(this)"/></div>
					 <div class="form-group col-md-12">
					 
	 				 
					 
					 <img src="../../
						<?php
							$q_pic = mysqli_query($con,"select * from user_profile_pic where user_id ='$userInSession'");
							if(mysqli_num_rows($q_pic) == 0){
								$path = "default.png";
								echo $path;
							} else {
								$path = "users/".$userInSession."/Profile/";
								$q_pic_array = mysqli_fetch_array($q_pic);
								echo $path.$q_pic_array[2];
							}

						?>" alt= "user" id="userImage" class="profile-photo" />
					</div>
					 <div class="form-group col-md-12"><input type="submit" value="Update Picture" name="file" class="btn btn-primary pull-right" id="post_button"/></div>
					 
					</form> 
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