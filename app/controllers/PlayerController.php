<?php
class SongController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function getAllSongs() {
        return $this->model->getAll();
    }

    public function addSong($data) {
        $this->model->add($data);
    }

    public function editSong($id, $data) {
        $this->model->edit($id, $data);
    }

    public function deleteSong($id) {
        $this->model->delete($id);
    }
}
