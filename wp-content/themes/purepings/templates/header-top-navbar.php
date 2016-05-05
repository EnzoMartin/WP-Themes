<header class="banner navbar navbar-default navbar-static-top" role="banner">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand hidden-sm" href="<?php echo home_url(); ?>/"><img src="<?php bloginfo('template_directory'); ?>/assets/img/purepings-logo.png"/></a>
        </div>

        <nav class="collapse navbar-collapse" role="navigation">
            <?php
            if (has_nav_menu('primary_navigation')) :
                wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'));
            endif;
            ?>
            <ul class="nav navbar-nav login-nav navbar-right">
                <li id="login-dropdown" class="menu-login">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <?php
                            $sites = explode('http',get_option('purepings_headerloginsites'));
                            $url = explode('|',$sites[1]);
                            ?>
                            <form id="login-form" class="navbar-form" method="POST" role="form" action="http<?php echo $url[0]; ?>">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="username" class="form-control" id="username" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="sites">Go to</label>
                                    <select id="sites-select" name="sites" class="form-control">
                                        <?php
                                        foreach($sites as $site){
                                            $split = explode('|',$site);
                                            if(count($split) > 1) {
                                                echo '<option value="http' . trim($split[0]) . '" data-pass="' . trim($split[3]) . '" data-user="' . trim($split[2]) . '">' . trim($split[1]) . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="center">
                                    <button type="submit" class="btn btn-info">Log in</button>
                                </div>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>