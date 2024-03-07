namespace Drupal\chatgpt_writer\ChatGPT;

/**
 * Interface for ChatGPTService.
 */
interface ChatGPTServiceInterface {

  /**
   * Generates content using the ChatGPT API.
   *
   * @param string $keywords
   *   The keywords to generate the content from.
   *
   * @return array
   *   An associative array containing 'success', 'title', and 'content' keys.
   */
  public function generateContent($keywords);
}
