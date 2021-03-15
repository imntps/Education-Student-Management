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
    <title>Home</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sarabun">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/css/pikaday.min.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Search.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
</head>

<body style="font-family: Sarabun, sans-serif;">
    <nav class="navbar navbar-dark navbar-expand-lg fixed-top portfolio-navbar gradient">
        <div class="container"><a class="navbar-brand logo" href="#">ระบบจัดการข้อมูลนักเรียน</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item item"><a href="server.php?logout"><button class="btn btn-primary" type="submit" name="logout_submit" style="background: linear-gradient(-145deg, rgb(124,113,245), rgb(19,158,255)), rgb(58,80,94);border-radius: 5px;border-top-right-radius: 12px;border-top-left-radius: 0px;border-bottom-left-radius: 0px;border-bottom-right-radius: 12px;border-style: solid;border-color: rgba(255,255,255,0.58);">ออกจากระบบ</button></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="portfolio-block website" style="margin-top: 10em;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item" role="presentation"><a class="nav-link active" role="tab" data-toggle="tab" href="#tab-1">หน้าหลัก</a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-toggle="tab" href="#tab-2">ข้อมูลนักศึกษา/บุคลากร<br></a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-toggle="tab" href="#tab-3">รายวิชา</a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-toggle="tab" href="#tab-8">ตารางเรียน</a></li>
                        </ul>

                        <!-- tab-1 หน้าหลัก -->
                        <div class="tab-content" style="margin-top: 10px;">
                            <div class="tab-pane active" role="tabpanel" id="tab-1">
                                <div class="row" style="margin-top: 1.5em;">
                                    <div class="col">
                                        <div>
                                            <?php 
                                                $t1r_std = 0;
                                                $t1r_tea = 0;
                                                $t1r_adm = 0;

                                                if ($t1r = mysqli_query($conn, "SELECT * FROM users")){

                                                    $t1r_row = mysqli_fetch_all($t1r, MYSQLI_ASSOC);
                                                    
                                                    foreach($t1r_row as $x => $y) {
                                                        foreach($y as $z => $v) {
                                                            if ($v == "นักศึกษา") {
                                                                $t1r_std+=1;
                                                            } else if($v == "ครู") {
                                                                $t1r_tea+=1;
                                                            }else if($v == "เจ้าหน้าที่") {
                                                                $t1r_adm+=1;
                                                            }
                                                        }
                                                    }

                                                    mysqli_free_result(mysqli_query($conn, "SELECT group_type FROM users"));
                                                }
                                            ?>
                                            <p>จำนวนนักเรียน : <?php echo $t1r_std; ?> </p>
                                            <p>จำนวนครู : <?php echo $t1r_tea; ?> </p>
                                            <p>จำนวนเจ้าหน้าที่ : <?php echo $t1r_adm; ?> </p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end tab-1 จบหน้าหลัก -->

                            <!-- tab-2 ข้อมูลนักศึกษา/บุคลากร -->
                            <div class="tab-pane" role="tabpanel" id="tab-2">
                                <div>
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item" role="presentation"><a class="nav-link active" role="tab" data-toggle="tab" href="#tab-6">รายชื่อ</a></li>
                                        <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-toggle="tab" href="#tab-7">เพิ่มรายชื่อนักศึกษา</a></li>
                                        <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-toggle="tab" href="#tab-11">เพิ่มรายชื่อครู/เจ้าหน้าที่</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" role="tabpanel" id="tab-6">
                                            <div class="row" style="text-align: center;margin-top: 1.5em;">
                                                <div class="col">
                                                    <div class="table-responsive table-bordered">
                                                        <table class="table">
                                                            <thead class="bg-primary">
                                                                <tr>
                                                                    <th style="width: 20%;">เลขบัตรประจำตัวประชาชน</th>
                                                                    <th style="width: 40%;">ชื่อจริง</th>
                                                                    <th style="width: 20%;">ประเภทผู้ใช้งาน<br></th>
                                                                    <th style="width: 20%;"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            <?php 
                                                                $t2r = mysqli_query($conn, "SELECT id, idcard, title, firstname, lastname, group_type FROM users");
                                                                while($t2r_row = mysqli_fetch_assoc($t2r)) {
                                                            ?>
                                                                <tr>
                                                                    <td><a  href="moreinfo.php?id=<?php echo $t2r_row['id']; ?>"><?php echo $t2r_row['idcard']; ?></a></td>
                                                                    <td><a href="moreinfo.php?id=<?php echo $t2r_row['id']; ?>"><?php echo $t2r_row['title'] . "&nbsp;" . $t2r_row['firstname']. "&nbsp;" . $t2r_row['lastname']; ?></a></td> 
                                                                    <td><?php echo $t2r_row['group_type']; ?></td>
                                                                    <td>
                                                                        <div class="btn-group" role="group">
                                                                            <a href="update.php?requpdateuser=<?php echo $t2r_row['id']; ?>"><button class="btn btn-primary" type="button" style="border-top-right-radius: 5px;border-bottom-right-radius: 5px;border-style: none;">แก้ไข</button></a>
                                                                            <a href="server.php?deleteuser=<?php echo $t2r_row['id']; ?>" onclick="return confirm('ยืนยันการลบ?')"><button class="btn btn-primary" type="button" style="border-top-left-radius: 5px;border-bottom-left-radius: 5px;border-style: none;background: rgb(255,73,84);">ลบ</button></a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" role="tabpanel" id="tab-7">
                                            <form method="post" action="server.php">
                                                <p><strong>ข้อมูลทั่วไป</strong></p>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>รหัสบัตรประจำตัวประชาชน</label>
                                                            <input class="form-control" type="text" placeholder="เลขบัตร ปชช 13 หลัก" required maxlength="13" minlength="13" name="idcard" autofocus="">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>ประเภทผู้ใช้งาน</label>
                                                            <select class="custom-select d-xl-flex" id="t7_group_type_select" name="group_type" required>
                                                                <option value="นักเรียน" selected>นักเรียน</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>คำนำหน้าชื่อ</label>
                                                            <select class="form-control" name="title" required>
                                                                <option value="นาย" selected>นาย</option>
                                                                <option value="นางสาว">นางสาว</option>
                                                                <option value="นาง">นาง</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>ชื่อ</label>
                                                            <input class="form-control" type="text" placeholder="" required name="firstname">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>นามสกุล</label>
                                                            <input class="form-control" type="text" name="lastname" placeholder="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <p><strong>ข้อมูลส่วนตัว</strong></p>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>เพศ</label>
                                                            <select class="form-control" name="gender" required>
                                                                <option value="ชาย" selected>ชาย</option>
                                                                <option value="หญิง">หญิง</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>วันเกิด</label>
                                                            <input class="form-control" type="date" name="date" required>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>เบอร์</label>
                                                            <input class="form-control" type="text" placeholder="" name="phone" maxlength="10" minlength="10"required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>น้ำหนัก</label>
                                                            <input class="form-control" type="number" required name="weight" placeholder="กิโลกรัม">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>ส่วนสูง</label>
                                                            <input class="form-control" type="number" name="height" placeholder="เซนติเมตร" required>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>กรุ๊ปเลือด</label><select class="form-control" name="blood_type">
                                                                <option value="A" selected>A</option>
                                                                <option value="B">B</option>
                                                                <option value="AB">AB</option>
                                                                <option value="O">O</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>สัญชาติ</label>
                                                            <input class="form-control" type="text" required name="nationality">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>เชื้อชาติ</label>
                                                            <input class="form-control" type="text" name="race" required>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>ศาสนา</label>
                                                            <select class="form-control" name="religion">
                                                                <option value="พุทธ" selected>พุทธ</option>
                                                                <option value="คริสต์">คริสต์</option>
                                                                <option value="อิสลาม">อิสลาม</option>
                                                                <option value="อื่นๆ">อื่นๆ</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <p><strong>ข้อมูลนักศึกษา</strong></p>
                                                <div class="form-row" >
                                                    <div class="col">
                                                        <div class="form-group"><label>ปีที่เข้าเรียน</label>
                                                            <input class="form-control" type="text" name="std_year" required minlength="4" maxlength="4" placeholder="2563">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>ระดับ</label>
                                                            <select class="form-control" required name="std_level">
                                                                <option value="2" selected>ปวช</option>
                                                                <option value="3">ปวส</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>แผนกวิชา</label>
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
                                                        <div class="form-group"><label>เทอม</label><select class="form-control" required name="std_term"><option value="1">1</option><option value="2">2</option></select></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group"><label>ห้องเรียน</label><input class="form-control" type="text" name="std_room" placeholder="01, 02, 03" maxlength="2"
                                                                minlength="2" required></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group"><label>เลขที่</label><input class="form-control" type="text" name="std_number" placeholder="0001, 0002" required minlength="4" maxlength="4"
                                                            ></div>
                                                    </div>
                                                </div>
                                            
                                                <div class="form-row">
                                                    <div class="col"><button class="btn btn-primary" type="submit" name="adduser_submit" style="border-top-left-radius: 5px;border-top-right-radius: 5px;border-bottom-right-radius: 5px;border-bottom-left-radius: 5px;border-style: none;width: 100%;">บันทึก</button></div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" role="tabpanel" id="tab-11">
                                            <form method="post" action="server.php">
                                                <p><strong>ข้อมูลทั่วไป</strong></p>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>รหัสบัตรประจำตัวประชาชน</label>
                                                            <input class="form-control" type="text" placeholder="เลขบัตร ปชช 13 หลัก" required maxlength="13" minlength="13" name="idcard" autofocus="">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>ประเภทผู้ใช้งาน</label>
                                                            <select class="custom-select d-xl-flex" id="t7_group_type_select" name="group_type" required>
                                                                <option value="ครู">ครู</option>
                                                                <option value="เจ้าหน้าที่">เจ้าหน้าที่</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>คำนำหน้าชื่อ</label>
                                                            <select class="form-control" name="title" required>
                                                                <option value="นาย" selected>นาย</option>
                                                                <option value="นางสาว">นางสาว</option>
                                                                <option value="นาง">นาง</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>ชื่อ</label>
                                                            <input class="form-control" type="text" placeholder="" required name="firstname">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>นามสกุล</label>
                                                            <input class="form-control" type="text" name="lastname" placeholder="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <p><strong>ข้อมูลส่วนตัว</strong></p>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>เพศ</label>
                                                            <select class="form-control" name="gender" required>
                                                                <option value="ชาย" selected>ชาย</option>
                                                                <option value="หญิง">หญิง</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>วันเกิด</label>
                                                            <input class="form-control" type="date" name="date" required>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>เบอร์</label>
                                                            <input class="form-control" type="text" placeholder="" name="phone" maxlength="10" minlength="10"required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>น้ำหนัก</label>
                                                            <input class="form-control" type="number" required name="weight" placeholder="กิโลกรัม">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>ส่วนสูง</label>
                                                            <input class="form-control" type="number" name="height" placeholder="เซนติเมตร" required>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>กรุ๊ปเลือด</label><select class="form-control" name="blood_type">
                                                                <option value="A" selected>A</option>
                                                                <option value="B">B</option>
                                                                <option value="AB">AB</option>
                                                                <option value="O">O</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>สัญชาติ</label>
                                                            <input class="form-control" type="text" required name="nationality">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>เชื้อชาติ</label>
                                                            <input class="form-control" type="text" name="race" required>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>ศาสนา</label>
                                                            <select class="form-control" name="religion">
                                                                <option value="พุทธ" selected>พุทธ</option>
                                                                <option value="คริสต์">คริสต์</option>
                                                                <option value="อิสลาม">อิสลาม</option>
                                                                <option value="อื่นๆ">อื่นๆ</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col"><button class="btn btn-primary" type="submit" name="addusermore_submit" style="border-top-left-radius: 5px;border-top-right-radius: 5px;border-bottom-right-radius: 5px;border-bottom-left-radius: 5px;border-style: none;width: 100%;">บันทึก</button></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end tab-2 จบข้อมูลนักศึกษา/บุคลากร -->

                            <!-- tab-3 รายวิชา -->
                            <div class="tab-pane" role="tabpanel" id="tab-3">
                                <div>
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item" role="presentation"><a class="nav-link active" role="tab" data-toggle="tab" href="#tab-4">รายวิชา</a></li>
                                        <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-toggle="tab" href="#tab-5">เพิ่มรายวิชา<br></a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" role="tabpanel" id="tab-4">
                                            <div class="row" style="text-align: center;margin-top: 1.5em;">
                                                <div class="col" style="text-align: center;">
                                                    <div class="table-responsive table-bordered">
                                                        <table class="table">
                                                            <thead class="bg-primary">
                                                                <tr>
                                                                    <th style="width: 40%;">ชื่อวิชา</th>
                                                                    <th style="width: 30%;">รหัสวิชา</th>
                                                                    <th style="width: 10%;">หน่วยกิต</th>
                                                                    <th style="width: 20%;"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php 
                                                                    $t3r = mysqli_query($conn, "SELECT id, s_name, s_code, credit FROM subject");
                                                                    while($t3r_row = mysqli_fetch_assoc($t3r)) {
                                                                ?>
                                                               
                                                                <tr>
                                                                    <td><?php echo $t3r_row['s_name']; ?></td>
                                                                    <td><?php echo $t3r_row['s_code']; ?></td>
                                                                    <td><?php echo $t3r_row['credit']; ?></td>
                                                                    <td>
                                                                        <div class="btn-group" role="group">
                                                                            <a href="server.php?deletesubject=<?php echo $t3r_row['id']; ?>" onclick="return confirm('ยืนยันการลบ?')"><button class="btn btn-primary" type="button" style="border-top-right-radius: 10px;border-bottom-right-radius: 10px;background: rgb(255,104,104);border-style: none;">ลบ</button></a>
                                                                            <a href="update.php?requpdatesubject=<?php echo $t3r_row['id']; ?>"><button class="btn btn-primary" type="button" style="border-top-left-radius: 10px;border-bottom-left-radius: 10px;border-style: none;">แก้ไข</button></a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" role="tabpanel" id="tab-5">
                                            <form method="post" action="server.php">
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group"><label>ชื่อวิชา</label><input class="form-control" name="s_name" type="text" required></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group"><label>รหัสวิชา</label><input class="form-control" name="s_code" type="text" required></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group"><label>หน่วยกิต</label><input class="form-control" name="credit" type="number" required></div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group" style="text-align: center;"><button class="btn btn-primary" name="addsubject_submit" type="submit" style="border-style: none;border-top-left-radius: 10px;border-top-right-radius: 10px;border-bottom-right-radius: 9px;border-bottom-left-radius: 10px;">บันทึก</button></div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end tab-3 จบรายวิชา -->

                            <!-- tab-8 ตารางเรียน -->
                            <div class="tab-pane" role="tabpanel" id="tab-8">
                                <div>
                                    <ul class="nav nav-tabs" role="tablist">
                                        <!-- <li class="nav-item" role="presentation"><a class="nav-link active" role="tab" data-toggle="tab" href="#tab-9">ข้อมูลตารางเรียน</a></li> -->
                                        <li class="nav-item" role="presentation"><a class="nav-link active" role="tab" data-toggle="tab" href="#tab-10">เพิ่มตารางเรียน</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <!-- <div class="tab-pane active" role="tabpanel" id="tab-9">
                                            <div class="row" style="margin-top: 1.5em;">
                                                <div class="col">
                                                    <form>
                                                        <div class="form-row">
                                                            <div class="col">
                                                                <div class="form-group"><label>ปีการศึกษา</label><select class="form-control" required><option value="12" selected>This is item 1</option><option value="13">This is item 2</option><option value="14">This is item 3</option></select></div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group"><label>แผนก</label><select class="form-control" required><option value="12" selected>This is item 1</option><option value="13">This is item 2</option><option value="14">This is item 3</option></select></div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group"><label>ห้องเรียน</label><select class="form-control"><option value="12" selected>This is item 1</option><option value="13">This is item 2</option><option value="14">This is item 3</option></select></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="col">
                                                                <div class="form-group"><button class="btn btn-primary" type="button" style="width: 100%;border-radius: 5px;">ค้นหา</button></div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 1.5em;">
                                                <div class="col">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th style="text-align: center;"><br><strong>วัน/คาบเรียน</strong><br></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><strong>วันจันทร์</strong><br></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>วันอังคาร</strong><br></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>วันพุธ</strong><br></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Cell 1</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Cell 1</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Cell 1</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="tab-pane active" role="tabpanel" id="tab-10">
                                            <div class="row" style="margin-top: 1.5em;">
                                                <div class="col">
                                                    <form method="post" action="server.php">
                                                        <div class="form-row">
                                                            <div class="col">
                                                                <div class="form-group"><label>ปีการศึกษา</label>
                                                                    <select class="form-control" name="std_year">
                                                                        <?php 
                                                                            $thisyear = date("Y") + 543;
                                                                            for ($x = 0; $x <= 6; $x++) {
                                                                                for ($z = 1; $z <= 2; $z++) {
                                                                                    echo "<option value=".$z."/".$thisyear.">".$z."/".$thisyear."</option>";
                                                                                }
                                                                                $thisyear = $thisyear - 1;
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                        <div class="form-group">
                                                            <label>ระดับ</label>
                                                            <select class="form-control" required name="std_level">
                                                                <option value="2" selected>ปวช</option>
                                                                <option value="3">ปวส</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                            <div class="col">
                                                                <div class="form-group"><label>แผนก</label>
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
                                                            <div class="col">
                                                                <div class="form-group"><label>ห้องเรียน</label>
                                                                    <input class="form-control" type="text" name="std_room" placeholder="01, 02, 03" maxlength="2" minlength="2" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="col">
                                                                <div class="form-group"><label>วัน</label>
                                                                    <select class="form-control" name="day">
                                                                        <?php
                                                                            $dayofweek = array("วันจันทร์","วันอังคาร","วันพุธ","วันพฤหัสบดี","วันศุกร์","วันเสาร์","วันอาทิตย์");
                                                                            foreach($dayofweek as $x => $y) {
                                                                                echo " <option value=".$x." selected>".$y."</option>";
                                                                            }
                                                                        ?>
                                                                       
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group" style="margin-top:2em;"><label>เวลาเริ่มเรียน</label>
                                                                    <input type="time" name="class_start" min="08:00" max="24:00" required>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group" style="margin-top:2em;"><label>เวลาสิ้นสุด</label>
                                                                    <input type="time" name="class_end" min="08:00" max="24:00" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="col">
                                                                <div class="form-group"><label>วิชา</label>
                                                                    <select class="form-control" name="s_code">
                                                                    <?php 
                                                                        $t10r_sub = mysqli_query($conn, "SELECT id, s_name, s_code, credit FROM subject");
                                                                        while($t10r_sub_row = mysqli_fetch_assoc($t10r_sub)) {
                                                                           echo "<option value=".$t10r_sub_row['s_code']." selected>".$t10r_sub_row['s_name']."</option>";
                                                                        }
                                                                    ?>
                                                                        
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group"><label>ครูผู้สอน</label>
                                                                    <select class="form-control" name="teacher">
                                                                    <?php 
                                                                        $t10r_tea = mysqli_query($conn, "SELECT idcard, title, firstname, lastname FROM users WHERE group_type = 'ครู'");
                                                                        while($t10r_tea_row = mysqli_fetch_assoc($t10r_tea)) {
                                                                           echo "<option value=".$t10r_tea_row['idcard']." selected>".$t10r_tea_row['title'].$t10r_tea_row['firstname']." ".$t10r_tea_row['lastname']."</option>";
                                                                        }
                                                                    ?>
                                                                        
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="col" style="margin: auto;"><button name="addclass_submit" class="btn btn-primary" type="submit" style="border-radius: 5px;width: 100%;">บันทึก</button></div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end tab-8 จบตารางเรียน -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div></div>
    </section>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/pikaday.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/fixjs/scripts_fix.js"></script>
</body>

</html>