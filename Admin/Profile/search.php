<?php
session_start();
// Create connection
$conn = mysqli_connect("localhost", "root", "", "website");
$userInSession = $_SESSION['user_id'];
$search = $_POST['search_item'];

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
//if($search != '')
$sql_post = "select * from user_post where post_text like '%$search%'";
$result_post = mysqli_query($conn,$sql_post);
$sql = "SELECT * FROM users where Name like '%$search%'";
$result=mysqli_query($conn,$sql); 
	

?>

<html lang="en">
<head>
	<title>Search Page</title>
	<!-- Required meta tags -->
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="Profile_css/ionicons.min.css"  />
	<link rel="stylesheet" href="Profile_css/font-awesome.min.css" />
	<link rel="stylesheet" href="Profile_style/friends_style.css">
	<link rel="stylesheet" href="Profile_style/style.css">

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
	<br><br>
	<h2><center>Search results for People: "<strong><?php echo $search; ?>"</strong></center></h2>

	<nav class="navbar navbar-default fixed-top navbar-expand-lg navbar-dark bg-dark" role="navigation">
		<button class="navbar-toggler" type="button" data-toggle="collapse">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
			<a class="navbar-brand" href="#">[FriendSpace]</a>
			<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
				<li class="nav-item">
					<a class="nav-link" href="Profile.php">Profile <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../Settings/settings.php">Settings<span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../../Logout.php">Logout<span class="sr-only">(current)</span></a>
				</li>
			</ul>
			<form action='search.php' method="post" class="form-inline my-2 my-lg-0">
				<input class="form-control mr-sm-2" name="search_item" type="search" placeholder="Search" aria-label="Search">
				<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
			</form>
		</div>
	</nav>
	<div id="page-contents">
		<div class="container">
			<div class="row">
				<div class="col-sm-1">
				
					<button type="button" class="btn btn-primary"> <a href="search.php" style="color:white">People</button><br><br>
					<button type="button" class="btn btn-primary"> <a href="search2.php?search_item=<?php echo $search;?>" style="color:white">Posts</button><br><br>
				</div>


				<div class="col-xl-11">
					<div id="peopletable">
						<table id="peopletable">
						 <colgroup>
						<col style="width:20%"/>
						<col style="width:80%"/>
						</colgroup> 
							<?php
							if(mysqli_num_rows($result) == 0)
							{
							?>
							<tr>
								<td style="widht:5000px;">
								<h1> No results found</h1>
								</td>
							</tr>
							
							<?php
							}
							while ($row = mysqli_fetch_array($result)) {
								$search_user_id=$row[0];
								$search_name = $row[1];
								$search_email = $row[2];
								$query11 = mysqli_query($conn,"select * from user_profile_pic where user_id = $search_user_id;");
								$fetch_query11 = mysqli_fetch_array($query11);
								$search_pic= $fetch_query11[2];
								$s_user_f = mysqli_query($conn,"SELECT * FROM user_friends where user_id='$userInSession'");
								$s_user_f_arr = mysqli_fetch_array($s_user_f);
								if(mysqli_num_rows($query11)==0)
								{
									$path="../default.png";
								}
								else
								{
									$path = "../users/".$search_user_id."/Profile/";
						$path = $path.$search_pic;
								}
								if(in_array($search_user_id,$s_user_f_arr) || $search_user_id == $userInSession)
								{
									?>
									<tr>
						<td><img src="<?php echo $path;?>" style="height:90px; widht=100px;" alt="user" id="userImage" class="photo"></td> 
						<td>
						<a href="friendProfile.php?user_email=
						<?php echo $search_email;?>"><?php echo $search_name; ?>
						</a>
						<br />
						</td>				   
						</tr>
						<?php
								}
								else
								{
							?>
									<tr>
						<td><img src="<?php echo $path;?>" style="height:90px; width:100px;" alt="user" id="userImage" class="photo"></td> 
						<td style="height:90px; width:200px;">
						<a href="friendProfile.php?user_email=
						<?php echo $search_email;?>" ><?php echo $search_name; ?></a><br></td>
						<td>
						<form method='POST'">
						<input type='hidden' name='searchid' value='<?php echo $search_user_id; ?>'>
									<td><button type='hidden'  class='btn btn-primary pull-right' name='addFriend'> Add Friend</button></td>
									 </form>
									 </td>
						</tr>
						<?php
								}
								?>
							
								
								<?php
							}
							?>
						</table>
					</div>
				</div>


				<div class="col-md-7">
					<div id="posttable">
						<table id="posttable">
							<colgroup>
								<col style="width:20%"/>
								<col style="width:80%"/>
							</colgroup> 
							<?php
							while ($row = mysqli_fetch_array($result)) {
								$user_id=$row['user_id'];
								$posts = mysqli_query($conn,"SELECT * FROM user_post where user_id='$user_id' by post_id desc");	
								echo "<tr>";
								echo "<td><img src=$path style='height:10%; max-width:100%;' alt= 'user' id='userImage' class='photo'</td>"; 
								echo "<td><a href='friendProfile.php?user_email=".$row['Email']."'> ".$row['Name']."</a><br><small>".mysqli_num_rows($user_f)." friends </small></td>";				   
								echo "</tr>";
							}
							?>
						</table>
					</div>
				</div>


			</div>
		</div>
	</div>

	<!-- Optional JavaScript -->
	<script>
	
	</script>
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
