<?php
function flash(string $type, string $message): void {
    $_SESSION["flash_$type"] = $message;
}

function get_flash(string $type): ?string {
    $msg = $_SESSION["flash_$type"] ?? null;
    unset($_SESSION["flash_$type"]);
    return $msg;
}
