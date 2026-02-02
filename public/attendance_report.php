<?php
$pageTitle = "Attendance Reports - SRMS";
$customCSS = "attendance.css";

require_once "../includes/config.php";
require_once "../includes/header.php";

$filterDateFrom = $_GET["date_from"] ?? date("Y-m-d", strtotime("-7 days"));
$filterDateTo = $_GET["date_to"] ?? date("Y-m-d");
$filterStudent = $_GET["student"] ?? "";

$sql = "SELECT a.date, a.status, s.id as student_id, s.student_id as std_id, s.first_name, s.last_name, s.course
        FROM attendance a
        JOIN students s ON a.student_id = s.id
        WHERE a.date BETWEEN ? AND ?";

$params = [$filterDateFrom, $filterDateTo];

if ($filterStudent !== "") {
    $sql .= " AND s.id = ?";
    $params[] = $filterStudent;
}

$sql .= " ORDER BY a.date DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

$studentsStmt = $pdo->query("SELECT id, student_id, first_name, last_name FROM students WHERE status = 'active' ORDER BY first_name");
$allStudents = $studentsStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="main-content">
    <div class="container">

        <div class="page-header">
            <h1>Attendance Reports</h1>
            <a href="attendance.php" class="btn btn-primary">Mark Attendance</a>
        </div>

        <div class="card">
            <form method="GET" action="attendance_report.php" class="filter-form">
                <div class="filter-row">
                    <div class="form-group">
                        <label>From Date</label>
                        <input type="date" name="date_from" value="<?= htmlspecialchars($filterDateFrom) ?>"
                            max="<?= date("Y-m-d") ?>">
                    </div>

                    <div class="form-group">
                        <label>To Date</label>
                        <input type="date" name="date_to" value="<?= htmlspecialchars($filterDateTo) ?>"
                            max="<?= date("Y-m-d") ?>">
                    </div>

                    <div class="form-group">
                        <label>Student</label>
                        <select name="student">
                            <option value="">All Students</option>
                            <?php foreach ($allStudents as $student): ?>
                                <option value="<?= (int) $student["id"] ?>" <?= ($filterStudent == $student["id"]) ? "selected" : "" ?>>
                                    <?= htmlspecialchars($student["student_id"] . " - " . $student["first_name"] . " " . $student["last_name"]) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary">Apply</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card">
            <p class="record-count"><?= count($records) ?> records found</p>

            <?php if (!$records): ?>
                <p class="no-data">No attendance records found</p>
            <?php else: ?>
                <form method="POST" action="attendance_save.php">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">

                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Course</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $record): ?>
                                <tr>
                                    <td><?= date("M d, Y", strtotime($record["date"])) ?></td>
                                    <td><?= htmlspecialchars($record["std_id"]) ?></td>
                                    <td><?= htmlspecialchars($record["first_name"] . " " . $record["last_name"]) ?></td>
                                    <td><?= htmlspecialchars($record["course"]) ?></td>
                                    <td>
                                        <select name="attendance[<?= (int) $record["student_id"] . "_" . $record["date"] ?>]"
                                            class="status-select">
                                            <option value="present" <?= $record["status"] === "present" ? "selected" : "" ?>>
                                                Present</option>
                                            <option value="absent" <?= $record["status"] === "absent" ? "selected" : "" ?>>Absent
                                            </option>
                                            <option value="late" <?= $record["status"] === "late" ? "selected" : "" ?>>Late
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="form-actions" style="margin-top: 15px;">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include "../includes/footer.php"; ?>