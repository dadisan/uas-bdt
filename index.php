<?php
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}

require "./util/connection.php";

$procedureCall = "CALL GetUnreturnedTransactions()";
global $conn;
$result = mysqli_query($conn, $procedureCall);
$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
  $rows[] = $row;
}

$transactions = $rows;
// var_dump($transactions);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
  <title>Peminjaman Buku</title>
</head>

<body>
  <?php require "navbar.php" ?>
  <?php require "header.php" ?>

  <!-- Container Start -->
  <div class="container mt-2">

    <div class="d-flex justify-content-between mb-3">
      <!-- Tombol Pinjam Buku -->
      <a href="./transactions/borrow_book.php" class="btn btn-success">Pinjam Buku</a>
      <!-- Tombol Lihat Semua Transaksi -->
      <a href="./transactions/index.php" class="btn btn-primary">Lihat Semua Transaksi</a>
    </div>

    <div>
      <table class="table table-dark rounded-3 overflow-hidden table-borderless table-striped text-center" cellpadding="10" cellspacing="0">
        <tbody>
          <tr>
            <th scope="col">ID Transaksi</th>
            <th scope="col">Judul Buku</th>
            <th scope="col">Nama Anggota</th>
            <th scope="col">Tanggal Pinjam</th>
            <th scope="col">Aksi</th>
          </tr>
          <?php $i = 1; ?>
          <?php foreach ($transactions as $row) : ?>
            <tr>
              <td><?= $row["id"]; ?></td>
              <td><?= $row["title"]; ?></td>
              <td><?= $row["name"]; ?></td>
              <td><?= $row["borrow_date"]; ?></td>
              <td>
                <a type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#returnModal<?= $row["id"]; ?>">Kembalikan</a>
              </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="returnModal<?= $row["id"]; ?>" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="returnModalLabel">Form Pengembalian Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="./transactions/return_book_process.php" method="post">
                      <div class="mb-3">
                        <label for="return_date" class="form-label">Tanggal Pengembalian</label>
                        <input type="date" name="return_date" class="form-control" id="return_date" required value="<?= date('Y-m-d') ?>">
                      </div>
                      <input type="hidden" name="transaction_id" value="<?= $row["id"]; ?>">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <?php $i++; ?>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- Container End -->

  <?php require "footer.php" ?>
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>