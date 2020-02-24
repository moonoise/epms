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
            <div class="col-md-4 col-sm-12 col-xs-12 ">
                <div class="form-group ui-widget">
                    <input type="text" class="form-control" placeholder = "เลือกตำแหน่ง" id="frm_position">
                    
                </div>
           </div>
           <div class="col-md-8 col-sm-12 col-xs-12">
           <h4>ตำแหน่ง: <span id="text_position"></span> <small> (รหัสตำแหน่ง) <span  id="text_id_position"></span></small></h4> 
           </div>
    
                  
        </div><!-- row -->

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
            <table id="show-question" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>รหัส</th>
                <th>สมรรถนะ</th>
                <th>*</th>
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
                    echo "<td><a href='#' class='btn btn-info btn-xs' onclick='addQuestion(`".$row['question_no']."`)'><i class='fa fa-pencil'></i> เพิ่ม </a></td>";
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


<div class="row">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
        <h2>รายการที่เพิ่มข้อมูล <small>...</small></h2>
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
            <div id="dialog" >
            <p class='text text-success'></p>
            </div>
           <table class="table table-hover ">
            <thead>
            <tr>
                <th>#</th>
                <th>รหัส</th>
                <th>สมรรถนะ</th>
                <th>*</th>
            </tr>
            </thead>
            <tbody id="show_question">

            </tbody>
        </table>
       </div>

        

    </div>  <!--  x_content -->

    </div> <!-- x_panel -->

    
</div> <!-- col-md-12 col-sm-12 col-xs-12 -->

</div> <!-- row -->

 <input type="hidden" id="hidden_pl_code">

 