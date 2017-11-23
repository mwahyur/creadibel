<body>
<div class="header">
  <div class="container">
    <div class="logo">
      <a href="<?php echo site_url('Home') ?>"><img src="<?php echo base_url('asset/images/creadible1.png') ?>"></a>
    </div>
    <div class="header-right">
    <?php if (!isset($this->session->userdata['id_user'])) { ?>
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Login</button>
        <span class="active uls-trigger"></span>
        <a class="account" href="/login">What's Credible</a>
        <span class="active uls-trigger"></span>
        <a class="account" href="/login">Contact Us</a>
        <span class="active uls-trigger"></span>
        <a class="account" href="/login">About Us</a>
    <?php }else{ ?>
        <a class="account" href="#"><?php echo $this->session->userdata('nama_user'); ?></a>
        <span class="active uls-trigger"></span>
        <a class="account" href="/login">What's Credible</a>
        <span class="active uls-trigger"></span>
        <a class="account" href="/login">Contact Us</a>
        <span class="active uls-trigger"></span>
        <a class="account" href="/login">About Us</a>
        <span class="active uls-trigger"></span>
        <a class="account" href="<?php echo site_url('Login_user/logout') ?>">Logout</a>
    <?php } ?>
        
  </div>
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    Log In</h4>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                        <div class="signin">
                        <form role="form" action="<?php echo site_url('Login_user/proseslogin') ?>" method="post">
                            <div class="log-input">
                                <div class="log-input-left">
                                   <input type="text" class="user" name="username" value="User Name" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'User Name';}"/>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                            <div class="log-input">
                                <div class="log-input-left">
                                   <input type="password" class="lock" name="password" value="password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email address:';}" required/>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                            <input type="submit" name="login" value="Log in">
                        </form>  
                        </div>
                        <div class="new_people">
                            <h2>For New People</h2><br/>
                            <a href="<?php echo site_url('Registrasi') ?>">Register Now!</a>
                        </div>
                    </div>  
            </div>
        </div>
    </div>
</div>
<script>
$('#myModal').modal('');
</script>
  </div>
</div>
