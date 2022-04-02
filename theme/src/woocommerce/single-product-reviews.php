<?php
/**
 * Display single product reviews (comments)
 *
 * @package WooCommerce/Templates
 * @version 4.3.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() )
	return;

?>

<div
	id="reviews"
	class="woocommerce-Reviews">

	<h2 class="is__hidden">
		<?= esc_html_e( 'Reviews', 'woocommerce' ) ?>
	</h2>

	<div>

		<?php if ( have_comments() ) : ?>

			<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

				<nav class="woocommerce-pagination">
					<?php

						paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
							'prev_text' => '&larr;',
							'next_text' => '&rarr;',
							'type' => 'list',
						) ) );

					?>
				</nav>

			<? endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews">
				Ainda não há avaliações, seja o primeiro.
			</p>

		<?php endif; ?>

	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

		<div
			id="review_form_wrapper"
			class="margin__top--large">

			<div id="review_form">

				<?php
					$commenter = wp_get_current_commenter();
					$comment_form = array(
						'title_reply' => have_comments() ? esc_html__( 'Add a review', 'woocommerce' ) : '',
						'title_reply_to' => 'Deixe uma resposta',
						'title_reply_before' => '<div id="reply-title" class="comment-reply-title">',
						'title_reply_after' => '</div>',
						'comment_notes_before' => '',
						'comment_notes_after' => '',
						'id_submit' => '',
						'label_submit' => esc_html__( 'Submit', 'woocommerce' ),
						'class_submit' => 'btn--primary margin__top--medium',
						'logged_in_as' => '',
						'comment_field' => '',
					);

					$name_email_required = (bool)get_option( 'require_name_email', 1 );
					$fields = array(
						'author' => array(
							'label'    => __( 'Name', 'woocommerce' ),
							'type'     => 'text',
							'value'    => $commenter['comment_author'],
							'required' => $name_email_required,
						),
						'email' => array(
							'label'    => __( 'Email', 'woocommerce' ),
							'type'     => 'email',
							'value'    => $commenter['comment_author_email'],
							'required' => $name_email_required,
						),
					);

					$comment_form['fields'] = array();

					foreach ( $fields as $key => $field ) {
						$field_html  = '<div class="margin__bottom--small comment-form-' . esc_attr( $key ) . '">';
						$field_html .= '<input id="' . esc_attr( $key ) . '" class="input" placeholder="' . esc_attr( $field['label'] ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' />';
						$field_html .= '</div>';

						$comment_form['fields'][ $key ] = $field_html;
					}

					$account_page_url = wc_get_page_permalink( 'myaccount' );
					if ( $account_page_url ) {
						/* translators: %s opening and closing link tags respectively */
						$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'woocommerce' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
					}

					if ( wc_review_ratings_enabled() ) {
						$comment_form['comment_field'] = '<div class="comment-form-rating"><select name="rating" id="rating" required>
							<option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
							<option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
							<option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
							<option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
							<option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
							<option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
						</select></div>';
					}

					$comment_form['comment_field'] .= '<div class="margin__bottom--small comment-form-comment"><textarea id="comment" name="comment" class="input" placeholder="Escreva sua avaliação aqui" required></textarea></div>';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>

			</div>
		
		</div>

		<div class="is__flex">
		  <?php get_template_part( 'recaptcha' ); ?>
		</div>

	<?php else : ?>

		<p class="woocommerce-verification-required">

			<?= esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?>

		</p>

	<?php endif; ?>

</div>
