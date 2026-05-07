<?php

header("Content-Type: application/json");

include 'koneksi.php';

$method = $_SERVER['REQUEST_METHOD'];


// ================= READ =================
if ($method == 'GET') {

    // GET BY ID
    if (isset($_GET['id'])) {

        $id = $_GET['id'];

        $query = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id'");
        $data = mysqli_fetch_assoc($query);

        echo json_encode($data);

    } else {

        // GET ALL
        $query = mysqli_query($koneksi, "SELECT * FROM users");

        $result = [];

        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }

        echo json_encode($result);
    }
}



// ================= CREATE =================
elseif ($method == 'POST') {

    $nama  = $_POST['nama'];
    $sandi = $_POST['sandi'];

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

    parse_str(file_get_contents("php://input"), $_PUT);

    $id    = $_PUT['id'];
    $nama  = $_PUT['nama'];
    $sandi = $_PUT['sandi'];

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

    parse_str(file_get_contents("php://input"), $_DELETE);

    $id = $_DELETE['id'];

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
