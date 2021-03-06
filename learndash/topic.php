<?php
/**
 * Displays a topic.
 *
 * Available Variables:
 * 
 * $course_id 		: (int) ID of the course
 * $course 		: (object) Post object of the course
 * $course_settings : (array) Settings specific to current course
 * $course_status 	: Course Status
 * $has_access 	: User has access to course or is enrolled.
 * 
 * $courses_options : Options/Settings as configured on Course Options page
 * $lessons_options : Options/Settings as configured on Lessons Options page
 * $quizzes_options : Options/Settings as configured on Quiz Options page
 * 
 * $user_id 		: (object) Current User ID
 * $logged_in 		: (true/false) User is logged in
 * $current_user 	: (object) Currently logged in user object
 * $quizzes 		: (array) Quizzes Array
 * $post 			: (object) The topic post object
 * $lesson_post 	: (object) Lesson post object in which the topic exists
 * $topics 		: (array) Array of Topics in the current lesson
 * $all_quizzes_completed : (true/false) User has completed all quizzes on the lesson Or, there are no quizzes.
 * $lesson_progression_enabled 	: (true/false)
 * $show_content	: (true/false) true if lesson progression is disabled or if previous lesson and topic is completed. 
 * $previous_lesson_completed 	: (true/false) true if previous lesson is completed
 * $previous_topic_completed	: (true/false) true if previous topic is completed
 * 
 * @since 2.1.0
 * 
 * @package LearnDash\Topic
 */
?>

<div class="container">

<?php if ( $lesson_progression_enabled && ! $previous_topic_completed ) : ?>

	<span id="learndash_complete_prev_topic">
	<?php
		$previous_item = learndash_get_previous( $post );
		if (empty($previous_item)) {
			$previous_item = learndash_get_previous( $lesson_post );
		}
		
		if ( ( !empty( $previous_item ) ) && ( $previous_item instanceof WP_Post ) ) {
			if ( $previous_item->post_type == 'sfwd-quiz') {
				echo sprintf( _x( 'Please go back and complete the previous <a class="learndash-link-previous-incomplete" href="%s">%s</a>.', 'placeholders: quiz URL, quiz label', 'learndash' ), get_permalink( $previous_item->ID ), LearnDash_Custom_Label::label_to_lower('quiz') );
				
			} else if ( $previous_item->post_type == 'sfwd-topic') {
				echo sprintf( _x( 'Please go back and complete the previous <a class="learndash-link-previous-incomplete" href="%s">%s</a>.', 'placeholders: topic URL, topic label', 'learndash' ), get_permalink( $previous_item->ID ), LearnDash_Custom_Label::label_to_lower('topic') );
			} else {
				echo sprintf( _x( 'Please go back and complete the previous <a class="learndash-link-previous-incomplete" href="%s">%s</a>.', 'placeholders: lesson URL, lesson label', 'learndash' ), get_permalink( $previous_item->ID ), LearnDash_Custom_Label::label_to_lower('lesson') );
			}
			
		} else {
			echo sprintf( _x( 'Please go back and complete the previous %s.', 'placeholder lesson', 'learndash' ), LearnDash_Custom_Label::label_to_lower('lesson') );
		}
	?></span>
    <br />

<?php elseif ( $lesson_progression_enabled && ! $previous_lesson_completed ) : ?>

	<span id="learndash_complete_prev_lesson">
	<?php
		$previous_item = learndash_get_previous( $post );
		if (empty($previous_item)) {
			$previous_item = learndash_get_previous( $lesson_post );
		}
		
		if ( ( !empty( $previous_item ) ) && ( $previous_item instanceof WP_Post ) ) {
			if ( $previous_item->post_type == 'sfwd-quiz') {
				echo sprintf( _x( 'Please go back and complete the previous <a class="learndash-link-previous-incomplete" href="%s">%s</a>.', 'placeholders: quiz URL, quiz label', 'learndash' ), get_permalink( $previous_item->ID ), LearnDash_Custom_Label::label_to_lower('quiz') );
				
			} else if ( $previous_item->post_type == 'sfwd-topic') {
				echo sprintf( _x( 'Please go back and complete the previous <a class="learndash-link-previous-incomplete" href="%s">%s</a>.', 'placeholders: topic URL, topic label', 'learndash' ), get_permalink( $previous_item->ID ), LearnDash_Custom_Label::label_to_lower('topic') );
			} else {
				echo sprintf( _x( 'Please go back and complete the previous <a class="learndash-link-previous-incomplete" href="%s">%s</a>.', 'placeholders: lesson URL, lesson label', 'learndash' ), get_permalink( $previous_item->ID ), LearnDash_Custom_Label::label_to_lower('lesson') );
			}
			
		} else {
			echo sprintf( _x( 'Please go back and complete the previous %s.', 'placeholder lesson', 'learndash' ), LearnDash_Custom_Label::label_to_lower('lesson') );
		}
	?></span>
    <br />

