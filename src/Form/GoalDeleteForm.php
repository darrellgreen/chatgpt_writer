<?php

namespace Drupal\chatgpt_writer\Form;

use Drupal\Core\Entity\ContentEntityDeleteForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides a form for deleting Goal entities.
 */
class GoalDeleteForm extends ContentEntityDeleteForm {

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete the goal %name?', ['%name' => $this->getEntity()->label()]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    // Provide the route to which the user should be redirected if they cancel the deletion.
    return $this->getEntity()->toUrl('collection');
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->t('This action cannot be undone, and all associated data will be permanently deleted.');
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $entity = $this->getEntity();
    $entity_name = $entity->label();

    // Logging the deletion event before the entity is deleted.
    $this->logger('chatgpt_writer')->notice('Deleted Goal entity %name.', ['%name' => $entity_name]);

    // Call the parent submitForm to handle the actual deletion.
    parent::submitForm($form, $form_state);

    // After deletion logic can be placed here, for example, setting a redirect.
    // $form_state->setRedirectUrl($this->getCancelUrl());
  }

}
