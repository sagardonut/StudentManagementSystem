<?php
$customCSS = "view_student.css";
$pageTitle = "View Student - Student Record Management System";

require_once "../includes/config.php";
require_once "../includes/header.php";

$student_id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
if ($student_id <= 0) {
    header("Location: students.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    header("Location: students.php");
    exit;
}

$att_stmt = $pdo->prepare("SELECT * FROM attendance WHERE student_id = ? ORDER BY date DESC");
$att_stmt->execute([$student_id]);
$attendance_result = $att_stmt->fetchAll(PDO::FETCH_ASSOC);

$grades_stmt = $pdo->prepare("SELECT * FROM grades WHERE student_id = ? ORDER BY created_at DESC");
$grades_stmt->execute([$student_id]);
$grades_result = $grades_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="header">
        <a href="students.php" class="back-btn"> Back</a>
        <h1><?= htmlspecialchars(($student["first_name"] ?? "") . " " . ($student["last_name"] ?? "")) ?></h1>
    </div>

    <div class="card">
        <div class="card-title">Student Information</div>

        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Student ID</span>
                <span class="info-value"><?= htmlspecialchars($student["student_id"] ?? "") ?></span>
            </div>

            <div class="info-item">
                <span class="info-label">Email</span>
                <span class="info-value"><?= htmlspecialchars($student["email"] ?? "N/A") ?></span>
            </div>

            <div class="info-item">
                <span class="info-label">Phone</span>
                <span class="info-value"><?= htmlspecialchars($student["phone"] ?? "N/A") ?></span>
            </div>

            <div class="info-item">
                <span class="info-label">Year</span>
                <span class="info-value"><?= htmlspecialchars($student["year"] ?? "N/A") ?></span>
            </div>

            <div class="info-item">
                <span class="info-label">Enrollment Date</span>
                <span class="info-value">
                    <?= !empty($student["enrollment_date"]) ? date("M d, Y", strtotime($student["enrollment_date"])) : "N/A" ?>
                </span>
            </div>
        </div>

        <div class="action-buttons">
            <a href="add_grade.php?id=<?= (int) $student["id"] ?>" class="btn btn-secondary">Add Grade</a>
            <a href="edit_student.php?id=<?= (int) $student["id"] ?>" class="btn edit-button">Edit Student</a>

            <form method="POST" action="delete_student.php" style="display:inline;"
                onsubmit="return confirm('Delete this student?');">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">
                <input type="hidden" name="id" value="<?= (int) $student["id"] ?>">
                <button type="submit" class="btn btn-danger">Delete Student</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-title">Attendance</div>

        <?php if (!empty($attendance_result)): ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attendance_result as $attendance): ?>
                            <?php $status_class = "status-" . strtolower($attendance["status"] ?? ""); ?>
                            <tr>
                                <td><?= date("M d, Y", strtotime($attendance["date"])) ?></td>
                                <td><span
                                        class="<?= htmlspecialchars($status_class) ?>"><?= htmlspecialchars(ucfirst($attendance["status"] ?? "")) ?></span>
                                </td>
                                <td><?= htmlspecialchars($attendance["remarks"] ?? "—") ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">📋</div>
                <p>No attendance records found</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="card">
        <div class="card-title">Academic Grades</div>

        <?php if (!empty($grades_result)): ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Grade</th>
                            <th>Marks</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($grades_result as $grade): ?>
                            <?php
                            $grade_class = "";
                            if (isset($grade["marks"])) {
                                $marks = (float) $grade["marks"];
                                $grade_class = ($marks >= 80) ? "grade-good" : (($marks >= 60) ? "grade-average" : "grade-poor");
                            }
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($grade["subject"] ?? "N/A") ?></td>
                                <td><span
                                        class="<?= htmlspecialchars($grade_class) ?>"><?= htmlspecialchars($grade["grade"] ?? "N/A") ?></span>
                                </td>
                                <td><?= htmlspecialchars($grade["marks"] ?? "—") ?></td>
                                <td><?= !empty($grade["created_at"]) ? date("M d, Y", strtotime($grade["created_at"])) : "—" ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon"> NO DATA FOUND !</div>
                <p>No grades recorded yet</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include "../includes/footer.php"; ?>