<?php endif; ?>
</div>

<?php if ( $show_content ) : 
	$video_content = explode( '$OL$', $content ); 
	
	if ( sizeof( $video_content ) > 1 ) :
	?>
		<div class="learndash_content ld-video">
			<div class="container">
				<?php echo $video_content[0]; ?>
			</div>
		</div>
	<?php 
		$content = $video_content[1]; 
		endif; 
	?>
	<div class="container ld_content_area">
		<div class="row">
			<div class="col-md-8 content-area">
				<h2><?php  the_title(); ?></h2>
				<?php echo $content; ?>
				<?php if ( ! empty( $quizzes ) ) : ?>
					<div id="learndash_quizzes" class="learndash_quizzes">
						<div id="quiz_heading"><span><?php echo LearnDash_Custom_Label::get_label( 'quizzes' ); ?></span><span class="right"><?php _e( 'Status', 'learndash' ) ?></span></div>

						<div id="quiz_list" class="quiz_list">
						<?php foreach( $quizzes as $quiz ) : ?>
							<div id='post-<?php echo esc_attr( $quiz['post']->ID ); ?>' class='<?php echo esc_attr( $quiz['sample'] ); ?>'>
								<div class="list-count"><?php echo $quiz['sno']; ?></div>
								<h4>
									<a class='<?php echo esc_attr( $quiz['status'] ); ?>' href='<?php echo esc_attr( $quiz['permalink'] ); ?>'><?php echo $quiz['post']->post_title; ?></a>
								</h4>
							</div>
						<?php endforeach; ?>
						</div>
					</div>	
				<?php endif; ?>

				<?php if ( ( lesson_hasassignments( $post ) ) && ( !empty( $user_id ) ) ) : ?>

					<?php $assignments = learndash_get_user_assignments( $post->ID, $user_id ); ?>

					<div id="learndash_uploaded_assignments" class=“learndash_uploaded_assignments”>
						<h2><?php _e( 'Files you have uploaded', 'learndash' ); ?></h2>
						<table>
							<?php if ( ! empty( $assignments ) ) : ?>
								<?php foreach( $assignments as $assignment ) : ?>
										<tr>
											<td><a href='<?php echo esc_attr( get_post_meta( $assignment->ID, 'file_link', true ) ); ?>' target="_blank"><?php echo __( 'Download', 'learndash' ) . ' ' . get_post_meta( $assignment->ID, 'file_name', true ); ?></a></td>
											<td><a href='<?php echo esc_attr( get_permalink( $assignment->ID) ); ?>'><?php _e( 'Comments', 'learndash' ); ?></a></td>
										</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</table>
					</div>
				<?php endif; ?>
				<?php endif; ?>
				

				<div class="ld-nav" id="learndash_next_prev_link"><?php echo learndash_previous_post_link(); ?>
					<?php if ( apply_filters( 'learndash_show_next_link', learndash_is_topic_complete( $user_id, $post->ID ),  $user_id, $post->ID ) ) { ?>
					<?php echo learndash_next_post_link(); ?>
					<?php } ?>
				</div>

				<div class="center" id="learndash_back_to_lesson"><a href='<?php echo esc_attr( get_permalink( $lesson_id) ); ?>'> <?php printf( _x( 'Back to %s', 'Back to Lesson Label', 'learndash' ), LearnDash_Custom_Label::get_label( 'lesson' ) ); ?></a></div>
			</div>

			<aside class="col-md-4 topic-info">
				<h4>Progress</h4>
				<?php echo do_shortcode( '[learndash_course_progress]' ); ?>

				<hr/>
				<?php if ( $all_quizzes_completed ) : ?>
					<p><?php echo  learndash_mark_complete( $post ); ?></p>
				<?php endif; ?>


				<section class="ld-course-content">
					<?php echo do_shortcode( '[course_content course_id="'. $course_id .'"]' ); ?>
				</section>
			</aside>
		</div>
	</div>