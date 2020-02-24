<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "includes/class-userOnline.php";
include_once "includes/class.permission.php";
$userOnline = new userOnline;
$_SESSION[__USERONLINE__] = $userOnline->usersOnline();

if((in_array($_SESSION[__GROUP_ID__],array(4))  ) ){  // || $_SESSION[__USER_ID__] == 'moonoise'
    if ($_SESSION[__ADMIN_ORG_ID_2__] != "") {
        $gOrg_id = $_SESSION[__ADMIN_ORG_ID_2__];
      }elseif ($_SESSION[__ADMIN_ORG_ID_1__] != "") {
        $gOrg_id = $_SESSION[__ADMIN_ORG_ID_1__];
      }elseif ($_SESSION[__ADMIN_ORG_ID__] != "") {
        $gOrg_id = $_SESSION[__ADMIN_ORG_ID__];
      }else {
        $gOrg_id = '77';
      }
}else 
{
  header("location:disallow.php");

}

activeTime($login_timeout,$_SESSION[__SESSION_TIME_LIFE__]);
   
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="icon" href="../external/icon/rid.png">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $site_name;?></title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <!-- <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet"> -->
    <link href="../vendors/fontawesome-5.6.3-web/css/all.css" rel="stylesheet">

    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>



    <!-- Custom Theme Style -->
    <link href="../vendors/bootstrap/dist/css/custom.css" rel="stylesheet">
   
 

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
           <!-- Logo top left -->
           <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo (in_array($_SESSION[__GROUP_ID__],array(4,5,6,7))?"setting-person.php":"view-profile.php" ); ?>" class="site_title"><i class="fa fa-user blue"></i> <span>ระบบ Login</span></a>
          </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <!-- sidebar menu -->
            <?php 
              include_once('template/menu.php');
            ?>
            <!-- /sidebar menu -->
  
              
            <!-- /menu footer buttons -->
            <?php 
            include_once('template/menu-footer-buttons.php');
            
            ?>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <?php
        include_once('template/top-navigation.php');
        ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <a class="date-title">
                <small class="date-title-text">ประเมินรอบที่ </small>
            </a>
            <div class="clearfix"></div>

             <div class="row">
             <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  
                  <div class="x_content">
                  
                     <form class="" method="POST" id="form-select-org" > 
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                    
                        <label for="org_id">สำนัก/กอง /ต่ำกว่าสำนัก 1 ระดับ :</label>
                        <select name="org_id" id="org_id" class="form-control">
                            <option value="" disabled="" selected="" hidden="">เลือกหน่วยงาน</option>
                            <option value="<?php echo $gOrg_id;?>" >เลือกทั้งหมด</option>
                        </select> 
                        
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                          <label for="org_id_1"><small>ต่ำกว่าสำนัก 1 ระดับ / ต่ำกว่าสำนัก 2 ระดับ :</small></label>
                          <select name="org_id_1" id="org_id_1" class="form-control">
                            <option value="" selected="" >เลือก สังกัด</option>
                          </select> 
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12 form-group ">
                      
                          <label for="org_id_1">ต่ำกว่าสำนัก 2 ระดับ :</label>
                          
                          <select name="org_id_2" id="org_id_2" class="form-control">
                            <option value=""  selected="" >เลือก สังกัด</option> <!-- disabled="" selected="" hidden="" -->
                          </select> 
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-4" >
                          <label for="selectYears" class="control-label col-md-3 col-sm-3 col-xs-3 form-group">ปีงบประมาณ:</label>
                            <div class="col-md-9 col-sm-9 col-xs-9 form-group">  
                            <select name="selectYears" id="selectYears" class="form-control">
                            </select>
                          </div>
                      </div>

                      <div class="col-md-2 col-sm-2 col-xs-4 form-group">
                        <button type="button" class="form-control btn btn-primary" id="submit-chart" >เลือก</button>
                     </div>


                     </form>
                    
                  </div>
                </div>
            </div>
             </div>


             <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-8"> 
                    <div class="x_panel">
                        <div class="x_title">
                            <h4>รายงานผลภาพรวมการประเมิน</h4>
                            <div class="clearfix"></div>
                        </div>
                    <div class="x_content">
                        <canvas id="myBarChart"></canvas>
                    </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4"> 
                <div class="x_panel">
                    <div class="x_content"> 
                        <p>สังกัด : <span class="text text-info" id="grade-org_name"></span></p>
                        <h4 class="text-info text-center">สถิติ</h4>
                        <hr>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>ดีเด่น :</td>
                                    <td><span class="text text-success" id="grade-A"></span> คน </td>
                                </tr>
                                <tr>
                                    <td>ดีมาก :</td>
                                    <td><span class="text text-success" id="grade-B"></span> คน</td>
                                </tr>
                                <tr>
                                    <td>ดี :</td>
                                    <td><span class="text text-success" id="grade-C"></span> คน</td>
                                </tr>
                                <tr>
                                    <td>พอใช้ :</td>
                                    <td><span class="text text-success" id="grade-D"></span> คน</td>
                                </tr>
                                <tr>
                                    <td>ต้องปรับปรุง :</td>
                                    <td><span class="text text-success" id="grade-F"></span> คน</td>
                                </tr>
                                <tr>
                                    <td><span class="text text-warning">ผู้ที่ไม่ต้องรับการประเมิน :</td>
                                    <td><span class="text text-warning" id="statusOff"></span>  คน</td>
                                </tr>
                                <tr>
                                    <td><span class="text text-danger">อยู่ระหว่างการประเมิน :</td>
                                    <td><span class="text text-danger" id="error"></span>  คน</td>
                                </tr>
                                <tr>
                                    <td><span class="text text-info">รวม :</td>
                                    <td><span class="text text-success" id="personTotal"></span>  คน</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>

                <div class="col-md-8 col-sm-8 col-xs-8"> 
                <div class="x_panel">
                    <div class="x_title">
                        <h4>คิดเป็นอัตราส่วน</h4>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> 
                        <canvas id="myPieChart"></canvas>
                    </div>
                </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-4"> 
                <div class="x_panel">
                    <div class="x_title">
                        <h5>คิดเป็นอัตราส่วน</h5>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> 
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>ดีเด่น :</td>
                                    <td><span class="text text-success" id="ratio-A"></span> % </td>
                                </tr>
                                <tr>
                                    <td>ดีมาก :</td>
                                    <td><span class="text text-success" id="ratio-B"></span> %</td>
                                </tr>
                                <tr>
                                    <td>ดี :</td>
                                    <td><span class="text text-success" id="ratio-C"></span> %</td>
                                </tr>
                                <tr>
                                    <td>พอใช้ :</td>
                                    <td><span class="text text-success" id="ratio-D"></span> %</td>
                                </tr>
                                <tr>
                                    <td>ต้องปรับปรุง :</td>
                                    <td><span class="text text-success" id="ratio-F"></span> %</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>

            </div>

          
          </div>
        </div>

        <!-- footer content -->
        <?php
          include_once('template/footer-content.php');
        ?>
        <!-- /footer content -->
      </div>
    </div>

