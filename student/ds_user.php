<?php
session_start();
include("../connectSQL.php");
$student_list = "";
$avatar = $_SESSION["avatar"];

$id_user = $_SESSION["id"];
$sql = "SELECT * FROM sv";
$result = $conn->query($sql);
$dem = 0;
while ($row = $result->fetch_array(MYSQLI_NUM)) {
    $dem++;
    $student_list .= "<tr>";
    $student_list .= "<th>" . $dem . "</th>";
    $student_list .= "<th>" . $row[1] . "</th>";
    if ($row[3] == 1) {
        $student_list .= "<th> Giáo viên </th>";
    } else {
        $student_list .= "<th> Sinh viên </th>";
    }

    $student_list .= "<th>" . $row[4] . "</th>";
    $student_list .= "<th>" . $row[5] . "</th>";
    $student_list .= "<th>" . $row[6] . "</th>";
    if ($id_user != $row[0]) {
        $student_list .= "<th> <a class='link' href='info_user.php?idguest=" . $row[0] . "'> Cá nhân </a> </th>";
    }
    else{
        $student_list .= "<th></th>";
    }
    $student_list .= "</tr>";
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Danh sách người dùng</title>
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
                <a href="ds_user.php" class="chon">Danh sách người dùng</a>
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
        <div class="title">Danh sách người dùng</div>
        <div class="students-list">
            <table>
                <tr>
                    <th>STT</th>
                    <th>Tên đăng nhập</th>
                    <th>Chức vụ</th>
                    <th>Họ và tên</th>
                    <th>SĐT</th>
                    <th>Email</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                echo $student_list;
                ?>
            </table>
        </div>
    </div>

</body>

</html>