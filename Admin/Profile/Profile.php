<?php
		session_start();
		$user=$_SESSION['user'];		
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
	if( isset($_POST['file']) && ($_POST['file']=='post'))
	{
		$txt=$_POST['post_txt'];
		if($txt=="" && isset($_POST['file']))
		{
			$txt="added a new photo.";
		}
		
		$priority=$_POST['priority'];
		$post_time=$_POST['pic_post_time'];
		
		if(isset($_POST['file']))
		{
			$path = "../../users/".$user_id."/Post/";
			$img_name=$_FILES['file']['name'];
			$img_tmp_name=$_FILES['file']['tmp_name'];
			$prod_img_path=$img_name;
			move_uploaded_file($img_tmp_name,$path.$prod_img_path);
			
		}
		else
		{
			$img_name="";
		}
		mysqli_query($con,"insert into user_post(user_id,post_txt,post_pic,post_time,priority) values('$user_id','$txt','$img_name','$post_time','$priority');");
	}
	if(isset($_POST['commenting']))
	{
		$post_id=intval($_POST['postid']);
		$user_id=intval($_POST['userid']);
		$txt=$_POST['comment_txt'];
		if($txt=="" && isset($_POST['commenting']))
		{
			$txt="added a new photo.";
		}
		if(isset($_POST['commenting']))
		{
			$path = "../../users/".$user_id."/Comment/";
			$img_name=$_FILES['file']['name'];
			$img_tmp_name=$_FILES['file']['tmp_name'];
			$prod_img_path=$img_name;
			move_uploaded_file($img_tmp_name,$path.$prod_img_path);
			
		}
		else
		{
			$img_name="";
		}
		mysqli_query($con,"insert into user_post_comment(post_id,user_id,comment,comment_pic) values($post_id,$user_id,'$txt','$img_name');");
	}
	if(isset($_POST['Like']))
	{
		$post_id=intval($_POST['postid']);
		$user_id=intval($_POST['userid']);
		mysqli_query($con,"insert into user_post_status(post_id,user_id,status) values($post_id,$user_id,'Like');");
	}
	if(isset($_POST['Unlike']))
	{
		$post_id=intval($_POST['postid']);
		$user_id=intval($_POST['userid']);
		mysqli_query($con,"delete from user_post_status where post_id=$post_id and  	user_id=$user_id;");
	}
	if(isset($_POST['comment']))
	{
		$post_id=intval($_POST['postid']);
		$user_id=intval($_POST['userid']);
		$txt=$_POST['comment_txt'];
		if($txt!="")
		{
		mysqli_query($con,"insert into user_post_comment(post_id,user_id,comment) values($post_id,$user_id,'$txt');");
		}
	}
	if(isset($_POST['delete_comment']))
	{
		$comm_id=intval($_POST['comm_id']);
		mysqli_query($con,"delete from user_post_comment where comment_id=$comm_id;");
	}	
	if(isset($_POST['delete_post']))
	{
		$post_id=intval($_POST['post_id']);
		mysqli_query($con,"delete from user_post where post_id=$post_id;");
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
	function time_get()
	{
			d = new Date();
		mon = d.getMonth()+1;
		time = d.getDate()+"-"+mon+"-"+d.getFullYear()+" "+d.getHours()+":"+d.getMinutes();
		posting_pic1.pic_post_time.value=time;
		
	}
	function blank_comment_check()
	{
	var post=document.commenting.cmnt.value;
	if(post=="")
	{
		return false;
	}
	return true;
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
					$user_f = mysqli_query($con,"SELECT * FROM users where adminUser=false");
					echo mysqli_num_rows($user_f);
				?>
				Total Users</a>
         </div><!--profile card ends-->
            <ul class="nav-news-feed">
              <li>
				<i class="icon ion-ios-paper"></i>
				<div>
					<a href="#">All Posts</a>
				</div>
			  </li>
              <li>
				<i class="icon ion-ios-people"></i>
				<div>
					<a href="allUsers.php">All Users</a>
				</div>
			  </li>
              <li>
				<i class="icon ion-ios-chatboxes"></i>
				<div>
					<a href="Messages/messages.php">Messages</a>
				</div>
			  </li>
            </ul><!--news-feed links ends-->
    </div>
		  </div>
		
	<div class="col-md-7">
		<div class="create-post">
		
		<form method="post" enctype="multipart/form-data" name="posting_pic1" onSubmit="return post_Img_check();" id="post_pic">
			<div class="form-group">
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
					
				" alt="" class="profile-photo-md">
				<textarea name="post_txt" cols="80" rows="2" class="form-control"  placeholder="What's on your mind?" id ="pic_post_txt1"></textarea>
				
			</div>
			<input type="hidden" name="pic_post_time"> 
			<div class="tools">
                    <ul class="publishing-tools list-inline">
                      <li>
					    <input id="post_img" type="file" name ="file" />
					  </li>
                      <li>
						<input type="hidden" name="txt_post_time">
						<select  name="priority" > 
							<option value="Public"> Public </option> 
						</select>
					  </li>
                    </ul>
					<input type="submit" value="post" name="file" class="btn btn-primary pull-right" onClick="time_get()" id = "post_button">
			</div>
		</form>
		
		</div>
		
		<!-- Post Content
        ================================================= -->	
		<div >
			<?php
				$que_post_bg1=mysqli_query($con,"select * from user_post");
				$count_bg1=mysqli_num_rows($que_post_bg1);
				//echo $count_bg1;
			?>
			<div style="position:absolute;"> 
			</div>
			<div>
				<table cellspacing="0">
				<?php
					$que_post=mysqli_query($con,"select * from user_post order by post_id desc");
					while($post_data=mysqli_fetch_array($que_post))
					{
						$postid=$post_data[0];
						$post_user_id=$post_data[1];
						$post_txt=$post_data[2];
						$post_img=$post_data[3];
						$que_user_info=mysqli_query($con,"select * from users where user_id=$post_user_id");
						$que_user_pic=mysqli_query($con,"select * from user_profile_pic where user_id=$post_user_id");
						$fetch_user_info=mysqli_fetch_array($que_user_info);
						$fetch_user_pic=mysqli_fetch_array($que_user_pic);
						$user_name=$fetch_user_info[1];
						$user_Email=$fetch_user_info[2];
						$user_gender=$fetch_user_info[4];
						$user_pic=$fetch_user_pic[2];
				?>
				<tr>
					
					<td>  </td>
					<td> </td>
				</tr>
				<tr>
					<td colspan="7" align="right" style=" border-top:outset; border-top-width:thin;">
					</td>
				</tr>
				<tr>
					<td style="padding-left:2px;" rowspan="2"> <img class="profile-photo-md" src="../../
					
					<?php
					if(mysqli_num_rows($que_user_pic) == 0){
						$path = "default.png";
						echo $path;
					} else {
						$path = "users/".$post_user_id."/Profile/";
						echo $path.$user_pic;
					}
					?>
					" height="60" width="55">  
					</td>
					<td colspan="3" style="padding-left:10px;"> <a href="friendProfile.php?user_email=<?php echo $user_Email;
					?>" style="text-transform:capitalize; text-decoration:none; color:#003399;" onMouseOver="post_name_underLine(<?php echo $postid; ?>)" onMouseOut="post_name_NounderLine(<?php echo $postid; ?>)" id="uname<?php echo $postid; ?>"> <?php echo $user_name; ?> </a>  
					</td>
					<td rowspan="2" width="5" align="right"> 
						<form method="post">  
							<input type="hidden" name="post_id" value="<?php echo $postid; ?>" >
							<input type="submit" name="delete_post" value=" " style="background-color:#FFFFFF; border:#FFFFFF; background-image:url(Profile_pics/delete.jpg); width:150%;"> 
						</form> 
					</td>
					<td > </td>
					<td> </td>
					<td> </td>
				</tr>
				<tr>
				<td colspan="3">
					<span style="color:#999999;padding-left:10px;">   <?php echo $post_data[4]; ?> </span> 
					<span style="color:#999999;padding-left:10px;"><?php echo $post_data[5]; ?></span>
					</td>
				</tr>
				<tr>
					<td> </td>
					<td> </td>
					<td> </td>
				</tr>
				
				
				<?php
					$len=strlen($post_data[2]);
					if($len>0 && $len<=73)
					{
						$line1=substr($post_data[2],0,73);
				?>
				<tr>
					<td></td>
					<td colspan="3" style="padding-left:10px;"><?php echo $line1; ?> </td>
				</tr>
				<?php
					}
				?>
				
				<?php 
					if($post_data[3]!="")
					{
				?>
				<tr>
					<td>   </td>
					<td colspan="8" align="center">
				<?php 
					$post_img_name = $post_data[3];
					$position = strpos($post_img_name,'.');
					$extension = substr($post_img_name,$position+1);
					$extension = strtolower($extension);
					if($extension == "mp4")
					{
				?>
					<video width="100%" controls>
						<source src ="../../users/<?php echo $post_user_id; ?>/Post/<?php echo $post_img; ?>" type='video/<?php echo $extension; ?>' >
					</video>
				<?php 
					}
					else
					{
				?>
					<img src="../../users/<?php echo $post_user_id; ?>/Post/<?php echo $post_img; ?>" style="max-width:100%; height:auto;"> 
				<?php 
					}
				?>
					</td>
					<td> </td>
					<td> </td>
				</tr>
				<?php
					}
				?>
				<tr style="color:#6D84C4;">
					<td >   </td>
					<?php
						$que_status=mysqli_query($con,"select * from user_post_status where post_id=$postid and user_id=$user_id;");
						$que_like=mysqli_query($con,"select * from user_post_status where post_id=$postid");
						$count_like=mysqli_num_rows($que_like);
						$status_data=mysqli_fetch_array($que_status);
						if($status_data[3]=="Like")
						{
					?>
			
					<td style="padding-top:15;">
					<form method="post">
					<input type="hidden" name="postid" value="<?php echo $postid; ?>">
					<input type="hidden" name="userid" value="<?php echo $user_id; ?>">
					<input type="submit" value="Unlike" name="Unlike" style="border:#FFFFFF;  font-size:15px; color:#6D84C4;" onMouseOver="unlike_underLine(<?php echo $postid; ?>
					)" onMouseOut="unlike_NounderLine(<?php echo $postid; ?>)" id="unlike<?php echo $postid; ?>"></form></td>
					<?php
						}
						else
						{
					?>
					<td style="padding-top:15;">
					<form method="post">
					<input type="hidden" name="postid" value="<?php echo $postid; ?>">
					<input type="hidden" name="userid" value="<?php echo $user_id; ?>">
					<input type="submit" value="Like" name="Like" style="border:#FFFFFF; background:#FFFFFF; font-size:15px; color:#6D84C4;" onMouseOver="like_underLine(<?php echo $postid; ?>)" onMouseOut="like_NounderLine(<?php echo $postid; ?>)" id="like<?php echo $postid; ?>"></form></td>
					<?php
						}
					?>
					<?php
		 
						$que_comment=mysqli_query($con,"select * from user_post_comment where post_id =$postid order by comment_id");
						$count_comment=mysqli_num_rows($que_comment);
					?>
		
					<td colspan="3"> &nbsp; <input type="button" value="Comment(<?php echo $count_comment; ?>)" style="background:#FFFFFF; border:#FFFFFF;font-size:15px; color:#6D84C4;" onClick="Comment_focus(<?php echo $postid; ?>);" onMouseOver="Comment_underLine(<?php echo $postid; ?>)" onMouseOut="Comment_NounderLine(<?php echo $postid; ?>)" id="comment<?php echo $postid; ?>">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td>   </td>
				</tr>
				<tr>
					<td>   </td>
					<td style="width:9;" colspan="3"><img src="Profile_pics/like1.PNG" style=" width:30px; height:30px;"><span style="color:#6D84C4;"><?php echo $count_like; ?></span> likes this. </td>
					<td> </td>
					<td> </td>
				</tr>
				<tr>
					<td>   </td>
					<td> </td>
					<td> </td>
					<td> </td>
				</tr>
				<?php
					while($comment_data=mysqli_fetch_array($que_comment))
					{
						$comment_id=$comment_data[0];
						$comment_user_id=$comment_data[2];
						$comment_img = $comment_data[4];
						$que_user_info1=mysqli_query($con,"select * from users where user_id=$comment_user_id");
						$que_user_pic1=mysqli_query($con,"select * from user_profile_pic where user_id=$comment_user_id");
						$fetch_user_info1=mysqli_fetch_array($que_user_info1);
						$fetch_user_pic1=mysqli_fetch_array($que_user_pic1);
						$user_name1=$fetch_user_info1[1];
						$user_Email1=$fetch_user_info1[2];
						$user_gender1=$fetch_user_info1[4];
						$user_pic1=$fetch_user_pic1[2];
				?>
				<tr>
					<td> </td>
					<td width="4%"  style="padding-left:12;" rowspan="2">  <img src="../../
					
					<?php
					if(mysqli_num_rows($que_user_pic1) == 0){
						$path = "default.png";
						echo $path;
					} else {
						$path = "users/".$comment_user_id."/Profile/";
						echo $path.$user_pic1;
					}
					?>
					" height="40" width="47">    </td>
					<td  style="padding-left:7;" > <a href="#" style="text-transform:capitalize; text-decoration:none; color:#3B5998;" onMouseOver="Comment_name_underLine(<?php echo $comment_id; ?>)" onMouseOut="Comment_name_NounderLine(<?php echo $comment_id; ?>)" id="cuname<?php echo $comment_id; ?>"> <?php echo $user_name1; ?></a> </td>
					<td align="right" rowspan="2" > 
					<form method="post">  
						<input type="hidden" name="comm_id" value="<?php echo $comment_id; ?>" >
						<input type="submit" name="delete_comment" value="X" style="background-color:#FFFFFF; border:#FFFFFF; background-image:url(Profile_pics/delete_comment_icon.png); width:13; height:13;"> &nbsp;
					</form>
					</td>
				</tr>
				<?php
					$clen=strlen($comment_data[3]);
					if($clen>0 && $clen<=60)
					{
						$cline1=substr($comment_data[3],0,60);
				?>
				<tr>
					<td> </td>
					<td  style="padding-left:7;" colspan="2"> <?php echo $cline1; ?></td>
				</tr>
				<?php
					}
				?>
				<?php
					if($comment_data[4]!="")
					{
				?>
				<tr>
					<td> </td>
					<td colspan="5" align="center">
				<?php
					$comment_img_name = $comment_data[4];
					$comment_position = strpos($comment_img_name,'.');
					$comment_extension = substr($comment_img_name,$comment_position+1);
					if($comment_extension == "mp4")
					{
				?>
					<video width="80%" controls>
						<source src ="../../users/<?php echo $comment_user_id; ?>/Comment/<?php echo $comment_img; ?>" type='video/<?php echo $comment_extension; ?>' >
					</video>
				<?php
					}
					else
					{
				?>
					<img src="../../users/<?php echo $comment_user_id; ?>/Comment/<?php echo $comment_img; ?>" style="max-width:100%; height:auto;"> 
				<?php
					}
					}
				?>
					</td>
				</tr>
				<?php
					}
					
				?>
				<tr>
					<td> </td>
					<td width="4%" style="padding-left:17;"  rowspan="2">  <img src="../../
					<?php
					if(mysqli_num_rows($que_user_pic) == 0){
						$path = "default.png";
						echo $path;
					} else {
						$path = "users/".$user_id."/Profile/";
						echo $path.$img;
					}
					?>
					" style="height:5%; max-width:100%;">   </td>
					<td colspan="2" style="padding-top:15;"> 
						<form method="post" enctype="multipart/form-data" name="commenting" onSubmit="return blank_comment_check()" id="cmnt"> 
							<input type="text" name="comment_txt" placeholder="Write a comment..." maxlength="420" style="width:440;" id="<?php echo $postid;?>"> 
							<input type="hidden" name="postid" value="<?php echo $postid; ?>"> 
							<input type="hidden" name="userid" value="<?php echo $user_id; ?>"> 
							<input id="post_img" type="file" name ="file" />
							<input type="submit" value="√" name="commenting" style="width: 21px;" align="right"> 
						</form> 
					</td>
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
				
				</table>
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
