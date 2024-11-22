<form action="" method="post" enctype="multipart/form-data">
    <h2 class="form-title"><?php echo _("Login to Your Account") ?></h2>
    
    <!-- Username Input -->
    <div class="input-field" autocomplete="username">
        <div class="input-field-icon">
            <i class="fas fa-user"></i>
        </div>
        <input id="username" name="username" type="text" 
               placeholder="<?php echo _("Enter your username") ?>" 
               class="input-field-input" required>
    </div>
    
    <!-- Password Input -->
    <div class="input-field" autocomplete="current-password">
        <div class="input-field-icon">
            <i class="fas fa-lock"></i>
        </div>
        <input id="password" name="password" type="password" 
               placeholder="<?php echo _("Enter your password") ?>" 
               class="input-field-input" required>
        <span class="input-field-icon-right">
            <a class="reveal silver" data-reveal="password">
                <i class="fas fa-eye"></i>
            </a>
        </span>
    </div>

    <!-- Remember Me -->
    <div class="form-options">
        <label class="checkbox-container">
            <input type="checkbox" name="remember_me">
            <span class="checkbox-checkmark"></span>
            <?php echo _("Remember Me") ?>
        </label>
        <a href="#" class="forgot-password-link">
            <?php echo _("Forgot your password?") ?>
        </a>
    </div>

    <!-- Submit Button -->
    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?php echo _("Login") ?></button>
    </div>

    <!-- Additional Links -->
    <div class="form-footer">
        <p><?php echo _("Don't have an account?") ?> 
            <a href="register.php"><?php echo _("Sign up") ?></a>
        </p>
    </div>
</form>
