<?php

namespace tframe\core;

class Session {
    protected const FLASH_KEY = 'flash_messages';

    public function __construct () {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => $flashMessage) {
            $flashMessages[$key]['remove'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
        $this->removeFlashMessages();
    }

    private function removeFlashMessages (): void {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => $flashMessage) {
            if ($flashMessage['remove']) {
                unset($_SESSION[self::FLASH_KEY][$key]);
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function setFlash ($key, $message, $url = null): void {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message,
            'redirectUrl' => $url,
        ];
    }

    public function getFlash ($key): mixed {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function getFlashContent ($key): mixed {
        return $_SESSION[self::FLASH_KEY][$key] ?? false;
    }

    public function set ($key, $value): void {
        $_SESSION[$key] = $value;
    }

    public function get ($key): mixed {
        return $_SESSION[$key] ?? false;
    }

    public function remove ($key): void {
        unset($_SESSION[$key]);
    }

    public function __destruct () {
        $this->removeFlashMessages();
    }
}