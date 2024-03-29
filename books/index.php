<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

require dirname(__DIR__) . "/util/connection.php";

global $conn;
$result = mysqli_query($conn, "SELECT * FROM books");
$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}

$books = $rows;
$alert = false;
$message = "";
$keyword = '';

if (isset($_GET["delete"])) {
    $alert = true;
    $alertType = $_GET["delete"] == "true" ? "alert-success" : "alert-danger";
    $idMember = $_GET["id"];
    $message = $_GET["delete"] == "true" ? "Id Buku $idMember berhasil dihapus!" : "Id Buku $idMember gagal dihapus!";
};

if (isset($_GET["update"])) {
    $alert = true;
    $alertType = $_GET["update"] == "true" ? "alert-success" : "alert-danger";
    $idMember = $_GET["id"];
    $message = $_GET["update"] == "true" ? "Id Buku $idMember berhasil diupdate!" : "Id Buku $idMember gagal diupdate!";
};

if (isset($_POST["search"])) {
    $keyword = $_POST["keyword"];
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM books WHERE title LIKE '%$keyword%' OR author LIKE '%$keyword%'");
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    $books = $rows;
}
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

    <title>Daftar Buku</title>
</head>

<body>
    <?php require "navbar.php" ?>
    <div class="container">
        <div class="my-4">
            <h1>Daftar Buku</h1>
            <?php if ($alert) { ?>
                <div class="alert <?= $alertType ?> alert-dismissible fade show" role="alert">
                    <?= $message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>
        </div>
        <div class="mb-4 row">
            <div class="col">
                <a type="button" class="btn btn-success" href="add.php">Tambah Buku</a>
            </div>
        </div>

        <div class="my-4 container-fluid">
            <form class="d-flex" role="search" method="post">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" autocomplete="off" name="keyword" value="<?= $keyword ?>">
                <button class="btn btn-outline-success" type="submit" name="search">Search</button>
            </form>
        </div>

        <div>
            <table class="table table-dark rounded-3 overflow-hidden table-borderless table-striped text-center" cellpadding="10" cellspacing="0">
                <tbody>
                    <tr>
                        <th scope="row">No</th>
                        <th scope="row">Judul</th>
                        <th scope="row">Penulis</th>
                        <th scope="row">Stok</th>
                        <th scope="row">Tanggal Terbit</th>
                        <th scope="row">Aksi</th>
                    </tr>
                    <?php $i = 1; ?>
                    <?php foreach ($books as $row) : ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row["title"]; ?></td>
                            <td><?= $row["author"]; ?></td>
                            <td><?= $row["stock"]; ?></td>
                            <td><?= $row["published_date"]; ?></td>
                            <td>
                                <a type="button" class="btn btn-warning" href="update.php?id=<?= $row["id"]; ?>">Update</a>
                                <a type="button" class="btn btn-danger" href="delete.php?id=<?= $row["id"]; ?>" onclick="return confirm('Apakah anda yakin?')">Hapus</a>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        let alert = document.querySelector(".alert");
        window.setTimeout(function() {
            alert.classList.remove("show");
        }, 5000);
        window.setTimeout(function() {
            alert.remove();
        }, 5300);
    </script>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>