<?php
$pageTitle = "Add Grade - SRMS";
$customCSS = "grades.css";

require_once '../config/db.php';
include '../includes/header.php';

$errors = [];
$data = [
    'student_id' => '',
    'subject' => '',
    'marks' => '',
    'grade' => '',
    'semester' => '',
    'academic_year' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    foreach ($data as $key => $value) {
        $data[$key] = trim($_POST[$key] ?? '');
    }

    // Logical validation
    if (!$data['student_id'])
        $errors[] = "Student is required";
    if (!$data['subject'])
        $errors[] = "Subject is required";

    if ($data['marks'] === '' || !is_numeric($data['marks']) || $data['marks'] < 0 || $data['marks'] > 100) {
        $errors[] = "Marks must be between 0 and 100";
    }

    if (!$data['grade'])
        $errors[] = "Grade is required";
    if (!$data['semester'])
        $errors[] = "Semester is required";
    if (!$data['academic_year'])
        $errors[] = "Academic year is required";

    // Insert if valid
    if (!$errors) {
        $stmt = $pdo->prepare(
            "INSERT INTO grades (student_id, subject, marks, grade, semester, academic_year)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute(array_values($data));

        header("Location: grades.php");
        exit;
    }
}

// Fetch students
$students = $pdo->query(
    "SELECT id, student_id, first_name, last_name 
     FROM students WHERE status='active' ORDER BY first_name"
)->fetchAll();
?>

<div class="container">
    <h2>Add Student Grade</h2>

    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li>
                        <?= htmlspecialchars($error) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" class="grade-form">

        <!-- Student -->
        <div class="form-group">
            <label for="student_id">Student</label>
            <select name="student_id" id="student_id" required>
                <option value="">-- Select Student --</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?= $student['id'] ?>" <?= $data['student_id'] == $student['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($student['student_id'] . " - " . $student['first_name'] . " " . $student['last_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Subject -->
        <div class="form-group inp-width">
            <label for="subject">Subject</label>
            <input type="text" name="subject" id="subject" value="<?= htmlspecialchars($data['subject']) ?>" required>
        </div>

        <!-- Marks -->
        <div class="form-group  inp-width">
            <label for="marks">Marks</label>
            <input type="number" name="marks" id="marks" min="0" max="100"
                value="<?= htmlspecialchars($data['marks']) ?>" required>
        </div>

        <!-- Grade -->
        <div class="form-group">
            <label for="grade">Grade</label>
            <select name="grade" id="grade" required>
                <option value="">-- Select Grade --</option>
                <?php
                $grades = ['A+', 'A', 'B+', 'B', 'C+', 'C', 'D', 'F'];
                foreach ($grades as $g):
                    ?>
                    <option value="<?= $g ?>" <?= $data['grade'] === $g ? 'selected' : '' ?>>
                        <?= $g ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Semester -->
        <div class="form-group">
            <label for="semester">Semester</label>
            <select name="semester" id="semester" required>
                <option value="">-- Select Semester --</option>
                <option value="1" <?= $data['semester'] == '1' ? 'selected' : '' ?>>Semester 1</option>
                <option value="2" <?= $data['semester'] == '2' ? 'selected' : '' ?>>Semester 2</option>
                <option value="3" <?= $data['semester'] == '3' ? 'selected' : '' ?>>Semester 3</option>
                <option value="4" <?= $data['semester'] == '4' ? 'selected' : '' ?>>Semester 4</option>
                <option value="5" <?= $data['semester'] == '5' ? 'selected' : '' ?>>Semester 5</option>
                <option value="6" <?= $data['semester'] == '6' ? 'selected' : '' ?>>Semester 6</option>
            </select>
        </div>

        <!-- Academic Year -->
        <div class="form-group  inp-width">
            <label for="academic_year">Academic Year</label>
            <input type="text" name="academic_year" placeholder="2024-2025"
                value="<?= htmlspecialchars($data['academic_year']) ?>" required>
        </div>

        <!-- Buttons -->
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Grade</button>
            <a href="grades.php" class="btn btn-secondary">Cancel</a>
        </div>

    </form>
</div>