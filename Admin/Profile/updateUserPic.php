<?php
		if(isset($_GET['user_email'])) {
			$user = $_GET['user_email'];
		}
		//session_start();
		//$user=$_SESSION['user'];		
		$con = mysqli_connect("localhost","root","");
		mysqli_select_db($con,"website");
		$query1 = mysqli_query($con,"select * from users where email='$user'");
		$rec1 = mysqli_fetch_array($query1);
		$user_id = $rec1[0];
		$query2=mysqli_query($con,"select * from user_profile_pic where user_id=$user_id");
		$rec2=mysqli_fetch_array($query2);
		
		$name=$rec1[1];
		$gender=$rec1[4];
		$user_bday=$rec1[5];
		$img=$rec2[2];
?>
<?php
if( isset($_POST['file']) && ($_POST['file']=='Update Picture'))
	{
		if(isset($_POST['file']) && $_FILES['file']['size'] > 0)
		{
			$path = "../../users/".$user_id."/Profile/";
			$img_name=$_FILES['file']['name'];
			$img_tmp_name=$_FILES['file']['tmp_name'];
			$prod_img_path=$img_name;
			move_uploaded_file($img_tmp_name,$path.$prod_img_path);
			
			$sqlquery = "UPDATE user_profile_pic SET image='$img_name' WHERE user_id=$user_id";
			//mysqli_query($con,"UPDATE user_profile_pic SET image='$img_name' WHERE user_id='$user_id';");
			if (mysqli_query($con,$sqlquery)) {
				header("Refresh:0");
			}	 else {
				echo "Error deleting record: " . mysqli_error($con);
			}
		}
		
		
	}
?>


<!doctype html>
<html lang="en">
<head>
  <title>Profile Page</title>
  <!-- Required meta tags -->
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="Profile_style/style.css">
  <link rel="stylesheet" href="Profile_css/ionicons.min.css"  />
  <link rel="stylesheet" href="Profile_css/font-awesome.min.css" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="Profile_js/Profile.js"> </script>
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
<body style="margin-top:50px">
 <nav class="navbar navbar-default fixed-top navbar-expand-lg navbar-dark bg-dark" role="navigation">
    <button class="navbar-toggler" type="button" data-toggle="collapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <a class="navbar-brand" href="#">[FriendSpace]</a>
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item active">
          <a class="nav-link" href="Profile.php">Profile <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../Settings/settings.php">Settings<span class="sr-only">(current)</span></a>
        </li>
	   <li class="nav-item">
		<a class="nav-link" href="../../Logout.php">Logout<span class="sr-only">(current)</span></a>
	  </li>
      </ul>
    <form action='Search.php' method="post" class="form-inline my-2 my-lg-0">
				<input class="form-control mr-sm-2" name="search_item" type="search" placeholder="Search" aria-label="Search">
				<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
			</form>
    </div>
</nav>
  <div id="page-contents">
	<div class="container">
	<div class="row">
	<div class="col-md-3 static">
	<div style="position:fixed;">
		 <div class="profile-card">
            	<img src="../../
				<?php
					//$q_pic = mysqli_query($con,"select * from user_profile_pic where user_id =$user_id");
					if(mysqli_num_rows($query2) == 0){
						$path = "default.png";
						echo $path;
					} else {
						$path = "users/".$user_id."/Profile/";
						//$q_pic_array = mysqli_fetch_array($q_pic);
						///echo $path.$q_pic_array[2];
						echo $path.$img;
					}
				?>
				" alt="user" class="profile-photo" />
            	<h5><a class="text-white">
				<?php
					$q_name = mysqli_query($con,"select * from users where user_id =$user_id");
					$q_name_array = mysqli_fetch_array($q_name);
					echo $q_name_array[1];
				?>
				</a></h5>
            	<a class="text-white"><i class="ion ion-podium"></i>
				<?php
					$user_f = mysqli_query($con,"SELECT * FROM user_friends where user_id=$user_id");
					echo mysqli_num_rows($user_f);
				?>
				Total Users</a>
         </div><!--profile card ends-->
            <ul class="nav-news-feed">
              <li>
				<i class="icon ion-ios-paper"></i>
				<div>
					<a href="friendProfile.php?user_email=<?php echo $user;?>"><?php echo $name;?> Posts</a>
				</div>
			  </li>
              <li><i class="icon ion-wrench"></i><div><a href="EditUserInfo.php?user_email=<?php echo $user;?>">Basic Information</a></div></li>
 			  <li><i class="ion-ios-person"></i><div><a href="#">Update Picture</a></div></li>

            </ul><!--news-feed links ends-->
    </div>
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
							if(mysqli_num_rows($query2) == 0){
								$path = "default.png";
								echo $path; 
							} else {
								$path = "users/".$user_id."/Profile/";
								echo $path.$img;
							}

						?>" style="height:15% width:15%;" alt= "user" id="userImage" class="profile-photo"/>
					</div>
					 <div class="form-group col-md-12"><input type="submit" value="Update Picture" name="file" class="btn btn-primary pull-right" id="post_button"/></div>
					 
					</form> 
					 </form>
                </div>
              </div>
           
	 
	</div>
	
	<!-- Online Chat
        ================================================= -->
	<div class="col-md-2 static">
<!--	<div style="position:fixed;">
		<div id="chat-block">
              <div class="title">Chat Online</div>
              <ul class="online-users list-inline">
                <li><a href="template.html" title="user_name"><img src="Profile_pics/user-1.jpg" alt="user" class="img-responsive profile-photo" /><span class="online-dot"></span></a></li>
              </ul>
        </div><!--chat block ends--
	</div>-->
	</div>
	</div>
	</div>
  </div>
    
 <!-- <nav class="navbar fixed-bottom navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Fixed bottom</a>
</nav> -->

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
