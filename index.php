<?php
session_start();
$old = $_SESSION['old'] ?? [];
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['old'], $_SESSION['errors']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 01 - Student Registration</title>
    <link rel="stylesheet" href="index.css">
   
</head>
<body>

<div class="container">
    <h2>Student Registration (Lab 01)</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert-error">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?php echo htmlspecialchars($err); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="register.php" method="POST">
        <div class="form-group">
            <label for="fullname">Full name</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($old['fullname'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="phone">Telephone</label>
            <input type="tel" id="phone" name="phone" placeholder="e.g. 6XXXXXXXX" value="<?php echo htmlspecialchars($old['phone'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="dob">Date of birth</label>
            <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($old['dob'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="programme">Programme</label>
            <select id="programme" name="programme">
                <option value="">[Choose an option]</option>
                <option value="Software Engineering" <?php if(($old['programme']??'')=='Software Engineering') echo 'selected'; ?>>Software Engineering</option>
                <option value="Computer Networks" <?php if(($old['programme']??'')=='Computer Networks') echo 'selected'; ?>>Computer Networks</option>
                <option value="Database Management" <?php if(($old['programme']??'')=='Database Management') echo 'selected'; ?>>Database Management</option>
            </select>
        </div>

        <div class="form-group">
            <label for="level">Level</label>
            <select id="level" name="level">
                <option value="">[Choose an option]</option>
                <option value="Level 1" <?php if(($old['level']??'')=='Level 1') echo 'selected'; ?>>Level 1</option>
                <option value="Level 2" <?php if(($old['level']??'')=='Level 2') echo 'selected'; ?>>Level 2</option>
                <option value="Level 3" <?php if(($old['level']??'')=='Level 3') echo 'selected'; ?>>Level 3</option>
            </select>
        </div>

        <div class="form-group">
            <label>Gender</label>
            <div class="radio-group">
                <label><input type="radio" name="gender" value="Option A" <?php if(($old['gender']??'')=='Option A') echo 'checked'; ?>> Option A</label>
                <label><input type="radio" name="gender" value="Option B" <?php if(($old['gender']??'')=='Option B') echo 'checked'; ?>> Option B</label>
            </div>
        </div>

        <div class="checkbox-group">
            <input type="checkbox" id="policy" name="policy" value="1" <?php if(isset($old['policy'])) echo 'checked'; ?>>
            <label for="policy">I agree to the registration policy</label>
        </div>

        <div class="btn-container">
            <button type="submit">Submit Form</button>
            <a href="index.php" class="btn-reset">Reset</a>
        </div>
    </form>
</div>

</body>
</html>