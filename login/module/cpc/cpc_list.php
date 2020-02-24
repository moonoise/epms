 <div class="row">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
        <h2>รายการสรรถณะ <small>...</small></h2>
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
            <table id="datatable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>รหัส</th>
                <th>สมรรถนะ</th>
                <!-- <th>*</th> -->
            </tr>
            </thead>
            <tbody>
                <?php
                include_once "../../config.php";
                include_once "../../includes/dbconn.php";
                $db  = new DbConn;
                $sql = "SELECT question_no,question_code,question_title FROM `cpc_question` WHERE  question_status = 1 ";
                $stm =  $db->conn->prepare($sql);
                $stm->execute();
                $queryResult = $stm->fetchAll();
                $num = 1;
                foreach ($queryResult as $row) {
                    
                    echo "<tr>";
                    echo "<th scope='row'>".$num++."</th>";
                    echo "<td>".$row['question_code']."</td>";
                    echo "<td>".$row['question_title'];
                    //echo "<button type='button' class='btn btn-success btn-xs pull-right'>Success</button>";
                    echo "</td>";
                    // echo "<td><a href='#' class='btn btn-info btn-xs' onclick='addQuestion(`".$row['question_no']."`)'><i class='fa fa-pencil'></i> เพิ่ม </a></td>";
                    echo "</tr>";
                    unset($row);
                    //unset($row);
                }
                ?>
            </tbody>
            </table>
            </div>
        </div>
        </div>  <!--  x_content -->

    </div> <!-- x_panel -->

    
</div> <!-- col-md-12 col-sm-12 col-xs-12 -->



</div> <!-- row -->
