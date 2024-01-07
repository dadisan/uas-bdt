<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

require dirname(__DIR__) . "/util/connection.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    global $conn;
    $query = "DELETE FROM books WHERE id=$id";
    mysqli_query($conn, $query);
}

header("Location: index.php");
exit();
