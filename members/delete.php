<?php
session_start();

require dirname(__DIR__) . "/util/connection.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = $_GET["id"];
global $conn;
mysqli_query($conn, "DELETE FROM members WHERE id = '$id'");

$rowAffected = mysqli_affected_rows($conn);

if ($rowAffected > 0) {
    header("Location: index.php?delete=true&id=$id");
} else {
    header("Location: index.php?delete=false&id=$id");
}
exit();
