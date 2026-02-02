<?php
$customCSS = "add_student.css";

require_once "../includes/config.php";
require_once "../includes/header.php";

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
if ($id <= 0) {
    header("Location: students.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    header("Location: students.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
        die("Invalid request");
    }

    $first_name = trim($_POST["first_name"] ?? "");
    $last_name = trim($_POST["last_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");

    $update = $pdo->prepare(
        "UPDATE students SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?"
    );
    $update->execute([$first_name, $last_name, $email, $phone, $id]);

    header("Location: view_student.php?id=" . $id);
    exit;
}
?>

<div class="container">
    <div class="header">
        <a href="view_student.php?id=<?= (int) $student["id"] ?>" class="back-btn">← Back to Student</a>
        <h1>Edit Student</h1>
        <p>Update student personal information</p>
    </div>

    <div class="card">
        <div class="card-title">Student Information</div>

        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" class="form-input"
                        value="<?= htmlspecialchars($student["first_name"]) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" class="form-input"
                        value="<?= htmlspecialchars($student["last_name"]) ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input"
                        value="<?= htmlspecialchars($student["email"]) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone" class="form-input"
                        value="<?= htmlspecialchars($student["phone"]) ?>" required>
                </div>
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn btn-primary">Update Student</button>
                <a href="view_student.php?id=<?= (int) $student["id"] ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include "../includes/footer.php"; ?>