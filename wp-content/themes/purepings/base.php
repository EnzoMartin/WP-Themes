<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

<!--[if lt IE 9]>
<div class="alert alert-warning">
    <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your
    browser</a> to improve your experience.', 'roots'); ?>
</div>
<![endif]-->

<?php
do_action('get_header');
get_template_part('templates/header-top-navbar');
$image = false;
$isHome = false;
if(is_home() || is_front_page()){
    $isHome = true;
    get_template_part('templates/banners', 'home');
} else {
    if (get_post_type() != 'post' && get_post_type() != 'location' && get_post_type() != 'feature' && isset($post) && has_post_thumbnail( $post->ID ) ) {
        $image = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
    } else {
        $image = get_bloginfo('template_directory') . '/assets/img/planets-bg.jpg';
    }
}
?>

<div id="page-bg">
    <?php if(!$isHome){ ?>
        <div id="bg-sides"></div>
        <div id="bg-image">
            <?php if($image){ ?>
                <img src="<?php echo $image; ?>"/>
            <?php } ?>
        </div>
        <div id="bg-overlay"></div>
    <?php } ?>
    <div class="container-background">
        <div class="wrap container" role="document">
            <div class="content row">
                <?php include roots_template_path(); ?>
                <?php if (roots_display_sidebar()) : ?>
                    <aside class="<?php echo roots_sidebar_class(); ?> hidden-xs hidden-sm" role="complementary">
                        <?php include roots_sidebar_path(); ?>
                    </aside><!-- /.sidebar -->
                <?php endif; ?>
            </div>
            <!-- /.content -->
        </div>
        <!-- /.wrap -->
    </div>
</div>

<?php get_template_part('templates/footer'); ?>
<script type='text/javascript'>(function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://widget.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({ c: '381c39d7-d4ba-4d35-84ae-c0b68339b29d', f: true }); done = true; } }; })();</script>
</body>
</html>
