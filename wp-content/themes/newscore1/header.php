<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up until <div id="main-container">
 *
 * @package NewsCore
 * @since RadiumFramework 1.0.0
 */

do_action( 'radium_doctype' );
do_action( 'radium_meta' );
do_action( 'radium_title' );
 
wp_head(); //* we need this for plugins and hooks
?>
</head>
<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">

    <?php do_action( 'radium_before' ); ?>

    <div id="theme-wrapper">
    	<div id="theme-wrapper-inner">
	    <?php
	    	do_action( 'radium_before_header' );
	    	do_action( 'radium_header' );
	    	do_action( 'radium_after_header' );
	    ?>

		<div id="main-container">
