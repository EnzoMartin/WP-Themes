<?php
$banners = new WP_Query(
    array(
        'post_type' => 'banner',
        'meta_key' => 'banners_text_order',
        'order' => 'ASC',
        'orderby' => 'meta_value_num',
        'nopaging' => true
    )
);
$html = [];
if ( $banners->have_posts() ) {
    $classes = 'active';
    while($banners->have_posts()): $banners->the_post();
        if(get_post_status() == 'publish') {
            $imageMeta = get_post_meta($post->ID, 'banners_image', true);
            $image = wp_get_attachment_url($imageMeta, 'fullsize');

            $subheading = get_post_meta($post->ID, 'banners_text_subheading', true);
            $caption = get_post_meta($post->ID, 'banners_text_caption', true);
            $link = get_post_meta($post->ID, 'banners_text_link', true);
            $linktext = get_post_meta($post->ID, 'banners_text_link_text', true);
            if ($linktext == '') {
                $linktext = 'Learn more information';
            }

            $banner = '<div class="item ' . $classes . '">
                        <a href="' . $link . '"><img src="' . $image . '" alt=""></a>
                        <div class="container">
                        <div class="carousel-caption">
                            <a href="' . $link . '"><h5>' . get_the_title() . '</h5><a/>' .
                (($subheading != '') ? '<a href="' . $link . '"><h6>' . $subheading . '</h6></a>' : '') .
                (($caption != '') ? '<a href="' . $link . '"><p>' . $caption . '</p></a>' : '') .
                (($link != '') ? '<a class="btn btn-info" href="' . $link . '">' . $linktext . '</a>' : '') .
                '</div></div>
            </div>';
            array_push($html, $banner);
            $classes = '';
        }
    endwhile;
}
wp_reset_query();
?>

<div id="home-carousel" class="carousel slide hidden-xs hidden-sm" data-ride="carousel">
    <?php
    $len = count($html);
    if($len > 1){
    ?>
    <ol class="carousel-indicators">
        <?php
        $count = 0;
        $classes = 'active';

        while($count < $len){
            echo '<li data-target="#home-carousel" data-slide-to="' . $count . '" class="'. $classes . '"></li>';
            $classes = '';
            $count++;
        }
        ?>
    </ol>
    <?php } ?>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <?php
        foreach($html as $banner){
            echo $banner;
        }
        ?>
    </div>

    <div class="carousel-overlay left"></div>
    <div class="carousel-overlay right"></div>

    <?php if($len > 1){ ?>
        <a class="left carousel-control" href="#home-carousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#home-carousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    <?php } ?>
</div>