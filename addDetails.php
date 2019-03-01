<?php
require "config/config.php";
session_start();
if (isset($_SESSION['attendee'])) {
    $username = $_SESSION['attendee'];
} else {
    header('location:index.php');
}

$error = "";

if (isset($_POST['branch'])) {
    $branchId = "";
    $branchName = "";
    $branchLocation = "";

    if ($_POST['branchId']) {
        $branchId = $_POST['branchId'];
    } else {
        $error = "Empty branch ID";
    }
    if ($_POST['branchName']) {
        $branchName = $_POST['branchName'];
    } else {
        $error = "Empty branch name";
    }
    if ($_POST['branchLocation']) {
        $branchLocation = $_POST['branchLocation'];
    } else {
        $error = "Empty branch location";
    }

    if ($branchId && $branchName && $branchLocation) {
        $branchSql = "INSERT INTO `branch` (`branchName`, `location`, `branchId`) VALUES ('".$branchId."', '".$branchName."', '".$branchLocation."');";
        if (mysqli_query($conn, $branchSql)) {
            echo "New record created successfully";
            header('location:addDetails.php');
        } else {
            echo "Error: " . $branchSql . "<br>" . mysqli_error($conn);
        }
        
        mysqli_close($conn);
    }
}

if (isset($_POST['participent'])) {
    $participentId = "";
    $firstName = "";
    $lastName = "";
    $participentBranchId = "";

    if ($_POST['participentId']) {
        $participentId = $_POST['participentId'];
    } else {
        $error = "Empty participent ID";
    }
    if ($_POST['firstName']) {
        $firstName = $_POST['firstName'];
    } else {
        $error = "Empty first name";
    }
    if ($_POST['lastName']) {
        $lastName = $_POST['lastName'];
    } else {
        $error = "Empty last name";
    }
    if ($_POST['participentBranchId']) {
        $participentBranchId = $_POST['participentBranchId'];
    } else {
        $error = "Empty branch location";
    }

    if ($participentId && $firstName && $lastName && $participentBranchId) {
        $qrcode = "";
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $qrcode .= $characters[rand(0, $charactersLength - 1)];
        }

        $participentSql = "INSERT INTO `participant` (`participantId`, `firstName`, `lastName`, `qr`, `branchId`, `status`) VALUES ('".$participentId."', '".$firstName."', '".$lastName."', '".$qrcode."', '".$participentBranchId."', 0);";
        if (mysqli_query($conn, $participentSql)) {
            echo "New record created successfully";
            header('location:addDetails.php');
        } else {
            echo "Error: " . $participentSql . "<br>" . mysqli_error($conn);
        }
        
        mysqli_close($conn);
    }
    header('location:addDetails.php');
}

if (isset($_POST["participents"])) {
    $participantsBranchId = "";
    if ($_POST['participantsBranchId']) {
        $participantsBranchId = $_POST['participantsBranchId'];
    } else {
        $error = "Empty branch location";
    }

    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        $skip = TRUE;
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            
            if ($skip) {
                $skip = FALSE;
                continue;
            }
            $qrcode = "";
            $length = 10;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $qrcode .= $characters[rand(0, $charactersLength - 1)];
            }

            $sqlInsert = "INSERT into participant (participantId,firstName,lastName,qr,branchId,status) values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $qrcode . "', '" . $participantsBranchId . "', 0)";
            $result = mysqli_query($conn, $sqlInsert);
            
            if (! empty($result)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        }
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
    <a href="main.php">Home</a>
    <a href="scripts/logout.php">Logout</a>
    <div>
        <h3>Create Branch</h3>
        <form action="addDetails.php" method="post">
            <input type="text" name="branchId" placeholder="Branch ID">
            <input type="text" name="branchName" placeholder="Branch Name">
            <input type="text" name="branchLocation" placeholder="Branch Location">
            <input type="submit" name="branch" value="Add">
        </form>
    </div>

    <div>
        <h3>Add Participent</h3>
        <form action="addDetails.php" method="post">
            <input type="text" name="participentId" placeholder="Participent ID">
            <input type="text" name="firstName" placeholder="First Name">
            <input type="text" name="lastName" placeholder="Last Name">
            <select name="participentBranchId">
                <?php
                    $bhSql="SELECT * FROM `branch`";
                    $bhquery=mysqli_query($conn, $bhSql);
                    while ($bhres=mysqli_fetch_array($bhquery)){
                ?>
                <option value="<?php echo $bhres['branchId']; ?>"><?php echo $bhres['branchName']; ?>(<?php echo $bhres['location']; ?>)</option>
                <?php 
                    }
                ?>
            </select>
            <input type="submit" name="participent" value="add">
        </form>
    </div>

    <div>
        <h3>Add Participents</h3>
        <form action="addDetails.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" id="file" accept=".csv">
            <select name="participantsBranchId">
                <?php
                    $bhSql="SELECT * FROM `branch`";
                    $bhquery=mysqli_query($conn, $bhSql);
                    while ($bhres=mysqli_fetch_array($bhquery)){
                ?>
                <option value="<?php echo $bhres['branchId']; ?>"><?php echo $bhres['branchName']; ?>(<?php echo $bhres['location']; ?>)</option>
                <?php 
                    }
                ?>
            </select>
            <input type="submit" name="participents" value="Add">
        </form>
    </div>
</body>

</html> 