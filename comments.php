<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Skyre
 * @version 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
if(skyre_get_post_option('comment_status') == 1) { return; }
?>

<div id="comments" class="comments-area sk-border-15">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h3 class="comments-title sk-border-15">
			<?php
			$comments_number = get_comments_number();
			if ( '1' === $comments_number ) {
				/* translators: %s: post title */
				printf( _x( 'One Reply to &ldquo;%s&rdquo;', 'comments title', 'skyre' ), get_the_title() );
			} else {
				printf(
					/* translators: 1: number of comments, 2: post title */
					_nx(
						'%1$s Reply to &ldquo;%2$s&rdquo;',
						'%1$s Replies to &ldquo;%2$s&rdquo;',
						$comments_number,
						'comments title',
						'skyre'
					),
					number_format_i18n( $comments_number ),
					get_the_title()
				);
			}
			?>
		</h3>

       <ul class="commentlist list-unstyled">
		<?php wp_list_comments( 'type=comment&callback=skyre_comment&avatar_size=80' ); ?>
       </ul>
       <div class="pagination">

		<?php the_comments_pagination( array(
			'prev_text' => skyre_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous', 'skyre' ) . '</span>',
			'next_text' => '<span class="screen-reader-text">' . __( 'Next', 'skyre' ) . '</span>' . skyre_get_svg( array( 'icon' => 'arrow-right' ) ),
		) );
		?>
       </div>
       <?php

	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php _e( 'Comments are closed.', 'skyre' ); ?></p>
	<?php
	endif;

	//comment forms
	$aria_req = ( $req ? " aria-required='true' " : '' );
	$fields =  array(

	  'author' =>
		'<p class="comment-form-author">' .
		'<input placeholder="' . __( 'Name', 'skyre' ) . ( $req ? '*' : '' ) . '" class="form-control sk-form" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
		'" size="30"' . $aria_req . ' /></p>',
	
	  'email' =>
		'<p class="comment-form-email">' .
		'<input placeholder="' . __( 'Email', 'skyre' ) . ( $req ? '*' : '' ) . '" class="form-control sk-form" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
		'" size="30"' . $aria_req . ' /></p>',
	
	  'url' =>
		'<p class="comment-form-url">' .
		'<input placeholder="' . __( 'Website', 'skyre' ) . '" class="form-control sk-form" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
		'" size="30" /></p>',
	); 
	$args = array(
	  'comment_field'           => '<textarea class="form-control sk-form" id="comment" name="comment" cols="45" rows="8" aria-required="true">' .'</textarea>',
	  'class_submit'      => 'btn btn-skyre',
	  'fields' => apply_filters( 'comment_form_default_fields', $fields ),
	  
	 );
	comment_form($args);
	?>
</div><!-- #comments -->
