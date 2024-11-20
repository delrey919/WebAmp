<?php

class SongModel {
    private $dbFile;

    public function __construct($dbFile) {
        $this->dbFile = $dbFile;
    }

    public function getAll() {
        $songs = json_decode(file_get_contents($this->dbFile), true) ?? [];
        foreach ($songs as $key => $song) {
            if (isset($_COOKIE["delete_song_$key"])) {
                unset($songs[$key]);
            }
        }
        return $songs;
    }

    public function add($data) {
        $songs = $this->getAll();
        $songs[] = $data;
        file_put_contents($this->dbFile, json_encode($songs, JSON_PRETTY_PRINT));
    }

    public function edit($id, $data) {
        $songs = $this->getAll();
        if (isset($songs[$id])) {
            $songs[$id] = $data;
            file_put_contents($this->dbFile, json_encode($songs, JSON_PRETTY_PRINT));
        }
    }
    public function delete($id) {
        $songs = $this->getAll();
        if (isset($songs[$id])) {
            unset($songs[$id]);
            file_put_contents($this->dbFile, json_encode(array_values($songs), JSON_PRETTY_PRINT));
        }
    }
}
