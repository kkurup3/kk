<?php
//error_reporting(0);
$servername = 'localhost';
$username = 'root';
$password = '';

session_start();
$userInSession=$_SESSION['user_id'];
// Create connection
$con = new mysqli($servername, $username, $password, "website");
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
$sql = "SELECT * FROM users where adminUser=false";
$result=mysqli_query($con,$sql); 

if(isset($_POST['DeleteUser'])){
	$useridTodelete = $_POST['userid'];
	$sqlDelete = "DELETE FROM users where user_id=$useridTodelete";
	
	if (mysqli_query($con,$sqlDelete)) {
		header("Refresh:0");
	} else {
    echo "Error deleting record: " . mysqli_error($con);
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
  <link rel="stylesheet" href="Profile_css/ionicons.min.css"  />
  <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="Profile_style/style.css">
  <link rel="stylesheet" href="Profile_style/friends_style.css">


  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="Profile_js/Profile.js"> </script>
<script>
	function time_get()
	{
			d = new Date();
		mon = d.getMonth()+1;
		time = d.getDate()+"-"+mon+"-"+d.getFullYear()+" "+d.getHours()+":"+d.getMinutes();
		posting_pic1.pic_post_time.value=time;
		
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
          <a class="nav-link" href="Settings/settings.php">Settings<span class="sr-only">(current)</span></a>
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
					$q_pic = mysqli_query($con,"select * from user_profile_pic where user_id =$userInSession");
					if(mysqli_num_rows($q_pic) == 0){
						$path = "default.png";
						echo $path;
					} else {
						$path = "users/".$userInSession."/Profile/";
						$q_pic_array = mysqli_fetch_array($q_pic);
						echo $path.$q_pic_array[2];
					}
				?>
				" alt="user" class="profile-photo" />
            	<h5><a class="text-white">
				<?php
					$q_name = mysqli_query($con,"select * from users where user_id ='$userInSession'");
					$q_name_array = mysqli_fetch_array($q_name);
					echo $q_name_array[1];
				?>
				</a></h5>
            	<a class="text-white"><i class="ion ion-podium"></i>
				<?php
					$user_f = mysqli_query($con,"SELECT * FROM users where adminUser=false");
					echo mysqli_num_rows($user_f);
				?>
				Total Users</a>
         </div><!--profile card ends-->
            <ul class="nav-news-feed">
              <li><i class="icon ion-ios-paper"></i><div><a href="Profile.php">All Posts</a></div></li>
              <li><i class="icon ion-ios-people"></i><div><a href="#">All Users</a></div></li>
              <li><i class="icon ion-ios-chatboxes"></i><div><a href="Messages/messages.php">Messages</a></div></li>
            </ul><!--news-feed links ends-->
    </div>
		  </div>
	<!-- friends section
        ================================================= 
		=================================================
		================================================= -->
		
	<div class="col-md-7">
	<div>
		<table id="friendstable">
		 <colgroup>
			<col style="width:20%"/>
			<col style="width:80%"/>
		</colgroup> 
            <?php
               while ($row = mysqli_fetch_array($result)) {
				$friend_id = $row['user_id'];
				$user = mysqli_query($con,"select Name,Email from users where user_id ='$friend_id'");
				$user_name = mysqli_fetch_array($user);
				$user_f = mysqli_query($con,"SELECT * FROM user_friends where user_id='$friend_id'");
				$user_i = mysqli_query($con,"select image from user_profile_pic where user_id ='$friend_id'");			
				
				if(mysqli_num_rows($user_i) == 0){
					$path = "../../default.png";
				} else {
					$user_image = mysqli_fetch_array($user_i);	
					$path = "../../users/".$friend_id."/Profile/".$user_image[0];
				}
		
                   echo "<tr>";
                   echo "<td><img src=$path style='height:100 max-width:100%;' alt= 'user' id='userImage' class='photo'</td>"; 
				   echo "<td><a href='friendProfile.php?user_email=".$user_name[1]."'>".$user_name[0]."</a><br><small>".mysqli_num_rows($user_f)." friends </small></td>";
				   echo "<form method='POST'>";
				   echo "<td><input type='hidden' value=".$friend_id." name='userid'></td>";				   
				   echo "<td><input type='submit' name='DeleteUser'  value='Delete User' id='deleteUser' class='btn btn-primary pull-right' ></td>";
				   
		
				   echo "</form>";
                   echo "</tr>";
               }
            ?>
		</table>
	</div>
	</div>
	<!-- end of friends 
        ================================================= 
		=================================================
		================================================= -->
		
	
	<!-- Online Chat
        ================================================= -->
	<div class="col-md-2 static">
<!--	<div style="position:fixed;">
		<div id="chat-block">
              <div class="title">Chat Online</div>
              <ul class="online-users list-inline">
                <li><a href="Profile.php" title="user_name"><img src="Profile_pics/user-1.jpg" alt="user" class="img-responsive profile-photo" /><span class="online-dot"></span></a></li>
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
