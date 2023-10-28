<?php

namespace tframe\common\components\alert;

class Sweetalert {
    public static function generateToastAlert(string $icon, string $title, int $timer = 2000, bool $showConfirmButton = false): string {
        return <<<JS
            <script>
                setTimeout(function () {
                    Swal.fire({
                        icon: '$icon',
                        title: '$title',
                        toast: true,
                        position: 'top-end',
                        timerProgressBar: true,
                        showConfirmButton: $showConfirmButton,
                        timer: $timer
                    })
                }, 100);
            </script>
        JS;
    }

    public static function generatePopupAlert(string $icon, string $title, string $text, bool $showConfirmButton = false): string {
        return <<<JS
            <script>
                setTimeout(function () {
                    Swal.fire({
                        icon: '$icon',
                        title: '$title',
                        text: '$text',
                        showConfirmButton: $showConfirmButton
                    })
                }, 100);
            </script>
        JS;
    }
}