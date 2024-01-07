<?php
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: ../login.php");
  exit();
}
require dirname(__DIR__) . "/util/connection.php";

$modal = false;
$message = "Gagal ditambahkan!";
$book_id = "";
$member_id = "";
$borrow_date = date('Y-m-d');

// Ambil data buku dari tabel books
$booksQuery = "SELECT id, title FROM available_books";
$booksResult = mysqli_query($conn, $booksQuery);
$books = mysqli_fetch_all($booksResult, MYSQLI_ASSOC);

// Ambil data member dari tabel members
$membersQuery = "SELECT id, name FROM members";
$membersResult = mysqli_query($conn, $membersQuery);
$members = mysqli_fetch_all($membersResult, MYSQLI_ASSOC);


if (isset($_POST["borrow-book"])) {
  $modal = true;
  $book_id = $_POST["book_id"];
  $member_id = $_POST["member_id"];
  $borrow_date = $_POST["borrow_date"];

  global $conn;
  $query = "INSERT INTO transactions (book_id, member_id, borrow_date) VALUES ('$book_id', '$member_id', '$borrow_date')";
  mysqli_query($conn, $query);
  $rowAffected = mysqli_affected_rows($conn);

  if ($rowAffected > 0) {
    $message = "Berhasil ditambahkan!";
  } else {
    $book_id = $_POST["book_id"];
    $member_id = $_POST["member_id"];
    $borrow_date = $_POST["borrow_date"];
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/mystyle.css">
  <title>Tambah Buku</title>
</head>

<body>
  <?php require "navbar.php" ?>
  <div class="container">
    <div class="my-4">
      <h1>Pinjam Buku</h1>
    </div>
    <div>
      <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="book_id" class="form-label">ID Buku</label>
          <select name="book_id" class="form-control">
            <?php foreach ($books as $book) : ?>
              <option value="<?= $book['id'] ?>"><?= $book['title'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label for="member_id" class="form-label">ID Member</label>
          <select name="member_id" class="form-control">
            <?php foreach ($members as $member) : ?>
              <option value="<?= $member['id'] ?>"><?= $member['name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label for="borrow_date" class="form-label">Tanggal Peminjaman</label>
          <input type="date" name="borrow_date" class="form-control" id="borrow_date" autocomplete="off" value="<?= $borrow_date ?>">
        </div>
        <button type="submit" name="borrow-book" class="btn btn-success">Pinjam Buku</button>
      </form>
    </div>
  </div>
  <?php

  if ($modal) { ?>
    <!-- Modal -->
    <div class="modal fade" id="add-buku-modal" tabindex="-1" aria-labelledby="add-buku-modal-label" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="add-buku-modal-label">Konfirmasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?= $message ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <a href="../index.php" type="button" class="btn btn-primary">Sewa Buku</a>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <script>
    function showModal() {
      let itemAddModal = new bootstrap.Modal(document.getElementById("add-buku-modal"));
      itemAddModal.show();
    }
  </script>

  <?php
  if ($modal) {
    echo "<script> showModal(); </script>";
  };
  ?>

  <!-- Bootstrap JS -->
  <!script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></!script>
</body>

</html>