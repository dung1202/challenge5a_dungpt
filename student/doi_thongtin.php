<?php
session_start();
include("../connectSQL.php");

$err = "";
$id = $_SESSION["id"];
$sql = "SELECT * FROM sv WHERE id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_array(MYSQLI_NUM);
$name = $row[4];
$username = $row[1];
$phonenumber = $row[5];
$email = $row[6];
$avatar = $_SESSION["avatar"];

// click change info
if (isset($_POST["update"])) {
    $email = $_POST["email"];
    $phonenumber = $_POST["phonenumber"];
    $fileURL = $_POST["URL"];
    $filename = $_FILES["uploadFile"]["name"];
    $tempname = $_FILES["uploadFile"]["tmp_name"];
    $folder = "../avatar/" . $filename;
    $ten_anh = $username . ".png";
    $folderURL = "../avatar/" . $ten_anh;

    if (empty($phonenumber) or empty($email)) {
        $err = "Thiếu thông tin";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err = "Sai định dạng email";
    } elseif (!preg_match("/^[0]{1}[0-9]{9}$/", $phonenumber)) {
        $err = "Điện thoại bắt đầu bằng 0 và có 10 chữ số";
    } else {
        if (!empty($filename)) {
            $sql = "UPDATE sv SET email = '$email', sdt = '$phonenumber', avatar = '$filename' WHERE id = '$id'";
            if (move_uploaded_file($tempname, $folder)) {
                $err = "Thành công";
            } else {
                $err = "Lỗi thử lại";
            }
            $res = $conn->query($sql);
            header("location: ./student.php");
        } else if (!empty($fileURL)) {
            $sql = "UPDATE sv SET email = '$email', sdt = '$phonenumber', avatar = '$ten_anh' WHERE id = '$id'";
            if (file_put_contents($folderURL, file_get_contents($fileURL))) {
                $err = "Thành công";
            } else {
                $err = "Lỗi thử lại";
            }
            $res = $conn->query($sql);
            header("location: ./student.php");
        } else {
            $err = "Cần file ảnh hoặc URL";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Đổi thông tin</title>
    <link rel="stylesheet" href="student.css">
    <script src="https://kit.fontawesome.com/50e4937a61.js" crossorigin="anonymous"></script>
</head>

<body class="conf">
    <div class="sidebar">
        <div class="code">Sinh viên</div>
        <ul class="menu">
            <li>
                <a href="student.php" class="chon"> <img class="avatar" src="<?php echo $avatar ?>"><?php echo "<div>" . $_SESSION["username"] . "</div>"; ?> </a>
            </li>
            <li>
                <a href="doi_mk.php" >Đổi mật khẩu</a>
            </li>
            <li>
                <a href="ds_user.php">Danh sách người dùng</a>
            </li>
            <li>
                <a href="baitap.php">Bài tập</a>
            </li>
            <li>
                <a href="ds_game.php">Game</a>
            </li>
            <li>
                <a href="../logout.php">Log out</a>
            </li>
        </ul>
    </div>

    <div class="content">
        <div class="row">
            <a href="student.php" class="add" style="float:right;">Trở lại</a>
        </div>

        <form action="" method="post" enctype="multipart/form-data">
            <p style="text-align: center;">Đổi thông tin: <?php echo $name ?> </p>
            <label for="username">Tên đăng nhập:</label><br>
            <input type="text" readonly name="username" value="<?php echo $username ?>"><br>
            <label for="name">Họ và tên:</label><br>
            <input type="text" readonly name="name" value="<?php echo $name ?>"><br>
            <label for="email">Email:</label><br>
            <input type="text" name="email" value="<?php echo $email ?>"><br>
            <label for="phonenumber">Số điện thoại:</label><br>
            <input type="text" name="phonenumber" value="<?php echo $phonenumber ?>"><br>
            <label for="phonenumber">Ảnh URL:</label><br>
            <input type="text" name="URL"><br>
            <label for="avatar">File ảnh:</label>
            <input type="file" name="uploadFile"><br><br>
            <?php
            if (!(empty($err))) {
                echo "<div class='error' style='background: black; padding: 10px; text-align: center; border-radius:10px;'>" . $err . "</div>";
            }
            ?>
            <input type="submit" value="Lưu" name="update">
        </form>
    </div>



</body>

</html>