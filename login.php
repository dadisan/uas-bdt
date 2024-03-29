<?php
session_start();
require_once "./util/connection.php";

if (isset($_SESSION['id'])) {
  header("Location: index.php");
  exit();
}

function validate($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$error = "";

if (isset($_POST['username']) && isset($_POST['password'])) {
  $username = validate($_POST['username']);
  $password = validate($_POST['password']);

  $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = mysqli_query($conn, $sql);
  mysqli_close($conn);

  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    if ($row['username'] === $username && $row['password'] === $password) {
      $_SESSION['username'] = $row['username'];
      $_SESSION['id'] = $row['id'];
      header("Location: index.php");
      exit();
    }
  } else {
    $error = "Incorect username or password!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
  <title>Login</title>
</head>

<body>
  <?php require "header.php" ?>
  <div class="container ">
    <div class="mt-3 d-flex justify-content-center">
      <h1>Login</h1>
    </div>
    <div class="d-flex justify-content-center">
      <div class="col-md-4 mt-3">
        <?php if ($error != "") { ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php } ?>
        <form action="login.php" method="POST" class="p-4 bg-dark text-white rounded-3">
          <div class="mb-2">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required autofocus />
          </div>
          <div class="mb-2">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" password="password" name="password" required />
          </div>
          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-success">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php require "footer.php" ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>