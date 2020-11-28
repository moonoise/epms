<div class="top_nav">
  <div class="nav_menu  <?php echo (in_array($_SESSION[__GROUP_ID__], array(1, 2, 3)) ? "nav_menu-for-user" : "nav_menu-for-admin"); ?>">
    <nav>
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars text-tickle_me"></i></a>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li class="">
          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <img src="<?php echo checkPicture2($_SESSION[__PICTURE_PROFILE__]); ?>" alt="" id="picture-top-navi">

            <?php echo $_SESSION[__F_NAME__] . " " . $_SESSION[__L_NAME__] ?>

            <span class=" fa fa-angle-down"></span>
          </a>
          <ul class="dropdown-menu dropdown-usermenu pull-right">

            <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
          </ul>
        </li>
        <li role="presentation" class="dropdown">
          <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-user text-tickle_me"></i>
            <span class="badge bg-green"><?php echo $_SESSION[__USERONLINE__]; ?></span>
            <small>จำนวนผู้ใช้งาน</small>
          </a>
        </li>
        <!-- <li role="presentation" class="dropdown">
        <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
          <i class="fa fa-envelope-o"></i>
          <span class="badge bg-green">6</span>
        </a>
        <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
          <li>
            <a>
              <span class="image"><img src="../external/images_profile/img.png" alt="Profile Image" /></span>
              <span>
                <span>John Smith</span>
                <span class="time">3 mins ago</span>
              </span>
              <span class="message">
                Film festivals used to be do-or-die moments for movie makers. They were where...
              </span>
            </a>
          </li>
          <li>
            <a>
              <span class="image"><img src="../external/images_profile/img.png" alt="Profile Image" /></span>
              <span>
                <span>John Smith</span>
                <span class="time">3 mins ago</span>
              </span>
              <span class="message">
                Film festivals used to be do-or-die moments for movie makers. They were where...
              </span>
            </a>
          </li>
          <li>
            <a>
              <span class="image"><img src="../external/images_profile/img.png" alt="Profile Image" /></span>
              <span>
                <span>John Smith</span>
                <span class="time">3 mins ago</span>
              </span>
              <span class="message">
                Film festivals used to be do-or-die moments for movie makers. They were where...
              </span>
            </a>
          </li>
          <li>
            <a>
              <span class="image"><img src="../external/images_profile/img.png" alt="Profile Image" /></span>
              <span>
                <span>John Smith</span>
                <span class="time">3 mins ago</span>
              </span>
              <span class="message">
                Film festivals used to be do-or-die moments for movie makers. They were where...
              </span>
            </a>
          </li>
          <li>
            <div class="text-center">
              <a>
                <strong>See All Alerts</strong>
                <i class="fa fa-angle-right"></i>
              </a>
            </div>
          </li>
        </ul>
      </li> -->
      </ul>
    </nav>
  </div>
</div>