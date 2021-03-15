
<?php include('loading.php'); ?>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "esm";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    session_start();

    // Login
    if (isset($_POST['new_login_submit'])) {
        $idcard = mysqli_real_escape_string($conn,$_POST['idcard']);
        $birth = mysqli_real_escape_string($conn,$_POST['birth']); 

        $result = mysqli_query($conn,"SELECT id FROM personal_info WHERE idcard = '$idcard' and birth = '$birth'");
        $count = mysqli_num_rows($result);

        if($count == 1) {
            $users_result = mysqli_query($conn, "SELECT group_type FROM users WHERE idcard = '$idcard'");
            $row = mysqli_fetch_array($users_result, MYSQLI_ASSOC);

            $_SESSION['login_user'] = $idcard;

            if ($row['group_type'] == 'นักศึกษา') {
                header("location: infomyself.php");
            } else if ($row['group_type'] == 'ครู') { 
                header("location: teacher-index.php");
            } else if ($row['group_type'] == 'เจ้าหน้าที่') { 
                header("location: index.php");
            }
        
         }else {
            header("location: login.php");
         }
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        header("location: login.php");
    }

    // Users Insert
    if (isset($_POST['adduser_submit'])) {

        $idcard = $_POST['idcard'];
        $title = $_POST['title'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];

        $gender = $_POST['gender'];
        $birth = $_POST['date'];
        $phone = $_POST['phone'];
        $weight = $_POST['weight'];
        $height = $_POST['height'];
        $blood_type = $_POST['blood_type'];
        $nationality = $_POST['nationality'];
        $race = $_POST['race'];
        $religion = $_POST['religion'];

        $std_year = $_POST['std_year'];
        $std_level = $_POST['std_level'];
        $std_department = $_POST['std_department'];
        $std_term = $_POST['std_term'];
        $std_room = $_POST['std_room'];
        $std_number = $_POST['std_number'];
        $std_id = substr($std_year,2) . $std_level . $std_department . $std_room . $std_number;
        
        $users_sql_insert = "INSERT INTO users (idcard, title, firstname, lastname) VALUES ('$idcard', '$title', '$firstname', '$lastname')";
        $pers_sql_insert = "INSERT INTO personal_info (idcard, gender, birth, blood_type, nationality, race, religion, weight, height, phone) VALUES ('$idcard', '$gender', '$birth', '$blood_type' , '$nationality' , '$race' , '$religion' , '$weight' , '$height' , '$phone')";
        $std_sql_insert = "INSERT INTO student_info (idcard, std_id, std_year, std_level, std_department , std_room , std_number , std_term) VALUES ('$idcard', '$std_id', '$std_year', '$std_level' , '$std_department', '$std_room', '$std_number' , '$std_term')";
       
        if (mysqli_query($conn, $users_sql_insert)) {
            if (mysqli_query($conn, $pers_sql_insert)) {
                if (mysqli_query($conn, $std_sql_insert)) {
                    echo "<script>lodingpage();</script>";
                    header("refresh:2; url=index.php"); 
                   // header('Location: index.php');
                } else {
                    echo "Error: " . $std_sql_insert . "<br>" . mysqli_error($conn);
                }
            } else {
                echo "Error: " . $pers_sql_insert . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Error: " . $users_sql_insert . "<br>" . mysqli_error($conn);
        }
    }

    // Users Insert
    if (isset($_POST['addusermore_submit'])) {

        $idcard = $_POST['idcard'];
        $title = $_POST['title'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];

        $gender = $_POST['gender'];
        $birth = $_POST['date'];
        $phone = $_POST['phone'];
        $weight = $_POST['weight'];
        $height = $_POST['height'];
        $blood_type = $_POST['blood_type'];
        $nationality = $_POST['nationality'];
        $race = $_POST['race'];
        $religion = $_POST['religion'];

        $users_sql_insert = "INSERT INTO users (idcard, title, firstname, lastname) VALUES ('$idcard', '$title', '$firstname', '$lastname')";
        $pers_sql_insert = "INSERT INTO personal_info (idcard, gender, birth, blood_type, nationality, race, religion, weight, height, phone) VALUES ('$idcard', '$gender', '$birth', '$blood_type' , '$nationality' , '$race' , '$religion' , '$weight' , '$height' , '$phone')";
    
        if (mysqli_query($conn, $users_sql_insert)) {
            if (mysqli_query($conn, $pers_sql_insert)) {
                echo "<script>lodingpage();</script>";
                header("refresh:2; url=index.php"); 
            } else {
                echo "Error: " . $pers_sql_insert . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Error: " . $users_sql_insert . "<br>" . mysqli_error($conn);
        }
    }

    // Subject Insert
    if (isset($_POST['addsubject_submit'])) {
        $s_name = $_POST['s_name'];
        $s_code = $_POST['s_code'];
        $credit = $_POST['credit'];
        
        $subject_sql_insert = "INSERT INTO subject (s_name, s_code, credit) VALUES ('$s_name', '$s_code', '$credit')";

        if (mysqli_query($conn, $subject_sql_insert)) {
            echo "<script>lodingpage();</script>";
            header("refresh:2; url=index.php"); 
        } else {
            echo "Error: " . $subject_sql_insert . "<br>" . mysqli_error($conn);
        }
    }

    // Class Insert
    if (isset($_POST['addclass_submit'])) {
        $std_year = substr($_POST['std_year'],2);
        $std_term = str_split($_POST['std_year'])[0];
        $std_level = $_POST['std_level'];
        $std_department = $_POST['std_department'];
        $std_room = $_POST['std_room'];
        $day = $_POST['day'];
        $class_start = $_POST['class_start'];
        $class_end = $_POST['class_end'];
        $s_code = $_POST['s_code'];
        $teacher = $_POST['teacher'];
        
        $class_sql_insert = "INSERT INTO class_schedule (std_year, std_term, std_level, std_department, std_room, day, class_start, class_end, s_code, teacher) VALUES ('$std_year', '$std_term', '$std_level', '$std_department', '$std_room', '$day', '$class_start', '$class_end', '$s_code', '$teacher')";
        
        if (mysqli_query($conn, $class_sql_insert)) {

            $findid = substr($std_year,2) . $std_level . $std_department . $std_room;
            
            $findresult = mysqli_query($conn, "SELECT std_id FROM student_info WHERE std_id LIKE '$findid%'");

            if (mysqli_num_rows($findresult) > 0) {

                while($findrow = mysqli_fetch_assoc($findresult)) {
                    $std_id = $findrow["std_id"];
                    $classpoint = "INSERT INTO class_point (std_id, std_year, std_term, s_code, point) VALUES ('$std_id', '$std_year', '$std_term', '$s_code', '0')";
                    
                    if (mysqli_query($conn, $classpoint)) {
                        
                    } else {
                        
                    }
                }

              } else {
                echo "0 results";
              }
            echo "<script>lodingpage();</script>";
            header("refresh:2; url=index.php"); 
        } else {
            echo "Error: " . $class_sql_insert . "<br>" . mysqli_error($conn);
        }
    }

    // Users Delete
    if (isset($_GET['deleteuser'])) {
        $deleteid = $_GET['deleteuser'];
        if (mysqli_query($conn, "DELETE FROM users WHERE id= $deleteid")) {
            echo "<script>lodingpage();</script>";
            header("refresh:2; url=index.php"); 
        } else {
            echo "<script>alert(Error deleting record: " . mysqli_error($conn) .");</script>";
        }
    }

    // Subject Delete
    if (isset($_GET['deletesubject'])) {
        $deleteid = $_GET['deletesubject'];
        if (mysqli_query($conn, "DELETE FROM subject WHERE id= $deleteid")) {
            echo "<script>lodingpage();</script>";
            header("refresh:2; url=index.php"); 
        } else {
            echo "<script>alert(Error deleting record: " . mysqli_error($conn) .");</script>";
        }
    }

     // Subject Update Point
     if (isset($_POST['updatepoint_submit'])) {
        $std_id = $_POST['std_id'];
        $std_point = $_POST['std_point'];
        $subject = $_POST['subject'];
        $point_update_sql = "UPDATE class_point SET point='$std_point' WHERE std_id='$std_id' AND s_code='$subject'";

        if (mysqli_query($conn, $point_update_sql)) {
            echo "<script>lodingpage();</script>";
            header("refresh:2; url=teacher-index.php"); 
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
     }

?>