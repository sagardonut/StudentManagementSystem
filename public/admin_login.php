<?php
require_once "../includes/config.php";

$valid_user = "admin";
$valid_pass = "admin123";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST["csrf_token"] ?? "";

    if (!$token || !hash_equals($_SESSION["csrf_token"], $token)) {
        $error = "Invalid request.";
    } else {
        $u = trim($_POST["username"] ?? "");
        $p = $_POST["password"] ?? "";

        if ($u === $valid_user && $p === $valid_pass) {
            $_SESSION["admin"] = true;
            header("Location: index.php");
            exit;
        }

        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        .main {
            display: grid;
            grid-template-columns: 65% 35%;
            height: 100vh;
        }

        .video-wrap {
            position: relative;
            height: 100%;
            overflow: hidden;
            background: #000;
        }

        .video-wrap video {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .login {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #000;
            color: #fff;
        }

        .form {
            width: 100%;
            max-width: 360px;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            color: #b685e7;
        }

        p {
            color: #ffffff;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 14px;
            margin-bottom: 18px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: #b685e7;
            color: #fff;
            font-size: 1rem;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.9
        }

        .error {
            color: #c0392b;
            margin-bottom: 15px;
        }

        small {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #ffffff;
        }
    </style>
</head>

<body>

    <div class="main">
        <div class="video-wrap">
            <video autoplay muted loop playsinline>
                <source src="../assets/videos/login-avatar.mp4" type="video/mp4">
            </video>
        </div>

        <div class="login">
            <form class="form" method="post">
                <h1>Admin Login</h1>
                <p>If this is confusing, it shouldn’t be.</p>

                <?php if ($error): ?>
                    <div class="error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"]) ?>">

                <label>Username</label>
                <input type="text" name="username" placeholder="admin" required>

                <label>Password</label>
                <input type="password" name="password" placeholder="admin123" required>

                <button>Login</button>
                <small>Demo admin login · Overthinking disabled</small>
            </form>
        </div>
    </div>

</body>

</html>