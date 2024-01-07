<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

require dirname(__DIR__) . "/util/connection.php";

$modal = false;
$message = "Gagal ditambahkan!";
$title = "";
$author = "";
$stock = "";
$published_date = "";

if (isset($_POST["add-book"])) {
    $modal = true;
    $title = $_POST["title"];
    $author = $_POST["author"];
    $stock = $_POST["stock"];
    $published_date = $_POST["published_date"];

    echo $published_date;

    global $conn;
    $query = "INSERT INTO books (title, author, stock, published_date) VALUES ('$title', '$author', $stock, '$published_date')";
    mysqli_query($conn, $query);
    $rowAffected = mysqli_affected_rows($conn);

    if ($rowAffected > 0) {
        $message = "Berhasil ditambahkan!";
    } else {
        $title = $_POST["title"];
        $author = $_POST["author"];
        $stock = $_POST["stock"];
        $published_date = $_POST["published_date"];
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
            <h1>Tambah Buku</h1>
        </div>
        <div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" name="title" class="form-control" id="title" autocomplete="off" value="<?= $title ?>">
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label">Penulis</label>
                    <input type="text" name="author" class="form-control" id="author" autocomplete="off" value="<?= $author ?>">
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stok</label>
                    <input type="number" name="stock" class="form-control" id="stock" autocomplete="off" value="<?= $stock ?>">
                </div>
                <div class="mb-3">
                    <label for="published_date" class="form-label">Tanggal Terbit</label>
                    <input type="date" name="published_date" class="form-control" id="published_date" autocomplete="off" value="<?= $published_date ?>">
                </div>
                <button type="submit" name="add-book" class="btn btn-success">Tambah Buku</button>
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
                        <a href="index.php" type="button" class="btn btn-primary">Daftar Buku</a>
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