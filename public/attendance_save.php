<?php
require_once "../includes/config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: attendance_report.php");
    exit;
}

if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    die("Invalid request");
}

if (empty($_POST["attendance"])) {
    header("Location: attendance_report.php");
    exit;
}

foreach ($_POST["attendance"] as $key => $status) {
    [$student_id, $date] = explode("_", $key);

    if (!in_array($status, ["present", "absent", "late"], true)) {
        continue;
    }

    $stmt = $pdo->prepare(
        "UPDATE attendance SET status = ? WHERE student_id = ? AND date = ?"
    );
    $stmt->execute([$status, (int) $student_id, $date]);
}

header("Location: attendance_report.php");
exit;
