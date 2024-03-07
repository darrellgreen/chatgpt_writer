<?php

namespace Drupal\chatgpt_writer;

use Drupal\Core\Config\ConfigFactoryInterface;
use GuzzleHttp\ClientInterface;
use Drupal\chatgpt_writer\ChatGPT\ChatGPTServiceInterface;
use GuzzleHttp\Exception\RequestException;

/**
 * Service class for interacting with the ChatGPT API.
 */
class ChatGPTService implements ChatGPTServiceInterface {

  /**
   * The HTTP client to send requests.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a ChatGPTService object.
   *
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The HTTP client.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(ClientInterface $http_client, ConfigFactoryInterface $config_factory) {
    $this->httpClient = $http_client;
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public function generateContent($keywords) {
    // Retrieve your ChatGPT API key from module configuration.
    $api_key = $this->configFactory->get('chatgpt_writer.settings')->get('api_key');
    $endpoint = 'https://api.openai.com/v1/completions';

    $options = [
      'headers' => [
        'Authorization' => "Bearer {$api_key}",
        'Content-Type' => 'application/json',
      ],
      'json' => [
        'model' => 'text-davinci-003', // Adjust the model as necessary.
        'prompt' => "Write an article about {$keywords}.",
        'temperature' => 0.7,
        'max_tokens' => 1024,
        'top_p' => 1.0,
        'frequency_penalty' => 0,
        'presence_penalty' => 0,
      ],
    ];

    try {
      $response = $this->httpClient->post($endpoint, $options);
      $data = json_decode($response->getBody()->getContents(), TRUE);

      if (isset($data['choices'][0]['text'])) {
        // Here, implement logic to extract and separate the title from the content
        // if the API response includes them together.
        return [
          'success' => TRUE,
          'content' => $data['choices'][0]['text'],
          // 'title' could be extracted from content if structured appropriately.
        ];
      }
      else {
        return ['success' => FALSE, 'message' => 'No content was generated.'];
      }
    } catch (RequestException $e) {
      watchdog_exception('chatgpt_writer', $e);
      return ['success' => FALSE, 'message' => $e->getMessage()];
    }
  }

}
