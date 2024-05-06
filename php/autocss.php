<?php
/* Автоматичні стилі, назва сторінки = назві стилю */
$current_page = basename($_SERVER['PHP_SELF'], '.php'); ?>
<link rel="stylesheet" type="text/css" href="../styles/pages/<?= htmlspecialchars($current_page); ?>.css">