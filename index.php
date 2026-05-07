<?php

include 'koneksi.php';


// ================= CREATE DARI FORM WEB =================
if(isset($_POST['tambah'])){

    $nama  = $_POST['nama'];
    $sandi = $_POST['sandi'];

    mysqli_query($koneksi,
        "INSERT INTO users(nama, sandi)
         VALUES('$nama','$sandi')"
    );

    header("Location: index.php");
    exit;
}


// ================= DELETE DARI WEB =================
if(isset($_GET['hapus'])){

    $id = $_GET['hapus'];

    mysqli_query($koneksi,
        "DELETE FROM users WHERE id='$id'"
    );

    header("Location: index.php");
    exit;
}


// ================= API JSON =================
if(isset($_GET['api'])){

    header("Content-Type: application/json");

    $method = $_SERVER['REQUEST_METHOD'];

    // ===== READ =====
    if($method == 'GET'){

        if(isset($_GET['id'])){

            $id = $_GET['id'];

            $query = mysqli_query($koneksi,
                "SELECT * FROM users WHERE id='$id'"
            );

            $data = mysqli_fetch_assoc($query);

            echo json_encode($data);

        } else {

            $query = mysqli_query($koneksi,
                "SELECT * FROM users"
            );

            $result = [];

            while($row = mysqli_fetch_assoc($query)){
                $result[] = $row;
            }

            echo json_encode($result);
        }
    }


    // ===== CREATE =====
    elseif($method == 'POST'){

        $nama  = $_POST['nama'];
        $sandi = $_POST['sandi'];

        $query = mysqli_query($koneksi,
            "INSERT INTO users(nama,sandi)
             VALUES('$nama','$sandi')"
        );

        echo json_encode([
            "status" => $query ? "success" : "error"
        ]);
    }


    // ===== UPDATE =====
    elseif($method == 'PUT'){

        parse_str(file_get_contents("php://input"), $_PUT);

        $id    = $_PUT['id'];
        $nama  = $_PUT['nama'];
        $sandi = $_PUT['sandi'];

        $query = mysqli_query($koneksi,
            "UPDATE users
             SET nama='$nama', sandi='$sandi'
             WHERE id='$id'"
        );

        echo json_encode([
            "status" => $query ? "success" : "error"
        ]);
    }


    // ===== DELETE =====
    elseif($method == 'DELETE'){

        parse_str(file_get_contents("php://input"), $_DELETE);

        $id = $_DELETE['id'];

        $query = mysqli_query($koneksi,
            "DELETE FROM users WHERE id='$id'"
        );

        echo json_encode([
            "status" => $query ? "success" : "error"
        ]);
    }

    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>CRUD Railway</title>
</head>
<body>

<h2>Tambah User</h2>

<form method="POST">

    <input
        type="text"
        name="nama"
        placeholder="Nama"
        required
    >

    <input
        type="text"
        name="sandi"
        placeholder="Sandi"
        required
    >

    <button type="submit" name="tambah">
        Simpan
    </button>

</form>


<h2>Data Users</h2>

<table>

<tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Sandi</th>
    <th>Aksi</th>
</tr>

<?php

$data = mysqli_query($koneksi,
    "SELECT * FROM users"
);

while($d = mysqli_fetch_assoc($data)){

?>

<tr>

    <td><?= $d['id'] ?></td>
    <td><?= $d['nama'] ?></td>
    <td><?= $d['sandi'] ?></td>

    <td>
        <a href="?hapus=<?= $d['id'] ?>">
            Hapus
        </a>
    </td>

</tr>

<?php } ?>

</table>

</body>
</html>
