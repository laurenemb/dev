<?php

namespace Drupal\hello\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class HelloAdminForm extends ConfigFormBase {

	/**
   * {@inheritdoc}
   */
	public function getFormId() {
		return 'hello_admin_form';
	}

	/**
   * {@inheritdoc}
   */
	protected function getEditableConfigNames() {
		return array('hello.config');
	}

	/**
   * {@inheritdoc}
   */
	public function buildForm(array $form, FormStateInterface $form_state) {
		$color = $this->config('hello.config')->get('color');

	$form['color_select'] = [
	  '#type' => 'select',
	  '#title' => $this->t('Select color'),
	  '#options' => [
	    'red' => $this->t('Red'),
	    'blue' => $this->t('Blue'),
	    'green' => $this->t('Green'),
	  ],
	];	

	return parent::buildForm($form, $form_state);
	}

	public function submitForm(array &$form, FormStateInterface $form_state) {
		$this->config('hello.config')
			->set('color', $form_state->getvalue('color_select'))
			->save();
	
		\Drupal::service('entity_type.manager')->getViewBuilder('block')->resetCache();

		parent::submitForm($form, $form_state);
	}
}