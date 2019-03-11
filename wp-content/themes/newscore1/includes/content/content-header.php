<header id="page-header">

    <div class="row">

        <div class="large-6 columns">
            <?php

            $header_content = array();

            $header_content = apply_filters( 'radium_header_content', $header_content );

            if ( $header_content['title']) { ?><h1 class="header"><?php echo $header_content['title']; ?></h1><?php }
            if ( $header_content['subtitle'] )  { ?><h3 class="subheader"><?php echo $header_content['subtitle']; ?></h3><?php }

            ?>
        </div>

        <div class="large-6 columns">
            <?php do_action('radium_header_breadcrumb'); ?>
        </div>

    </div>

</header>