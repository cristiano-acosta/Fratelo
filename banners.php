<?php /*if (is_front_page()) { ?><!-- get_template_part('banners'); --><div id="banners">	  <div class="container">		  <div class="row">			  <div id="prev" class="span1" >				  <img src="<?php bloginfo( 'template_url' ); ?>/img/prev.png">			  </div>			  <div class="box-shadow span10">					<ul class="rslides_banners">						<!-- aqui vai os post_thumbnail do custon post type banners -->						<?php							date_default_timezone_set("Brazil/East"); // ajustando a data para o Brasil							$hora = date("H:i"); // armazenando a hora no formato: 00, 06, 16, 19, etc...							//$hora = "14:59"; // armazenando a hora no formato: 00, 06, 16, 19, etc...							if($hora >= "03:00" && $hora <="14:59") {								//$category = 'almoco';								$query = array( 'post_type' => 'banners' , 'category_name' => 'almoco','posts_per_page' => -1,);							} else  {								//$category = 'janta';								$query = array( 'post_type' => 'banners' , 'category_name' => 'janta','posts_per_page' => -1,);							}							//var_dump($query);							//var_dump($hora);							 //$banners = new WP_Query( array( 'post_type' => 'pizza' , 'orderby' => 'rand','posts_per_page' => -1,) );								$banners = new WP_Query( $query );								while ( $banners->have_posts() ) : $banners->the_post();							    $image = get_post_meta($post->ID, 'wpcf-imagem-banner', true);										if ($image != "" ) {						?>										<li class="">											<article>												<div class="description">													<h1><?php the_title(); ?></h1>													<p><?php the_excerpt(); //excerpt('10'); ?></p>												</div>												<figure>													<?php echo '<img src="'.$image.'" alt="' . $post_type->description . '" />'; ?>												</figure>											</article>										</li>						<?php										}								endwhile; /*= End loop =/							wp_reset_query(); /*= Reset Query =/						?>					</ul>					<!-- <div class="inner-shadow"></div>div.inner-shadow end -->			  </div><!-- div.box-shadow end -->				<div id="next" class="span1" >					<img src="<?php bloginfo( 'template_url' ); ?>/img/next.png">				</div>		  </div>	  </div></div><?php }*/ ?>