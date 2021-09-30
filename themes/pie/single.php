<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package pie
 */

get_header();
?>

	<main id="primary" class="site-main">
	<?php 
		if(have_posts() ) :
			while (have_posts() ) :
				the_post();
				$primaryTitle = get_the_title();
				?>
					<div>
						<div>
							<h2 class="title_poste"><?= the_title() ?></h2>
							<div class="div_img_poste">
							<img class="img_poste"  src="<?= get_field("img") ?>" alt="">
							</div>
							<div class="test">
							<div class="div_desc_poste">
							<p class="description_poste"><?= get_field("desc") ?></p>
							</div>
							</div>
							
							
						</div>
					<div>
			<?php endwhile; 
			endif;?>
				<hr>
				<h2 class="title_poste">Autre article</h2>
					<?php  
					setlocale (LC_TIME, 'fr_FR.utf8','fra');
					$the_query = new WP_Query(array( 'orderby' => 'rand', 'posts_per_page' => '3', "post__not_in"=> array(get_the_ID())));
					?>  	<div class="containerposte"><?php  
					foreach($the_query->get_posts() as $post) : 
						?>  
					
						<div class="cardposte">
								<p  class="date_poste"><?= strftime("%d %B %G", strtotime($post->post_date)); ?></p>
								<img class="photo_poste" src="<?= get_field("img") ?>" alt="">
								<h3 class="titre_poste"><?= the_title() ?></h3>
								<div class="poste_desc">
								<p class="desc_poste"><?= substr(get_field("desc"), 0, 300).'...'; ?></p>
								</div>
								<p class="lasuite">	<a class="Lire"  href="/<?= $post->post_name?>" >Lire la suite</a></p>
							</div>		
						<?php 
					endforeach;?>
						</div>	
				</div>
			</div>
	</main>
<?php
get_footer();
