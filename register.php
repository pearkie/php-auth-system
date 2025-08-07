<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validate inputs
    if ($email === '' || $password === '') {
        $error = 'Please fill in all fields.';
    } else {
        // Load existing users
        $usersFile = 'users.json';
        $users = [];

        if (file_exists($usersFile)) {
            $json = file_get_contents($usersFile);
            $users = json_decode($json, true) ?? [];
        }

        // Check if email is already taken
        $emailExists = false;
        foreach ($users as $user) {
            if ($user['$email'] === $email) {
                $emailExists = true;
                break;
            }
        }

        if ($emailExists) {
            $error = 'Email is already registered.';
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Add new user
            $users[] = [
                'email' => $email,
                'password' => $hashedPassword
            ];

            // Save users
            file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

            // Redirect to login
            header('Location: login.php');
            exit;
        }
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Email:</label><br>
        <input type="email" name="email" required> <br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required> <br><br>

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</body>
</html>

