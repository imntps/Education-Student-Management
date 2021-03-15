<?php include('server.php') ?>
<?php 
     if(empty($_SESSION['login_user'])) {
        header("location: login.php");
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>ESM</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sarabun">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/css/pikaday.min.css">]


</head>

<body>
    <nav class="navbar navbar-dark navbar-expand-lg fixed-top portfolio-navbar gradient">
        <div class="container"><a class="navbar-brand logo" href="#">ESM</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navbarNav"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse"
                id="navbarNav">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item item"><a href="server.php?logout"><button class="btn btn-primary" type="submit" name="logout_submit" style="background: linear-gradient(-145deg, rgb(124,113,245), rgb(19,158,255)), rgb(58,80,94);border-radius: 5px;border-top-right-radius: 12px;border-top-left-radius: 0px;border-bottom-left-radius: 0px;border-bottom-right-radius: 12px;border-style: solid;border-color: rgba(255,255,255,0.58);">ออกจากระบบ</button></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <?php 
        $info_idcard = $_SESSION['login_user'];
        $result = mysqli_query($conn, "SELECT * FROM users WHERE idcard = $info_idcard");
        $row = mysqli_fetch_assoc($result);
    ?>

    <section class="portfolio-block mobile-app" style="margin-top: 2em;font-family: Sarabun, sans-serif;">
        <div class="container align-items-center">
            <div class="row align-items-center">
                <div class="col">
                    <div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item" role="presentation"><a class="nav-link active" role="tab" data-toggle="tab" href="#tab-1">หน้าหลัก</a></li>
                            <?php 
                                if ($row["group_type"] == "นักศึกษา"){ 
                                    echo '<li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-toggle="tab" href="#tab-2">ผลการเรียน</a></li>';
                                }
                            ?>
                        </ul>
                        
                        <div class="tab-content">
                            <div class="tab-pane active" role="tabpanel" id="tab-1">
                                <form action="?saveuser=<?php echo $row['id']; ?>" method="post">
                                    <p><strong>ข้อมูลทั่วไป</strong></p>
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group"><label>รหัสบัตรประจำตัวประชาชน</label>
                                                <label class="form-control" name="idcard"><?php echo $row["idcard"]; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group"><label>คำนำหน้าชื่อ</label>
                                                    <?php 
                                                        $title = array("นาย", "นางสาว", "นาง");

                                                        foreach ($title as $v) {
                                                        if ( $row["title"] == $v) {
                                                                echo '<label class="form-control">'.$v.'</label>';
                                                            }
                                                        }
                                                    ?>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group"><label>ชื่อ</label><label class="form-control" name="firstname"><?php echo $row["firstname"]; ?></label></div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group"><label>นามสกุล</label><label class="form-control" name="lastname"><?php echo $row["lastname"]; ?></label></div>
                                        </div>
                                    </div>
                                    <hr>
                                    
                                    <?php 
                                        $select_pers_id = $row["idcard"];
                                        $pers_result = mysqli_query($conn, "SELECT * FROM personal_info WHERE idcard = $select_pers_id");
                                        
                                        $pers_row = mysqli_fetch_assoc($pers_result);
                                    ?>

                                    <p><strong>ข้อมูลส่วนตัว</strong></p>
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group"><label>เพศ</label>
                                                <label class="form-control"><?php echo $pers_row["gender"]; ?></label>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-group"><label>วันเกิด</label>
                                                <label class="form-control" name="date"><?php echo $pers_row["birth"]; ?></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group"><label>เบอร์</label>
                                                <label class="form-control" name="phone"><?php echo $pers_row["phone"]; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group"><label>น้ำหนัก</label>
                                                <label class="form-control" name="weight"><?php echo $pers_row["weight"]; ?></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group"><label>ส่วนสูง</label>
                                                <label class="form-control" name="height"><?php echo $pers_row["height"]; ?></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>กรุ๊ปเลือด</label>
                                                
                                                <label class="form-control" name="blood_type"><?php echo $pers_row["blood_type"]; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group"><label>สัญชาติ</label>
                                                <label class="form-control" name="nationality"><?php echo $pers_row["nationality"]; ?></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group"><label>เชื้อชาติ</label>
                                                <label class="form-control" name="race"><?php echo $pers_row["race"]; ?></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group"><label>ศาสนา</label>
                                                <label class="form-control" name="religion"><?php echo $pers_row["religion"]; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div id="inputstdinfo">  
                                        <?php 
                                            $select_std_id = $row['idcard'];
                                            $std_result = mysqli_query($conn, "SELECT * FROM student_info WHERE idcard = $select_std_id");
                                            $std_row = mysqli_fetch_assoc($std_result);
                                        ?>
                                        <p><strong>ข้อมูลนักศึกษา</strong></p>
                                        <div class="form-row" >
                                            <div class="col">
                                                <div class="form-group"><label>รหัสนีกศึกษา</label>
                                                    <label class="form-control" name="std_year"><?php echo $std_row["std_id"]; ?></label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group"><label>ระดับ</label>
                                                        <?php 
                                                            $std_level = array("2", "3");
                                                            $std_level_label = "ปวช";
                                                            foreach ($std_level as $v) {
                                                                if ($v == 3) { $std_level_label = "ปวส"; }
                                                                if ( $std_row["std_level"] == $v) {
                                                                    echo '<label  class="form-control" name="std_level">'.$std_level_label.'</label>';
                                                                }
                                                            }
                                                        ?>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group"><label>แผนกวิชา</label>
                                                        <?php 
                                                            $dep_sql = mysqli_query($conn, "SELECT std_department, de_name FROM department");
                                                            while($dep_row = mysqli_fetch_assoc($dep_sql)) {
                                                                if ($dep_row['std_department'] == $std_row['std_department']) {
                                                                    echo '<label class="form-control">'.$dep_row['de_name'].'</label>';
                                                                }
                                                            }
                                                        ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                            <div class="tab-pane" role="tabpanel" id="tab-2">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <?php
                                            $std_ids = $std_row["std_id"];
                                            $currentTerm = "";
                                            $currentYear = "";

                                            $t2r = mysqli_query($conn, "SELECT std_year, std_term, s_code, point FROM class_point WHERE std_id = '$std_ids' ORDER BY std_term,std_year");
                                            while($t2r_row = mysqli_fetch_assoc($t2r)) {
                                                $scode = $t2r_row['s_code'];
                                                $sj_result = mysqli_query($conn, "SELECT s_name, credit FROM subject WHERE s_code = '$scode'");
                                                $sj = mysqli_fetch_assoc($sj_result);
                                                if ($currentTerm != $t2r_row['std_term'] || $currentYear != $t2r_row['std_year']) {
                                                    $currentTerm = $t2r_row['std_term'];
                                                    $currentYear = $t2r_row['std_year'];
                                                    
                                                    echo    '<table class="table" style="text-align:center;">
                                                <br><button type="button" class="btn btn-primary" style="border-radius:5px;">ภาคเรียน '. $currentTerm . " / ".$currentYear.'</button>
                                                                <thead>
                                                                    <tr>
                                                                    <th scope="col">รหัสวิชา</th>
                                                                    <th scope="col">ชื่อวิชา</th>
                                                                    <th scope="col">หน่วยกิต</th>
                                                                    <th scope="col">คะแนน</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>   
                                                                    <td>'.$t2r_row["s_code"].'</td>
                                                                    <td>'.$sj["s_name"].'</td>
                                                                    <td>'.$sj["credit"].'</td>
                                                                    <td>'.$t2r_row["point"].'</td>
                                                                </tr>';
                                                                
                                                } else {

                                                    echo    '<tr>   
                                                                <td>'.$t2r_row["s_code"].'</td>
                                                                <td>'.$sj["s_name"].'</td>
                                                                <td>'.$sj["credit"].'</td>
                                                                <td>'.$t2r_row["point"].'</td>
                                                            </tr>'; 
                                                }

                                                if ($currentTerm != $t2r_row['std_term'] && $currentYear != $t2r_row['std_year']) {
                                                    echo '</tbody></table>';
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <div class="col">
                                    <table class="table" style="text-align:center;">
                                        <thead>
                                            <tr>
                                                <td scope="col">สรุปผลการเรียนประจำภาคเรียน</td>
                                                <td scope="col">หน่วยกิตที่ได้ในภาคเรียน</td>
                                                <td scope="col">หน่วยกิตสะสม</td>
                                                <td scope="col">ระดับคะแนนเฉลี่ยในภาคเรียน</td>
                                                <td scope="col">ระดับคะแนนเฉลี่ยสะสม</td>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php 
                                                function grade($pt){
                                                    if ($pt >=80) {
                                                        return 4.0;
                                                    } else if ($pt >=75){
                                                        return 3.5;
                                                    }else if ($pt >=70){
                                                        return 3.0;
                                                    }else if ($pt >=65){
                                                        return 2.5;
                                                    }else if ($pt >=60){
                                                        return 2.0;
                                                    }else if ($pt >=55){
                                                        return 1.5;
                                                    }else if ($pt >=50){
                                                        return 1.0;
                                                    }else if ($pt <=49){
                                                        return 0.0;
                                                    }
                                                }

                                                $credit_all = 0.0;
                                                $credit_term = 0.0;
                                                $gpa_point = 0.0;
                                                $gpa_all = 0.0;
                                                $t2r = mysqli_query($conn, "SELECT std_year, std_term FROM class_point WHERE std_id = '$std_ids' ORDER BY std_term,std_year");
                                                $crTerm = "";
                                                $crYear = "";
                                                $gpa_all_dev = 1;
                                                while($gpa_row = mysqli_fetch_assoc($t2r)) {

                                                    if ($crTerm != $gpa_row['std_term'] || $crYear != $gpa_row['std_year']) { 
                                                        $crTerm = $gpa_row['std_term'];
                                                        $crYear = $gpa_row['std_year'];
                                                        $credit_term = 0.0;
                                                        $gpa_point = 0.0;

                                                        $codenpoint = mysqli_query($conn, "SELECT s_code, point FROM class_point WHERE std_term = '$crTerm' AND std_year = '$crYear'");
                                                        while($codenpoint_row = mysqli_fetch_assoc($codenpoint)) {
                                                            $sc = $codenpoint_row['s_code'];
                                                            $credit_res = mysqli_fetch_assoc(mysqli_query($conn, "SELECT credit FROM subject WHERE s_code = '$sc'"))['credit'];
                                                            $credit_term = $credit_term + $credit_res;
                                                            $gpa_point = $gpa_point + ($credit_res * grade($codenpoint_row['point']));
                                                        }

                                                        $gpa_all = $gpa_all + $gpa_point;
                                                        $credit_all = $credit_all + $credit_term;
                                                        echo '<tr><td scope="col">'. $gpa_row['std_term'] . '/'.$gpa_row['std_year'].'</td>';
                                                        echo '<td scope="col">'. $credit_term.'</td>';
                                                        echo '<td scope="col">'. $credit_all.'</td>';
                                                        echo '<td scope="col">'. number_format($gpa_point / $credit_term,2).'</td>';
                                                        echo '<td scope="col">'. number_format(($gpa_all/$credit_term) / $gpa_all_dev,2).'</td>';
                                                        $gpa_all_dev++;
                                                    } else {
                                                        $credit_term = $credit_term + $credit_res;
                                                    }

                                                    if ($crTerm != $gpa_row['std_term'] && $crYear != $gpa_row['std_year']) {
                                                        echo '</tr>';
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <?php 
                                if ($row["group_type"] != "นักศึกษา"){  
                                    echo '<script>document.getElementById("inputstdinfo").style.display = "none";document.getElementById("tab-2").style.display = "none";</script>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/pikaday.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
