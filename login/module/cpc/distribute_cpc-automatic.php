<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";

$db = new DbConn;

$years = __year__;
$pl_code = array();
$sqlCheckConfig = "SELECT * FROM `config` WHERE `config_name` = :years ";
$stmConfig = $db->conn->prepare($sqlCheckConfig);
$stmConfig->bindParam(":years",$years);
$stmConfig->execute();
$countConfig = $stmConfig->rowCount();
if($countConfig == 0){

    $sql_PLname = "SELECT pl_code FROM `per_personal_2561` GROUP BY pl_code";
    $stmPLname = $db->conn->prepare($sql_PLname);
    $stmPLname->execute();
    $resultPLname = $stmPLname->fetchAll(PDO::FETCH_NUM);

    foreach ($resultPLname as $key => $value) {
        array_push($pl_code,$value[0]);
    }

}else if($countConfig > 0 ){

}

?>
<div class="row">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
        <h2>กระจายตัวชี้วัดอัตโนมัติ <small>...</small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>

            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
        </div> <!-- x_title -->
        
        <div class="x_content">

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                <button type="button" class="btn btn-app" id="submit-distribute">
                      <i class="fa fa-play green"></i> กระจาย
                </button>

                <div class="panel-body" runat="server" style="overflow-y: scroll; height: 1000px">
                    <div class="mid-width wrapItems" style="background-color:#eee; height:3000px">

                        <div id="Test1" runat="server" width="100%"></div>
                        <div id="Test2" runat="server" width="100%"></div>
                    </div>
                </div>
                   
                </div>
            </div>
        </div>  <!--  x_content -->

    </div> <!-- x_panel -->

    
</div> <!-- col-md-12 col-sm-12 col-xs-12 -->



</div> <!-- row -->

<script>

$("#submit-distribute").on("click",function(){
    
})

</script>
