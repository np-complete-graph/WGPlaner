<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>WG Finanzen | Profil</title>
        <link rel="shortcut icon" href="/img/favicon.png">
		<link href="./css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="./css/style.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="./js/jquery.min.js"></script>
		<script type="text/javascript" src="./js/bootstrap.min.js"></script>
		<script type="text/javascript" src="./js/navbar.js"></script>
		<script>
				//Change profile picture
				var max_profiles = 3;
				function nextProfilePicture(id){
					var id = $('#profileImage').data("id");
					var profile_img = document.getElementById("profileImage");
					var profile_index = document.getElementById("profilePicture");
					var index = id+1;
					if (index > max_profiles)	index = 0;
					//Set new Index
					profile_index.value = index;
					profile_img.src = "./img/profiles/profile"+index+".jpg";
					$('#profileImage').data("id", index);
				}
				
				function previousProfilePicture(){
					var id = $('#profileImage').data("id");
					var profile_img = document.getElementById("profileImage");
					var profile_index = document.getElementById("profilePicture");
					var index = id-1;
					if (index < 0)	index = max_profiles;
					//Set new Index
					profile_index.value = index;
					profile_img.src = "./img/profiles/profile"+index+".jpg";
					$('#profileImage').data("id", index);
				}

				function leaveFinancesDialog(elem){
					if(confirm('Willst du wirklich aus den Finanzen austreten?'))
						window.location = elem.getAttribute('data-url');
				}
		</script>
    </head>
    <body>
	<div id="wrapper">
        <div class="overlay"></div>
        <?php 	include_once('./protect.php');
        		include_once('./navbar.html');
				$id = filter_input(INPUT_GET,'id');
				$result = $db->query("SELECT * FROM users WHERE UserId='$id' AND isDeleted=0;");
				if ($result->num_rows > 0){
					$row = $result->fetch_assoc();
					//Extract Information of user
					$userid = $row['UserId'];
					$username = $row['Username'];
					$isFinanceMember = $row['isFinanceMember'];
					$email = $row['Email'];
					$profilePicture = $row['ProfilePicture'];
					$profileImage = "./img/profiles/profile".$row['ProfilePicture'].".jpg";
					$memberSince = date('d.m.Y',strtotime($row['Date']));
				}
				$canEdit = ($_SESSION['UserId'] == $userid || $_SESSION['isAdmin']) ? 1 : 0;
				
				function showFinanceButton(){
					global $db;
					global $userid;
					global $isFinanceMember;
                    global $canEdit;
                    if ($canEdit){
                        if ($isFinanceMember){
                            echo "<input type='hidden' name='isFinanceMember' value='1'>";
                            echo "<button data-url='./Finanzen/scripts/financesLeave.php?id=$userid' onclick='leaveFinancesDialog(this);' class='flat-button danger'>Aus Finanzen austreten</button>";
                        }
                        else echo "<input type='hidden' name='isFinanceMember' value='0'><a href='./Finanzen/scripts/financesEnter.php?id=$userid' class='flat-button danger'>In Finanzen eintreten</a>";
                    }else{
                    	if ($isFinanceMember){
                    		echo "In Finanzen";
                    	}else{
                    		echo "Nicht in Finanzen";
                    	}
                    }
				}
        
                function showUpdateButton(){
                    global $canEdit;
                    if ($canEdit){
                    	echo "<button class='flat-button success fill' type='submit' $flag>Update</button>";
                    }
                }
		?>

        <!-- Page Content -->
        <!-- Profile Content -->
        <div id="page-content-wrapper">
            <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                <span class="hamb-top"></span>
    			<span class="hamb-middle"></span>
				<span class="hamb-bottom"></span>
            </button>
	<div class="container content" align="center">
			<div class="row">
			<h1>Profil von <?php echo $username;?></h1>
				<div class="col-md-6">
					<!-- Profile Picture -->
					<img src=<?php echo $profileImage;?> id="profileImage" style='width: 100%; max-height: 300px; margin-bottom: 20px;' alt='No Profile image!' data-id="<?php echo $profilePicture;?>"/>
					<nav>
					  <ul class="pager">
						<li class="main-color" style="cursor: pointer;"><a onclick="previousProfilePicture()"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
						<li class="main-color" style="cursor: pointer;"><a onclick="nextProfilePicture()"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
					  </ul>
					</nav>
				</div>
				<div class="col-md-6">
				
				<!-- User Data -->
				<form action="./manageUser.php" method="POST">
					<input type="hidden" name="method" value="0"/>
					<input type="hidden" name="isFinanceMember" value=<?php echo $isFinanceMember?>/>
					<input type="hidden" name="id" value="<?php echo $id;?>"/>
					<input type="hidden" id="profilePicture" name="profilePicture" value="<?php echo $profilePicture; ?>"/>
						<input type="text" class="flat-textbox" name="username" placeholder="Username" value="<?php echo $username; ?>">
					<br>
						<input type="text" class="flat-textbox" name="email" placeholder="Email" value="<?php echo $email;?>">
					<br>
						<input type="text" class="flat-textbox" name="password" placeholder="Neues Passwort (falls nötig)" >
					<br>
					<div>
						<?php showUpdateButton();?>
					</div>
					<br>
				</form>
				</div>
				
				<!-- User Information -->
				<div class="col-md-12">
				<div class="table-title">
					<h3>Information</h3>
					</div>
					<table class="table-fill">
					<thead>
					<tr>
					<th>Anlass</th>
					<th>Wert</th>
					</tr>
					</thead>
					<tbody>
						<tr>
							<td>Mitglied seit:</td>
							<td><?php echo $memberSince;?></td>
						</tr>
						<tr>
						<td>Finanzstatus:</td>
						<td><?php showFinanceButton();?></td>
						</tr>
					</tbody>
					</table>
				</div>
			</div>
			</div>
        <!-- /#page-content-wrapper -->

    </div>
    </div>
    <!-- /#wrapper -->
    </body>
</html>

