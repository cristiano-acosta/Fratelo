<!-- Refactory Cardapio FRatello  -->
<?php if (is_page('delivery')) { ?>
<nav  class="span12 Cardapio delivery ">
  <ul class="" id="myTab">
    <?php
			/*= Construtor de links que laça os custom post types  =*/
		  $args = array( 'public' => true, '_builtin' => false, 'exclude_from_search' => false,		);
		  $output = 'objects'; // names or objects
		  $post_types = get_post_types($args, $output); //
	    //print_r( $post_types );
			//unset( $post_types[2] );
		    foreach ($post_types as $post_type)  {
			   if ( 'cafe-chas' !== $post_type->name & 'molho' !== $post_type->name & 'bebidas' !== $post_type->name ) {
			    $option = '<li><a href="#' . $post_type->name . '">';
			    $option .= '<img src="' . get_template_directory_uri() .
		          '/img/cardapio/thumb.' . $post_type->name . '.png" alt="' . $post_type->
		          description . '" />';
			    $option .= '<div class="menu_title"> <h3>' . $post_type->labels->singular_name . '</h3></div>';
		      $option .= '</a></li>';
		      echo $option;
		    }
		    }
	  ?>
  </ul>
</nav>
<div class="span12 tab-content Cardapio delivery" id="myTabContent">
	<?php
		/*= recupera o laço dos post types cadastrados  =*/
		foreach ($post_types as $post_type)  {
			if ( 'cafe-chas' !== $post_type->name & 'molho' !== $post_type->name & 'bebidas' !== $post_type->name ) {
							/*= constroi templete para pizzas e calzones  =*/

			if ( 'pizza' == $post_type->name ) {
				include 'cardapio-pizzas.php';
			}
			if ( 'calzones' == $post_type->name ) {
				include 'cardapio-calzones.php';
			}
			if ( 'bebidas' == $post_type->name ) {
			 include 'cardapio-bebidas.php';
			}
			if ( 'calzones' !== $post_type->name & 'pizza' !== $post_type->name & 'bebidas' !== $post_type->name ) {
	?>
			<div class="tab-pane fade row " id="<?php echo $post_type->name; ?>">
				<div class="span12 tag_title">
					<div class="row category_slide">
						<?php
							$items_do_cardapio = new WP_Query(array('post_type' => $post_type->name,'posts_per_page' => -1,'order' => 'ASC','orderby' =>'name'));
								while($items_do_cardapio->have_posts()) : $items_do_cardapio->the_post();
						?>
								<article class="span4 menu-entry" id="post-<?php the_ID() ?>">
									<div class="price-img">
										<?php	/*= Pego a imagem ou a imagem padrão do Custom Post Type  =*/
											if(has_post_thumbnail()){the_post_thumbnail(); } else{ echo '<img src="' . get_template_directory_uri() . '/img/cardapio/medio.pizza.png" alt="' . $post_type->description . '" />'; }
										?>
									</div>
									<div class="menu-entry-info">
									  <div class="menu-entry-content"><?php the_content(); ?></div>
				          </div>
									<div class="price_overlay">
										<div style="float:left;" class="price_left"></div>
										<div style="float:left;" class="item_price">
											<div class="item_price_dig">
												<h4 class="menu_title"><?php the_title(); ?></h4>
											</div>
										</div>
										<div style="float:left;" class="price_right"></div>
									</div>
								</article>
						<?php endwhile; ?>
					</div>
				</div>
			</div>
		<?php } ?>
	<?php }} ?>
</div>
<?php } else { ?>
<nav  class="span12">
  <ul class="" id="myTab">
    <?php
			/*= Construtor de links que laça os custom post types  =*/
		  $args = array( 'public' => true, '_builtin' => false, 'exclude_from_search' => false,		);
		  $output = 'objects'; // names or objects
		  $post_types = get_post_types($args, $output); //print_r( $post_types);
		    foreach ($post_types as $post_type)  {
			    $option = '<li><a href="#' . $post_type->name . '">';
			    $option .= '<img src="' . get_template_directory_uri() .
		          '/img/cardapio/thumb.' . $post_type->name . '.png" alt="' . $post_type->
		          description . '" />';
			    $option .= '<div class="menu_title"> <h3>' . $post_type->labels->singular_name . '</h3></div>';
		      $option .= '</a></li>';
		      echo $option;
		    }
	  ?>
  </ul>
</nav>
<div class="span12 tab-content" id="myTabContent">
	<?php
		/*= recupera o laço dos post types cadastrados  =*/
		foreach ($post_types as $post_type)  {
			/*= constroi templete para pizzas e calzones  =*/
			if ( 'pizza' == $post_type->name ) {
				include 'cardapio-pizzas.php';
			}
			if ( 'calzones' == $post_type->name ) {
				include 'cardapio-calzones.php';
			}
			if ( 'bebidas' == $post_type->name ) {
			 include 'cardapio-bebidas.php';
			}

			if ( 'calzones' !== $post_type->name & 'pizza' !== $post_type->name & 'bebidas' !== $post_type->name ) {
	?>
			<div class="tab-pane fade row " id="<?php echo $post_type->name; ?>">
				<div class="span12 tag_title">
					<div class="row category_slide">
						<?php
							$items_do_cardapio = new WP_Query(array('post_type' => $post_type->name,'posts_per_page' => -1,'order' => 'ASC','orderby' =>'name'));
								while($items_do_cardapio->have_posts()) : $items_do_cardapio->the_post();
						?>
								<article class="span4 menu-entry" id="post-<?php the_ID() ?>">

									<div class="price-img">
										<?php	/*= Pego a imagem ou a imagem padrão do Custom Post Type  =*/
											if(has_post_thumbnail()){the_post_thumbnail(); } else{ echo '<img src="' . get_template_directory_uri() . '/img/cardapio/medio.pizza.png" alt="' . $post_type->description . '" />'; }
										?>
									</div><div class="menu-entry-info">

					          <div class="menu-entry-content"><?php the_content(); ?></div>
				          </div>
									<div class="price_overlay">
										<div style="float:left;" class="price_left"></div>
										<div style="float:left;" class="item_price">
											<div class="item_price_dig">
												<?php /* para achar os campos ====>$custom_field_keys = get_post_custom_keys(); foreach ( $custom_field_keys as$key => $value ) {                                                                                      				$valuet = trim($value); if ( '_' == $valuet{0} )continue;cho $key . " => " . $value . "<br />"; 				}
													$pizza_broto = get_post_meta($post->ID,'wpcf-pizza-broto',true);
													$pizza_pequena = get_post_meta($post->ID,'wpcf-pizza-pequena',true);
													$pizza_grande = get_post_meta($post->ID,'wpcf-pizza-grande',true);
													$preco = get_post_meta($post->ID,'wpcf-preco',true);// check if the custum field has a value
														if($pizza_broto != ''){ echo '<p class="pizza_broto">Broto <br> R$ ' . $pizza_broto . '</p>'; }
														if($pizza_pequena != ''){ echo '<p class="pizza_pequena">Pequena <br> R$ ' . $pizza_pequena . '</p>';}
														if($pizza_grande != ''){ echo '<p class="pizza_grande">Grande <br> R$ ' . $pizza_grande . '</p>'; }
															else if($preco != ''){ echo '<p class="preco"> R$ ' . $preco. '</p>'; }*/
												?>
												<h4 class="menu_title"><?php the_title(); ?></h4>
											</div>
										</div>
										<div style="float:left;" class="price_right"></div>
									</div>
								</article>
						<?php endwhile; ?>
					</div>
				</div>
			</div>
		<?php } ?>
	<?php }
} ?>
</div>
