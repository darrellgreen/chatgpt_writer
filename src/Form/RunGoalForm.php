<?php

namespace Drupal\chatgpt_writer\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form to manually trigger a Goal.
 */
class RunGoalForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'chatgpt_writer_run_goal_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Run Goal'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Assume we have a service to handle the API call and entity creation.
    \Drupal::service('chatgpt_writer.goal_processor')->runGoal();

    \Drupal::messenger()->addMessage($this->t('Goal processed.'));
  }

}
