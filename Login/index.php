<?php
session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'signup' => $_SESSION['signup_error'] ?? ''
];
$activeForm = $_SESSION['active_form'] ?? 'login';

session_unset();

function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Sign Up</title>
    <link rel="stylesheet" href="style.css">
     <!-- <script src="https://cdn.tailwindcss.com"></script> -->
</head>
<body>
    
    <div class="container">
        <div class="form-box <?= isActiveForm('login', $activeForm); ?>" id="login-form">
            <form action="login_signup.php" method="post">
                <h2 >Login</h2>
                <?= showError($errors['login']); ?>
                <input type="email" name="email" id="" placeholder="Email" required>
                <input type="password" name="password" id="" placeholder="Password" required>
                <button type="submit" name="login" value="">Login</button>
                <p>Don’t have an account? <a href="#" onclick="showForm('signup-form')">Sign Up</a></p>
            </form>
        </div>

        <div class="form-box <?= isActiveForm('signup', $activeForm); ?>" id="signup-form">
            <form action="login_signup.php" method="post">
                <h2>Sign Up</h2>
                <?= showError($errors['signup']); ?>
                <input type="text" name="name" id="" placeholder="Name" required>
                <input type="email" name="email" id="" placeholder="Email" required>
                <input type="password" name="password" id="" placeholder="Password" required>
                <select name="role" id="">
                    <option value="">--Select Role--</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" name="signup" value="">Sign Up</button>
                <p>Already have an account? <a href="#" onclick="showForm('login-form')">Log In</a></p>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>