<?php
// Set page-specific variables
$pageTitle = "Mark Attendance - SRMS";
$customCSS = "attendance.css";

// Include database connection
require_once __DIR__ . '/../config/db.php';

// Include header
include '../includes/header.php';

// Initialize variables
$errors = [];
$success = '';
$currentDate = date('Y-m-d');

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $attendanceDate = $_POST['attendance_date'] ?? $currentDate;
    $attendanceData = $_POST['attendance'] ?? [];

    if (!empty($attendanceData)) {
        try {
            foreach ($attendanceData as $studentId => $status) {
                // Check if record exists
                $checkStmt = $pdo->prepare("SELECT id FROM attendance WHERE student_id = ? AND date = ?");
                $checkStmt->execute([$studentId, $attendanceDate]);

                if ($checkStmt->fetch()) {
                    // Update
                    $stmt = $pdo->prepare("UPDATE attendance SET status = ? WHERE student_id = ? AND date = ?");
                    $stmt->execute([$status, $studentId, $attendanceDate]);
                } else {
                    // Insert
                    $stmt = $pdo->prepare("INSERT INTO attendance (student_id, date, status) VALUES (?, ?, ?)");
                    $stmt->execute([$studentId, $attendanceDate, $status]);
                }
            }

            $success = 'Attendance saved successfully!';

        } catch (PDOException $e) {
            $errors[] = 'Failed to save attendance';
            error_log($e->getMessage());
        }
    }
}

// Fetch students
try {
    $studentsStmt = $pdo->query("SELECT id, student_id, first_name, last_name, course FROM students WHERE status = 'active' ORDER BY first_name");
    $students = $studentsStmt->fetchAll(PDO::FETCH_ASSOC);

    // Get existing attendance
    $attendanceStmt = $pdo->prepare("SELECT student_id, status FROM attendance WHERE date = ?");
    $attendanceStmt->execute([$currentDate]);
    $existingAttendance = [];
    while ($row = $attendanceStmt->fetch(PDO::FETCH_ASSOC)) {
        $existingAttendance[$row['student_id']] = $row['status'];
    }

} catch (PDOException $e) {
    $errors[] = 'Failed to load students';
    $students = [];
}

?>

<div class="main-content">
    <div class="container">

        <div class="page-header">
            <h1>Mark Attendance</h1>
            <p><?php echo date('F j, Y'); ?></p>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <form method="POST" action="attendance.php">

                <input type="hidden" name="attendance_date" value="<?php echo $currentDate; ?>">

                <div class="card-actions">
                    <span>Total Students: <?php echo count($students); ?></span>
                    <a href="attendance_report.php" class="btn btn-secondary">View Reports</a>
                </div>

                <?php if (empty($students)): ?>
                    <p class="no-data">No students found</p>
                <?php else: ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Course</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student):
                                $studentDbId = $student['id'];
                                $currentStatus = $existingAttendance[$studentDbId] ?? 'present';
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($student['student_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name'], ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($student['course'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <select name="attendance[<?php echo $studentDbId; ?>]" class="status-select">
                                            <option value="present" <?php echo $currentStatus === 'present' ? 'selected' : ''; ?>>
                                                Present</option>
                                            <option value="absent" <?php echo $currentStatus === 'absent' ? 'selected' : ''; ?>>
                                                Absent</option>
                                            <option value="late" <?php echo $currentStatus === 'late' ? 'selected' : ''; ?>>Late
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save Attendance</button>
                    </div>
                <?php endif; ?>

            </form>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>