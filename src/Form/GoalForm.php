<?php

namespace Drupal\chatgpt_writer\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the Goal entity edit forms.
 */
class GoalForm extends ContentEntityForm {

  /**
   * Builds the entity form.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\chatgpt_writer\Entity\Goal */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    // The fields are automatically generated from the entity field definitions.
    // You can customize the form further here if needed.

    return $form;
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Custom submission logic can be added here.

    parent::submitForm($form, $form_state);
  }

  /**
   * Validates the form input.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Custom validation logic can be added here.

    parent::validateForm($form, $form_state);
  }

}
