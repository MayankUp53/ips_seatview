<?php
$class = 'message';
if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
}
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<!--
<div class="<?= h($class) ?>" onclick="this.classList.add('hidden');"><?= $message ?></div>
-->
<!-- Bootstrap -->
<div class="alert alert-warning" role="alert"><?php echo h($message); ?></div>