<?php
$pageTitle = $pageTitle ?? "Student Record Management System";

require_once "config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" sizes="32x32" href="../assets/icons/favicon.png">
	<meta name="description"
		content="Manage student records, grades, attendance, and academic status efficiently using the Student Record Management System admin dashboard.">

	<!-- Open Graph for Facebook WhatsApp LinkedIn links -->
	<meta property="og:title" content="Students | Student Record Management System">
	<meta property="og:description"
		content="Admin panel to manage students, view grades, attendance, and academic status in one place.">
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://www.sarvika.com/wp-content/uploads/2022/02/Student-Management-System.png">
	<meta property="og:image"
		content="https://www.sarvika.com/wp-content/uploads/2022/02/Student-Management-System.png">

	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="Students | Student Record Management System">
	<meta name="twitter:description" content="Admin dashboard for managing student records, grades, and attendance.">
	<meta name="twitter:image"
		content="https://www.sarvika.com/wp-content/uploads/2022/02/Student-Management-System.png">

	<title><?= htmlspecialchars($pageTitle) ?></title>

	<?php if (!empty($customCSS)): ?>

		<link rel="stylesheet" href="../assets/css/<?= htmlspecialchars($customCSS) ?>">
	<?php endif; ?>

	<link rel="stylesheet" href="../assets/css/styles.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

	<nav class="floating-nav" id="floatingNav">
		<div class="nav-container">
			<a href="index.php" class="nav-item">
				<i class="fas fa-home"></i>
				<span class="nav-label">Home</span>
			</a>

			<a href="students.php" class="nav-item">
				<i class="fas fa-user-graduate"></i>
				<span class="nav-label">Students</span>
			</a>

			<a href="grades.php" class="nav-item">
				<i class="fas fa-book"></i>
				<span class="nav-label">Add Grades</span>
			</a>

			<a href="attendance_report.php" class="nav-item">
				<i class="fas fa-chart-bar"></i>
				<span class="nav-label">Attendance Report</span>
			</a>
			<div class="nav-divider"></div>
			<a href="logout.php" class="nav-item">
				<i class="fas fa-sign-out-alt"></i>
				<span class="nav-label">Logout</span>
			</a>
		</div>
	</nav>

	<script src="../assets/js/script.js"></script>