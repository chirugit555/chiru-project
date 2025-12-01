
<?php
require __DIR__ . '/../src/config.php';
require __DIR__ . '/../src/functions.php';

$errors = [];
$name   = trim($_POST['name'] ?? '');
$email  = trim($_POST['email'] ?? '');
$phone  = trim($_POST['phone'] ?? '');
$pet    = trim($_POST['pet_choice'] ?? 'Any');
$home   = trim($_POST['home_type'] ?? '');
$reason = trim($_POST['reason'] ?? '');

// Validation
if ($name === '') {
    $errors[] = 'Name is required.';
}
if (!is_valid_email($email)) {
    $errors[] = 'A valid email is required.';
}
if (!is_valid_phone($phone)) {
    $errors[] = 'A valid phone number is required.';
}
if ($home === '') {
    $errors[] = 'Home type is required.';
}

if (empty($errors)) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO adoption_requests
            (full_name, email, phone, pet_choice, home_type, reason)
            VALUES (:name, :email, :phone, :pet, :home, :reason)
        ");

        $stmt->execute([
            ':name'   => $name,
            ':email'  => $email,
            ':phone'  => $phone,
            ':pet'    => $pet,
            ':home'   => $home,
            ':reason' => $reason,
        ]);

        $successMessage = "Thank you, {$name}! Your adoption request has been received.";
    } catch (PDOException $e) {
        $errors[] = 'An error occurred while saving your request. Please try again later.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adoption Request | Adopt-A-Pals</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <h1>Adopt-A-Pals</h1>
</header>
<main>
    <div class="container">
        <h2>Adoption Request Status</h2>

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
                <?= e($successMessage ?? 'Request submitted.'); ?>
            </div>
        <?php endif; ?>

        <p>
            <a href="index.php#adopt">Back to Adoption Page</a>
        </p>
    </div>
</main>
<footer>
    &copy; <?= date('Y'); ?> Adopt-A-Pals
</footer>
</body>
</html>
