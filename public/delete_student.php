<?php
require_once "../includes/config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: students.php");
    exit;
}

if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    die("Invalid request");
}

$id = isset($_POST["id"]) ? (int) $_POST["id"] : 0;

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: students.php");
exit;
