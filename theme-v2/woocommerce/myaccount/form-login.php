<?php
/**
 * Login Form - Barel Ofir v2 Custom
 *
 * @package barel-v2
 */
defined("ABSPATH") || exit;

do_action("woocommerce_before_customer_login_form");
?>

<style>
.barel-login-wrap{max-width:1280px;margin:40px auto 60px;padding:0 20px;display:grid;grid-template-columns:1fr 1fr;gap:32px;direction:rtl}
@media(max-width:768px){.barel-login-wrap{grid-template-columns:1fr}}
.barel-login-box,.barel-register-box{background:#fff;border:1.5px solid #e5e5e5;border-radius:14px;padding:32px;box-shadow:0 1px 4px rgba(0,0,0,.08)}
.login-box-title{font-family:"Rubik",sans-serif;font-weight:800;font-size:20px;color:#111;margin-bottom:20px;display:flex;align-items:center;gap:8px}
.login-box-title::before{content:"";display:block;width:4px;height:22px;background:#c0001a;border-radius:2px}
.barel-form .form-row{margin-bottom:14px}
.barel-form label{display:block;font-size:13px;font-weight:700;color:#111;margin-bottom:5px}
.barel-form .input-text{width:100%;border:1.5px solid #e5e5e5;border-radius:8px;padding:11px 14px;font-family:"Heebo",sans-serif;font-size:14px;color:#111;outline:none;transition:border-color .2s}
.barel-form .input-text:focus{border-color:#c0001a;box-shadow:0 0 0 3px rgba(192,0,26,.07)}
.barel-form .woocommerce-form__label-for-checkbox{display:flex;align-items:center;gap:8px;font-size:13px;color:#444;cursor:pointer}
.barel-form .woocommerce-form__input-checkbox{accent-color:#c0001a;width:15px;height:15px}
.barel-login-btn{width:100%;background:#c0001a;color:#fff;border:none;border-radius:8px;padding:13px;font-family:"Heebo",sans-serif;font-size:15px;font-weight:700;cursor:pointer;margin-top:8px;transition:background .2s}
.barel-login-btn:hover{background:#8f0013}
.barel-lost-pw{display:inline-block;font-size:12px;color:#777;margin-top:8px;text-align:center;width:100%;text-decoration:none}
.barel-lost-pw:hover{color:#c0001a}
</style>

<div class="barel-login-wrap">
  <!-- LOGIN -->
  <div class="barel-login-box">
    <div class="login-box-title">כניסה לחשבון</div>
    <form class="woocommerce-form woocommerce-form-login login barel-form" method="post" novalidate>
      <?php do_action("woocommerce_login_form_start"); ?>
      <div class="form-row">
        <label for="username">שם משתמש או אימייל <span class="required">*</span></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo (!empty($_POST["username"]) && is_string($_POST["username"])) ? esc_attr(wp_unslash($_POST["username"])) : ""; ?>" required />
      </div>
      <div class="form-row">
        <label for="password">סיסמה <span class="required">*</span></label>
        <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" required />
      </div>
      <?php do_action("woocommerce_login_form"); ?>
      <div class="form-row">
        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
          <input class="woocommerce-form__input woocommerce-form__input-checkbox woocommerce-form-login__rememberme" name="rememberme" type="checkbox" id="rememberme" value="forever" />
          <span>זכור אותי</span>
        </label>
      </div>
      <?php wp_nonce_field("woocommerce-login", "woocommerce-login-nonce"); ?>
      <input type="hidden" name="redirect" value="<?php echo esc_url(wc_get_page_permalink("myaccount")); ?>" />
      <button type="submit" class="woocommerce-button button woocommerce-form-login__submit barel-login-btn" name="login" value="<?php esc_attr_e("Log in", "woocommerce"); ?>">כניסה</button>
      <?php do_action("woocommerce_login_form_end"); ?>
    </form>
    <a class="barel-lost-pw" href="<?php echo esc_url(wp_lostpassword_url()); ?>">שכחת סיסמה?</a>
  </div>

  <!-- REGISTER -->
  <?php if ("yes" === get_option("woocommerce_enable_myaccount_registration")): ?>
  <div class="barel-register-box">
    <div class="login-box-title">הרשמה</div>
    <form method="post" class="woocommerce-form woocommerce-form-register register barel-form" novalidate>
      <?php do_action("woocommerce_register_form_start"); ?>
      <?php if ("no" === get_option("woocommerce_registration_generate_username")): ?>
      <div class="form-row">
        <label for="reg_username">שם משתמש <span class="required">*</span></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo (!empty($_POST["username"])) ? esc_attr(wp_unslash($_POST["username"])) : ""; ?>" required />
      </div>
      <?php endif; ?>
      <div class="form-row">
        <label for="reg_email">כתובת אימייל <span class="required">*</span></label>
        <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo (!empty($_POST["email"])) ? esc_attr(wp_unslash($_POST["email"])) : ""; ?>" required />
      </div>
      <?php if ("no" === get_option("woocommerce_registration_generate_password")): ?>
      <div class="form-row">
        <label for="reg_password">סיסמה <span class="required">*</span></label>
        <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" required />
      </div>
      <?php endif; ?>
      <?php do_action("woocommerce_register_form"); ?>
      <?php wp_nonce_field("woocommerce-register", "woocommerce-register-nonce"); ?>
      <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit barel-login-btn" name="register" value="<?php esc_attr_e("Register", "woocommerce"); ?>">הרשמה</button>
      <?php do_action("woocommerce_register_form_end"); ?>
    </form>
    <p style="font-size:12px;color:#888;margin-top:12px;text-align:center">בלחיצה על הרשמה אתה מסכים ל<a href="/terms/" style="color:#c0001a">תנאי השימוש</a></p>
  </div>
  <?php endif; ?>
</div>

<?php do_action("woocommerce_after_customer_login_form"); ?>
