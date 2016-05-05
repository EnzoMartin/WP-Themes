<?php
$image = get_bloginfo('template_directory') . '/assets/img/base-banner.jpg';
$imageMeta = get_post_meta($post->ID, 'voice_image', true);
if($imageMeta){
    $image = wp_get_attachment_url($imageMeta, 'fullsize');
}

$headingMeta = get_post_meta($post->ID, 'voice_text_heading', true);
if($headingMeta == ''){
    $headingMeta = get_the_title();
}
$subheadingMeta = get_post_meta($post->ID, 'voice_text_subheading', true);
$urlMeta = get_post_meta($post->ID, 'voice_text_url', true);
?>

<div class="banner" style="background-image: url('<?php echo $image; ?>')">
	<a href="<?php echo $urlMeta; ?>" class="bg-link"></a>
    <div class="bottom">
	    <a href="<?php echo $urlMeta; ?>">
	        <div class="heading pull-left">
	            <h2><?php echo $headingMeta; ?></h2>
	        </div>
	    </a>
        <div class="subheading">
            <?php if($subheadingMeta != ''){ ?>
	            <a href="<?php echo $urlMeta; ?>">
                    <h3 class="pull-left hidden-xs"><?php echo $subheadingMeta; ?></h3>
	            </a>
            <?php } ?>
            <a href="<?php echo $urlMeta; ?>" class="btn btn-order pull-right">Order your server</a>
        </div>
    </div>
</div>