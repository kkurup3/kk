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



<html lang="en">
<head>
  <title>Profile Page</title>
  <!-- Required meta tags -->
  
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="Profile_style/style.css">
  <link rel="stylesheet" href="Profile_css/ionicons.min.css"  />
  <link rel="stylesheet" href="Profile_css/font-awesome.min.css" />
  <!-- Bootstrap CSS -->
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
  
  
<script>
	function saveChanges(){
	$("p").remove("#error_show");
	$("p").remove("#success");
	var nameLength = ($('#Name').val()).length;
	var name = $('#Name').val();
	var dob =$('#dob').val();
	var sex = $("input[name='gender']:checked").val();
	var userId = $("#userid").val();
	if(nameLength == 0){
		$("p").remove("#error_show");
		$("p").remove("#success");
		$('#errorMsg').append('<p id="error_show"><i class="icon ion-arrow-down-b"></i> &nbsp; Name is mandatory</p>');
	}  else {
		$.ajax({
            url:'DBInsert.php',
            method:'POST',
            data:{
				userid: userId,
				Name:name,
				DOB:dob,
				gender:sex,
				EditUserInfo:true
            },
            success:function(data){
				$('#errorMsg').append('<p id="success">Updated details successfully. &nbsp;<i class="icon ion-information"></i></p>');
            }
         });
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
					$q_pic = mysqli_query($con,"select * from user_profile_pic where user_id =$user_id");
					if(mysqli_num_rows($q_pic) == 0){
						$path = "default.png";
						echo $path;
					} else {
						$path = "users/".$user_id."/Profile/";
						$q_pic_array = mysqli_fetch_array($q_pic);
						echo $path.$q_pic_array[2];
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
              <li><i class="icon ion-wrench"></i><div><a href="#">Basic Information</a></div></li>
 			  <li><i class="ion-ios-person"></i><div><a href="UpdateUserPic.php?user_email=<?php echo $user;?>">Update Picture</a></div></li>

            </ul><!--news-feed links ends-->
    </div>
		  </div>
		
	<div class="col-md-7">
	 <div class="edit-profile-container">
                <div class="block-title">
                  <h4 class="grey"><i class="icon ion-wrench"></i>&nbsp;Edit Information</h4>                
                </div>
				<div id="errorMsg">
					
				</div>		
                <div class="edit-block">
                  <form name="update-pass" id="education" class="form-inline">
                   
						<input type="hidden" id="userid" value="<?php echo $user_id;?>"></input>
                      						   
                      <div class="form-group col-md-12">
						<div class="form-group col-md-3"><label for="lastName">Name</label></div>
						<div class="form-group col-md-9"><input class="form-control input-group-lg" type="text" placeholder="Last Name" id="Name" value="<?php echo $name;?>">
						</input></div>
                      </div>					  
					  
					  <div class="form-group col-md-12">
						<div class="form-group col-md-3"><label for="dob">Date of Birth</label></div>
						<div class="form-group col-md-9"><input class="form-control input-group-lg" type="date" id="dob" value="<?php echo $user_bday;?>"
								max="2019-04-31" min="1980-01-01"/></div>
                      </div>
					  
					   <div class="form-group col-md-12">
						<div class="form-group col-md-3"><label for="gender">Iam a:</label></div>
						<div class="form-group col-md-9">
						<input type="radio" name="gender" value="male" <?php echo ($gender=='male')?'checked':'' ?>>Male</input>  &nbsp;&nbsp;
						<input type="radio" name="gender" value="female" <?php echo ($gender=='female')?'checked':'' ?> >Female</input></div>
                      </div>
                   
					<div class="form-group col-md-12">
					 <button type="button"class="btn btn-primary" onclick="saveChanges()">Save Changes</button>
					</div>					 
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
</body>
</html>
