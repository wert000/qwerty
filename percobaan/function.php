<?php
function koneksi()
{
  // koneksi ke database
  return mysqli_connect('localhost', 'root', '', 'querty_data');
}

function query($query)
{
  $conn = koneksi();
  // query isi table mahasiswa
  $result = mysqli_query($conn, $query);

  // ubah data ke dalam array
  // $row = mysqli_fetch_row($result); //array numerik
  // $row = mysqli_fetch_assoc($result); //array associative
  // $row = mysqli_fetch_array($result); //gabungan mysqli_fetch_row dan mysqli_fetch_assoc
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    // mengisi row kosong
    $rows[] = $row;
  }

  return $rows;
}
