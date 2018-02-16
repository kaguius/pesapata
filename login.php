<?php
	$userid = "";
	$adminstatus = "";
	$property_manager_id = "";	
	session_start();
	$page_title = "Login";
	include_once('includes/db_conn.php');
	if (!empty($_GET)){	
		$login_status = $_GET['login_status'];
	}
	$transactiontime = date("Y-m-d G:i:s");
	include_once('includes/login_header.php');
	
?>		
	<div id="page">
		<div id="content">
			<div class="post">
				<h2>Pesa Pata Direct Portal</h2>
				<p align="center"><img src="images/pesapatalogowhite.jpg" width="250px"></p>
				<table class="dataTable" width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="300" align="right"></td>
					<td align="left" valign="middle" width="350" style="border: 1px dotted #C5D6FC; padding-left:2px;">
					<form id="frmLogin" name="frmLogin" method="post" onSubmit='return vdator2.exec();' action="<?php echo $_SERVER['PHP_SELF'];?>">
                                                <table width="100%" border="0" align="center" cellpadding="5" cellspacing="5">
                                                        <tr>
                                                                <td width="30%">Username :</td>
                                                                <td width="70%">
                                                                        <input id="username" name="username" type="text" class="input" />
                                                                        <script language="JavaScript" type="text/javascript">if(document.getElementById) document.getElementById('username').focus();</script> 
                                                                </td>
                                                        </tr>
                                                        <tr>
                                                          	<td>Password :</td>
                                                          	<td >
                                                          		<input name="password" id="password" type="password" class="main_input" />
                                                          	</td>
                                                        </tr>
                                                        <tr>
                                                          	<td colspan="2" align="right">
                                                          		<input name="submit" type="submit" id="submit" class="input2" value="Login" onclick="return CheckForm();" />
								</td>							
                                                        </tr>
							<?php if($login_status== 'badlogin'){ ?>
							<tr>
								<td colspan="2" align="left">
									<font color="red" size="2px">The username or password don't match the records in the database, or your login has been disabled from the system.</font>
								</td>
							</tr>
							<?php } ?>
							<tr>
								<td colspan="2" align="center">
									<a href="password_gen.php"><font size="2px">Forgot your password</font></a>
								</td>
							</tr>
                                                </table>
                                        </td>
					<td width="300" align="left"><img src="images/logo2.png" alt="" /></td>
                                  </tr>
                                </table>
				
                                </form>
                        </table>
                        </form>
			
				<br />
				
					<script  type="text/javascript">
						var frmvalidator = new Validator("frmLogin");
						frmvalidator.addValidation("username","req","Username cannot be empty");
						frmvalidator.addValidation("password","req","Please enter the password");
					</script>
				</form>
			</div>
		</div>
		<br class="clearfix" />
		</div>
	</div>
<?php
		if (!empty($_POST)) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			$result = mysql_query("SELECT id, username, password_main, admin_status, station, user_status FROM user_profiles WHERE username = '$username'");
			while ($row = mysql_fetch_array($result))
			{
				$intcount++;
				$user_id = $row['id'];
				$user_username_text = $row['username'];
				$user_username = mysql_real_escape_string($user_username_text);
				$user_password_text = $row['password_main'];
				$user_password = mysql_real_escape_string($user_password_text);
				$user_status = $row['user_status'];
				$admin_status = $row['admin_status'];
				$station = $row['station'];
			}
			
			$hashedpassword = MD5($password);
			
			if(($hashedpassword == $user_password) && ($user_username == $username)) {
				$ipaddress = $_SERVER['REMOTE_ADDR'];
				$browsertype = $_SERVER['HTTP_USER_AGENT'];
				
				$sql="INSERT INTO user_logs (username, user_id, log_time, log_ipaddress, log_browser) 
				VALUES ('$user_username','$user_id', '$transactiontime','$ipaddress','$browsertype')";
				//echo $sql;
				$result = mysql_query($sql);

				$_SESSION["username"] = $username;
				$_SESSION["userid"] = $user_id;
				$_SESSION["adminstatus"] = $admin_status;
				$_SESSION["station"] = $station;
				
				?>
				<script type="text/javascript">
				<!--
					document.location = "index.php";
				//-->
				</script>
				<?php
			}
			else {
				$ipaddress = $_SERVER['REMOTE_ADDR'];
				$sql="INSERT INTO users_failed_logs (username, password, ipaddress, tranasctiontime) 
				VALUES ('$username','$password', '$ipaddress', '$transactiontime')";
				//echo $sql;
				$result = mysql_query($sql);

				$badlogin = MD5(badlogin);
				$query = "login.php?login_status=badlogin&status=$badlogin";
				?>
				<script type="text/javascript">
				<!--
					/*alert("Either the Email Address or the Password do not match the records in the database or you have been disabled from the system, please contact the system admin at www.e-kodi.com/contact.php");*/
					document.location = "<?php echo $query ?>";
				//-->
				</script>
				<?php
			}		
			
		}
?>
<?php
	include_once('includes/footer.php');
?>
