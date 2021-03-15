<?php include('server.php') ?>

<?php 

    // Users Update
    if (isset($_GET['saveuser'])) {

        $updateid = $_GET['save'];
        $idcard = $_POST['idcard'];
        $title = $_POST['title'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $group_type = $_POST['group_type'];

        $gender = $_POST['gender'];
        $birth = $_POST['date'];
        $phone = $_POST['phone'];
        $weight = $_POST['weight'];
        $height = $_POST['height'];
        $blood_type = $_POST['blood_type'];
        $nationality = $_POST['nationality'];
        $race = $_POST['race'];
        $religion = $_POST['religion'];

        if ($group_type == "นักศึกษา") {
            $std_year = $_POST['std_year'];
            $std_level = $_POST['std_level'];
            $std_department = $_POST['std_department'];
            $std_term = $_POST['std_term'];
            $std_room = $_POST['std_room'];
            $std_number = $_POST['std_number'];
            $std_id = substr($std_year,2) . $std_level . $std_department . $std_room . $std_number;
        }
        
        $user_sql_update = "UPDATE users SET title='$title', firstname ='$firstname',lastname = '$lastname', group_type = '$group_type' WHERE id= '$updateid'";
        $pera_sql_update = "UPDATE personal_info SET gender='$gender', birth ='$birth',phone = '$phone',weight = '$weight',height = '$height',blood_type = '$blood_type',nationality = '$nationality',race = '$race',religion = '$religion' WHERE idcard= '$idcard'";
        
        if (mysqli_query($conn, $user_sql_update)) {
            if (mysqli_query($conn, $pera_sql_update)) {
                if ($group_type == "นักศึกษา") {
                    if (mysqli_query($conn, $std_sql_update)) {
                        header("Location: index.php"); 
                    } else {
                        echo "Error: " . $std_sql_update . "<br>" . mysqli_error($conn);
                    }
                } else {
                    header("Location: index.php"); 
                }
            } else {
                echo "Error: " . $pera_sql_update . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Error: " . $user_sql_update . "<br>" . mysqli_error($conn);
        }
    }

    if (isset($_GET['savesubject'])) {
        $s_id = $_GET['savesubject'];
        $s_name = $_POST['s_name'];
        $s_code = $_POST['s_code'];
        $credit = $_POST['credit'];

        $subject_sql_update = "UPDATE subject SET s_name='$s_name', s_code ='$s_code',credit = '$credit' WHERE id= '$s_id'";
        if (mysqli_query($conn, $subject_sql_update)) {
            header("Location: index.php"); 
        } else {
            echo "Error: " . $subject_sql_update . "<br>" . mysqli_error($conn);
        }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/css/pikaday.min.css">
</head>

<body style="font-family: Sarabun, sans-serif;">
    <nav class="navbar navbar-dark navbar-expand-lg fixed-top portfolio-navbar gradient">
        <div class="container"><a class="navbar-brand logo" href="#">ESM</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navbarNav"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse"
                id="navbarNav">
                <ul class="nav navbar-nav ml-auto"></ul>
            </div>
        </div>
    </nav>

    <div id="updatesubject" style="display:none;">
        <?php 
            if (isset($_GET['requpdatesubject'])) {
                $updateid = $_GET['requpdatesubject'];
                $result = mysqli_query($conn, "SELECT * FROM subject WHERE id = $updateid");
                $row = mysqli_fetch_assoc($result);
                echo "<script>document.getElementById('updatesubject').style.display = 'block';</script>";
            }
        ?>
        <section class="portfolio-block mobile-app">
            <div class="container align-items-center" style="margin-top: 1.5em;">
                <form action="?savesubject=<?php echo $row['id']; ?>"method="post">
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group"><label>ชื่อวิชา</label><input class="form-control" type="text" name="s_name" required value="<?php echo $row["s_name"]; ?>"></div>
                        </div>
                        <div class="col">
                            <div class="form-group"><label>รหัสวิชา</label><input class="form-control" type="text" name="s_code" required value="<?php echo $row["s_code"]; ?>"></div>
                        </div>
                        <div class="col">
                            <div class="form-group"><label>หน่วยกิต</label><input class="form-control" type="number" name="credit" required value="<?php echo $row["credit"]; ?>"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group" style="text-align: center;"><button name="updatesubject_submit" class="btn btn-primary" type="submit" style="border-style: none;border-top-left-radius: 10px;border-top-right-radius: 10px;border-bottom-right-radius: 9px;border-bottom-left-radius: 10px;">บันทึก</button></div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <div id="updateuser" style="display:none">
        <?php 
              if (isset($_GET['requpdateuser'])) {
                $updateid = $_GET['requpdateuser'];
                $result = mysqli_query($conn, "SELECT * FROM users WHERE id = $updateid");
                $row = mysqli_fetch_assoc($result);
                echo "<script>document.getElementById('updateuser').style.display = 'block';</script>";
            }
        ?>
        <section class="portfolio-block mobile-app">
            <div class="container align-items-center" style="margin-top: 1.5em;">
                <form action="?saveuser=<?php echo $row['id']; ?>" method="post">
                    <p><strong>ข้อมูลทั่วไป</strong></p>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group"><label>รหัสบัตรประจำตัวประชาชน</label>
                                <input class="form-control" type="text" placeholder="เลขบัตร ปชช 13 หลัก" maxlength="13" minlength="13" name="idcard" autofocus="" value="<?php echo $row["idcard"]; ?>">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>ประเภทผู้ใช้งาน</label>
                                <select class="custom-select d-xl-flex" id="t7_group_type_select" name="group_type" required disabled>
                                    <?php 
                                        $group_type = array("นักเรียน", "ครู", "เจ้าหน้าที่");

                                        foreach ($group_type as $v) {
                                        if ( $row["group_type"] == $v) {
                                                echo '<option value="'.$v.'" selected>'.$v.'</option>';
                                            } else {
                                                echo '<option value="'.$v.'">'.$v.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group"><label>คำนำหน้าชื่อ</label>
                                <select class="form-control" name="title" required>
                                    <?php 
                                        $title = array("นาย", "นางสาว", "นาง");

                                        foreach ($title as $v) {
                                        if ( $row["title"] == $v) {
                                                echo '<option value="'.$v.'" selected>'.$v.'</option>';
                                            } else {
                                                echo '<option value="'.$v.'">'.$v.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group"><label>ชื่อ</label><input class="form-control" type="text" placeholder="" required name="firstname" value="<?php echo $row["firstname"]; ?>"></div>
                        </div>
                        <div class="col">
                            <div class="form-group"><label>นามสกุล</label><input class="form-control" type="text" name="lastname" placeholder="" required value="<?php echo $row["lastname"]; ?>"></div>
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
                                <select class="form-control" name="gender" required>
                                    <?php 
                                        $gender = array("ชาย", "หญิง");

                                        foreach ($gender as $v) {
                                            if ( $row["gender"] == $v) {
                                                echo '<option value="'.$v.'" selected>'.$v.'</option>';
                                            } else {
                                                echo '<option value="'.$v.'">'.$v.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group"><label>วันเกิด</label><input class="form-control" type="date" name="date" required value="<?php echo $pers_row["birth"]; ?>"></div>
                        </div>
                        <div class="col">
                            <div class="form-group"><label>เบอร์</label><input class="form-control" type="text" placeholder="" name="phone" maxlength="10" minlength="10" required value="<?php echo $pers_row["phone"]; ?>"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group"><label>น้ำหนัก</label><input class="form-control" type="number" required name="weight" placeholder="กิโลกรัม" value="<?php echo $pers_row["weight"]; ?>"></div>
                        </div>
                        <div class="col">
                            <div class="form-group"><label>ส่วนสูง</label><input class="form-control" type="number" name="height" placeholder="เซนติเมตร" required value="<?php echo $pers_row["height"]; ?>"></div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>กรุ๊ปเลือด</label>
                                <select class="form-control" name="blood_type">
                                    <?php 
                                        $blood_type = array("A", "B", "AB", "O");

                                        foreach ($blood_type as $v) {
                                            if ( $pers_row["blood_type"] == $v) {
                                                echo '<option value="'.$v.'" selected>'.$v.'</option>';
                                            } else {
                                                echo '<option value="'.$v.'">'.$v.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group"><label>สัญชาติ</label><input class="form-control" type="text" required name="nationality" value="<?php echo $pers_row["nationality"]; ?>"></div>
                        </div>
                        <div class="col">
                            <div class="form-group"><label>เชื้อชาติ</label><input class="form-control" type="text" name="race" required value="<?php echo $pers_row["race"]; ?>"></div>
                        </div>
                        <div class="col">
                            <div class="form-group"><label>ศาสนา</label><select class="form-control" name="religion"><option value="พุทธ" selected>พุทธ</option><option value="คริสต์">คริสต์</option><option value="อิสลาม">อิสลาม</option><option value="อื่นๆ">อื่นๆ</option></select></div>
                        </div>
                    </div>
                    <hr>

                    <?php 
                        $select_std_id = $row['idcard'];
                        $std_result = mysqli_query($conn, "SELECT * FROM student_info WHERE idcard = $select_std_id");
                        $std_row = mysqli_fetch_assoc($std_result);
                    ?>
                    <div id="inputstdinfo">
                    <p><strong>ข้อมูลนักศึกษา</strong></p>
                    <div class="form-row" >
                        <div class="col">
                            <div class="form-group"><label>ปีที่เข้าเรียน</label><input class="form-control" type="text" name="std_year" required minlength="4" maxlength="4" placeholder="2563" value="<?php echo $std_row["std_year"]; ?>"></div>
                        </div>
                        <div class="col">
                            <div class="form-group"><label>ระดับ</label>
                                <select class="form-control" required name="std_level">
                                    <?php 
                                        $std_level = array("2", "3");
                                        $std_level_label = "ปวช";
                                        foreach ($std_level as $v) {
                                            if ($v == 3) { $std_level_label = "ปวส"; }
                                            if ( $std_row["std_level"] == $v) {
                                                echo '<option value="'.$v.'" selected>'.$std_level_label.'</option>';
                                            } else {
                                                echo '<option value="'.$v.'">'.$std_level_label.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group"><label>แผนกวิชา</label>
                                <select class="form-control" required name="std_department">
                                    <?php 
                                        $dep_sql = mysqli_query($conn, "SELECT std_department, de_name FROM department");
                                        while($dep_row = mysqli_fetch_assoc($dep_sql)) {
                                            if ($dep_row['std_department'] == $std_row['std_department']) {
                                                echo '<option value="'.$dep_row['std_department'].'" selected>'.$dep_row['de_name'].'</option>';
                                            } else {
                                                echo '<option value="'.$dep_row['std_department'].'">'.$dep_row['de_name'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group"><label>เทอม</label>
                                <select class="form-control" required name="std_term">
                                    <?php 
                                        $std_term = array("1", "2");
                                        foreach ($std_term as $v) {
                                            if ( $std_row["std_term"] == $v) {
                                                echo '<option value="'.$v.'" selected>'.$v.'</option>';
                                            } else {
                                                echo '<option value="'.$v.'">'.$v.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group"><label>ห้องเรียน</label><input class="form-control" type="text" name="std_room" placeholder="01, 02, 03" maxlength="2"
                                    minlength="2" required value="<?php echo $std_row["std_room"]; ?>"></div>
                        </div>
                        <div class="col">
                            <div class="form-group"><label>เลขที่</label><input class="form-control" type="text" name="std_number" placeholder="0001, 0002" required minlength="4" maxlength="4"
                            value="<?php echo $std_row["std_number"]; ?>"></div>
                        </div>
                    </div>
                    </div>

                    <?php 
                        if ($row["group_type"] != "นักศึกษา"){
                            echo '<script>document.getElementById("inputstdinfo").style.display = "none";</script>';
                        }
                    ?>
                    
                    <div class="form-row">
                        <div class="col"><button class="btn btn-primary" type="submit" name="updateuser_submit" style="border-top-left-radius: 5px;border-top-right-radius: 5px;border-bottom-right-radius: 5px;border-bottom-left-radius: 5px;border-style: none;width: 100%;">บันทึก</button></div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/pikaday.min.js"></script>
    <script src="assets/js/theme.js"></script>

</body>

</html>

