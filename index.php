<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        form {
            border: 3px solid white;
        }

        input[type=text],
        input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
        }
    </style>
    <title>Đăng nhập</title>
</head>

<body class="conf">
    <?php
    session_start();
    include_once("connectSQL.php");
    if ((isset($_POST['user']) || isset($_POST["pass"]))) {
        if (!((empty($_POST['user']) || empty($_POST["pass"])))) {
            $user = trim($_POST['user']);
            $pass = md5(trim($_POST['pass']));
            // f83e69e4170a786e44e3d32a2479cce9
            $sql = "SELECT * FROM sv WHERE username = '$user' AND pass = '$pass'";
            $res = $conn->query($sql);
            $row = $res->fetch_array(MYSQLI_NUM);
            if (empty($row[0])) {
                $err = "Sai user or pass";
            } else {
                $_SESSION["id"] = $row[0];
                $_SESSION["username"] = $row[1];
                $_SESSION["code"] = $row[3];
                if ($row[3] == 1) {
                    header("location: ./teacher/teacher.php");
                    exit();
                } else {
                    header("location: ./student/student.php");
                    exit();
                }
            }
            mysqli_close($conn);
        }
    }
    ?>

    <form class="page" action="" method="post">
        <div class="container">
            <label>
                <b>Tên đăng nhập</b>
                <input type="text" name="user" placeholder="Nhập tên đăng nhập"><br>
            </label>
            <label>
                <b>Mật khẩu</b>
                <input type="password" name="pass" placeholder="Nhập mật khẩu" onmouseover="change_t(this)" onmouseout="change_p(this)"><br>
            </label>
            <?php
            if ((isset($_POST['user']) || isset($_POST["pass"]))) {
                if ((empty($_POST['user']) || empty($_POST["pass"]))) {
                    echo "<div class='error'>Nhập đủ user và pass</div>";
                }
            }
            ?>
            <?php
            if (!empty($err))
                if ($err === "Sai user or pass")
                    echo "<div class='error'>" . $err . "</div>";
            ?>
            <button class="submit" type="submit" value="Login">Login</button>
        </div>
    </form>
    <script>
        function change_t(a){
            a.type="text"
        }
        function change_p(a){
            a.type="password"
        }
    </script>
</body>

</html>