<?php
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}

require dirname(__DIR__) . "/util/connection.php";

$procedureCall = "CALL GetAllTransactions";
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
  <title>Sewa Buku</title>
</head>

<body>
  <?php require "navbar.php" ?>

  <!-- Container Start -->
  <div class="container mt-2">
    <div class="my-4">
      <h1>Semua Transaksi</h1>
    </div>

    <div>
      <table class="table table-dark rounded-3 overflow-hidden table-borderless table-striped text-center" cellpadding="10" cellspacing="0">
        <tbody>
          <tr>
            <th scope="col">ID Transaksi</th>
            <th scope="col">Judul Buku</th>
            <th scope="col">Nama Anggota</th>
            <th scope="col">Tanggal Pinjam</th>
            <th scope="col">Tanggal Pengembalian</th>
            <th scope="col">Aksi</th>
          </tr>
          <?php $i = 1; ?>
          <?php foreach ($transactions as $row) : ?>
            <tr>
              <td><?= $row["id"]; ?></td>
              <td><?= $row["title"]; ?></td>
              <td><?= $row["name"]; ?></td>
              <td><?= $row["borrow_date"]; ?></td>
              <td><?= $row["return_date"]; ?></td>
              <td>
                <a type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#returnModal<?= $row["id"]; ?>">Kembalikan</a>
                <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row["id"]; ?>">Hapus</a>
              </td>
            </tr>

            <!-- Modal Kembalikan -->
            <div class="modal fade" id="returnModal<?= $row["id"]; ?>" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="returnModalLabel">Form Pengembalian Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="return_book_process.php" method="post">
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

            <!-- Modal Konfirmasi Hapus -->
            <div class="modal fade" id="deleteModal<?= $row["id"]; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Apakah Anda yakin ingin menghapus transaksi ini?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a type="button" class="btn btn-danger" href="delete_transaction.php?id=<?= $row["id"]; ?>">Hapus</a>
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

  <!-- Footer Start -->
  <footer class="bg-dark text-light text-center">
    <hr />
    <p>©2024 | David</p>
    <hr />
  </footer>
  <!-- Footer End -->

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>