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

$idMember = $_GET["id"];

$modal = false;
$message = "Gagal diupdate!";

global $conn;
$result = mysqli_query($conn, "SELECT * FROM members WHERE id = '$idMember'");
$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}
$member = $rows[0];

$message = "";

if (isset($_POST["update-member"])) {
    global $conn;
    $idMember = $_GET["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];

    $query = "UPDATE members SET name = '$name', email = '$email' WHERE id = '$idMember'";
    mysqli_query($conn, $query);
    $rowAffected = mysqli_affected_rows($conn);

    if ($rowAffected > 0) {
        $idMember = $_GET["id"];
        header("Location: index.php?update=true&id='{$idMember}'");
    } else {
        $alertType = "alert-danger";
        $message = "Gagal diupdate <br>";
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

    <title>Update Anggota</title>
</head>

<body>
    <?php require "navbar.php" ?>
    <div class="container">
        <div class="my-4">
            <h1>Ubah Anggota</h1>
            <?php if ($message) { ?>
                <div class="alert <?= $alertType ?> alert-dismissible fade show" role="alert">
                    <?= $message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>
        </div>
        <div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" id="name" autocomplete="off" value="<?= $member["name"] ?>">
                </div>
                <div class=" mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" autocomplete="off" value="<?= $member["email"] ?>">
                </div>
                <button type=" submit" name="update-member" class="btn btn-success">Update Anggota</button>
            </form>
        </div>
    </div>

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