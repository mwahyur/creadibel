<?php
$this->load->view('templates/Head');
?>
<?php
$this->load->view('templates/Topbar');
?>
	<section>
		<div id="page-wrapper" class="sign-in-wrapper">
			<div class="graphs">
				<div class="sign-up">
					<h1>Create New User</h1>
					<h2>Personal Information</h2>
					<form role="form" action="<?php echo site_url('Registrasi/Adduser') ?>" method="post">
						<div class="sign-u">
							<div class="sign-up1">
								<h4>Nama* :</h4>
							</div>
							<div class="sign-up2">
								<input type="text" name="nama_user" placeholder="" required/>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="sign-u">
							<div class="sign-up1">
								<h4>Username* :</h4>
							</div>
							<div class="sign-up2">
									<input type="text" name="username_user"  placeholder="" required/>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="sign-u">
							<div class="sign-up1">
								<h4>Password* :</h4>
							</div>
							<div class="sign-up2">
									<input type="password" name="pwd_user" placeholder="" required/>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="sign-u">
							<div class="sign-up1">
								<h4>Email* :</h4>
							</div>
							<div class="sign-up2">
									<input type="text" name="email_user" placeholder="" required/>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="sign-u">
							<div class="sign-up1">
								<h4>No Telp / No HP* :</h4>
							</div>
							<div class="sign-up2">
									<input type="text" name="tlp_user" placeholder="" required/>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="sub_home">
							<div class="sub_home_left">
									<input type="submit" name="regis" value="Create">
							</div>
							<div class="sub_home_right">
								<p>Go Back to <a href="<?php echo site_url('Home') ?>">Home</a></p>
							</div>
							<div class="clearfix"></div>
						</div>
					</form>
				</div>
			</div>
		</div>
	<!--footer section start-->
		<footer class="diff">
		   <p class="text-center">&copy 2016 Resale. All Rights Reserved | Design by <a href="<?php echo site_url('Home') ?>" target="_blank">Creadible</a></p>
		</footer>
	<!--footer section end-->
	</section>
</body>
</html>