<?php
require_once "config.php";
?>

<!-- Footer Section -->
<footer class="main-footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-section">
                <h3><i class="fas fa-graduation-cap"></i> Student Portal</h3>
                <p>Manage student records efficiently and effectively.</p>
                <div class="social-links">
                    <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>

            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="index.php"><i class="fas fa-angle-right"></i> Home</a></li>
                    <li><a href="students.php"><i class="fas fa-angle-right"></i> Students</a></li>
                    <li><a href="grades.php"><i class="fas fa-angle-right"></i> Reports</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>Contact Info</h4>
                <ul class="footer-contact">
                    <li><i class="fas fa-map-marker-alt"></i> Kathmandu, Nepal</li>
                    <li><i class="fas fa-phone"></i> +977-123-456-789</li>
                    <li><i class="fas fa-envelope"></i> info@studentportal.com</li>
                    <li><i class="fas fa-clock"></i> Mon - Fri: 9AM - 5PM</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Student Record Management System. All rights reserved.</p>
            <p>Developed with <i class="fas fa-heart" style="color: #ef4444;"></i> by SagarShah</p>
        </div>
    </div>
</footer>

<!-- Link to external footer CSS -->
<link rel="stylesheet" href="../assets/css/footer.css">