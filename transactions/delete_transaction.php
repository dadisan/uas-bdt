<?php
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}
require dirname(__DIR__) . "/util/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
  $transactionId = $_GET["id"];

  // Lakukan operasi penghapusan transaksi
  $query = "DELETE FROM transactions WHERE id = $transactionId";
  $result = mysqli_query($conn, $query);

  if ($result) {
    header("Location: index.php");
    exit();
  } else {
    echo "Gagal menghapus transaksi.";
  }
}
