<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<!--
<div class="message success" onclick="this.classList.add('hidden')"><?= $message ?></div>
-->
<!-- Bootstrap -->
<div class="alert alert-success" role="alert"><?php echo h($message); ?></div>