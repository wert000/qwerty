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

  // jika hasilnya hanya satu data
  if (mysqli_num_rows($result) == 1) {
    return mysqli_fetch_assoc($result);
  }


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

function tambah($data)
{
  $conn = koneksi();

  $nama = htmlspecialchars($data['nama']);
  $nrp = htmlspecialchars($data['nrp']);
  $email = htmlspecialchars($data['email']);
  $jurusan = htmlspecialchars($data['jurusan']);
  $gambar = htmlspecialchars($data['gambar']);
  $query = "INSERT INTO mahasiswa VALUES
  (null,'$nama','$nrp', '$email', '$jurusan', '$gambar')";
  mysqli_query($conn, $query) or die(mysqli_error($conn));
  echo mysqli_error($conn);
  return mysqli_affected_rows($conn);
}

function hapus($id)
{
  // or die(mysqli_error($conn)) = menampilkan pesan salah dalam menjalankan query
  $conn = koneksi();
  mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id") or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

function ubah($data)
{
  $conn = koneksi();

  $id = htmlspecialchars($data['id']);
  $nama = htmlspecialchars($data['nama']);
  $nrp = htmlspecialchars($data['nrp']);
  $email = htmlspecialchars($data['email']);
  $jurusan = htmlspecialchars($data['jurusan']);
  $gambar = htmlspecialchars($data['gambar']);
  $query = "UPDATE mahasiswa SET 
              nama ='$nama',
              nrp = '$nrp',
              email ='$email',
              jurusan ='$jurusan',
              gambar ='$gambar'
              WHERE id=$id";
  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

function cari($keyword)
{
  $conn = koneksi();
  $query = "SELECT * FROM mahasiswa 
            WHERE 
            nama LIKE '%$keyword%' OR
            nrp LIKE '%$keyword%'";

  $result = mysqli_query($conn, $query);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}

function login($data)
{
  $conn = Koneksi();
  $username = htmlspecialchars($data['username']);
  $password = htmlspecialchars($data['password']);

  // cek dulu username
  if ($user = query("SELECT * FROM user WHERE username ='$username'")) {
    // cek password
    if (password_verify($password, $user['password'])) {
      // set seassion
      $_SESSION['login'] = true;

      header("location: index.php");
      exit;
    }
  }
  return [
    'error' => true,
    'pesan' => 'Username/Password Salah!'
  ];
}


function registrasi($data)
{
  $conn = Koneksi();

  $username = htmlspecialchars(strtolower($data['username']));
  $password1 = mysqli_real_escape_string($conn, $data['password1']);
  $password2 = mysqli_real_escape_string($conn, $data['password2']);

  // jika username / password kosong
  if (empty($username) || empty($password1) || empty($password2)) {
    echo "<script>
            alert('username / password tidak boleh kosong');
            document.location.href = registrasi.php;
          </script>";
    return false;
  }

  // jika username /password sudah ada
  if (query("SELECT * FROM user WHERE username = '$username'")) {
    echo "<script>
            alert('username sudah terdaftar');
            document.location.href = registrasi.php;
          </script>";
    return false;
  }

  // jika konfirmasi password tidak sesuai
  if ($password1 !== $password2) {
    echo "<script>
              alert('konfirmasi password tidak sesuai');
              document.location.href = registrasi.php;
          </script>";
    return false;
  }

  // jika password < 5 digit
  if (strlen($password1) < 5) {
    echo "<script>
              alert('password terlalu pendek');
              document.location.href = registrasi.php;
          </script>";
    return false;
  }

  // jika username dan password sudah sesuai
  // enkripsi password
  // php.net(mengenai algoritma enkripsi) password_hash
  $password_baru = password_hash($password1, PASSWORD_DEFAULT);
  // insert ke table user
  $query = "INSERT INTO user VALUES (null, '$username', '$password_baru')";
  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}
