<?php
require_once __DIR__ . '/../app/controllers/SongController.php';
require_once __DIR__ . '/../app/models/SongModel.php';

$songModel = new SongModel(__DIR__ . '/../app/database.json');
$songController = new SongController($songModel);

$songs = $songController->getAllSongs();
$lastPlayed = $_COOKIE['last_played'] ?? 'Selecciona una cançó';
$previousSong = $_COOKIE['previous_song'] ?? 'Cap cançó anterior';
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebAmp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '../views/header.php'; ?>
    <div class="container mt-5">
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">Player</div>
                    <div class="card-body">
                        <p id="current-song" class="text-muted"><?= htmlspecialchars($lastPlayed) ?></p>
                        <audio id="audio-player" controls class="w-100"></audio>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">Opcions</div>
                    <div class="card-body">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="shuffle">
                            <label for="shuffle" class="form-check-label">Aleatori</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="mute">
                            <label for="mute" class="form-check-label">Silencia</label>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-warning text-dark">Cançó Anterior</div>
                    <div class="card-body">
                        <p id="last-song"><?= htmlspecialchars($previousSong) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-warning text-dark">Llista de Cançons</div>
                    <div class="card-body">
                        <?php include __DIR__ . '../views/song_list.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '../views/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
