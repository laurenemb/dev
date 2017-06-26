<?php

namespace Drupal\node_like\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormStateInterface;
use Drupal\reusable_forms\Form\ReusableFormBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines the LikeForm class.
 */
class LikeForm extends ReusableFormBase {

  protected $database;

  /**
   * {@inheritdoc}.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * {@inheritdoc}.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'like_form';
  }



  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $form = parent::buildForm($form, $form_state);
    $nid = $this->entity->id();
    $like_number = $this->database->select('node_like', 'n')
    ->condition('nid', $nid)
    ->countQuery()
    ->execute()
    ->fetchField();

    $form['like_count'] = array(
      '#type' => 'markup',
      '#markup' => $like_number.' like(s)',
    );

    if(!$this->currentUser()->isAnonymous()){
      $form['like'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('J\'aime'),
    );
    }
    return $form;
  }

  /**
   * {@inheritdoc}
   */
   public function submitForm(array &$form, FormStateInterface $form_state) {
    $nid = $this->entity->id();
    $this->database->merge('node_like')
      ->key(array('nid' => $nid, 'uid' => $this->currentUser()->id()))
      ->fields(array('nid' => $nid, 'uid' => $this->currentUser()->id()))
      ->execute();
  }
}
