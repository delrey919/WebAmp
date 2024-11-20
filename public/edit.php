<?php
require_once __DIR__ . '/../app/controllers/SongController.php';
require_once __DIR__ . '/../app/models/SongModel.php';

$songModel = new SongModel(__DIR__ . '/../app/database.json');
$songController = new SongController($songModel);

$id = $_GET['id'] ?? null;
$songs = $songController->getAllSongs();

if (!is_numeric($id) || !isset($songs[$id])) {
    header('Location: index.php');
    exit;
}

$currentSong = $songs[$id];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'],
        'artist' => $_POST['artist']
    ];

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $data['file'] = $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], __DIR__ . '/uploads/' . $_FILES['file']['name']);
    } else {
        $data['file'] = $currentSong['file'];
    }

    $songController->editSong($id, $data);
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message' => 'Cançó actualitzada correctament']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cançó</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '../views/header.php'; ?>
    <div class="container mt-5">
    <a href="index.php" class="btn btn-warning text-dark">Tornar a l'Inici</a>
        <h1>Editar Cançó</h1>
        <form id="editForm" enctype="multipart/form-data" class="mt-4">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Nom de la Cançó</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($currentSong['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="artist" class="form-label">Artista</label>
                <input type="text" name="artist" id="artist" class="form-control" value="<?= htmlspecialchars($currentSong['artist']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">Fitxer de Cançó</label>
                <input type="file" name="file" id="file" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Guardar Canvis</button>
        </form>
        <a href="index.php" class="btn btn-secondary mt-3">Tornar a l'Inici</a>
        <div id="responseMessage" class="mt-3"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#editForm').on('submit', function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: 'edit.php?id=<?= $id ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.status === 'success') {
                            $('#responseMessage').html('<div class="alert alert-success">' + response.message + '</div>');
                            setTimeout(() => {
                                window.location.href = 'index.php';
                            }, 2000);
                        } else {
                            $('#responseMessage').html('<div class="alert alert-danger">Error: ' + response.message + '</div>');
                        }
                    },
                    error: function () {
                        $('#responseMessage').html('<div class="alert alert-danger">Error al enviar la solicitud.</div>');
                    }
                });
            });
        });
    </script>
</body>
</html>
