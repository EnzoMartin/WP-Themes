<?php
if(get_post_type($post) == 'game') {
	get_sidebar('game');
} else if(get_post_type($post) == 'voice') {
	get_sidebar('voice');
} else if($post->post_name == 'web-hosting'){
    get_sidebar('web');
} else if($post->post_name == 'vps-servers'){
    get_sidebar('vps');
} else if($post->post_name == 'voice-servers'){
    get_sidebar('voice-servers');
} else if($post->post_name == 'game-servers'){
    get_sidebar('games');
} else { ?>
    <div class="sidebar">
        <div class="sidebar-bg">
            <?php dynamic_sidebar('sidebar-secondary'); ?>
            <?php dynamic_sidebar('sidebar-primary'); ?>
        </div>
    </div>
    <?php get_template_part('templates/sidebar-support'); ?>
<?php } ?>