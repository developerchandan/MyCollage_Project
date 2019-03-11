<?php
/**
 * The template for displaying the footer.
 *
 * @package RadiumFramework
 * @since RadiumFramework 1.0.0
 */
 ?>
</div><!-- #main-container -->
<?php
	do_action( 'radium_before_footer' );
	do_action( 'radium_footer' );
	do_action( 'radium_after_footer' );
?>
</div><!-- #theme-wrapper-inner -->
</div><!-- #theme-wrapper -->
<?php wp_footer(); ?>
</body>
</html>