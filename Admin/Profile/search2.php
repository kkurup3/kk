<?php
session_start();
// Create connection
$conn = mysqli_connect("localhost", "root", "", "website");
$username = $_SESSION['user_id'];
$search = $_GET['search_item'];
//echo $search;
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$sql_post = "select * from user_post where post_txt like '%$search%'";
$result_post = mysqli_query($conn,$sql_post);
$sql = "SELECT * FROM users where Name='$search'";
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
	<h2><center>Search results for Post: "<strong><?php echo $search; ?>"</strong></center></h2>

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
				<div class="col-md-3 static">
					<button type="button" class="btn btn-primary" id="showPeople"><a href="search.php" style="color:white">People</a></button><br><br>
					<button type="button" class="btn btn-primary" id=showPosts><a href="search2.php" style="color:white">Posts</a></button><br><br>
				</div>
			

				<div class="col-md-7">
					<div>
						<table cellspacing="0">
						<?php
							if(mysqli_num_rows($result_post) == 0)
							{
							?>
							<tr>
								<td style="widht:5000px;">
								<h1> No results found</h1>
								</td>
							</tr>
							
							<?php
							}
							
							while ($row = mysqli_fetch_array($result_post)) {
								//echo "post";
								//$search_post_id=$row1[1];
								//$posts = mysqli_query($conn,"SELECT * FROM user_post WHERE user_id=$search_post_id ORDER BY post_id DESC");	

								//if(!$posts) {
									//echo "No messages";
								//}

								//while($row = mysqli_fetch_array($posts)) {
									$search_id = $row[0];
									$search_userid = $row[1];
									$search_txt = $row[2];
									$search_pic= $row[3];
									$search_pri = $row[5];
									$query12 = mysqli_query($conn,"select * from users where user_id=$search_userid");
									$fetch_query12=mysqli_fetch_array($query12);
									$query13=mysqli_query($conn,"select * from user_profile_pic where user_id=$search_userid");
									$fetch_query13 = mysqli_fetch_array($query13);
									$search_name = $fetch_query12[1];
									$search_mail = $fetch_query12[2];
									$search_profile_pic = $fetch_query13[2];
									if($search_pri == 'Public')
									{
										
								?>
					
				<tr>
					<td colspan="7" align="right" style=" border-top:outset; border-top-width:thin;">
					</td>
				</tr>
				<tr>
					<td style="padding-left:2px;" rowspan="2"> <img class="profile-photo-md" src="../
					<?php
					if(mysqli_num_rows($query13) == 0){
						$path = "default.png";
						echo $path;
					}
					else 
					{
						$path = "users/".$search_userid."/Profile/";
						echo $path.$search_profile_pic;
					}
					?>" height="60" width="55">  
					</td>
					<td colspan="3" style="padding-left:10px;"> <a href="friendProfile.php?user_email=<?php echo $search_mail;
					?>" style="text-transform:capitalize; text-decoration:none; color:#003399;" onMouseOver="post_name_underLine(<?php echo $notifyid; ?>)" onMouseOut="post_name_NounderLine(<?php echo $search_id; ?>)" id="uname<?php echo $search_id; ?>"> <?php echo $search_name; ?> </a>  
					</td>
					
					<td > </td>
					<td> </td>
					<td> </td>
				</tr>
				<tr>
				<td colspan="3">
					</td>
				</tr>
				<tr>
					<td> </td>
					<td> </td>
					<td> </td>
				</tr>
				
				
				<?php
					$len=strlen($row[2]);
					if($len>0 && $len<=73)
					{
						$line1=substr($row[2],0,73);
				?>
				<tr>
					<td></td>
					<td colspan="3" style="padding-left:10px;"><?php echo $line1; ?> </td>
				</tr>
				<?php
					}
				?>
				
				<?php 
					if($row[3]!="")
					{
				?>
				<tr>
					<td>   </td>
					<td colspan="8" align="center">
				<?php 
					$post_img_name = $row[3];
					$position = strpos($post_img_name,'.');
					$extension = substr($post_img_name,$position+1);
					$extension = strtolower($extension);
					if($extension == "mp4")
					{
				?>
					<video width="100%" controls>
						<source src ="../users/<?php echo $search_userid; ?>/Post/<?php echo $search_pic; ?>" type='video/<?php echo $extension; ?>' >
					</video>
				<?php 
					}
					else
					{
				?>
					<img src="../users/<?php echo $search_userid; ?>/Post/<?php echo $search_pic; ?>" style="max-width:100%; height:auto;"> 
				<?php 
					}
				?>
					</td>
					<td> </td>
					<td> </td>
				</tr>
				<tr>
					
				</tr>
								<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?php
					}
				?>
								<?php
							}
								
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

