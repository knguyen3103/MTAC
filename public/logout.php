<?php
session_start();
session_unset();
session_destroy();

// Gửi thông báo bằng query string
header("Location: login.php?logout=1");
exit;
