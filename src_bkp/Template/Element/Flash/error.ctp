<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<!--
<div class="message error" onclick="this.classList.add('hidden');"><?= $message ?></div>
-->
<!-- Bootstrap -->
<div class="alert alert-danger" role="alert"><?php echo h($message); ?></div>
