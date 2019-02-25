<?php
session_start();
if (isset($_SESSION['attendee'])) {
    $username = $_SESSION['attendee'];
} else {
    header('location:index.php');
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
        <a href="addDetails.php">Add users</a>
        <a href="scanView.php">Mark attendence</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="scripts/logout.php">Logout</a>
    </div>
</body>

</html> 