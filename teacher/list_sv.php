<?php
session_start();
include("../connectSQL.php");
$assignment_list = "";
$id = $_SESSION["id"];

if (isset($_GET["action"])) {
    if ($_GET["action"] == "show") {
        $id_assign = $_GET["id"];
        $sql = "SELECT * FROM sv WHERE code = 2";
        $result = $conn->query($sql);
        $dem = 1;
        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $sl =  "SELECT * FROM nop_bt WHERE id_sv = '$row[0]' AND id_bt = '$id_assign'";
            $data = $conn->query($sl);
            $sl = $data->fetch_array(MYSQLI_NUM);
            $assignment_list .= "<tr>";
            $assignment_list .= "<th>" . $dem . "</th>";
            $assignment_list .= "<th>" . $row[4] . "</th>";
            if (!empty($sl[4])) {
                $assignment_list .= "<th>" . $sl[4] . "</th>";
                $assignment_list .= "<th> <a href='../bt_sv/" . $sl[3] . "' download> Download </a> </th>";
            } else {
                $assignment_list .= "<th></th>";
                $assignment_list .= "<th></th>";
            }
            $assignment_list .= "</tr>";
            $dem++;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sv làm bt</title>
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

    <!-- assignment tab -->
    <div class="content" id="assignment">
        <a href="assign.php" class="add">Trở lại</a>
        <div class="assignment-list">
            <table>
                <tr>
                    <th>STT</th>
                    <th>Họ và tên</th>
                    <th>Ngày nộp</th>
                    <th>Bài làm</th>
                </tr>
                <?php
                echo $assignment_list;
                ?>
            </table>
        </div>
    </div>

</body>

</html>