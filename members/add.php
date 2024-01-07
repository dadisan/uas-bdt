<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}
require dirname(__DIR__) . "/util/connection.php";

$modal = false;
$message = "Gagal ditambahkan!";
$name = "";
$email = "";

if (isset($_POST["add-member"])) {
    $modal = true;
    $name = $_POST["name"];
    $email = $_POST["email"];

    global $conn;
    $query = "INSERT INTO members (name, email) VALUES ('$name', '$email')";
    mysqli_query($conn, $query);
    $rowAffected = mysqli_affected_rows($conn);

    if ($rowAffected > 0) {
        $message = "Berhasil ditambahkan!";
    } else {
        $name = $_POST["name"];
        $email = $_POST["email"];
    }
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/mystyle.css">

    <title>Tambah Anggota</title>
</head>

<body>
    <?php require "navbar.php" ?>
    <div class="container">
        <div class="my-4">
            <h1>Tambah Anggota</h1>
        </div>
        <div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class=" mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" id="name" autocomplete="off" value="<?= $name ?>">
                </div>
                <div class=" mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" autocomplete="off" value="<?= $email ?>">
                </div>
                <button type="submit" name="add-member" class="btn btn-success">Tambah Anggota</button>
            </form>
        </div>
    </div>
    <?php

    if ($modal) { ?>
        <!-- Modal -->
        <div class="modal fade" id="add-member-modal" tabindex="-1" aria-labelledby="add-member-modal-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="add-member-modal-label">Konfirmasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?= $message ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <a href="index.php" type="button" class="btn btn-primary">Daftar Anggota</a>
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
            let itemAddModal = new bootstrap.Modal(document.getElementById("add-member-modal"));
            itemAddModal.show();
        }
    </script>

    <?php
    if ($modal) {
        echo "<script> showModal(); </script>";
    };
    ?>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>