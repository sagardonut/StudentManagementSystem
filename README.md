# 🎓 Student Management System

<div align="center">

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)

**A comprehensive web-based student management solution for educational institutions**

[Features](#-features) • [Installation](#-installation--setup) • [Usage](#-usage) • [Documentation](#-documentation) • [Contributing](#-contributing)

</div>

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Screenshots](#-screenshots)
- [Technology Stack](#-technology-stack)
- [System Requirements](#-system-requirements)
- [Installation & Setup](#-installation--setup)
- [Database Schema](#-database-schema)
- [Project Structure](#-project-structure)
- [Usage](#-usage)
- [API Endpoints](#-api-endpoints)
- [Security Features](#-security-features)
- [Future Roadmap](#-future-roadmap)
- [Troubleshooting](#-troubleshooting)
- [Contributing](#-contributing)
- [License](#-license)
- [Acknowledgments](#-acknowledgments)
- [Contact](#-contact)

---

## 🌟 Overview

The **Student Management System** is a full-featured web application designed to streamline academic administration. Built with modern web technologies, it provides a robust platform for managing student records, tracking attendance, and maintaining grade information.

### 🎯 Purpose

This system serves as a comprehensive solution for:
- **Educational Institutions**: Manage student data efficiently
- **Academic Projects**: Demonstrate full-stack development skills
- **Learning Platform**: Understand CRUD operations and database management
- **Portfolio Showcase**: Display practical PHP and MySQL expertise

---

## ✨ Features

### 🔐 Authentication & Authorization
- Secure admin login system
- Session management
- Logout functionality with session cleanup

### 👨‍🎓 Student Management
- ➕ **Add Students**: Create new student records with comprehensive details
- ✏️ **Edit Students**: Update existing student information
- 🗑️ **Delete Students**: Remove student records with confirmation
- 👁️ **View Students**: Display detailed student profiles
- 🔍 **Search Students**: Advanced search with real-time autocomplete (AJAX)
- 📊 **List Students**: Paginated view of all registered students

### 📈 Grade Management
- Record and track student grades
- Subject-wise grade entry
- Grade history and reports
- Performance analytics

### 📅 Attendance System
- Daily attendance marking interface
- Attendance reports by date range
- Student-wise attendance statistics
- Export attendance data
- Visual attendance indicators

### 🎨 User Interface
- Clean, intuitive design
- Responsive layout components
- Shared header and footer templates
- Consistent color scheme and branding
- User-friendly navigation

### ⚡ Advanced Features
- **AJAX Integration**: Real-time student search without page reload
- **Modular Architecture**: Reusable components and functions
- **Optimized Performance**: Efficient database queries
- **Video Elements**: Enhanced UI with multimedia support

---

## 📸 Screenshots

<img width="1919" height="1021" alt="image" src="https://github.com/user-attachments/assets/6c3aef9f-5c04-4665-8b67-50e62db0b525" />
   <img width="1916" height="1075" alt="image" src="https://github.com/user-attachments/assets/69468661-7848-41ee-ad8f-bb64b7a1be74" />
      <img width="1919" height="1077" alt="image" src="https://github.com/user-attachments/assets/71b2d376-f698-4135-aad3-c685592eb2c4" />
        <img width="1919" height="1079" alt="image" src="https://github.com/user-attachments/assets/1a3e57e2-1105-4d8b-8866-4e603269c362" />
  <img width="1910" height="926" alt="image" src="https://github.com/user-attachments/assets/637b4db8-69dc-4155-9090-fc3e3a53d8b6" />
<img width="1919" height="1075" alt="image" src="https://github.com/user-attachments/assets/5660eec8-95c8-45ae-beb2-119c6b3142a1" />

---

## 🛠️ Technology Stack

### Backend
- **PHP 7.4+**: Server-side scripting
- **MySQL 5.7+**: Relational database management
- **PDO**: Secure database connections

### Frontend
- **HTML5**: Semantic markup
- **CSS3**: Modern styling with custom properties
- **JavaScript (ES6+)**: Interactive functionality
- **AJAX**: Asynchronous data operations

### Development Tools
- **XAMPP/WAMP**: Local development environment
- **phpMyAdmin**: Database administration
- **Git**: Version control

---

## 💻 System Requirements

### Minimum Requirements
- **Web Server**: Apache 2.4+
- **PHP**: Version 7.4 or higher
- **MySQL**: Version 5.7 or higher
- **Browser**: Modern browser (Chrome, Firefox, Safari, Edge)
- **RAM**: 2GB minimum
- **Storage**: 100MB free space

### Recommended
- **PHP**: Version 8.0+
- **MySQL**: Version 8.0+
- **RAM**: 4GB or more
- **Storage**: 500MB for future data growth

---

## ⚙️ Installation & Setup

### Step 1: Clone the Repository

```bash
git clone https://github.com/sagardonut/StudentManagementSystem.git
cd StudentManagementSystem
```

### Step 2: Set Up Local Server

Move the project to your web server directory:

**For XAMPP:**
```bash
# Windows
C:\xampp\htdocs\StudentManagementSystem

# Linux/Mac
/opt/lampp/htdocs/StudentManagementSystem
```

**For WAMP:**
```bash
C:\wamp64\www\StudentManagementSystem
```

### Step 3: Start Services

1. Open **XAMPP/WAMP Control Panel**
2. Start **Apache** server
3. Start **MySQL** service

### Step 4: Create Database

1. Open your browser and navigate to:
   ```
   http://localhost/phpmyadmin
   ```

2. Create a new database:
   - Click **"New"** in the left sidebar
   - Database name: `student_management`
   - Collation: `utf8mb4_general_ci`
   - Click **"Create"**

3. Import the database schema:
   - Select the `student_management` database
   - Click **"Import"** tab
   - Choose the `database.sql` file from the project
   - Click **"Go"**

### Step 5: Configure Database Connection

Edit `config/db.php`:

```php
<?php
$host = "localhost";
$dbname = "student_management";
$username = "root";
$password = ""; // Leave empty for default XAMPP/WAMP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
```

### Step 6: Access the Application

Open your browser and navigate to:
```
http://localhost/StudentManagementSystem/public/
```

### Step 7: Login

Use the default admin credentials:
- **Username**: `admin`
- **Password**: `admin123`

> ⚠️ **Security Warning**: Change these credentials immediately after first login!

---

## 🗄️ Database Schema

### Tables Overview

#### 1. **students**
Stores comprehensive student information

| Column | Type | Description |
|--------|------|-------------|
| id | INT (PK, AI) | Unique student identifier |
| first_name | VARCHAR(50) | Student's first name |
| last_name | VARCHAR(50) | Student's last name |
| email | VARCHAR(100) | Contact email |
| phone | VARCHAR(15) | Contact phone number |
| date_of_birth | DATE | Student's birth date |
| address | TEXT | Residential address |
| enrollment_date | DATE | Date of enrollment |
| status | ENUM | Active/Inactive status |
| created_at | TIMESTAMP | Record creation time |
| updated_at | TIMESTAMP | Last update time |

#### 2. **grades**
Manages student academic performance

| Column | Type | Description |
|--------|------|-------------|
| id | INT (PK, AI) | Grade record identifier |
| student_id | INT (FK) | Reference to students table |
| subject | VARCHAR(100) | Subject name |
| grade | VARCHAR(5) | Letter grade (A, B, C, etc.) |
| percentage | DECIMAL(5,2) | Numeric score |
| semester | VARCHAR(20) | Academic term |
| academic_year | VARCHAR(10) | Year of assessment |
| remarks | TEXT | Additional comments |
| created_at | TIMESTAMP | Record creation time |

#### 3. **attendance**
Tracks daily student attendance

| Column | Type | Description |
|--------|------|-------------|
| id | INT (PK, AI) | Attendance record ID |
| student_id | INT (FK) | Reference to students table |
| date | DATE | Attendance date |
| status | ENUM | Present/Absent/Late |
| remarks | TEXT | Additional notes |
| recorded_by | VARCHAR(50) | Admin who recorded |
| created_at | TIMESTAMP | Record creation time |

### Entity Relationship Diagram

```
┌─────────────┐         ┌─────────────┐
│  students   │────────<│   grades    │
│             │         │             │
│ • id (PK)   │         │ • id (PK)   │
│ • name      │         │ • student_id│
│ • email     │         │ • subject   │
│ • ...       │         │ • grade     │
└─────────────┘         └─────────────┘
       │
       │
       ∨
┌─────────────┐
│ attendance  │
│             │
│ • id (PK)   │
│ • student_id│
│ • date      │
│ • status    │
└─────────────┘
```

---

## 📂 Project Structure

```
StudentManagementSystem/
│
├── 📁 ajax/                          # AJAX handlers
│   └── students_autocomplete.php    # Real-time search functionality
│
├── 📁 assets/                        # Static resources
│   ├── 📁 css/                       # Stylesheets
│   │   ├── add_student.css          # Add student page styles
│   │   ├── attendance.css           # Attendance module styles
│   │   ├── footer.css               # Footer component styles
│   │   ├── grades.css               # Grade management styles
│   │   ├── index.css                # Homepage styles
│   │   ├── students.css             # Student list styles
│   │   ├── styles.css               # Global styles
│   │   └── view_student.css         # Student profile styles
│   │
│   ├── 📁 images/                    # Image assets
│   │   └── favicon.png              # Site favicon
│   │
│   ├── 📁 js/                        # JavaScript files
│   │   ├── index.js                 # Homepage scripts
│   │   └── script.js                # Global scripts
│   │
│   └── 📁 videos/                    # Video assets
│       └── login-avatar.mp4         # Login page animation
│
├── 📁 config/                        # Configuration files
│   └── db.php                       # Database connection
│
├── 📁 includes/                      # Reusable components
│   ├── config.php                   # Global configuration
│   ├── footer.php                   # Footer template
│   ├── functions.php                # Helper functions
│   └── header.php                   # Header template
│
├── 📁 public/                        # Application pages
│   ├── add_grade.php                # Add new grade
│   ├── add_student.php              # Student registration form
│   ├── admin_login.php              # Admin authentication
│   ├── attendance.php               # Mark attendance
│   ├── attendance_save.php          # Save attendance data
│   ├── attendance_report.php        # Attendance reports
│   ├── delete_student.php           # Remove student
│   ├── edit_student.php             # Update student info
│   ├── grades.php                   # Grade management
│   ├── index.php                    # Dashboard/Homepage
│   ├── logout.php                   # Session termination
│   ├── search.php                   # Search functionality
│   ├── students.php                 # Student list view
│   └── view_student.php             # Student profile
│
├── 📄 database.sql                   # Database schema & seed data
├── 📄 README.md                      # Project documentation
└── 📄 .gitignore                     # Git ignore rules

```

### Key Directories Explained

- **`ajax/`**: Contains PHP scripts that handle AJAX requests for dynamic content loading
- **`assets/`**: All static files including CSS, JavaScript, images, and videos
- **`config/`**: Database connection and configuration settings
- **`includes/`**: Reusable PHP templates and helper functions
- **`public/`**: Main application pages accessible via browser

---

## 📖 Usage

### Admin Dashboard

After logging in, you'll see the main dashboard with quick access to:
- Total students count
- Recent attendance summary
- Grade statistics
- Quick action buttons

### Managing Students

#### Add New Student
1. Navigate to **"Students"** → **"Add Student"**
2. Fill in the required information
3. Click **"Save"**

#### Edit Student
1. Go to **"Students"** list
2. Click **"Edit"** next to the student's name
3. Update the information
4. Click **"Update"**

#### Delete Student
1. Go to **"Students"** list
2. Click **"Delete"** next to the student's name
3. Confirm the deletion

#### Search Students
- Use the search bar on the student list page
- Start typing the student's name
- AJAX autocomplete will show matching results in real-time

### Recording Attendance

1. Navigate to **"Attendance"**
2. Select the date
3. Mark each student as Present/Absent/Late
4. Click **"Save Attendance"**

### Managing Grades

1. Go to **"Grades"**
2. Select a student
3. Enter subject, grade, and percentage
4. Add semester and academic year
5. Click **"Add Grade"**

### Viewing Reports

- **Attendance Report**: View attendance statistics by date range
- **Grade Report**: See academic performance by student or subject
- **Student Profile**: Complete overview of individual student data

---

## 🔌 API Endpoints

### Student Autocomplete
```
GET /ajax/students_autocomplete.php?term={search_term}

Response:
[
  {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  ...
]
```

### Common Operations

| Operation | Method | Endpoint | Parameters |
|-----------|--------|----------|------------|
| Add Student | POST | /public/add_student.php | Form data |
| Edit Student | POST | /public/edit_student.php | id, Form data |
| Delete Student | GET | /public/delete_student.php | id |
| View Student | GET | /public/view_student.php | id |
| Search Students | GET | /public/search.php | query |
| Save Attendance | POST | /public/attendance_save.php | date, attendance[] |

---

## 🔒 Security Features

### Current Implementation
- Session-based authentication
- SQL injection prevention using PDO prepared statements
- XSS protection with input sanitization
- CSRF token validation (recommended to add)

### Recommended Enhancements
```php
// Password hashing (to be implemented)
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Password verification
if (password_verify($input_password, $hashed_password)) {
    // Login successful
}
```

### Security Best Practices
1. ✅ Use prepared statements for all database queries
2. ✅ Validate and sanitize all user inputs
3. ⚠️ Implement password hashing (bcrypt/argon2)
4. ⚠️ Add CSRF protection
5. ⚠️ Use HTTPS in production
6. ⚠️ Implement rate limiting for login attempts
7. ⚠️ Regular security audits

---

## 🚀 Future Roadmap

### Phase 1: Enhanced Security (Priority: High)
- [ ] Implement bcrypt password hashing
- [ ] Add CSRF token validation
- [ ] Two-factor authentication (2FA)
- [ ] Password reset functionality
- [ ] Account lockout after failed attempts

### Phase 2: User Experience (Priority: High)
- [ ] Responsive design (Bootstrap 5/Tailwind CSS)
- [ ] Dark mode toggle
- [ ] Improved data visualization (Chart.js)
- [ ] Advanced filtering and sorting
- [ ] Bulk operations (import/export CSV)

### Phase 3: Features (Priority: Medium)
- [ ] Student login portal
- [ ] Parent/Guardian access
- [ ] Email notifications
- [ ] SMS alerts integration
- [ ] Document upload (ID cards, certificates)
- [ ] Fee management module
- [ ] Exam scheduling system

### Phase 4: Technical Improvements (Priority: Medium)
- [ ] RESTful API architecture
- [ ] Pagination for large datasets
- [ ] Caching mechanism (Redis)
- [ ] Database optimization and indexing
- [ ] API rate limiting
- [ ] Logging system

### Phase 5: Advanced Features (Priority: Low)
- [ ] Multi-language support (i18n)
- [ ] Role-based access control (RBAC)
- [ ] Advanced reporting (PDF/Excel export)
- [ ] Mobile app (React Native)
- [ ] Real-time notifications (WebSocket)
- [ ] AI-powered analytics

---

## 🐛 Troubleshooting

### Common Issues and Solutions

#### 1. **Database Connection Error**
```
Error: Connection failed: SQLSTATE[HY000] [1045] Access denied
```
**Solution:**
- Check `config/db.php` credentials
- Verify MySQL service is running
- Ensure database exists

#### 2. **Page Not Found (404)**
```
Error: The requested URL was not found
```
**Solution:**
- Check file path and spelling
- Verify `.htaccess` configuration
- Ensure mod_rewrite is enabled in Apache

#### 3. **AJAX Autocomplete Not Working**
**Solution:**
- Check browser console for JavaScript errors
- Verify `ajax/students_autocomplete.php` path
- Ensure jQuery is loaded properly

#### 4. **Session Issues**
```
Error: Headers already sent
```
**Solution:**
- Ensure `session_start()` is called before any output
- Check for whitespace before `<?php` tags
- Verify `php.ini` session configuration

#### 5. **Blank Page After Login**
**Solution:**
- Enable PHP error reporting in `php.ini`:
  ```ini
  display_errors = On
  error_reporting = E_ALL
  ```
- Check Apache error logs
- Verify session variables are set correctly

### Debug Mode

Enable debug mode by adding to `config/db.php`:
```php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

---

## 🤝 Contributing

We welcome contributions from the community! Here's how you can help:

### How to Contribute

1. **Fork the Repository**
   ```bash
   git fork https://github.com/sagardonut/StudentManagementSystem.git
   ```

2. **Create a Feature Branch**
   ```bash
   git checkout -b feature/AmazingFeature
   ```

3. **Commit Your Changes**
   ```bash
   git commit -m "Add some AmazingFeature"
   ```

4. **Push to the Branch**
   ```bash
   git push origin feature/AmazingFeature
   ```

5. **Open a Pull Request**

### Contribution Guidelines

- Follow PSR-12 coding standards for PHP
- Write clear, descriptive commit messages
- Add comments for complex logic
- Update documentation for new features
- Test your changes thoroughly
- Ensure backward compatibility

### Code Review Process

1. All submissions require review
2. Maintain code quality standards
3. Pass all automated tests
4. Update relevant documentation

---

## 📄 License

This project is created for **educational purposes only**.

### Terms of Use
- ✅ Free to use for learning and educational projects
- ✅ Modify and customize for personal use
- ✅ Use as reference for academic projects
- ❌ Not licensed for commercial use without permission
- ❌ No warranty or liability provided

### Attribution
If you use this project in your work, please provide appropriate credit:
```
Based on Student Management System by Sagar Donut
GitHub: https://github.com/sagardonut/StudentManagementSystem
```

---

## 🙏 Acknowledgments

### Technologies Used
- **PHP** - Server-side scripting language
- **MySQL** - Database management system
- **Apache** - Web server
- **JavaScript** - Client-side scripting
- **XAMPP/WAMP** - Development environment

### Resources
- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Reference Manual](https://dev.mysql.com/doc/)
- [MDN Web Docs](https://developer.mozilla.org/)
- [W3Schools](https://www.w3schools.com/)

### Inspiration
This project was created to help students and developers learn full-stack web development concepts through a practical, real-world application.

---

## 📞 Contact

### Project Maintainer

**Sagar Donut**

- 🌐 GitHub: [@sagardonut](https://github.com/sagardonut)
- 🔗 Project Link: [Student Management System](https://github.com/sagardonut/StudentManagementSystem)

### Support

- 🐛 **Report Issues**: [GitHub Issues](https://github.com/sagardonut/StudentManagementSystem/issues)
- 💡 **Feature Requests**: [GitHub Discussions](https://github.com/sagardonut/StudentManagementSystem/discussions)
- 📧 **Email**: [Create an issue for contact]

---

## 📊 Project Stats

<div align="center">

![GitHub stars](https://img.shields.io/github/stars/sagardonut/StudentManagementSystem?style=social)
![GitHub forks](https://img.shields.io/github/forks/sagardonut/StudentManagementSystem?style=social)
![GitHub watchers](https://img.shields.io/github/watchers/sagardonut/StudentManagementSystem?style=social)

![GitHub last commit](https://img.shields.io/github/last-commit/sagardonut/StudentManagementSystem)
![GitHub issues](https://img.shields.io/github/issues/sagardonut/StudentManagementSystem)
![GitHub pull requests](https://img.shields.io/github/issues-pr/sagardonut/StudentManagementSystem)

</div>

---

## 🌟 Show Your Support

If you find this project helpful, please consider:

- ⭐ **Starring** the repository
- 🍴 **Forking** for your own projects
- 📢 **Sharing** with others who might benefit
- 🐛 **Reporting bugs** or suggesting improvements
- 💬 **Joining discussions** in the community

---

<div align="center">

### 💡 "Education is the most powerful weapon which you can use to change the world." - Nelson Mandela

**Built with ❤️ for the Education Community**

---

**[⬆ Back to Top](#-student-management-system)**

</div>
