<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="radium_login_register_wrapper">

    <div class="row">

        <div class='large-6 columns'>

            <form method="post" class="login">

                <h2><?php _e("I'm a Returning Customer", "radium"); ?></h2>

                <p>
                    <label for="username"><?php _e('Username or email', 'radium'); ?> <span class="required">*</span></label>
                    <input type="text" class="input-text" name="username" id="username" />
                </p>

                <p>
                    <label for="password"><?php _e('Password', 'radium'); ?> <span class="required">*</span></label>
                    <input class="input-text" type="password" name="password" id="password" />
                </p>

                <p>
			<?php wp_nonce_field( 'woocommerce-login' ); ?>
                    
<a class="lost_password" href="<?php echo esc_url( wp_lostpassword_url( home_url() ) ); ?>"><?php _e('Lost Password?', 'radium'); ?></a>
                    <input type="submit" class="button" name="login" value="<?php _e('Login', 'radium'); ?>" />
                    <input type="hidden" name="radium_login_register_section_name" value="login" />
                </p>
		<?php do_action( 'woocommerce_login_form_end' ); ?>


            </form>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

            <form method="post" class="register">
		<?php do_action( 'woocommerce_register_form_start' ); ?>

                <h2><?php _e('Register', 'radium'); ?></h2>

                <?php if ( get_option( 'woocommerce_registration_email_for_username' ) == 'no' ) : ?>

                    <p>
                        <label for="reg_username"><?php _e('Username', 'radium'); ?> <span class="required">*</span></label>
                        <input type="text" class="input-text" name="username" id="reg_username" value="<?php if (isset($_POST['username'])) echo esc_attr($_POST['username']); ?>" />
                    </p>

                <?php endif; ?>

            	<p>
                    <label for="reg_email"><?php _e('Email', 'radium'); ?> <span class="required">*</span></label>
                    <input type="email" class="input-text" name="email" id="reg_email" value="<?php if (isset($_POST['email'])) echo esc_attr($_POST['email']); ?>" />
                </p>

                <p>
                    <label for="reg_password"><?php _e('Password', 'radium'); ?> <span class="required">*</span></label>
                    <input type="password" class="input-text" name="password" id="reg_password" value="<?php if (isset($_POST['password'])) echo esc_attr($_POST['password']); ?>" />
                </p>

                <p>
                    <label for="reg_password2"><?php _e('Re-enter password', 'radium'); ?> <span class="required">*</span></label>
                    <input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if (isset($_POST['password2'])) echo esc_attr($_POST['password2']); ?>" />
                </p>

                <!-- Spam Trap -->
                <div style="left:-999em; position:absolute;"><label for="trap">Anti-spam</label><input type="text" name="email_2" id="trap" /></div>

			<?php do_action( 'woocommerce_register_form' ); ?>
			<?php do_action( 'register_form' ); ?>

                <p>
					<?php wp_nonce_field( 'woocommerce-register', 'register' ); ?>
                    <input type="submit" class="button" name="register" value="<?php _e('Register', 'radium'); ?>" />
                    <input type="hidden" name="radium_login_register_section_name" value="register" />
                </p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>

        	<?php endif; ?>

        </div>

		<div class="large-6 columns">

			<div class="radium_login_register_reg">

		    	<h2><?php _e('Register', 'radium'); ?></h2>

		        <?php _e('Test Drive the Demo. Login with demo for both username and password and checkout: ', 'radium'); ?>

		        <input type="submit" class="button" name="create_account" value="<?php _e('Register', 'radium'); ?>">

		    </div>

		    <div class="radium_login_register_log">

		    	<h2><?php _e('', 'radium'); ?></h2>

		        <?php _e('', 'radium'); ?>

		        <input type="submit" class="button" name="create_account" value="<?php _e('Login', 'radium'); ?>">

		    </div>

		</div>

	</div>

</div>


<?php endif; ?>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
