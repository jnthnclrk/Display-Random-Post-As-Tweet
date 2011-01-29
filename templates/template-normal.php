<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php $page_data = get_page ( get_option('slidepost_page_slug') ); echo $page_data->post_title; echo ' &#8212; '; bloginfo('name'); ?></title>
<link rel="stylesheet" href="https://si2.twimg.com/a/1296265969/phoenix/css/phoenix.bundle.css" type="text/css" media="screen" /></head>
<body>
<div id="main">
	<?php
	query_posts(array('orderby' => 'rand', 'showposts' => 1, 'post_type' => get_option('drpat_content_type')));
	if(have_posts()) : while(have_posts()) : the_post();?>
		<div class="permalink">
			<div class="components-middle">
				<div class="component">
					<div class="tweet permalink-tweet">
						<div class="tweet-row">
							<div class="tweet-text tweet-text-large">
								<?php //the_category(': ') ?>
								<?php the_title() ?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_permalink(); ?></a>
								<?php
									$cathashtag = get_the_category();
									for ($i = 0; $i <= sizeof( $cathashtag )-1; $i++) {
										$cathashtags = $cathashtags.' '.$cathashtag[$i]-> cat_name;
									}
									$cathashtags = str_replace('&amp; ', '', $cathashtags );
									$cathashtags = str_replace(',', '', $cathashtags );
									$cathashtags = str_replace(' ', ' #', $cathashtags );
									echo strtolower( $cathashtags );
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php //the_content(); ?>
	<?php endwhile; else: ?>
		< ?php _e('Sorry, no posts matched your criteria.'); ?>
	<?php endif; ?>
</div>
</body>
</html>