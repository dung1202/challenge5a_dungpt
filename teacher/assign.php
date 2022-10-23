<?php
session_start();
include("../connectSQl.php");
$err = '';
$assignment_list = "";
$id = $_SESSION["id"];

if (isset($_POST["submit"])) {

    if (!empty($_FILES["file"]["name"])) {
        $targetDir = "../baitap/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $title = $_POST["title"];
        $allowTypes = array('doc', 'docx', 'pdf');

        if ($_FILES["file"]["size"] > 2097152) {
            $err = "File của bạn quá lớn";
        } elseif (empty($title)) {
            $err = "Cần có tiêu đề";
        } else {

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                $id = $_SESSION["id"];
                $sl =  "SELECT * FROM bt";
                $data = $conn->query($sl);
                $sl = (int)$data->num_rows + 1;
                $sql = "INSERT INTO bt (id,tieu_de,id_gv, filename, updateon) VALUES('$sl','$title','$id','$fileName',NOW())";
                if ($conn->query($sql) == true) {
                    $err = "Thành công";
                } else {
                    $err = "Lỗi, xin thử lại";
                }
            } else {
                $err = "Không thể upload file của bạn";
            }
        }
    } else {
        $err = "Cần upload file";
    }
}

// show assignment list
$sql = "SELECT * FROM bt WHERE id_gv='$id'";
$result = $conn->query($sql);
while ($row = $result->fetch_array(MYSQLI_NUM)) {
    // process each row
    $assignment_list .= "<tr>";
    $assignment_list .= "<th>" . $row[1] . "</th>";
    $assignment_list .= "<th>" . $row[3] . "</th>";
    $assignment_list .= "<th> <a class='link' href='list_sv.php?action=show&id=" . $row[0] . "'>Xem danh sách sinh viên đã nộp bài tập</a> </th>";
    $assignment_list .= "</tr>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="teacher.css">
    <script src="https://kit.fontawesome.com/50e4937a61.js" crossorigin="anonymous"></script>
</head>

<body class="conf">
    <div class="sidebar">
        <div class="code">Giáo viên</div>
        <ul class="menu">
            <li>
                <a href="me.php"><img class="avatar" src="../avatar/giao_vien.jpg"><?php echo "<div>" . $_SESSION["username"] . "</div>"; ?> </a>
            </li>
            <li>
                <a href="teacher.php">Danh sách người dùng</a>
            </li>
            <li>
                <a href="" class="chon">Bài tập</a>
            </li>
            <li>
                <a href="chall.php">Game</a>
            </li>
            <li>
                <a href="../logout.php">Log out</a>
            </li>
        </ul>
    </div>
    <div class="content" id="assignment">
        <form action="" method="post" enctype="multipart/form-data" class="assignment">
            <label for="title">Tên bài tập:</label>
            <input type="text" class="ten" id="title" name="title"><br><br>
            <label for="myfile">file:</label>
            <input type="file" id="myfile" name="file"><br><br>
            <input type="submit" value="Upload" name="submit"><br><br>
            <?php
            if (!empty($err))
                echo '<div class="error">' . $err . '</div>';
            ?>
        </form>

        <div class="assignment-list">
            <table>
                <tr>
                    <th>Tên bài tập</th>
                    <th>Tên file</th>
                    <th>Danh sách sinh viên đã nộp</th>
                </tr>
                <?php
                echo $assignment_list;
                ?>
            </table>
        </div>
    </div>
</body>

</html>