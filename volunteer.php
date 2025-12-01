
<?php
require __DIR__ . '/../src/config.php';
require __DIR__ . '/../src/functions.php';

$errors = [];
$name = trim($_POST['vname'] ?? '');
$email = trim($_POST['vemail'] ?? '');
$role = trim($_POST['vrole'] ?? '');
$days = $_POST['days'] ?? [];
$msg  = trim($_POST['vmessage'] ?? '');

$availability = is_array($days) ? implode(', ', $days) : '';

if ($name === '') {
    $errors[] = 'Name is required.';
}
if (!is_valid_email($email)) {
    $errors[] = 'A valid email is required.';
}
if ($role === '') {
    $errors[] = 'Preferred role is required.';
}

if (empty($errors)) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO volunteers
            (full_name, email, role, availability, message)
            VALUES (:name, :email, :role, :availability, :message)
        ");

        $stmt->execute([
            ':name'         => $name,
            ':email'        => $email,
            ':role'         => $role,
            ':availability' => $availability,
            ':message'      => $msg,
        ]);

        $successMessage = "Thank you, {$name}! You have been registered as a volunteer.";
    } catch (PDOException $e) {
        $errors[] = 'An error occurred while saving your volunteer registration.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Volunteer Status | Adopt-A-Pals</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <h1>Adopt-A-Pals</h1>
</header>
<main>
    <div class="container">
        <h2>Volunteer Registration Status</h2>

        <?php if (!empty($errors)): ?>
            <div class="message message-error">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?= e($err); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
            <div class="message message-success">
                <?= e($successMessage ?? 'Registration submitted.'); ?>
            </div>
        <?php endif; ?>

        <p><a href="index.php#volunteer">Back to Volunteer Page</a></p>
    </div>
</main>
<footer>
    &copy; <?= date('Y'); ?> Adopt-A-Pals
</footer>
</body>
</html>
