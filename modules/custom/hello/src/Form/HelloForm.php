<?php

namespace Drupal\hello\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;

class HelloForm extends FormBase{

	/**
   * {@inheritdoc}
   */
	public function getFormID() {
		return 'hello_form';
	}

	/**
   * {@inheritdoc}
   */
	public function buildForm(array $form, FormStateInterface $form_state) {
		
		if (isset($form_state->getRebuildInfo()['result'])) {
			$form['result'] = array(
				'#markup' => '<h2>' . $this->t('Result: ') . $form_state->getRebuildInfo()['result'] . '</h2>',);
		}

		$form['first_value'] = array(
		  '#type' => 'textfield',
		  '#title' => $this->t('First value'),
		  '#description' => $this->t('Enter first value'),
		  '#required' => TRUE,
/*		  '#ajax' => array(
		  	'callback' => array($this, 'AjaxValidateNumeric'),
		  	'event' => 'change',
		  ),*/
		  '#prefix' => '<span id="error-message-first_value"></span>'	
		);

		$form['operation'] = array(
		  '#type' => 'radios',
		  '#title' => $this->t('Operation'),
		  '#default_value' => 0,
		  '#options' => array(
			  	0 => $this->t('Ajouter'), 
			  	1 => $this->t('Soustract'), 
			  	2 => $this->t('Multiply'), 
			  	3 => $this->t('Divide')),
		  '#description' => $this->t('Choose operation for processng'),
		);

		$form['second_value'] = array(
		  '#type' => 'textfield',
		  '#title' => $this->t('Second value'),
		  '#description' => $this->t('Enter second value'),
		  '#required' => TRUE,
		);

		$form['actions']['submit'] = array(
		  '#type' => 'submit',
		  '#value' => $this->t('Calculate'),
		);

		return $form;
	}

	public function validateForm(array &$form, FormStateInterface $form_state) {
		$field = $form_state->getValue('first_value');
		if (!is_numeric($field)) {
			$form_state->setErrorByName('first_value', t('Field must be numeric !'));
		}
		$field = $form_state->getValue('second_value');
		if (!is_numeric($field)) {
			$form_state->setErrorByName('second_value', t('Field must be numeric !'));
		}
		if ($field=='0' && $form_state->getValue('operation') == 3) {
			$form_state->setErrorByName('second_value', t('Not division with zero !'));
		}
	}

	/**
   * {@inheritdoc}
   */
	public function submitForm(array &$form, FormStateInterface $form_state) {
		
		$first_value = $form_state->getValue('first_value');
		$second_value = $form_state->getValue('second_value');
		$operation = $form_state->getValue('operation');
		//kint($operation);

		$resultat = '';
		switch ($operation) {
			case'0':
				$resultat = $first_value + $second_value;
				break;
			case'1':
				$resultat = $first_value - $second_value;
				break;
			case'2':
				$resultat = $first_value * $second_value;
				break;
			case'3':
				$resultat = $first_value / $second_value;
				break;
			}
			//kint($resultat);

		$state = \Drupal::state();

		$state->set('hello_submit_time', REQUEST_TIME);


		$form_state->addRebuildInfo('result', $resultat);
		$form_state->setRebuild();
	}

	public function AjaxValidateNumeric(array &$form, FormStateInterface $form_state) {
		$field = $form_state->getTriggeringElement()['#name'];
		$css = ['border' => '2px solid red'];
		$message = 'Ajax message: ' . $form_state->getValue($field);

		$response = new AjaxResponse();
		$response->addCommand(new CssCommand('#edit-text', $css));
		$response->addCommand(new HtmlCommand('#error-message-first_value', $message));

		return $response;

	}

}