<?php

namespace Drupal\node_like\Plugin\ReusableForm;

use Drupal\reusable_forms\ReusableFormPluginBase;

/**
 * Provides a Like Form.
 *
 * @ReusableForm(
 *   id = "like_form",
 *   name = @Translation("Like form"),
 *   form = "Drupal\node_like\Form\LikeForm"
 * )
 */
class LikeForm extends ReusableFormPluginBase {

}