<?php

namespace Drupal\chatgpt_writer\Access;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

class GoalAccessControlHandler extends EntityAccessControlHandler {
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    \Drupal::logger('chatgpt_writer')->notice('Access check for operation @operation by user @user.', ['@operation' => $operation, '@user' => $account->id()]);

    switch ($operation) {
			case 'update':
					if ($entity->getOwnerId() === $account->id()) {
							return AccessResult::allowedIfHasPermission($account, 'edit own chatgpt_writer_goal');
					} else {
							return AccessResult::allowedIfHasPermission($account, 'edit any chatgpt_writer_goal');
					}
      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete any chatgpt_writer_goal');
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view chatgpt_writer_goal');

    }
    return parent::checkAccess($entity, $operation, $account);
  }
}
