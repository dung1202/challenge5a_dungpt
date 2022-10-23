<?php
session_start();
include("../connectSQL.php");

$username = $password = $name = $phonenumber = $email = "";

if (isset($_GET["action"])) {
    if ($_GET["action"] == "edit") {
        $id = $_GET["id"];
        $sql = "SELECT * FROM sv WHERE id = '$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_array(MYSQLI_NUM);
        $username = $row[1];
        $password = $row[2];
        $name = $row[4];
        $phonenumber = $row[5];
        $email = $row[6];
        $pass_old = $password;
    }
}


if (isset($_POST["modification"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $name = $_POST["name"];
    $phonenumber = $_POST["phonenumber"];
    $email = $_POST["email"];
    if (!($pass_old == $password)) {
        $password = md5($password);
    }
    // check if information is in the right format
    if (empty($username) or empty($password) or empty($name) or empty($phonenumber) or empty($email)) {
        $err = "Cần ghi đầy đủ thông tin";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err = "Không đúng định dạng email";
    } elseif (!preg_match("/^[0]{1}[0-9]{9}$/", $phonenumber)) {
        $err = "Số điện thoại cần bắt đầu từ 0 và gồm mười chữ số";
    } else {
        $sql = "UPDATE sv SET username='$username',pass='$password',name='$name',sdt='$phonenumber',
        email='$email' WHERE id = '$id'";
        if ($conn->query($sql) == true) {
            $err = "Thay đổi thông tin thành công";
            // header("location: ./sv_edit.php");
        } else {
            $err = "Thay đổi thông tin không thành công";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa thông tin</title>
    <link rel="stylesheet" href="teacher.css">
    <script src="https://kit.fontawesome.com/50e4937a61.js" crossorigin="anonymous"></script>
</head>

<body class="conf">
    <div class="sidebar">
        <div class="code">Giáo viên</div>
        <ul class="menu">
            <li>
                <a href="me.php"> <img class="avatar" src="../avatar/giao_vien.jpg"><?php echo "<div>" . $_SESSION["username"] . "</div>"; ?> </a>
            </li>
            <li>
                <a href="" class="chon">Chỉnh sửa thông tin</a>
            </li>
            <li>
                <a href="assign.php">Bài tập</a>
            </li>
            <li>
                <a href="chall.php">Game</a>
            </li>
            <li>
                <a href="../logout.php">Log out</a>
            </li>
        </ul>

    </div>

    <div class="content displaynone" id="stu-modification">
        <a href="teacher.php" class="add">Trở lại</a>
        <form method="post" action="" class="addition">
            <p>Chỉnh sửa thông tin sinh viên</p>

            <div class="tieu">Tên đăng nhập</div>
            <input type="text" name="username" placeholder="Username" value="<?php echo $username ?>">
            <div class="tieu">Mật khẩu</div>
            <input type="password" name="password" onmouseover="change_t(this)" onmouseout="change_p(this)" placeholder="Password" value="<?php echo $password ?>">
            <div class="tieu">Họ và tên</div>
            <input type="text" name="name" placeholder="Name" value="<?php echo $name ?>">
            <div class="tieu">Email</div>
            <input type="text" name="email" placeholder="Email" value="<?php echo $email ?>">
            <div class="tieu">Số điện thoại</div>
            <input type="text" name="phonenumber" placeholder="Phone number" value="<?php echo $phonenumber ?>">
            <?php
            if (!(empty($err))) {
                echo "<div class='error'>" . $err . "</div>";
            }
            ?>
            <input type="submit" value="Lưu" name="modification">
        </form>
    </div>
    <script>
        function change_t(a) {
            a.type = "text"
        }

        function change_p(a) {
            a.type = "password"
        }
    </script>

</body>

</html>