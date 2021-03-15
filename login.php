<?php include('server.php') ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sarabun">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/css/pikaday.min.css">
</head>

<body>
    <nav class="navbar navbar-dark navbar-expand-lg fixed-top portfolio-navbar gradient">
        <div class="container"><a class="navbar-brand logo" href="#">ESM</a></div>
    </nav>
    <section class="portfolio-block mobile-app">
        <div class="container align-items-center" style="font-family: Sarabun, sans-serif;">
            <div class="row align-items-center" style="margin-top: 2em;">
                <div class="col">
                    <form style="text-align: center;" method="post" action="server.php">
                        <div class="form-group"><label style="font-size: 20px;text-align: center;">เข้าสู่ระบบ</label></div>
                        <div class="form-group"><label>หมายเลขบัตรประชาชน</label><input class="form-control" type="text" name="idcard" style="text-align: center;" minlength="13" maxlength="13" required=""></div>
                        <div class="form-group"><label>ว/ด/ป เกิด</label>
                            <input class="form-control" type="date" name="birth" style="text-align: center;" required>
                        </div>
                        <div class="form-group"><button class="btn btn-primary" name="new_login_submit" type="submit" style="border-radius: 5px;">เข้าสู่ระบบ</button></div>
                    </form>
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