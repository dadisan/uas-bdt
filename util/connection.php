<?php

$HOST = "localhost"; // <- ubah ini
$USERNAME = "root"; // <- ubah ini
$PASSWORD = "dapid000"; // <- ubah ini
$DATABASE = "perpustakaan"; // <- ubah ini

// Create connection
$conn = mysqli_connect($HOST, $USERNAME, $PASSWORD, $DATABASE);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//   echo "Connected successfully";
