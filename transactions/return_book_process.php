<?php
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}

require dirname(__DIR__) . "/util/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $return_date = $_POST["return_date"];
  $transaction_id = $_POST["transaction_id"];

  // Panggil function untuk memperbarui return_date
  $query = "SELECT UpdateReturnDate($transaction_id, '$return_date') AS success";
  $result = mysqli_query($conn, $query);

  if ($result === false) {
    // Penanganan kesalahan eksekusi kueri
    echo "Error: " . mysqli_error($conn);
    exit();
  }

  $row = mysqli_fetch_assoc($result);

  if ($row["success"] == "1") {
    // Redirect ke halaman sebelumnya atau halaman tertentu
    header("Location: ../index.php");
    exit();
  } else {
    echo "Gagal menyimpan return_date ke dalam database.";
  }
}
