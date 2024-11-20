<ul class="list-group">
    <?php foreach ($songs as $index => $song): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <strong><?= htmlspecialchars($song['name']) ?></strong> - <?= htmlspecialchars($song['artist']) ?>
            </div>
            <div>
                <button class="btn btn-primary btn-sm play-btn" data-audio="uploads/<?= htmlspecialchars($song['file']) ?>">▶ Reproduir</button>
                <a href="edit.php?id=<?= $index ?>" class="btn btn-warning btn-sm">Editar</a>
                <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $index ?>">Eliminar</button>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
