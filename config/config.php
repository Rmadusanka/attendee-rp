<?php 
$conn = mysqli_connect("localhost", "root", "", "attendee_rp");
if (!$conn) {
    echo "connection failed" . mysqli_connect_error();
}
 