<?php
require_once __DIR__ . '/../includes/init.php';

unset($_SESSION['user']);

header('Location: ../index.php');
exit;