<?php

/*
Template Name: Cars Single
*/

?>


<?php get_header(); ?>

<h1>this is single - cars </h1>

<h2 class="single-cars"> <?php the_field('car_name'); ?> </h2>
<h3> <?php the_field('car_description'); ?> </h3>

<?php the_content(); ?>

<?php get_footer(); ?>