<?php
require_once "../includes/config.php";

if (empty($_SESSION["admin"])) {
    header("Location: admin_login.php");
    exit;
}

$customCSS = "students.css";
$pageTitle = "Students - Student Record Management System";

require_once "../includes/header.php";

$limit = 8;
$page = (isset($_GET["page"]) && ctype_digit($_GET["page"])) ? (int) $_GET["page"] : 1;
$page = max(1, $page);
$offset = ($page - 1) * $limit;

$statusFilter = $_GET["status"] ?? "";
$yearFilter = $_GET["year"] ?? "";

$where = [];
$params = [];

if ($statusFilter !== "") {
    $where[] = "status = :status";
    $params[":status"] = $statusFilter;
}
if ($yearFilter !== "") {
    $where[] = "year = :year";
    $params[":year"] = $yearFilter;
}

$whereSql = $where ? ("WHERE " . implode(" AND ", $where)) : "";

$countStmt = $pdo->prepare("SELECT COUNT(*) FROM students $whereSql");
$countStmt->execute($params);
$totalStudents = (int) $countStmt->fetchColumn();
$totalPages = max(1, (int) ceil($totalStudents / $limit));

$stmt = $pdo->prepare("SELECT * FROM students $whereSql ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
foreach ($params as $k => $v) {
    $stmt->bindValue($k, $v);
}
$stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
$stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

$activeCount = (int) $pdo->query("SELECT COUNT(*) FROM students WHERE status = 'active'")->fetchColumn();
$graduatedCount = (int) $pdo->query("SELECT COUNT(*) FROM students WHERE status = 'graduated'")->fetchColumn();
$inactiveCount = (int) $pdo->query("SELECT COUNT(*) FROM students WHERE status = 'inactive'")->fetchColumn();

function initials($first, $last)
{
    $f = $first ? strtoupper(substr($first, 0, 1)) : "";
    $l = $last ? strtoupper(substr($last, 0, 1)) : "";
    return $f . $l;
}

function niceDate($date)
{
    if (!$date)
        return "";
    return date("M d, Y", strtotime($date));
}
?>

<div class="container">
    <div class="page-header">
        <div class="page-title">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div>
                <h1>Students</h1>
                <p class="page-subtitle">Manage and view all student records</p>
            </div>
        </div>
        <button class="btn btn-primary" onclick="window.location.href='add_student.php'">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add Student
        </button>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3><?= number_format($totalStudents) ?></h3>
                <p>Total Students</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <h3><?= number_format($activeCount) ?></h3>
                <p>Active Students</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3><?= number_format($graduatedCount) ?></h3>
                <p>Graduated</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon warning">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="stat-content">
                <h3><?= number_format($inactiveCount) ?></h3>
                <p>Inactive</p>
            </div>
        </div>
    </div>

    <div class="action-bar">
        <div class="filter-group">
            <select class="filter-select" onchange="applyFilter('status', this.value)">
                <option value="">All Status</option>
                <option value="active" <?= $statusFilter === "active" ? "selected" : "" ?>>Active</option>
                <option value="inactive" <?= $statusFilter === "inactive" ? "selected" : "" ?>>Inactive</option>
                <option value="graduated" <?= $statusFilter === "graduated" ? "selected" : "" ?>>Graduated</option>
            </select>
            <select class="filter-select" onchange="applyFilter('year', this.value)">
                <option value="">All Years</option>
                <option value="1" <?= $yearFilter === "1" ? "selected" : "" ?>>Year 1</option>
                <option value="2" <?= $yearFilter === "2" ? "selected" : "" ?>>Year 2</option>
                <option value="3" <?= $yearFilter === "3" ? "selected" : "" ?>>Year 3</option>
            </select>
        </div>
    </div>

    <div class="table-card">
        <div class="table-header">
            <h2>Student Records</h2>
        </div>

        <?php if ($students): ?>
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Student ID</th>
                            <th>Contact</th>
                            <th>Course</th>
                            <th>Year</th>
                            <th>Enrolled</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td>
                                    <div class="student-info">
                                        <div class="student-avatar">
                                            <?= htmlspecialchars(initials($student["first_name"], $student["last_name"])) ?>
                                        </div>
                                        <div class="student-details">
                                            <h4><?= htmlspecialchars(($student["first_name"] ?? "") . " " . ($student["last_name"] ?? "")) ?>
                                            </h4>
                                            <span>Added <?= htmlspecialchars(niceDate($student["created_at"] ?? "")) ?></span>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <code
                                        style="background: var(--gray-100); padding: 4px 8px; border-radius: 4px; font-size: 0.8125rem;">
                                                                                                                                                                                                                                                                        <?= htmlspecialchars($student["student_id"] ?? "") ?>
                                                                                                                                                                                                                                                                    </code>
                                </td>

                                <td>
                                    <div class="contact-info">
                                        <a href="mailto:<?= htmlspecialchars($student["email"] ?? "") ?>">
                                            <?= htmlspecialchars($student["email"] ?? "") ?>
                                        </a>
                                        <a href="tel:<?= htmlspecialchars($student["phone"] ?? "") ?>">
                                            <?= htmlspecialchars($student["phone"] ?? "") ?>
                                        </a>
                                    </div>
                                </td>

                                <td><span class="course-badge"><?= htmlspecialchars($student["course"] ?? "") ?></span></td>
                                <td><span class="year-badge"><?= htmlspecialchars($student["year"] ?? "") ?></span></td>
                                <td><?= htmlspecialchars(niceDate($student["enrollment_date"] ?? "")) ?></td>

                                <td>
                                    <?php $st = strtolower((string) ($student["status"] ?? "unknown")); ?>
                                    <span class="status-badge status-<?= htmlspecialchars($st) ?>">
                                        <?= htmlspecialchars(ucfirst($st)) ?>
                                    </span>
                                </td>

                                <td>
                                    <div class="actions-cell">
                                        <button class="btn btn-outline btn-icon btn-view" title="View Details"
                                            onclick="viewStudent(<?= (int) $student["id"] ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-outline btn-icon btn-edit" title="Edit Student"
                                            onclick="editStudent(<?= (int) $student["id"] ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                <div class="pagination-info">
                    Showing <?= min($offset + 1, $totalStudents) ?> to <?= min($offset + $limit, $totalStudents) ?> of
                    <?= $totalStudents ?> entries
                </div>

                <div class="pagination">
                    <?php
                    $queryParams = $_GET;
                    unset($queryParams["page"]);
                    $queryString = http_build_query($queryParams);
                    $queryString = $queryString ? "&" . $queryString : "";
                    ?>

                    <a href="?page=<?= max(1, $page - 1) . $queryString ?>"
                        class="<?= $page <= 1 ? "disabled" : "" ?>">&laquo;</a>

                    <?php
                    $startPage = max(1, $page - 2);
                    $endPage = min($totalPages, $page + 2);

                    if ($startPage > 1) {
                        echo '<a href="?page=1' . $queryString . '">1</a>';
                        if ($startPage > 2)
                            echo '<span style="padding: 0 8px;">...</span>';
                    }

                    for ($i = $startPage; $i <= $endPage; $i++) {
                        $active = ($i === $page) ? ' class="active"' : "";
                        echo '<a href="?page=' . $i . $queryString . '"' . $active . '>' . $i . '</a>';
                    }

                    if ($endPage < $totalPages) {
                        if ($endPage < $totalPages - 1)
                            echo '<span style="padding: 0 8px;">...</span>';
                        echo '<a href="?page=' . $totalPages . $queryString . '">' . $totalPages . '</a>';
                    }
                    ?>

                    <a href="?page=<?= min($totalPages, $page + 1) . $queryString ?>"
                        class="<?= $page >= $totalPages ? "disabled" : "" ?>">&raquo;</a>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h3>No students found</h3>
                <p>Try adjusting your filter criteria, or add a new student.</p>
                <button class="btn btn-primary" onclick="window.location.href='add_student.php'">Add Student</button>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function viewStudent(id) {
        window.location.href = "view_student.php?id=" + id;
    }

    function editStudent(id) {
        window.location.href = "edit_student.php?id=" + id;
    }

    function applyFilter(name, value) {
        const url = new URL(window.location.href);

        if (value) url.searchParams.set(name, value);
        else url.searchParams.delete(name);

        url.searchParams.delete("page");
        window.location.href = url.toString();
    }
</script>

<?php require_once "../includes/footer.php"; ?>