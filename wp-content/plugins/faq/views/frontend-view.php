<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 6/10/17
 * Time: 1:21 PM
 */

add_shortcode('faq_list', 'faq_front_page');

/**
 * @return string
 */
function faq_front_page($atts)
{
	$reposetory = new \Faq\Models\QuestionRepository();
	$results = $reposetory->getVisibleQuestions();

	$html = '<h1>Questions</h1><br/>';
	foreach ( $results as $question ) {
		$html .= faq_render_question_block($question);
	}

	return $html;
}

/**
 * @param $faq \Faq\Models\Question
 * @return string
 */
function faq_render_question_block(\Faq\Models\Question $faq)

{
	$question = $faq->getQuestion();
	$answer = $faq->getAnswer();
	return "
	<div>
		<h3>Question:</h3>
		$question
		<h3>Answer:</h3>
		$answer
	</div><hr/>
		<br/>";

}