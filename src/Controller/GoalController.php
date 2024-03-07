<?php

namespace Drupal\chatgpt_writer\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\chatgpt_writer\Entity\Goal;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\chatgpt_writer\ChatGPTService;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class GoalController.
 */
class GoalController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The ChatGPT service.
   *
   * @var \Drupal\chatgpt_writer\ChatGPTService
   */
  protected $chatGPTService;

  /**
   * Constructs a GoalController object.
   *
   * @param \Drupal\chatgpt_writer\ChatGPTService $chatGPTService
   *   The ChatGPT service.
   */
  public function __construct(ChatGPTService $chatGPTService) {
    $this->chatGPTService = $chatGPTService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('chatgpt_writer.chatgpt_service')
    );
  }

  /**
   * Runs the specified Goal.
   *
   * @param \Drupal\chatgpt_writter\Entity\Goal $chatgpt_writer_goal
   *   The goal entity to run.
   *
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   *   A redirect response object.
   */
  public function runGoal(Goal $chatgpt_writer_goal) {
    // Assuming you have a method in your service to handle the execution.
    // Pass necessary parameters from the Goal entity.
    $result = $this->chatGPTService->generateContent($chatgpt_writer_goal->getKeywords());

    // Process the result.
    // This is where you would handle the logic based on the API response.
    // For example, creating or updating entities, logging information, etc.

    if ($result['success']) {
      $this->messenger()->addMessage($this->t('Goal run successfully.'));
    } else {
      $this->messenger()->addError($this->t('Failed to run goal.'));
    }

    // Redirect back to the goals list.
    return $this->redirect('entity.chatgpt_writer_goal.collection');
  }

}
