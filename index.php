
<?php
require __DIR__ . '/../src/config.php';
require __DIR__ . '/../src/functions.php';

// Fetch pets from DB for listing & dropdown
$petsStmt = $pdo->query("SELECT id, name, type, age, tag, status FROM pets ORDER BY name ASC");
$pets = $petsStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adopt-A-Pals | Animal Welfare & Adoption</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <h1>Adopt-A-Pals</h1>
    <p>Animal Welfare &amp; Pet Adoption Center</p>
</header>

<nav>
    <ul>
        <li><a href="#home">Home</a></li>
        <li><a href="#adopt">Adopt</a></li>
        <li><a href="#volunteer">Volunteer</a></li>
        <li><a href="#contact">Contact</a></li>
    </ul>
</nav>

<main id="home">
    <div class="container">
        <!-- Hero -->
        <section class="hero">
            <h2>Find Your New Best Friend</h2>
            <p>Rescue. Love. Repeat. Adopt a pal and change two lives – theirs and yours.</p>
            <div class="hero-buttons">
                <a href="#adopt">Adopt a Pal</a>
                <a href="#volunteer">Become a Volunteer</a>
            </div>
        </section>

        <!-- About -->
        <section id="about">
            <h2 class="section-title">About Adopt-A-Pals</h2>
            <p>
                Adopt-A-Pals is a community-run non-profit dedicated to rescuing, rehabilitating,
                and rehoming abandoned animals. We also conduct awareness programs on responsible pet parenting.
            </p>
            <div class="info-box">
                <strong>Our mission:</strong> No healthy, adoptable pet should be homeless or afraid.
            </div>
        </section>

        <!-- Adopt Section -->
        <section id="adopt">
            <h2 class="section-title">Adopt a Pal</h2>

            <p>These are some of the animals currently looking for loving homes:</p>
            <div class="pets-grid">
                <?php if ($pets): ?>
                    <?php foreach ($pets as $pet): ?>
                        <article class="pet-card">
                            <h3><?= e($pet['name']); ?></h3>
                            <p class="pet-meta"><strong>Type:</strong> <?= e($pet['type']); ?></p>
                            <p class="pet-meta"><strong>Age:</strong> <?= e($pet['age']); ?></p>
                            <p class="pet-meta"><strong>Status:</strong> <?= e($pet['status']); ?></p>
                            <span class="pet-tag"><?= e($pet['tag']); ?></span>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No pets listed yet. Please check back soon.</p>
                <?php endif; ?>
            </div>

            <h3>Adoption Interest Form</h3>
            <form method="post" action="adopt.php" novalidate>
                <table>
                    <tr>
                        <th colspan="2">Adopt-A-Pals – Adoption Form</th>
                    </tr>
                    <tr>
                        <td>Your Name *</td>
                        <td><input type="text" name="name" required></td>
                    </tr>
                    <tr>
                        <td>Email *</td>
                        <td><input type="email" name="email" required></td>
                    </tr>
                    <tr>
                        <td>Phone *</td>
                        <td><input type="tel" name="phone" required></td>
                    </tr>
                    <tr>
                        <td>Which pal?</td>
                        <td>
                            <select name="pet_choice">
                                <?php foreach ($pets as $pet): ?>
                                    <option value="<?= e($pet['name']); ?>">
                                        <?= e($pet['name']); ?> (<?= e($pet['type']); ?>)
                                    </option>
                                <?php endforeach; ?>
                                <option value="Any">Any suitable pal</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Home Type *</td>
                        <td>
                            <select name="home_type" required>
                                <option value="">Select...</option>
                                <option value="Apartment">Apartment</option>
                                <option value="Independent house">Independent house</option>
                                <option value="Farm / Large space">Farm / Large space</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Why do you want to adopt?</td>
                        <td><textarea name="reason"></textarea></td>
                    </tr>
                    <tr>
                        <td>Submit</td>
                        <td><input type="submit" value="Submit Adoption Request"></td>
                    </tr>
                </table>
            </form>
        </section>

        <!-- Volunteer Section -->
        <section id="volunteer">
            <h2 class="section-title">Volunteer with Us</h2>
            <p>Help us with feeding, walking, events, and outreach. Every hour counts.</p>

            <form method="post" action="volunteer.php" novalidate>
                <table>
                    <tr>
                        <th colspan="2">Volunteer Registration</th>
                    </tr>
                    <tr>
                        <td>Name *</td>
                        <td><input type="text" name="vname" required></td>
                    </tr>
                    <tr>
                        <td>Email *</td>
                        <td><input type="email" name="vemail" required></td>
                    </tr>
                    <tr>
                        <td>Preferred Role *</td>
                        <td>
                            <select name="vrole" required>
                                <option value="">Select...</option>
                                <option value="Animal care">Animal care</option>
                                <option value="Fundraising">Fundraising</option>
                                <option value="Events & campaigns">Events & campaigns</option>
                                <option value="Social media">Social media & awareness</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Availability</td>
                        <td>
                            <label><input type="checkbox" name="days[]" value="Weekdays"> Weekdays</label><br>
                            <label><input type="checkbox" name="days[]" value="Weekends"> Weekends</label><br>
                            <label><input type="checkbox" name="days[]" value="Evenings"> Evenings</label>
                        </td>
                    </tr>
                    <tr>
                        <td>Message (optional)</td>
                        <td><textarea name="vmessage"></textarea></td>
                    </tr>
                    <tr>
                        <td>Submit</td>
                        <td><input type="submit" value="Sign Up as Volunteer"></td>
                    </tr>
                </table>
            </form>
        </section>

        <!-- Contact Section -->
        <section id="contact">
            <h2 class="section-title">Contact Us</h2>
            <p>Have questions about adoption, volunteering, or donations? Reach out to us.</p>

            <table>
                <tr>
                    <th>Center</th>
                    <th>Details</th>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>Adopt-A-Pals Animal Welfare Center, Green Street, Pawtown, 123456</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>contact@adopt-a-pals.org</td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td>+91-9876543210</td>
                </tr>
            </table>

            <h3>Send Us a Message</h3>
            <form method="post" action="contact.php" novalidate>
                <table>
                    <tr>
                        <th colspan="2">Contact Form</th>
                    </tr>
                    <tr>
                        <td>Your Name *</td>
                        <td><input type="text" name="cname" required></td>
                    </tr>
                    <tr>
                        <td>Email *</td>
                        <td><input type="email" name="cemail" required></td>
                    </tr>
                    <tr>
                        <td>Subject</td>
                        <td><input type="text" name="csubject"></td>
                    </tr>
                    <tr>
                        <td>Message *</td>
                        <td><textarea name="cmessage" required></textarea></td>
                    </tr>
                    <tr>
                        <td>Submit</td>
                        <td><input type="submit" value="Send Message"></td>
                    </tr>
                </table>
            </form>
        </section>
    </div>
</main>

<footer>
    &copy; <?= date('Y'); ?> Adopt-A-Pals Animal Welfare &amp; Adoption Center. All rights reserved.
</footer>
</body>
</html>
