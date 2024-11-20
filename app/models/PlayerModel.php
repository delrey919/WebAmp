<?php
class PlayerModel {
    public function saveSettings($settings) {
        $_SESSION['player_settings'] = $settings;
    }

    public function getSettings() {
        return $_SESSION['player_settings'] ?? [];
    }
}
