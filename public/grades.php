<?php
$pageTitle = "Grades - SRMS";
$customCSS = "grades.css";

require_once "../includes/config.php";
require_once "../includes/header.php";

$filterStudent = $_GET["student"] ?? "";
$filterSubject = $_GET["subject"] ?? "";
$filterSemester = $_GET["semester"] ?? "";

$sql = "SELECT g.*, s.student_id, s.first_name, s.last_name, s.course
        FROM grades g
        JOIN students s ON g.student_id = s.id
        WHERE 1=1";

$params = [];

if ($filterStudent !== "") {
    $sql .= " AND s.id = ?";
    $params[] = $filterStudent;
}
if ($filterSubject !== "") {
    $sql .= " AND g.subject = ?";
    $params[] = $filterSubject;
}
if ($filterSemester !== "") {
    $sql .= " AND g.semester = ?";
    $params[] = $filterSemester;
}

$sql .= " ORDER BY g.id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$grades = $stmt->fetchAll(PDO::FETCH_ASSOC);

$allStudents = $pdo->query("SELECT id, student_id, first_name, last_name FROM students WHERE status = 'active' ORDER BY first_name")
    ->fetchAll(PDO::FETCH_ASSOC);

$allSubjects = $pdo->query("SELECT DISTINCT subject FROM grades ORDER BY subject")
    ->fetchAll(PDO::FETCH_COLUMN);
?>

<div class="main-content">
    <div class="container">

        <div class="page-header">
            <h1>Student Grades</h1>
            <a href="add_grade.php" class="btn btn-primary">Add Grade</a>
        </div>

        <div class="card">
            <form method="GET" action="grades.php" class="filter-form">
                <div class="filter-row">
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
                        <label>Subject</label>
                        <select name="subject">
                            <option value="">All Subjects</option>
                            <?php foreach ($allSubjects as $subject): ?>
                                <option value="<?= htmlspecialchars($subject) ?>" <?= ($filterSubject === $subject) ? "selected" : "" ?>>
                                    <?= htmlspecialchars($subject) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Semester</label>
                        <select name="semester">
                            <option value="">All Semesters</option>
                            <?php
                            $semesters = ["1st Semester", "2nd Semester", "3rd Semester", "4th Semester", "5th Semester", "6th Semester"];
                            foreach ($semesters as $sem):
                                ?>
                                <option value="<?= htmlspecialchars($sem) ?>" <?= ($filterSemester === $sem) ? "selected" : "" ?>>
                                    <?= htmlspecialchars($sem) ?>
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
            <p class="record-count"><?= count($grades) ?> grades found</p>

            <?php if (!$grades): ?>
                <p class="no-data">No grades found</p>
            <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Course</th>
                            <th>Subject</th>
                            <th>Marks</th>
                            <th>Grade</th>
                            <th>Semester</th>
                            <th>Academic Year</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($grades as $grade): ?>
                            <tr>
                                <td><?= htmlspecialchars($grade["student_id"]) ?></td>
                                <td><?= htmlspecialchars($grade["first_name"] . " " . $grade["last_name"]) ?></td>
                                <td><?= htmlspecialchars($grade["course"]) ?></td>
                                <td><?= htmlspecialchars($grade["subject"]) ?></td>
                                <td><?= htmlspecialchars($grade["marks"]) ?></td>
                                <td>
                                    <?php $g = strtolower((string) ($grade["grade"] ?? "")); ?>
                                    <span class="grade-badge grade-<?= htmlspecialchars($g) ?>">
                                        <?= htmlspecialchars($grade["grade"] ?? "") ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($grade["semester"]) ?></td>
                                <td><?= htmlspecialchars($grade["academic_year"]) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include "../includes/footer.php"; ?>