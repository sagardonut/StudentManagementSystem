<?php
$customCSS = "add_student.css";

require_once "../includes/config.php";
require_once "../includes/header.php";

$errors = [];
$data = [
    'student_id' => '',
    'first_name' => '',
    'last_name' => '',
    'email' => '',
    'phone' => '',
    'course' => '',
    'year' => '',
    'enrollment_date' => '',
    'status' => 'inactive'
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
        $errors[] = "Invalid request";
    } else {

        foreach ($data as $key => $v) {
            $data[$key] = trim($_POST[$key] ?? "");
        }

        if (!$data["student_id"])
            $errors[] = "Student ID is required";
        if (!$data["first_name"])
            $errors[] = "First name is required";
        if (!$data["last_name"])
            $errors[] = "Last name is required";

        if (!$data["email"] || !filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Valid email is required";
        }

        if (!$data["course"])
            $errors[] = "Course is required";

        if ($data["year"] !== "") {
            $year = (int) $data["year"];
            if ($year < 1 || $year > 3) {
                $errors[] = "Year must be between 1 and 3";
            }
        }

        if (!$data["enrollment_date"]) {
            $errors[] = "Enrollment date is required";
        }

        if ($data["status"] === "graduated") {
            $data["year"] = 0;
        }

        if (!$errors) {
            $check = $pdo->prepare(
                "SELECT id FROM students WHERE student_id = ? OR email = ?"
            );
            $check->execute([$data["student_id"], $data["email"]]);

            if ($check->fetch()) {
                $errors[] = "Student ID or Email already exists";
            }
        }

        if (!$errors) {
            $stmt = $pdo->prepare(
                "INSERT INTO students
                (student_id, first_name, last_name, email, phone, course, year, enrollment_date, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );

            $stmt->execute(array_values($data));

            header("Location: view_student.php?id=" . $pdo->lastInsertId());
            exit;
        }
    }
}
?>



<div class="container">
    <!-- Header -->
    <div class="header">
        <h1>Student Record Management System</h1>
        <p>Manage student information efficiently</p>
    </div>

    <div class="card">
        <?php if ($errors): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li>
                            <?php echo htmlspecialchars($error); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>


        <h2 class="card-title">Add New Student</h2>
        <form id="studentForm" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">

                    <label class="form-label" for="firstName">First Name</label>
                    <input type="text" id="firstName" name="first_name" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="last_name" class="form-input" required>
                </div>
            </div>

            <!-- ID and Email Row -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="studentId">Student ID</label>
                    <input type="text" id="studentId" name="student_id" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="studentEmail">Email</label>
                    <input type="email" id="studentEmail" name="email" class="form-input" required>
                </div>
            </div>

            <!-- Phone and Course Row -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="studentPhone">Phone</label>
                    <input type="tel" id="studentPhone" name="phone" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label" for="studentCourse">Course</label>
                    <input type="text" id="studentCourse" name="course" class="form-input" required>
                </div>
            </div>

            <!-- Year and Enrollment Date Row -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="studentYear">Year</label>
                    <input type="number" id="studentYear" name="year" class="form-input" min="1" max="3">
                </div>
                <div class="form-group">
                    <label class="form-label" for="enrollmentDate">Enrollment Date</label>
                    <input type="date" id="enrollmentDate" name="enrollment_date" class="form-input" required>
                </div>
            </div>

            <!-- Status Row -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="status">Status</label>
                    <select id="status" name="status" class="form-input">
                        <option value="active" selected>Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="graduated">Graduated</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Add Student</button>
        </form>
    </div>
</div>

<?php include "../includes/footer.php"; ?>