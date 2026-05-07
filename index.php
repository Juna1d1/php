<?php

header("Content-Type: application/json");

include 'koneksi.php';

$method = $_SERVER['REQUEST_METHOD'];


// ================= READ =================
if ($method == 'GET') {

    if (isset($_GET['id'])) {

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

        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }

        echo json_encode($result);
    }
}



// ================= CREATE =================
elseif ($method == 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);

    $nama  = $data['nama'];
    $sandi = $data['sandi'];

    $query = mysqli_query($koneksi,
        "INSERT INTO users(nama, sandi)
         VALUES('$nama','$sandi')"
    );

    if ($query) {

        echo json_encode([
            "status" => "success",
            "message" => "Data berhasil ditambah"
        ]);

    } else {

        echo json_encode([
            "status" => "error",
            "message" => mysqli_error($koneksi)
        ]);
    }
}



// ================= UPDATE =================
elseif ($method == 'PUT') {

    $data = json_decode(file_get_contents("php://input"), true);

    $id    = $data['id'];
    $nama  = $data['nama'];
    $sandi = $data['sandi'];

    $query = mysqli_query($koneksi,
        "UPDATE users
         SET nama='$nama', sandi='$sandi'
         WHERE id='$id'"
    );

    if ($query) {

        echo json_encode([
            "status" => "success",
            "message" => "Data berhasil diupdate"
        ]);

    } else {

        echo json_encode([
            "status" => "error",
            "message" => mysqli_error($koneksi)
        ]);
    }
}



// ================= DELETE =================
elseif ($method == 'DELETE') {

    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data['id'];

    $query = mysqli_query($koneksi,
        "DELETE FROM users WHERE id='$id'"
    );

    if ($query) {

        echo json_encode([
            "status" => "success",
            "message" => "Data berhasil dihapus"
        ]);

    } else {

        echo json_encode([
            "status" => "error",
            "message" => mysqli_error($koneksi)
        ]);
    }
}

?>
