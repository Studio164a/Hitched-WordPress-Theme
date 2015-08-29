<?php 
// Note: 
// front-page.php is the Wordpress theme template file that is used 
// for the homepage. Since Hitched has a couple of homepage versions to 
// choose from, this template acts as a bootstrap and simply defers the
// templating onto the selected verion of the homepage. 
// Note that the default version of the homepage is homepage.php

get_template_part( 'homepage', get_theme_mod('homepage_version') ) ?>