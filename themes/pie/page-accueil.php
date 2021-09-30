<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pie
 */

use Elementor\Modules\Library\Documents\Section;

get_header();
?>

	<main id="primary" class="site-main">
	<?php 
	$user_login = wp_get_current_user()->user_login;
	if($user_login){
		echo the_content();
	}?>
			<section id="home_events">
           <h2>Prochain événements</h2>
		   <div id="nextevents">
           <article>
			<?= do_shortcode("[events layout_type='box' per_page = '3' show_filters = 'false']"); ?>
		   </article>
		   </div>
		   <div id="button_events"><button>Voir les événements <img src="<?php echo get_template_directory_uri(); ?>/img/fleche_droite.png" alt=""></button></div>
         </section>

		 <hr>

<div id="magie">
         <section id="desc_home">
                    <h2><?= get_field("titre_home")?></h2>
                    <p><?= get_field("desc_home") ?></p>
         </section>

		 <hr>





         <section class="home_news">
        
         <h2>News</h2>
         <?php  
					setlocale (LC_TIME, 'fr_FR.utf8','fra');
					$the_query = new WP_Query(array( 'orderby' => 'desc', 'posts_per_page' => '3'));
					?>  	<div class="containerposte"><?php  
					foreach($the_query->get_posts() as $post) : 
						?>  
					
						<article class="home_cardposte">
								<p  class="date_poste"><?= strftime("%d %B %G", strtotime($post->post_date)); ?></p>
								<img class="photo_poste" src="<?= get_field("img") ?>" alt="">
								<h3 class="titre_poste"><?= the_title() ?></h3>
								<div class="poste_desc">
								<p class="desc_poste"><?= substr(get_field("desc"), 0, 300).'...'; ?></p>
								</div>
								<p class="lasuite">	<a class="Lire"  href="/<?= $post->post_name?>" >Lire la suite</a></p>
							</article>		
						<?php 
					endforeach; /*$the_query->reset_postdata()*/?>
                    </div>	
                    <div id="button_en_savoir_plus"><button>En savoir plus  <img src="<?php echo get_template_directory_uri(); ?>/img/fleche_droite.png" alt=""></button></div>
                    <a href=""><img src="" alt=""></a>
         </section>
		 
         </div>           

	</main><!-- #main -->

<?php
/*get_sidebar();*/
get_footer();
