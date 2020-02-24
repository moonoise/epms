<?php
function checkPicture2($namePicture) {
  $file1 = $namePicture;
  $file_headers1 = @get_headers($file1);
 

  if ($file_headers1[0] != 'HTTP/1.1 404 Not Found') {
      return $file1;
  }else return "../external/images_profile/user.png";
}
?>
<div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?php echo checkPicture2($_SESSION[__PICTURE_PROFILE__]);?>" alt="..." class="img-circle profile_img" id="profile_img">
              </div>
              <div class="profile_info">
                <span>ยินดีต้อนรับ</span>
                <h2><?php echo $_SESSION[__F_NAME__]." ".$_SESSION[__L_NAME__];?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3><?php echo $_SESSION[__GROUP_NAME__];?></h3>
                <ul class="nav side-menu">
                <?php if(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(1,2,3)) ){    
                      echo "<li><a href='view-profile.php'><i class='fa fa-user'></i>ข้อมูลส่วนตัว</a></li>";
                 }?>
                 <?php if(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(1,2,3)) ){
                      echo "<li><a><i class='fa fa-bar-chart-o'></i>การประเมินผล <span class='fa fa-chevron-down'></span></a>
                              <ul class='nav child_menu'>
                                <li><a href='view-evaluation.php'>แบบประเมิน</a></li>
                                <li><a href='view-evaluation-accept.php'>ยืนยันประเมิน</a></li>
                              </ul>
                            </li>";
                 }
                 if(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(1,2,3)) ){
                    echo '<li><a><i class="fa fa-file-text"></i>  รายงานผลรายบุคคล <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                              <li><a href="view-evaluation-result.php">ผลการประเมิน</a></li>
                              <li><a href="view-evaluation-result-cpc.php">สมรรถนะรายบุคคล</a></li>
                              <li><a href="view-report.php">แบบรายงาน</a></li>
                              <li><a href="view-evaluation-result-year.php">รายงานคะแนนย้อนหลัง</a></li>
                            </ul>
                          </li>';

                 }

                 if(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(1,2,3)) ){
                  echo '<li><a  href="view-cpc2.php"><i class="fa  fa-shopping-cart"></i><i class="fa fa-list-ol"></i>  รายการสมรรถนะ </a>
                        </li>';
                  echo '<li><a  href="view-kpi2.php"><i class="fa  fa-shopping-cart"></i><i class="fa  fa-list-ul"></i>  รายการตัวชี้วัด </a>
                        </li>';
                }
                
                   ?>

                 <?php if(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(4,5,6,7)) ){  
                      echo " <li><a href='setting-person.php'><i class='fa fa-user'></i> ผู้ประเมิน </a></li>";
                      echo " <li><a><i class='fa fa-newspaper-o far fa-newspaper'></i> รายงานภาพรวม <span class='fa fa-chevron-down'></span></a>
                      <ul class='nav child_menu'>
                      <li><a href='view-report-admin-all.php'><i class='fa fa-desktop'></i> ภาพรวม</a></li>";
                            //   <li><a href='#'><i class='fa fa-area-chart fas fa-chart-bar'></i> กราฟ</a></li>
                    if (in_array($_SESSION[__GROUP_ID__],array(4)) || $_SESSION[__USER_ID__] == 'fad009') {
                      echo '<li><a href="view-change-score.php">เฉพาะ งานการเงินและบัญชี</a></li>';
                      echo '<li><a href="view-specialCase.php">รายชื่อผู้ที่มีตัวชี้วัดพิเศษ</a></li>';
                    }
                    if (in_array($_SESSION[__GROUP_ID__],array(4)) ) { // || $_SESSION[__USER_ID__] == 'moonoise'
                      echo '<li><a href="view-chart-1.php">กราฟ 1 </a></li>';
                      echo '<li><a href="view-chart-2.php">กราฟ 2 </a></li>';
                      echo '<li><a href="view-chart-1.php">กราฟ 3 </a></li>';
                    }
                      echo "
                          </ul>
                      </li>";
                  }?>
<!-- view-report-admin-chart.php -->
                  <?php if(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(4,5,6)) ){
                    echo "<li><a><i class='fa fas fa-cog'></i> ตั้งค่าผู้ดูแลระบบ <span class='fa fa-chevron-down'></span></a>
                    <ul class='nav child_menu'>
                    ";
                    if (in_array($_SESSION[__GROUP_ID__],array(4))) {
                      echo '<li><a href="view-panel.php">Tools Panel</a></li>';
                      
                    } 
                   
                    if (in_array($_SESSION[__GROUP_ID__],array(5,6))) {
                      echo "<li><a href='view-user.php'>จัดการผู้ดูแลระบบ</a></li>";
                      }
                    // if (in_array($_SESSION[__GROUP_ID__],array(4,5))) {
                    //   echo " <li><a href='group.php'>จัดการกลุ่มผู้ดูแลระบบ</a></li>
                    //         <li><a href='view-news.php'>ประชาสัมพันธ์</a></li>
                    //         <li><a href='view-cpc.php'>CPC</a></li>
                    //         <li><a href='view-kpi.php'>KPI</a></li>";
                            
                    //   }
                      echo "
                      </ul>
                    </li>";
                   }?>
                
                 <?php 
                //  if(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(4,5,6,7)) ){  
                //   echo "<li><a><i class='fa fa-cog'></i> ตั้งค่าข้อมูลส่วนตัว <span class='fa fa-chevron-down'></span></a>
                //         <ul class='nav child_menu'>
                //         ";

                //   echo "
                //           <li><a href='user-setting.php'>ข้อมูลส่วนตัว</a></li>
                //           <li><a href='password.php'>เปลี่ยนรหัสผ่าน</a></li>
                //         ";
                      
                     
                  
                //       echo "
                //         </ul>
                //       </li>";
                //   }
                  ?>

                </ul>
              </div>

            </div>
