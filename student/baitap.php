<?php
session_start();
include("../connectSQl.php");
$assignment_list = "";
$avatar = $_SESSION["avatar"];
$id = $_SESSION["id"];

// show assignment list
$sql = "SELECT * FROM bt";
$result = $conn->query($sql);
while ($row = $result->fetch_array(MYSQLI_NUM)) {
    $sl =  "SELECT * FROM nop_bt WHERE id_bt = '$row[0]' AND id_sv = '$id'";
    $data = $conn->query($sl);
    $sl = (int)$data->num_rows;
    if ($sl == 1) {
        $sub = 'X';
    } else {
        $sub = '';
    }
    $assignment_list .= "<tr>";
    $assignment_list .= "<th>" . $row[1] . "</th>";
    $assignment_list .= "<th> <a class='link' href='../baitap/" . $row[3] . "' download> Download </a> </th>";
    $assignment_list .= "<th> <a class='link' href='nop_bt.php?id=" . $row[0] . "'> Submit </a> </th>";
    $assignment_list .= "<th>" . $sub . "</th>";
    $assignment_list .= "</tr>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách bài tập</title>
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
    <div class="content" id="assignment">
        <div class="assignment-list">
            <table>
                <tr>
                    <th>Tên bài tập</th>
                    <th>Download</th>
                    <th>Nộp bài</th>
                    <th>Đã nộp</th>
                </tr>
                <?php
                echo $assignment_list;
                ?>
            </table>
        </div>
    </div>

</body>

</html>