<?php
require_once "../includes/config.php";

session_unset();
session_destroy();

header("Location: admin_login.php");
exit;
