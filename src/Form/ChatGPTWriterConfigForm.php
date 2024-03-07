<?php

namespace Drupal\chatgpt_writer\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configuration form definition for the ChatGPT Writer module.
 */
class ChatGPTWriterConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'chatgpt_writer.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'chatgpt_writer_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('chatgpt_writer.settings');

    $form['openai_openai_api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('OpenAI API Key'),
      '#default_value' => $config->get('openai_openai_api_key'),
      '#description' => $this->t('Enter your OpenAI API key required to make GPT-3 API calls.'),
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $apiKey = $form_state->getValue('openai_openai_api_key');

    // Check if the API key is empty.
    if (empty($apiKey)) {
        $form_state->setErrorByName('openai_openai_api_key', $this->t('The OpenAI API key cannot be empty.'));
    }

    // Basic length check - adjust the length according to the actual expected length of the API key.
    if (strlen($apiKey) < 40 || strlen($apiKey) > 60) {
        $form_state->setErrorByName('openai_openai_api_key', $this->t('The OpenAI API key does not appear to be the correct length.'));
    }

    // Prefix check - adjust according to the actual expected prefix of the API key.
    if (!preg_match('/^sk-\w+/', $apiKey)) {
        $form_state->setErrorByName('openai_openai_api_key', $this->t('The OpenAI API key format appears incorrect. It should start with "sk-".'));
    }
}

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('chatgpt_writer.settings')
      ->set('openai_openai_api_key', $form_state->getValue('openai_openai_api_key'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
