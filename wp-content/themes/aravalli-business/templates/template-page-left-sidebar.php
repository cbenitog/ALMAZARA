<?php
/**
Template Name:  Page Left Sidebar
**/

get_header();
?>
<section class="bs-py-default">
	<div class="container">
		<div class="row g-5">
			<?php get_sidebar(); ?>
			<div id="ms-primary-content" class="col-lg-8 col-12">
				   <?php 		
					the_post(); the_content(); 
					
					if( $post->comment_status == 'open' ) { 
						 comments_template( '', true ); // show comments 
					}
				?>           
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>

