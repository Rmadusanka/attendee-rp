<?php
require "config/config.php";

$error = "";

if (isset($_POST['submit'])) {
    $username = "";
    $password = "";

    if (isset($_POST['username']) && $_POST['password']) {
        $username = $_POST['username'];
        $password = $_POST['password'];
    } else {
        $error = 'Something went wrong';
    }

    if ($username && $password) {

        $sql = "SELECT * FROM login WHERE username='" . $username . "' AND password='" . md5($password) . "'";
        $query = mysqli_query($conn, $sql) or die("There is an login error");
        $res = mysqli_fetch_array($query);
        if (!empty($res['username']) && !empty($res['password'])) {
            session_start();
            $_SESSION['attendee'] = $res['username'];
            header('location:main.php');
        } else {
            $error = "Invaild username or password";
        }
    } else {
        $error = "Please Enter Username and Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div>
        <div>
            <?php echo $error; ?>
        </div>
        <form action="index.php" method="post">
            <input type="text" name="username">
            <input type="password" name="password">
            <input type="submit" name="submit">
        </form>
    </div>
</body>

</html> 