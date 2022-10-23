<?php
session_start();
include("../connectSQL.php");
$avatar = $_SESSION['avatar'];

$assign_name = "";
if (isset($_GET["id"])) {
    $id_assign = $_GET["id"];
    $sql = "SELECT * FROM bt WHERE id='$id_assign'";
    $result = $conn->query($sql);
    $row = $result->fetch_array(MYSQLI_NUM);
    $assign_name = $row[1];
}

if (isset($_POST["submit"])) {
    if (!empty($_FILES["file"]["name"])) {
        $targetDir = "../bt_sv/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $allowTypes = array('doc', 'docx', 'pdf');


        if ($_FILES["file"]["size"] > 2097152) {
            $err = "File của bạn quá lớn";
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                $id_stu = $_SESSION["id"];
                $sl =  "SELECT * FROM nop_bt";
                $data = $conn->query($sl);
                $sl = (int)$data->num_rows + 1;
                $sql = "INSERT INTO nop_bt (id,id_bt,id_sv, filename, updateon) VALUES('$sl','$id_assign','$id_stu','$fileName',NOW())";
                $conn->query($sql);
                header("location: ./baitap.php");
            } else {
                $err = "Lỗi, xin thử lại";
            }
        }
    } else {
        $err = "Cần có file";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nộp bài tập</title>
    <link rel="stylesheet" href="student.css">
    <script src="https://kit.fontawesome.com/50e4937a61.js" crossorigin="anonymous"></script>
</head>

<body class="conf">
    <div class="sidebar">
        <div class="code">Sinh viên</div>
        <ul class="menu">
            <li>
                <a href="student.php" > <img class="avatar" src="<?php echo $avatar?>"><?php echo "<div>" . $_SESSION["username"] . "</div>"; ?> </a>
            </li>
            <li>
                <a href="ds_user.php">Danh sách người dùng</a>
            </li>
            <li>
                <a href="baitap.php" class="chon">Bài tập</a>
            </li>
            <li>
                <a href="ds_game.php">Game</a>
            </li>
            <li>
                <a href="../logout.php">Log out</a>
            </li>
        </ul>
    </div>

    <!-- assignment tab -->
    <div class="content">
        <a href="baitap.php" class="add">Trở lại</a>
        <form class='nop_file' action="" method="post" enctype="multipart/form-data">
            <p style="text-align:center;"> Tên bài tập: <?php echo $assign_name; ?> </p>
            <input  type="file" id="myfile" name="file"><br><br>
            <?php
            if (!(empty($err))) {
                echo "<div class='error' style='background: black; padding: 10px; text-align: center; border-radius:10px;'>" . $err . "</div>";
            }
            ?>
            <input type="submit" value="Tải lên" name="submit"><br><br>
        </form>
    </div>

</body>

</html>