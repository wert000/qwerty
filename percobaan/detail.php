<?php
require 'function.php';

// ambil id dari url

$id = $_GET['id'];

$mahasiswa = query("SELECT * FROM mahasiswa WHERE id=$id");

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Mahasiswa</title>
</head>

<body>
  <h3>Detail Mahasiswa</h3>
  <ul>
    <li>
      <img src="">
    </li>
  </ul>

</body>

</html>