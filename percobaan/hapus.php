<?php

require 'function.php';

// jika tidak id di url
if (!isset($_GET['id'])) {
  header("location: index.php");
  exit;
}

// mengunakan id untuk supaya tau data mana yang ingin di hapus jika tidak memiliki parameter maka data akan terhapus semua
// mengambil id dari url
$id = $_GET['id'];

if (hapus($id) > 0) {
  echo "<script>
          alert ('data berhasil dihapus');
          document.location.href= 'index.php';
        </script>";
} else {
  echo "alert('data gagal dihapus')";
}
