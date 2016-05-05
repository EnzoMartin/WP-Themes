<?php
/*
Template Name: Game Servers Template
*/
?>

<?php get_template_part('templates/page', 'header'); ?>
<main id="games-list" class="main <?php echo roots_main_class(); ?>" role="main">
    <div class="main-bg">
        <div class="content-padding">
            <?php get_template_part('templates/content', 'page'); ?>
        </div>
        <?php
        $games = new WP_Query(
            array(
                'post_type' => 'game',
                'order' => 'ASC',
                'orderby' => 'title',
                'nopaging' => true
            )
        );
        if ( $games->have_posts() ) { ?>
            <div class="content-padding">
                <h2>
                    <?php echo get_option('purepings_contentgames'); ?>
                    <small class="hidden-xs pull-right"><?php echo get_option('purepings_contentgamessubheading'); ?></small>
                </h2>
            </div>
	        <div class="visible-xs row">
		        <div class="col-xs-12 center">
		            <small><?php echo get_option('purepings_contentgamessubheading'); ?></small>
		        </div>
	        </div>
            <?php
            $leftColumn = [];
            $rightColumn = [];
            $i = 0;
            while($games->have_posts()): $games->the_post();
                $html = '
                    <a href="' . get_permalink() . '">
                        <div class="icon hidden-xs pull-left">
                            <div class="icon-bg" style="background-image:url(' . wp_get_attachment_url(get_post_meta(get_the_ID(),'game_icon',true)) . ')"></i></div>
                        </div>
                        <div class="title pull-left">' . get_the_title() . '</div>
                        <div class="arrow hidden-xs pull-right"><i class="fa fa-chevron-right"></i></div>
                        <div class="price pull-right">' . get_post_meta(get_the_ID(),'game_text_price',true) . '</div>
                    </a>';

                if($i % 2 == 0){
                    array_push($leftColumn,$html);
                } else {
                    array_push($rightColumn,$html);
                }

                $i++;
            endwhile;
            wp_reset_query();

            ?>

            <table class="table table-games">
                <tbody>
                    <?php
                    $count = 0;
                    $length = count($leftColumn);

                    while($count < $length){
                        echo '<tr>';
                        if(array_key_exists($count,$rightColumn)){
                            echo '<td class="col-xs-6">' . $leftColumn[$count] . '</td><td class="col-xs-6">' . $rightColumn[$count] . '</td>';
                        } else {
                            echo '<td class="col-xs-6">' . $leftColumn[$count] . '</td><td class="col-xs-6"></td>';
                        }
                        echo '</tr>';
                        $count++;
                    }
                    ?>
                </tbody>
            </table>
        <?php
        }
        wp_reset_query();
        ?>
    </div>
</main>