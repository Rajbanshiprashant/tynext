<?php
$conn = mysqli_connect("localhost", "root", "", "trynext");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
