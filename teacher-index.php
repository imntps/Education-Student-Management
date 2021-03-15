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
                        <?php 
                            $crT = "";
                            $crY = "";
                            $tabAc = "active";
                            $tabArray = array();
                            echo '<ul class="nav nav-tabs" role="tablist">';

                            $sche = mysqli_query($conn, "SELECT std_term,std_year FROM class_schedule WHERE teacher = '$info_idcard' ORDER BY std_term,std_year");
                            while($sche_row = mysqli_fetch_assoc($sche)) {
                                if ($crT != $sche_row['std_term'] || $crY != $sche_row['std_year']) { 
                                    $crT = $sche_row['std_term'];
                                    $crY = $sche_row['std_year'];
                                    echo '<li class="nav-item" role="presentation"><a class="nav-link '.$tabAc.'" role="tab" data-toggle="tab" href="#tab-'.$crT.$crY.'">ปีการศึกษา '.$crT.'/'.$crY.'</a></li>';
                                    if ($tabAc == "active") { $tabAc = "";}
                                    array_push($tabArray, $crT.$crY);
                                }
                            }
                            echo '</ul>';
                        ?>


                        <?php
                            echo '<div class="tab-content">';
                            $sAc = "active";
                            foreach($tabArray as $v){
                                // สร้าง tab รห้สวิชา
                                echo '<div class="tab-pane '.$sAc.'" role="tabpanel" id="tab-'.$v.'"><div class="row align-items-center" style="margin-top:1em;"><div class="col"><ul class="nav nav-tabs" role="tablist">';
                                if ($sAc == "active") { $sAc = ""; }
                                $slterm = str_split($v)[0];
                                $slyear = substr($v,1);
                                $slsj = mysqli_query($conn, "SELECT s_code FROM class_schedule WHERE teacher = '$info_idcard' AND std_term = '$slterm' AND std_year = '$slyear'");
                                $crSub = "";
                                $slAc = "active";
                                $sjcodeid = array();
                                while($slsj_row = mysqli_fetch_assoc($slsj)) {
                                    if ($crSub != $slsj_row['s_code']){
                                        $crSub = $slsj_row['s_code'];
                                        echo '<li class="nav-item" role="presentation"><a class="nav-link '.$slAc.'" role="tab" data-toggle="tab" href="#tab-'.$crSub.'">รายวิชา '.$crSub.'</a></li>';
                                        if ($slAc == "active") {$slAc = ""; }
                                        array_push($sjcodeid, $crSub);
                                    }
                                }

                                echo '</ul>';

                                // สร้าง content ห้องรหัสวิชา
                                $sjAc = "active";
                                $stdcontent = array();
                                foreach($sjcodeid as $x){ 
                                    echo '<div class="tab-pane '.$sjAc.'" role="tabpanel" id="tab-'.$x.'"><div class="row align-items-center" style="margin-top:1em;"><div class="col"><ul class="nav nav-tabs" role="tablist">';
                                    if ($sjAc == "active") {$sjAc = ""; };
                                    // สร้าง tab ห้องเรียน
                                        $roomid_sql = mysqli_query($conn, "SELECT std_department,std_level,std_room FROM class_schedule WHERE teacher = '$info_idcard' AND std_term = '$slterm' AND std_year = '$slyear' AND s_code = '$x'");
                                        $stdAc = "active";
                                        while($roomid_row = mysqli_fetch_assoc($roomid_sql)) { 
                                            $start_std_id = substr($slyear,2) . $roomid_row['std_level'] . $roomid_row['std_department'] . $roomid_row['std_room'];
                                            $level2int = intval($roomid_row['std_level']);
                                            $array_level = array("ปวช", "ปวส");
                                            $std_department_id = $roomid_row['std_department'];
                                            $departname_sql = mysqli_query($conn, "SELECT de_name FROM department WHERE std_department = '$std_department_id'");
                                            $departname_row = mysqli_fetch_array($departname_sql, MYSQLI_ASSOC);
                                            array_push($stdcontent, $start_std_id);
                                            echo '<li class="nav-item" role="presentation"><a class="nav-link '.$stdAc.'" role="tab" data-toggle="tab" href="#tab-'.$start_std_id.'">แผนก <u>'. $departname_row['de_name'] .'</u> ระดับ <u>'.$array_level[$level2int-2].'</u> ห้อง <u>'.$roomid_row['std_room'].'</u></a></li>';
                                            if ($stdAc == "active") {$stdAc = ""; };
                                        }
                                    echo '</ul>';
                                        // สร้าง content ห้องเรียน
                                    echo '<div class="tab-content" style="margin-top: 10px;">';
    
                                    $stdCAc = "active";
                                    foreach($stdcontent as $z){
                                        echo '<div class="tab-pane '.$stdCAc.'" role="tabpanel" id="tab-'.$z.'"><div class="row" style="margin-top: 1.5em;"><div class="col">';
                                            
                                            echo '<table class="table"><thead>';
                                            echo '<td>รห้สนักศึกษา</td>';
                                            echo '<td>ชื่อนักศึกษา</td>';
                                            echo '<td>คะแนน</td>';
                                            echo '<td>เกรด</td>';
                                            echo '<td></td>';
                                            echo '</thead><tbody>';
                                            
                                                    $allStd_sql= mysqli_query($conn, "SELECT std_id,point FROM class_point WHERE s_code = '$x' AND std_id like '$z%' ORDER BY std_id");

                                                    while($allStd_row = mysqli_fetch_assoc($allStd_sql)) {
                                                        $local_std_id = $allStd_row['std_id'];
                                                   
                                                        //$allStd_selct_idcard_sql = mysqli_query($conn, "SELECT idcard FROM student_info WHERE std_id = '$local_std_id'");
                                                        $allStd_selct_idcard_sql = mysqli_query($conn, "SELECT idcard FROM student_info WHERE std_id = '$local_std_id'");
                                                        $allStd_selct_idcard_row = mysqli_fetch_array($allStd_selct_idcard_sql, MYSQLI_ASSOC);

                                                        $local_std_idcard = $allStd_selct_idcard_row['idcard'];
                                                        $allStd_selct_name_sql = mysqli_query($conn, "SELECT firstname,lastname FROM users WHERE idcard = '$local_std_idcard'");
                                                        $allStd_selct_name_row = mysqli_fetch_array($allStd_selct_name_sql, MYSQLI_ASSOC);

                                                        echo    '<tr><form action="server.php" method="post">
                                                                    <td><input name="std_id" value="'.$allStd_row['std_id'].'" readonly></td>
                                                                    <td>'.$allStd_selct_name_row['firstname']. ' ' . $allStd_selct_name_row['lastname'].'</td>
                                                                    <td><input type="number" name="std_point" min="0" max="100" value="'.$allStd_row['point'].'"><input name="subject" value="'.$x.'" hidden></td>
                                                                    <td><input type="submit" name="updatepoint_submit" value="update"></td>
                                                                    </form>
                                                                </tr>';
                                                    }
                                                
                                            echo '</tbody></table>';
                                        echo '</div></div></div>';
                                        if ($stdCAc == "active") {$stdCAc = ""; };
                                    }

                                    echo '</div></div></div></div>';
                                }   
                                
                                echo '</div></div></div>';
                              
                            }
                            echo '</div>';
                        ?>
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
