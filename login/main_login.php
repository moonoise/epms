<?php
include_once "config.php";
session_start();
if (isset($_SESSION[__USER_NAME__])) {
    header("location:index.php");
    
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../external/icon/rid.png">
    
    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../vendors/bootstrap/dist/css/custom.min.css" rel="stylesheet">
    
  </head>

  <body class="login">
    
  <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form class="form-signin" name="form1" method="post" action="checklogin.php">
            <img src="../external/icon/rid.png" width="180px" alt="..." style="float:none;">
              <h4 class="text-info">-- เข้าสู่ระบบ สำหรับผู้ดูแลระบบ สำนัก/กอง --</h4>
              <div>
                <input type="text" class="form-control" required="" name="myusername" id="myusername"   placeholder="Username" autofocus/>
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" name="mypassword" id="mypassword"/>
              </div>
              <div>
                <button class="btn btn-info submit" name="Submit" id="submit">Log in</button>
                <!-- <a class="reset_pass" href="forgot-password.php">ลืมรหัสผ่าน ?</a> -->
              </div>
              <label class="checkbox">
               <!-- <input type="checkbox" value="remember-me"> <small>คลิ๊ก เพื่อจำบัญชีนี้</small> -->
               
               </label>
               
               <div id="message"></div>
              <div class="clearfix"></div>

              <!-- <div class="separator">
                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
              </div> -->
            </form>
          </section>
        </div>

        <!-- <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form>
              <h1>Create Account</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <a class="btn btn-default submit" href="index.html">Submit</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div> -->
      </div>
    </div>
   

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
     <script src="../vendors/jquery/dist/jquery.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- The AJAX login script -->
    <script src="js/login.js"></script>

  </body>
</html>
