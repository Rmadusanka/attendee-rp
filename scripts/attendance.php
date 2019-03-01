<?php

    if (isset($_POST['data'])) {
        require "../config/config.php";
        $select_sql = "Select * FROM participant WHERE qr='" .$_POST['data']. "'";
        $select_query = mysqli_query($conn, $select_sql) or die (mysql_error());
        $row = mysqli_num_rows($select_query);
        if ($row) {
            $res = mysqli_fetch_array($select_query);
            if (!$res['status']) {
                $sql = "UPDATE participant SET status=1 WHERE qr='" .$_POST['data']. "'";

                if (mysqli_query($conn, $sql)) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . mysqli_error($conn);
                }     
            } else {
                echo "User already added";
            }
                   
        } else {
            echo "User not found.";
        }

        mysqli_close($conn);
    }

?>