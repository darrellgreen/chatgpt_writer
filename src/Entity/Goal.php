<?php

namespace Drupal\chatgpt_writer\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\chatgpt_writer\GoalInterface;
use Drupal\user\UserInterface; // Ensure this use statement is correctly added.
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\user\EntityOwnerTrait;

/**
 * Defines the Goal entity for the ChatGPT Writer module.
 *
 * @ContentEntityType(
 *   id = "chatgpt_writer_goal",
 *   label = @Translation("Goal"),
 *   base_table = "chatgpt_writer_goal",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *   },
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\chatgpt_writer\ListBuilder\GoalListBuilder",
 *     "form" = {
 *       "default" = "Drupal\chatgpt_writer\Form\GoalForm",
 *       "add" = "Drupal\chatgpt_writer\Form\GoalForm",
 *       "edit" = "Drupal\chatgpt_writer\Form\GoalForm",
 *       "delete" = "Drupal\chatgpt_writer\Form\GoalDeleteForm",
 *     },
 *     "access" = "Drupal\chatgpt_writer\Access\GoalAccessControlHandler",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/chatgpt_writer/{chatgpt_writer_goal}",
 *     "add-form" = "/admin/structure/chatgpt_writer/goal/add",
 *     "edit-form" = "/admin/structure/chatgpt_writer_goal/{chatgpt_writer_goal}/edit",
 *     "delete-form" = "/admin/structure/chatgpt_writer_goal/{chatgpt_writer_goal}/delete",
 *     "collection" = "/admin/structure/chatgpt_writer",
 *   },
 * )
 */
class Goal extends ContentEntityBase implements GoalInterface, EntityChangedInterface {
  use EntityChangedTrait, EntityOwnerTrait; // Provides implementations for getChangedTime() and setChangedTime().

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    // Base field definitions follow...
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Goal.'))
      ->setRequired(TRUE)
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ]);

    $fields['keywords'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Keywords'))
      ->setDescription(t('Keywords associated with the Goal.'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string_long',
        'weight' => -3,
      ])
      ->setDisplayOptions('form', [
        'type' => 'textarea',
        'weight' => -3,
      ]);

    $fields['frequency'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('Frequency'))
      ->setDescription(t('How often the Goal should be processed.'))
      ->setSettings([
        'allowed_values' => [
          'daily' => 'Daily',
          'weekly' => 'Weekly',
          'monthly' => 'Monthly',
        ],
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'list_default',
        'weight' => -2,
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => -2,
      ]);

    $fields['target_content_type'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Target Content Type'))
      ->setDescription(t('The content type of entities to which the Goal applies.'))
      ->setSetting('target_type', 'node_type')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'entity_reference_label',
        'weight' => -1,
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => -1,
      ]);
    // Add or update your baseFieldDefinitions method with:
    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('User ID'))
      ->setDescription(t('The user ID of the goal author.'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => -5,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Add the 'changed' field for tracking the last update time.
    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the goal was last edited.'))
      ->setReadOnly(TRUE);

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getKeywords() {
    return $this->get('keywords')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setKeywords($keywords) {
    $this->set('keywords', $keywords);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getFrequency() {
    return $this->get('frequency')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setFrequency($frequency) {
    $this->set('frequency', $frequency);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getTargetContentType() {
    return $this->get('target_content_type')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setTargetContentType($target_content_type) {
    $this->set('target_content_type', $target_content_type);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * Sets the entity owner.
   *
   * @param \Drupal\user\UserInterface $account
   *   The user entity.
   *
   * @return $this
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getChangedTimeAcrossTranslations() {
    // If your entity doesn't support translations or doesn't need this, a simple implementation could be:
    return $this->getChangedTime();
  }

  public function getChangedTime() {
    return $this->get('changed')->value;
  }
  
  public function setChangedTime($timestamp) {
    $this->set('changed', $timestamp);
  }

  // Implementations for EntityOwnerInterface methods and any other required methods.

}
