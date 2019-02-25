<?php

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
        <h3>Create Branch</h3>
        <form action="addDetails.php" method="post">
            <input type="text" name="branchId">
            <input type="text" name="branchName">
            <input type="text" name="branchLocation">
            <input type="submit" name="branch">
        </form>
    </div>

    <div>
        <h3>Add Participent</h3>
        <form action="addDetails.php" method="post">
            <input type="text" name="participentId">
            <input type="text" name="firstName">
            <input type="text" name="lastName">
            <select name="participentBranchId">
                <option value=""></option>
            </select>
            <input type="submit" name="participent">
        </form>
    </div>

    <div>
        <h3>Add Participents</h3>
        <form action="addDetails.php" method="post">
            <input type="file" name="participentsCSV">
            <input type="submit" name="participents">
        </form>
    </div>
</body>

</html> 