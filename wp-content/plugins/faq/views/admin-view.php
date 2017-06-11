<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 6/10/17
 * Time: 11:28 PM
 */


add_action( 'admin_menu', 'faq_menu' );
add_action( 'admin_action_faq_add_new_question', 'faq_add_new_question_admin_action' );

/**
 * Proceed request
 */
function faq_add_new_question_admin_action()
{
	$reposetory = new \Faq\Models\QuestionRepository();
	/** @var \Faq\Models\Question $obj */
	$obj = $reposetory->get(0);
	$obj->setName('Admin');
	$obj->setQuestion($_POST['question']);
	$obj->setAnswer($_POST['answer']);
	$obj->setIsVisible(isset($_POST['visible']) && $_POST['visible'] == 1);
//	var_dump($obj);
	$reposetory->save($obj);

	wp_redirect( $_SERVER['HTTP_REFERER'] );
	exit();
}

function faq_menu() {
	add_options_page( 'FAQ', 'FAQ', 'manage_options', 'faq-identifier', 'faq_configuration' );
}

function get_all_questions()
{
	$reposetory = new \Faq\Models\QuestionRepository();

	return $reposetory->load();
}
function faq_configuration()
{
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	$html = '';
	$html .= faq_render_submit_form();

	$questions = get_all_questions();
	$html .= '<h2>Questions list</h2><br/>';


	foreach ( $questions as $question ) {
		$html .= faq_render_question_block($question);
	}

	echo $html;

}

/**
 * @return string
 */
function faq_render_submit_form()
{
	$html = '';
	$action = admin_url( 'admin.php' );
	$html .= "<form name='new-question' action='$action' method='post'>";
	$html .= "<br/>";
	$html .= "<h2>Question create?</h2>";
	$html .= "<input type='text' name='question' placeholder='Question'/>";
	$html .= "<br/>";
	$html .= "<input type='text' name='answer' placeholder='Answer'/>";
	$html .= "<br/>";
	$html .= "<input type='checkbox' name='visible' value='1'/>";
	$html .= "<label> - is visible</label>";
	$html .= "<br/>";

	$html .= "<input type=\"hidden\" name=\"action\" value=\"faq_add_new_question\" />";
	$html .= "<button>Submit question</button>";
	$html .= "</form>";

	return $html;
}


/**
 * @param $faq \Faq\Models\Question
 * @return string
 */
function faq_render_admin_question_block(\Faq\Models\Question $faq)

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