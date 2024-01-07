<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

require dirname(__DIR__) . "/util/connection.php";

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$idBook = $_GET['id'];

$modal = false;
$message = "Gagal diupdate!";

global $conn;
$result = mysqli_query($conn, "SELECT * FROM books WHERE id = '$idBook'");
$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}

$book = $rows[0];
// var_dump($book);
// die();

$message = "";

if (isset($_POST["update-book"])) {
    global $conn;
    $idBook = $_GET["id"];
    $title = $_POST["title"];
    $author = $_POST["author"];
    $stock = $_POST["stock"];
    $publishedDate = $_POST["published-date"];

    $query = "UPDATE books SET title = '$title', author = '$author', stock = '$stock', published_date = '$publishedDate' WHERE id = '$idBook'";
    mysqli_query($conn, $query);
    $rowAffected = mysqli_affected_rows($conn);

    if ($rowAffected > 0) {
        $idBook = $_GET["id"];
        header("Location: index.php?update=true&id='{$idBook}'");
    } else {
        $alertType = "alert-danger";
        $message = "Gagal diupdate <br>";
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
    <title>Update Buku</title>
</head>

<body>
    <?php require "navbar.php" ?>
    <div class="container">
        <div class="my-4">
            <h1>Edit Buku</h1>
        </div>
        <div>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $book['id'] ?>">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" name="title" class="form-control" id="title" autocomplete="off" value="<?= $book['title'] ?>">
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label">Penulis</label>
                    <input type="text" name="author" class="form-control" id="author" autocomplete="off" value="<?= $book['author'] ?>">
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stok</label>
                    <input type="number" name="stock" class="form-control" id="stock" autocomplete="off" value="<?= $book['stock'] ?>">
                </div>
                <div class="mb-3">
                    <label for="published-date" class="form-label">Tanggal Terbit</label>
                    <input type="date" name="published-date" class="form-control" id="published-date" autocomplete="off" value="<?= $book['published_date'] ?>">
                </div>
                <button type="submit" name="update-book" class="btn btn-primary">Update Buku</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>