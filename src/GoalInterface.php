<?php

namespace Drupal\chatgpt_writer;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a Goal entity.
 */
interface GoalInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

  /**
   * Gets the Goal name.
   *
   * @return string
   *   Name of the Goal.
   */
  public function getName();

  /**
   * Sets the Goal name.
   *
   * @param string $name
   *   The name of the Goal.
   *
   * @return $this
   */
  public function setName($name);

  /**
   * Gets the Goal keywords.
   *
   * @return string
   *   Keywords of the Goal.
   */
  public function getKeywords();

  /**
   * Sets the Goal keywords.
   *
   * @param string $keywords
   *   The keywords of the Goal.
   *
   * @return $this
   */
  public function setKeywords($keywords);

  /**
   * Gets the Goal frequency.
   *
   * @return string
   *   Frequency of the Goal.
   */
  public function getFrequency();

  /**
   * Sets the Goal frequency.
   *
   * @param string $frequency
   *   The frequency of the Goal.
   *
   * @return $this
   */
  public function setFrequency($frequency);

  /**
   * Gets the target content type for the Goal.
   *
   * @return string
   *   The target content type of the Goal.
   */
  public function getTargetContentType();

  /**
   * Sets the target content type for the Goal.
   *
   * @param string $target_content_type
   *   The target content type of the Goal.
   *
   * @return $this
   */
  public function setTargetContentType($target_content_type);

}