<div id="message"></div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

     <!-- fontawesome-5.6.3-web -->
     <script src="../vendors/fontawesome-5.6.3-web/js/all.js"></script>

    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- jQuery custom content scroller -->
    <script src="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>

  <!-- Chart.js -->
  <script src="../node_modules/chart.js/dist/Chart.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../vendors/bootstrap/dist/js/custom.js"></script>

    <script>

       var ctx = document.getElementById("myBarChart");
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels:["ดีเด่น","ดีมาก","ดี","พอใช้","ต้องปรับปรุง"],
                datasets: [{
                    label: '',
                    borderWidth: 1,
                    data:['','','','',''],
                    backgroundColor:[
                        "rgba(3, 88, 106, 0.6)",
                        "rgba(38, 185, 154, 0.6)",
                        "rgba(52, 152, 219, 0.88)",
                        "rgba(243, 156, 18, 0.88)",
                        "rgba(231, 76, 60, 0.88)"
                    ]
                }
            ]},
            options: {
                scales: {
                    yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                    }]
                }
                }
        });
        // console.log(myBarChart.data.datasets)

    var ctx2 = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx2, {
                    type: 'pie',
                    data: {
                        labels:["ดีเด่น","ดีมาก","ดี","พอใช้","ต้องปรับปรุง"],
                        datasets: [{
                            label: '',
                            borderWidth: 1,
                            backgroundColor:[
                                "rgba(3, 88, 106, 0.6)",
                                "rgba(38, 185, 154, 0.6)",
                                "rgba(52, 152, 219, 0.88)",
                                "rgba(243, 156, 18, 0.88)",
                                "rgba(231, 76, 60, 0.88)"

                            ]
                        }
                    ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                            }]
                        }
                        }
                });

    function barChart(data) {
        if ($('#myBarChart').length ){ 
            $("#statusOff").html(data['login_status_0']);
            $("#personTotal").html(Number(data['0'])+Number(data['1'])+Number(data['2'])+Number(data['3'])+Number(data['4'])+Number(data['login_status_0'])+Number(data['Error'])  )
            $("#error").html(data['Error']);
            // console.log(Number(data['Error']) )

        
            var dataSet = [
                            Number(data['0']),
                            Number(data['1']),
                            Number(data['2']),
                            Number(data['3']),
                            Number(data['4'])      
                        ];

            // console.log(dataSet)
           removeData(myBarChart)
           addData(myBarChart,dataSet)

            resultA =  ( data["0"] /  (data["0"]+data["1"]+data["2"]+data["3"]+data["4"]) ) * 100   
            resultB =  ( data["1"] /  (data["0"]+data["1"]+data["2"]+data["3"]+data["4"]) ) * 100   
            resultC =  ( data["2"] /  (data["0"]+data["1"]+data["2"]+data["3"]+data["4"]) ) * 100   
            resultD =  ( data["3"] /  (data["0"]+data["1"]+data["2"]+data["3"]+data["4"]) ) * 100   
            resultF =  ( data["4"] /  (data["0"]+data["1"]+data["2"]+data["3"]+data["4"]) ) * 100   

            $("#ratio-A").html(resultA.toFixed(2));
            $("#ratio-B").html(resultB.toFixed(2));
            $("#ratio-C").html(resultC.toFixed(2));
            $("#ratio-D").html(resultD.toFixed(2));
            $("#ratio-F").html(resultF.toFixed(2));

            var dataSetPie = [
                            resultA.toFixed(2),
                            resultB.toFixed(2),
                            resultC.toFixed(2),
                            resultD.toFixed(2),
                            resultF.toFixed(2)
                        ];

            // console.log(dataSet)
           removeData(myPieChart)
           addData(myPieChart,dataSetPie)
            
            
        }

    }

    function removeData(chart) {
        // chart.data.labels.pop();
        chart.data.datasets.forEach((dataset) => {
            // console.log(dataset.data)
            dataset.data = []; 
        });
        chart.update();
    }

    function addData(chart, data) {
        // chart.data.labels.push(label);
        
        chart.data.datasets.forEach((dataset) => {
            // console.log(dataset.data)
            // dataset.data.push(data);
            dataset.data = data
        });
      chart.update();
    }
     

    $("#submit-chart").click(function (e) { 
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "module/report_admin/ajax-report-001.php",
            data: $("#form-select-org").serialize(),
            dataType: "JSON",
            success: function (response) {
                barChart(response)
                $("#grade-org_name").html(response['org_name']);
                $("#grade-A").html(response[0]);
                $("#grade-B").html(response[1]);
                $("#grade-C").html(response[2]);
                $("#grade-D").html(response[3]);
                $("#grade-F").html(response[4]);
                $("#message").html(""); 
            },
            beforeSend: function () {
                    $("#message").html("<div class='loading'>Loading&#8230;</div>");
            }
        });
    });

       

        $.ajax({
            type: "POST",
            url: "module/report_admin/ajax-load-json-years-2.php",
            dataType: "JSON",
            success: function (response) {
            $.each(response.result, function (indexInArray, valueOfElement) { 
                var y = valueOfElement["table_year"].split("-");
                var y543 = parseInt(y[0]) + 543
                var default_year = ""
                if (valueOfElement["use_status"] == 1) {
                    default_year = "selected"
                }
                $("#selectYears").append("<option value=\""+valueOfElement["table_id"]+"\" "+default_year+">ปี "+ y543 +" รอบ "+y[1]+" </option>");
                // console.log(valueOfElement['cpc_score'])
            });
            }
        });

        function add_org(result,idOrg,rm) {
  
            if(rm == true){
                $(idOrg).children('option:not(:first)').remove();
            }
            if(result != ''){
                $.each(result,function(key,value){
                    $(idOrg).append('<option value= ' + value['org_id'] + '>' + value['org_name'] + '</option>');
                });
            
                }
            }

            var org_id_default = "<?php echo $gOrg_id;?>";
                $.ajax({
                    url:"module/module_org/ajax.org.php",
                    dataType:"json",
                    data:"org_id="+ org_id_default,
                success: function(result){
                    add_org(result,'#org_id');
                
                }
            });


    $("#org_id").change(function(){
        var v = $(this).val();
        $.ajax({
            url:"module/module_org/ajax.org.php",
            dataType:"json",
            data:"org_id=" + v,
            success:function(result){
            add_org(result,"#org_id_1",true);
            add_org('',"#org_id_2",true);
            
            }
        });
    });


    $("#org_id_1").change(function(){
        var v = $(this).val();
        $.ajax({
            url:"module/module_org/ajax.org.php",
            dataType:"json",
            data:"org_id=" + v,
            success:function(result){
            add_org(result,"#org_id_2",true);
            }
        });
    });


    </script>
    
  </body>
</html>


       