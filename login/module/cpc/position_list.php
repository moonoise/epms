 <div class="row">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
        <h2>ตำแหน่ง <small>...</small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>

            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
        </div>
        <div class="x_content">

        <?php
        include_once "../../config.php";
        include_once "../../includes/dbconn.php";
            $db = new DbConn;
            $sql = "select pl_code,pl_name from per_line where pl_active = '1' ";
            $s =  $db->conn->prepare($sql);
            $s->execute();
            $result = $s->fetchAll();
            $num = "1";
        ?>
<table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>ลำดับ</th>
                          <th>รหัส</th>
                          <th>ตำแหน่ง</th>
                        </tr>
                      </thead>


                      <tbody>
                      <?php
                        foreach ($result as $row) {

                        echo "<tr>";
                        echo "<td>".$num++."</td>";
                        echo "<td>".$row['pl_code']."</td>";
                        echo "<td>".$row['pl_name']."</td>";  
                        echo "</tr>";
                        }
                      ?>
                      </tbody>
                    </table>


        </div>
    </div>
    </div>
</div>
<script>

</script>


</div>

