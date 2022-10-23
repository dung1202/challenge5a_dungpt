<?php
session_start();
include("../connectSQL.php");
$challenge_list = $title = $hint = "";
$id = $_SESSION["id"];
// click submit assignment 
if (isset($_POST["submit"])) {
    $title = $_POST["title"];
    $hint = $_POST["hint"];

    if (!empty($title) && !empty($hint)) {
        // check whether chose file yet
        if (!empty($_FILES["file"]["name"])) {
            $targetDir = "../game/";
            $fileNameTmp = basename($_FILES["file"]["name"]);
            $fileName = $title . "." . $fileNameTmp;
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            $allowTypes = array('txt');
            // check format
            if (in_array($fileType, $allowTypes)) {

                if ($_FILES["file"]["size"] > 2097152) {
                    $err = "File của bạn quá lớn";
                } else {
                    // upload file to server
                    if (file_exists("$targetFilePath")) unlink("$targetFilePath");
                    $id = $_SESSION["id"];
                    $sl =  "SELECT * FROM game";
                    $data = $conn->query($sl);
                    $sl = (int)$data->num_rows + 1;
                    $sql = "INSERT INTO game (id, id_gv, tieu_de, goi_y, updateon) VALUES('$sl','$id','$title','$hint', NOW())";
                    if ($conn->query($sql) == true) {
                        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                            $err = "Thành công";
                        } else {
                            $err = "Lỗi, xin thử lại";
                        }
                    } else {
                        $err = "Lỗi, xin thử lại";
                    }
                }
            } else {
                $err = "Chỉ nhận file đuôi .txt";
            }
        } else {
            $err = "Cần có file upload";
        }
    } else {
        $err = "Tiêu đề hay gợi ý rỗng";
    }
}

$sql = "SELECT * FROM game WHERE id_gv='$id'";
$result = $conn->query($sql);
while ($row = $result->fetch_array(MYSQLI_NUM)) {
    // process each row
    $challenge_list .= "<tr>";
    $challenge_list .= "<th>" . $row[1] . "</th>";
    $challenge_list .= "<th>" . $row[4] . "</th>";
    $challenge_list .= "</tr>";
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
                <a href="me.php"> <img class="avatar" src="../avatar/giao_vien.jpg"><?php echo "<div>" . $_SESSION["username"] . "</div>"; ?> </a>
            </li>
            <li>
                <a href="teacher.php">Danh sách người dùng</a>
            </li>
            <li>
                <a href="assign.php">Bài tập</a>
            </li>
            <li>
                <a href="" class="chon">Game</a>
            </li>
            <li>
                <a href="../logout.php">Log out</a>
            </li>
        </ul>

    </div>

    <!-- assignment tab -->
    <div class="content" id="assignment">

        <form action="" method="post" enctype="multipart/form-data" class="assignment">
            <label for="title">Tên thử thách:</label>
            <input type="text" id="title" class="ten" name="title" value="<?php echo $title; ?>"><br><br>
            <label for="hint">Gợi ý:</label><br><br>
            <textarea id="hint" class="ten textarea" name="hint" rows="5" cols="45"><?php echo $hint; ?></textarea><br><br>
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
                    <th>Name</th>
                    <th>Update on</th>
                </tr>
                <?php
                echo $challenge_list;
                ?>
            </table>
        </div>
    </div>

</body>

</html>