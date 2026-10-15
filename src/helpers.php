<?php
function h($v): string {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}
?>
