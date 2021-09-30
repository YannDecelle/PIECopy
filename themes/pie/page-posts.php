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

use WPForms\Integrations\Divi\Divi;

get_header();
?>

<main id="primary" class="site-main">
  
    <?php 
     if ( have_posts()) : 
		while ( have_posts() ) :
            the_post()	;  		
	
    
        $img = []; 
        $title =[];
        setlocale (LC_TIME, 'fr_FR.utf8','fra');
        $date = [];
        $tag =  [];
        $tempoTag = [];
        $src = [];

        foreach(get_posts() as $post) :     
               $img[] = get_field("img");
               $title[] = $post->post_title;
                $date[] = $post->post_date;
                $src[] = $post->post_name;
            if(get_field("tag_1") != null){
                $tempoTag[] = get_field("tag_1");
            }
            if(get_field("tag_2") != null){
                $tempoTag[] = get_field("tag_2");
            }
            $tag[] = $tempoTag;
            $tempoTag = [];
            
              
        endforeach; ?>

    <div id="bloc" class="tout">
      
        <div class="bloc_gauche containere">
            <?php if(isset($img[0])) :  ?>
                <a href="/<?= $src[0]?>">
            <img id="img_firstposts" class="img_posts " src="<?= $img[0] ?>"></a>
            <div class="desc_posts">
                <div class="tag_posts">
                    <?php for( $i=0; $i<sizeof($tag[0]); $i++) : ?>
                    <div class="tagcont_posts">
                        <p class="tagname_posts">
                            <?= $tag[0][$i]; ?>
                        </p>
                    </div>
                    <?php   endfor;  ?>
                </div>

                <?php  $length = strlen($title[0]) ;
                                $max = 23;
                           if($length> $max){
                            ?> <p class="desc"> <?= substr($title[0], 0, $max).'...'; ?></p> <?php 
                            
                           }else {
                            ?> <p class="desc"> <?= $title[0] ?></p> <?php 
                           } ?>
                <div class="date_posts">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/calendar.png" alt="#" />
                    <p class="date"> <?= strftime("%d %B %G", strtotime($date[0])); ?> </p>
                </div>
            </div>

            <?php endif; ?>
        </div>

        <div class="col-lg-5 droite">
            <div class="row">
                <div class="col-lg-6 ">
                <a href="/<?=  $src[1]?>">
                    <div class="containere">
                        <?php if(isset($img[1])) :  ?>
                        <img class="img_posts" src="<?= $img[1] ?>">
                        <div class="desc_posts">
                            <div class="tag_posts">
                                <?php for( $i=0; $i<sizeof($tag[1]); $i++) : ?>
                                <div class="tagcont_posts">
                                    <p class="tagname_posts">
                                        <?= $tag[1][$i]; ?>
                                    </p>
                                </div>
                                <?php   endfor;  ?>
                            </div>
                            <?php  $length = strlen($title[1]) ;
                                $max = 23;
                           if($length> $max){
                            ?> <p class="desc"> <?= substr($title[1], 0, $max).'...'; ?></p> <?php 
                            
                           }else {
                            ?> <p class="desc"> <?= $title[1] ?></p> <?php 
                           } ?>

                            <div class="date_posts">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/calendar.png" alt="#" />
                                <p class="date"> <?= strftime(" %d %B %G", strtotime($date[1])); ?> </p>
                            </div>

                        </div>

                        <?php endif; ?>
                    </div>
                    </a>
                    <a href="/<?=  $src[2]?>">
                    <div class="containere">
                        <?php if(isset($img[2])) :  ?>
                        <img class="img_posts mt-3" src="<?= $img[2] ?>">
                        <div class="desc_posts">
                            <div class="tag_posts">
                                <?php for( $i=0; $i<sizeof($tag[2]); $i++) : ?>
                                <div class="tagcont_posts">
                                    <p class="tagname_posts">
                                        <?= $tag[2][$i]; ?>
                                    </p>
                                </div>
                                <?php   endfor;  ?>
                            </div>
                            <?php  $length = strlen($title[2]) ;
                                $max = 23;
                           if($length> $max){
                            ?> <p class="desc"> <?= substr($title[2], 0, $max).'...'; ?></p> <?php 
                            
                           }else {
                            ?> <p class="desc"> <?= $title[2] ?></p> <?php 
                           } ?>
                            <div class="date_posts">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/calendar.png" alt="#" />
                                <p class="date"> <?= strftime(" %d %B %G", strtotime($date[2])); ?> </p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                           </a>
                </div>
                <div class="col-lg-6">
                <a href="/<?=  $src[3]?>">
                    <div class="containere">
                        <?php if(isset($img[3])) :  ?>
                        <img class="img_posts mr-4" src="<?= $img[3] ?>">
                        <div class="desc_posts">
                            <div class="tag_posts">
                                <?php for( $i=0; $i<sizeof($tag[3]); $i++) : ?>
                                <div class="tagcont_posts">
                                    <p class="tagname_posts">
                                        <?= $tag[3][$i]; ?>
                                    </p>
                                </div>
                                <?php   endfor;  ?>
                            </div>
                            <?php  $length = strlen($title[3]) ;
                                $max = 23;
                           if($length> $max){
                            ?> <p class="desc"> <?= substr($title[3], 0, $max).'...'; ?></p> <?php 
                            
                           }else {
                            ?> <p class="desc"> <?= $title[3] ?></p> <?php 
                           } ?>
                            <div class="date_posts">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/calendar.png" alt="#" />
                                <p class="date"> <?= strftime(" %d %B %G", strtotime($date[3])); ?> </p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                   </a>
                    <a href="/<?=  $src[4]?>">
                    <div class="containere">
                        <?php if(isset($img[4])) :  ?>
                        <img class="img_posts mt-3 mr-4" src="<?= $img[4] ?>">
                        <div class="desc_posts">
                            <div class="tag_posts">
                                <?php for( $i=0; $i<sizeof($tag[4]); $i++) : ?>
                                <div class="tagcont_posts">
                                    <p class="tagname_posts">
                                        <?= $tag[4][$i]; ?>
                                    </p>
                                </div>
                                <?php   endfor;  ?>
                            </div>
                            <?php  $length = strlen($title[4]) ;
                                $max = 23;
                           if($length> $max){
                            ?> <p class="desc"> <?= substr($title[4], 0, $max).'...'; ?></p> <?php 
                            
                           }else {
                            ?> <p class="desc"> <?= $title[4] ?></p> <?php 
                           } ?>

                            <div class="date_posts">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/calendar.png" alt="#" />
                                <p class="date"> <?= strftime(" %d %B %G", strtotime($date[4])); ?> </p>
                            </div>

                        </div>
                        <?php endif; ?>
                    </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
  
    <?php endwhile; // End of the loop. 
 endif;
 ?>
    <div class="news_separator">
        <h2>Tous les Articles</h2>
    </div>
    <?php 
     if ( have_posts()) : ?>
    <?php
		while ( have_posts() ) :
            the_post()	;  		
		?>
    <?php  
            setlocale (LC_TIME, 'fr_FR.utf8','fra');
            ?> <div id="container_allposts"> <?php 
            foreach(get_posts() as $post) : ?>

       <a href="/<?= $post->post_name?>"> <div class="container_post">
            <div class="img_post">
                <img class="img_listPosts" src="<?= get_field("img")?>" alt="">
            </div>
            <div class="desc_post">
                <div class="tag_posts">
                    <?php   if(get_field("tag_1") != null) : ?>
                    <div class="tagcont_posts">
                        <p class="tagname_posts"><?= get_field("tag_1")?></p>
                    </div>
                    <?php   endif;?>
                    <?php   if(get_field("tag_2") != null) : ?>
                    <div class="tagcont_posts">
                        <p class="tagname_posts"><?= get_field("tag_2")?></p>
                    </div>
                    <?php   endif;?>
                   
                </div>
                <h2 class="titre_post"><?= $post->post_title ?></h2>
                <div class="date_posts">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/calendar2.png" alt="#" />
                    <p class="date_post"> <?= strftime(" %d %B %G", strtotime($post->post_date)); ?> </p>
                </div>
                <p class="description_post"> <?= substr(get_field("desc"), 0, 200).'...'; ?> </p>
            </div>
        </div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endwhile;?>
    <?php endif; ?>
</main><!-- #main -->

<?php
// get_sidebar(); 
get_footer();

?>