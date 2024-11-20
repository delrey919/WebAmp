<?php
require_once '../app/controllers/SongController.php';
require_once '../app/models/SongModel.php';

$songModel = new SongModel('../app/database.json');
$songController = new SongController($songModel);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'], 
        'artist' => $_POST['artist'],
        'file' => $_FILES['file']['name']
    ];
    move_uploaded_file($_FILES['file']['tmp_name'], '../public/uploads/' . $_FILES['file']['name']);
    $songController->addSong($data);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afegir Cançó</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '../views/header.php'; ?>
    
    <div class="container mt-5">
    <a href="index.php" class="btn btn-warning text-dark">Tornar a l'Inici</a>
        <h1>Afegir Cançó</h1>
        
        <form action="add.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="artist" class="form-label">Artista</label>
                <input type="text" name="artist" id="artist" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">Fitxer</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Afegir</button>
        </form>
    </div>
    
    <?php include __DIR__ . '../views/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
