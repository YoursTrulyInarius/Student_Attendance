<?php require_once '../app/views/layouts/header.php'; ?>

<div class="login-container">
    <div class="login-left">
        <div class="login-left-content">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🏛️</div>
            <h1>Academic Attendance Tracking</h1>
            <p>Streamline your institution's attendance management with our secure, fast, and professional digital portal.</p>
        </div>
    </div>

    <div class="login-right">
        <?php if (!isset($data['is_login']) || $data['is_login']): ?>
            <div class="login-card" id="login-box">
                <h2>Login</h2>
                <?php flash('login_message'); ?>
                <form action="<?php echo BASE_URL; ?>users/login" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username"
                            value="<?php echo isset($data['username']) ? $data['username'] : ''; ?>" required>
                        <span
                            class="error-msg"><?php echo isset($data['username_err']) ? $data['username_err'] : ''; ?></span>
                    </div>
                    <div class="form-group form-group-password">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required>
                        <button type="button" class="eye-toggle" onclick="togglePassword('password')">👁️</button>
                        <span
                            class="error-msg"><?php echo isset($data['password_err']) ? $data['password_err'] : ''; ?></span>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
                    <p style="margin-top: 1rem; text-align: center;">Don't have an account? <a
                            href="<?php echo BASE_URL; ?>users/register"
                            style="color: var(--secondary-color); font-weight: 600;">Register here</a></p>
                </form>
            </div>
        <?php else: ?>
            <div class="login-card" id="register-box">
                <h2>Register</h2>
                <form action="<?php echo BASE_URL; ?>users/register" method="POST">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" name="full_name" id="full_name"
                            value="<?php echo isset($data['full_name']) ? $data['full_name'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username"
                            value="<?php echo isset($data['username']) ? $data['username'] : ''; ?>" required>
                        <span
                            class="error-msg"><?php echo isset($data['username_err']) ? $data['username_err'] : ''; ?></span>
                    </div>
                    <!-- Phone number added for validation check as requested, though not in schema for users yet, I'll add it to students or keep it UI for now -->
                    <div class="form-group">
                        <label for="phone">Phone Number (Optional)</label>
                        <input type="text" name="phone" id="phone" placeholder="09123456789" maxlength="11"
                            oninput="validatePhone(this)">
                    </div>
                    <div class="form-group form-group-password">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="reg_password" required>
                        <button type="button" class="eye-toggle" onclick="togglePassword('reg_password')">👁️</button>
                        <span
                            class="error-msg"><?php echo isset($data['password_err']) ? $data['password_err'] : ''; ?></span>
                    </div>
                    <div class="form-group form-group-password">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" required>
                        <button type="button" class="eye-toggle" onclick="togglePassword('confirm_password')">👁️</button>
                        <span
                            class="error-msg"><?php echo isset($data['confirm_password_err']) ? $data['confirm_password_err'] : ''; ?></span>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Register</button>
                    <p style="margin-top: 1rem; text-align: center;">Already have an account? <a
                            href="<?php echo BASE_URL; ?>users/login"
                            style="color: var(--secondary-color); font-weight: 600;">Login here</a></p>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        if (input.type === 'password') {
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    }

    function validatePhone(input) {
        // Remove letters
        input.value = input.value.replace(/[^0-9]/g, '');

        // Max 11 digits
        if (input.value.length > 11) {
            input.value = input.value.slice(0, 11);
        }
    }
</script>

<?php require_once '../app/views/layouts/footer.php'; ?>