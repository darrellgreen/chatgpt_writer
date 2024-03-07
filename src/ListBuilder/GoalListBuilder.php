<?php

namespace Drupal\chatgpt_writer\ListBuilder;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Goal entities.
 */
class GoalListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['name'] = $this->t('Name');
    $header['keywords'] = $this->t('Keywords');
    $header['frequency'] = $this->t('Frequency');
    $header['target_content_type'] = $this->t('Target Content Type');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\chatgpt_writer\Entity\Goal $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.chatgpt_writer_goal.edit_form',
      ['chatgpt_writer_goal' => $entity->id()]
    );

    // Handle 'keywords' field more gracefully
    $keywords = $entity->get('keywords')->value;
    $row['keywords'] = $keywords ? $keywords : $this->t('Not specified');

    // Handle 'frequency' field more gracefully
    $frequency = $entity->get('frequency')->value;
    $row['frequency'] = $frequency ? $this->t($frequency) : $this->t('Not specified');

    // Handle 'target_content_type' field more gracefully
    $targetContentTypeEntity = $entity->get('target_content_type')->entity;
    $row['target_content_type'] = $targetContentTypeEntity ? $targetContentTypeEntity->label() : $this->t('Not specified');

    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  protected function getDefaultOperations(EntityInterface $entity) {
    $operations = parent::getDefaultOperations($entity);

    // "Edit" operation
    if ($entity->access('update') && $entity->hasLinkTemplate('edit-form')) {
      $operations['edit'] = [
        'title' => $this->t('Edit'),
        'url' => $this->ensureDestination($entity->toUrl('edit-form')),
      ];
    }

    // "Delete" operation
    if ($entity->access('delete') && $entity->hasLinkTemplate('delete-form')) {
      $operations['delete'] = [
        'title' => $this->t('Delete'),
        'url' => $this->ensureDestination($entity->toUrl('delete-form')),
      ];
    }

    // "Run" operation
    if (\Drupal::currentUser()->hasPermission('run chatgpt writer goals') && $entity->access('view')) {
      $operations['run'] = [
        'title' => $this->t('Run'),
        'weight' => 20,
        'url' => $this->ensureDestination(Url::fromRoute('chatgpt_writer.run_goal', ['chatgpt_writer_goal' => $entity->id()])),
      ];
    }

    return $operations;
  }

}
