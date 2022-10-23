<?php
session_start();
include("../connectSQL.php");
$title = $hint = "";
$avatar = $_SESSION["avatar"];

if (isset($_GET["id"])) {
    $chal_id = $_GET["id"];
    $sql = "SELECT * FROM game WHERE id = '$chal_id'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        $id = $row[0];
        $title = $row[1];
        $hint = $row[3];
    }
}

if (isset($_POST["submit"])) {
    $result = $_POST["result"];
    $folder = "../game/";
    $list = scandir($folder);
    $len = count($list);
    for ($i = 0; $i < $len; $i++) {
        $arr = explode('.', $list[$i]);
        if ($title == $arr[0] && $result == $arr[1]) {
            $dapan = $list[$i];
            break;
        }
    }
    if (empty($dapan)) {
        $err = "Câu trả lời sai";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết game</title>
    <link rel="stylesheet" href="student.css">
    <script src="https://kit.fontawesome.com/50e4937a61.js" crossorigin="anonymous"></script>
</head>

<body class="conf">
    <div class="sidebar">
        <div class="code">Sinh viên</div>
        <ul class="menu">
            <li>
                <a href="" class="chon"> <img class="avatar" src="<?php echo $avatar ?>"><?php echo "<div>" . $_SESSION["username"] . "</div>"; ?> </a>
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
    <div class="con">
        <a href="ds_game.php" class="add">Trở lại</a>
        <form class="nop_game" action="" method="post" enctype="multipart/form-data">
            <p style="text-align:center;">Tên game: <?php echo $title; ?></p>
            <span style="text-align:center;display:block; margin-bottom: 10px;">Gợi ý: <?php echo $hint; ?> </span>
            <span style="text-align:center;display:block;">Câu trả lời:</span>
            <input class="ipn" type="input" id="result" name="result"><br><br>
            <?php
            if (!(empty($err))) {
                echo "<div class='error' style='background: black; padding: 10px; text-align: center; border-radius:10px;'>" . $err . "</div>";
            }
            ?>
            <input type="submit" value="Submit" name="submit"><br><br>
        </form>
        <?php
        if (!empty($dapan)) {
            echo '<div>
            <p style="margin-top: 40px;">Nội dung file</p>
            <div class="true">';
        } ?>
        <?php
        if (!empty($dapan)) {
            $file = fopen("../game/" . $dapan, "r");
            while (!feof($file)) {
                echo fgets($file) . "<br />";
            }
            fclose($file);
        }
        ?>
        <?php
        if (!empty($dapan)) echo '</div>';
        ?>
    </div>
    </div>

</body>

</html>