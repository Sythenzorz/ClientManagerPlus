<?php
/*
Template Name: webmprojects
*/

get_header(); ?>

<div id="primary">
	<div id="content">

		<div id = "Details" class = "wrap clearfix">

			<div id = "ClientDetails" class = "span_12 first clearfix">
				<br/>
				<h2><?php the_title(); ?></h2>
				<strong>Client Name: </strong><?php echo esc_html(get_post_meta( get_the_ID(), 'webm_id', true ) ); ?><br />
				<strong>Client E-Mail: </strong><?php echo esc_html(get_post_meta( get_the_ID(), 'webm_client_email', true ) ); ?><br />
				<strong>Client Phone Number: </strong><?php echo esc_html(get_post_meta( get_the_ID(), 'webm_client_phoneno', true ) ); ?><br />
			</div>


			<div id = "Objectives" class = "span_12 last clearfix">
				<br/>
				<h2>To Do List: </h2>
				<?php echo esc_html(get_post_meta( get_the_ID(), 'webm_id_entry1', true ) ); ?><br />
				<?php echo esc_html(get_post_meta( get_the_ID(), 'webm_id_entry2', true ) ); ?><br />
				<?php echo esc_html(get_post_meta( get_the_ID(), 'webm_id_entry3', true ) ); ?><br /><br />
				<strong>Currently Working On:</strong> <?php echo esc_html(get_post_meta( get_the_ID(), 'webm_id_current', true ) ); ?><br />
			</div>
		</div>

		<div id = "meterwrapper" class = "wrap clearfix">
			Overall Project: <strong><?php echo get_post_meta($post->ID, 'progress', true); ?>%</strong> Complete.<br /><br />
			<div class="meter">
				<span style="width:<?php echo get_post_meta($post->ID, 'progress', true); ?>%;"></span>
			</div>
		</div>

		<div id = "clientfooter" class = "wrap clearfix">
			<p style = "text-align: center;">Please note that the Overall progress meter may take a few minutes to update.</p>
			<?php comments_template(); ?>
		</div>
	</div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
