<?php
session_start();
include("../connectSQL.php");
$challenge_list = "";
$avatar = $_SESSION["avatar"];

$sql = "SELECT * FROM game";
$result = $conn->query($sql);
while($row = $result->fetch_array(MYSQLI_NUM)) { 
    $challenge_list .= "<tr>";
    $challenge_list .= "<th>".$row[1]."</th>";
    $challenge_list .= "<th> <a class='link' href='game_ct.php?id=".$row[0]."'> Xem chi tiết </a> </th>";
    $challenge_list .= "</tr>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách game</title>
    <link rel="stylesheet" href="student.css">
    <script src="https://kit.fontawesome.com/50e4937a61.js" crossorigin="anonymous"></script>
</head>
<body class="conf">
    <div class="sidebar">
        <div class="code">Sinh viên</div>
        <ul class="menu">
            <li>
                <a href="student.php"> <img class="avatar" src="<?php echo $avatar?>"><?php echo "<div>" . $_SESSION["username"] . "</div>"; ?> </a>
            </li>
            <li>
                <a href="ds_user.php">Danh sách người dùng</a>
            </li>
            <li>
                <a href="baitap.php">Bài tập</a>
            </li>
            <li>
                <a href="ds_game.php" class="chon">Game</a>
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
                    <th>Tên game</th>
                    <th>Chi tiết</th>
                </tr>
                <?php 
                    echo $challenge_list;
                ?>
            </table>
        </div>
    </div>

</body>
</html>