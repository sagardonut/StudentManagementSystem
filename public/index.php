<?php
require_once "../includes/config.php";

if (empty($_SESSION["admin"])) {
    header("Location: admin_login.php");
    exit;
}

$customCSS = "index.css";
$pageTitle = "Search - Student Record Management System";

require_once "../includes/header.php";
?>

<div class="search-page">
    <div class="search-container">
        <div class="search-box-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="search" id="studentSearch" class="search-input" placeholder="Search students by ID or Name."
                autocomplete="off" />
        </div>
    </div>

    <div id="searchResults" class="search-results"></div>
</div>

<script>
    let allStudents = [];
    const searchInput = document.getElementById("studentSearch");
    const resultsContainer = document.getElementById("searchResults");

    fetch("../ajax/students_autocomplete.php")
        .then(res => res.json())
        .then(data => { allStudents = Array.isArray(data) ? data : []; })
        .catch(() => { allStudents = []; });

    searchInput.addEventListener("input", function () {
        const query = this.value.trim().toLowerCase();
        resultsContainer.innerHTML = "";

        if (query.length < 1) return;

        const matches = allStudents.filter(s => {
            const first = (s.first_name || "").toLowerCase();
            const last = (s.last_name || "").toLowerCase();
            const sid = (s.student_id || "").toLowerCase();
            const email = (s.email || "").toLowerCase();
            const course = (s.course || "").toLowerCase();

            return first.includes(query) || last.includes(query) || sid.includes(query) || email.includes(query) || course.includes(query);
        });

        if (!matches.length) {
            resultsContainer.innerHTML = '<p class="no-results">No students found</p>';
            return;
        }

        matches.forEach(student => {
            const card = document.createElement("div");
            card.className = "result-card";
            card.onclick = () => {
                window.location.href = `view_student.php?id=${student.id}`;
            };

            const status = (student.status || "unknown").toString();
            const statusText = status.charAt(0).toUpperCase() + status.slice(1);

            card.innerHTML = `
                <h3>${student.first_name ?? ""} ${student.last_name ?? ""}</h3>
                <p><strong>ID:</strong> ${student.student_id ?? ""}</p>
                <p><strong>Course:</strong> ${student.course ?? ""} (Year ${student.year ?? ""})</p>
                <p>
                    <strong>Status:</strong>
                    <span class="status-badge status-${status}">
                        ${statusText}
                    </span>
                </p>
                <p class="view-more">View full profile</p>
            `;

            resultsContainer.appendChild(card);
        });
    });
</script>