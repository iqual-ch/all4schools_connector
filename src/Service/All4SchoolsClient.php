<?php

namespace Drupal\all4schools_connector\Service;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Http\ClientFactory;
use Drupal\Core\Logger\LoggerChannelFactory;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Client for All4Schools API.
 */
class All4SchoolsClient {

  use StringTranslationTrait;

  /**
   * The HTTP client to fetch the a4s data with.
   *
   * @var \GuzzleHttp\Client
   */
  protected $client;

  /**
   * Configuration for the A4S API information.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected $config;

  /**
   * The Logger channel Factory.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger;

  /**
   * The client factory to create the client with the configuration.
   *
   * @var \Drupal\Core\Http\ClientFactory
   */
  protected $httpClientFactory;

  /**
   * All4SchoolssClient constructor.
   *
   * @param \Drupal\Core\Http\ClientFactory $http_client_factory
   *   The Http Client factory.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Core\Logger\LoggerChannelFactory $loggerChannelFactory
   *   The logger channel factory.
   */
  public function __construct(ClientFactory $http_client_factory, ConfigFactoryInterface $config_factory, LoggerChannelFactory $loggerChannelFactory) {
    $this->config = $config_factory->get('all4schools_connector.settings');
    $this->logger = $loggerChannelFactory->get('all4schools_api');
    $this->client = $http_client_factory->fromOptions([
      'base_uri' => $this->getConfig('base_url'),
      'request_id' => $this->getConfig('request_id'),
      'app_user_id' => $this->getConfig('app_user_id'),
    ]);
  }

  /**
   * Get configuration or state setting for A4S API.
   *
   * @param string $name
   *   Setting name to get the config or state from the A4S configuration.
   *
   * @return mixed
   *   The config value.
   */
  protected function getConfig($name) {

    return $this->config->get($name);
  }

  /**
   * Get the offers from All4Schools.
   *
   * @param string $method
   *   The Http method.
   * @param string $uri
   *   The endpoint uri.
   * @param array $args
   *   Optional query parameters array.
   * @param int $school
   *   The school id, defaults to 1.
   * @param string $requestId
   *   The request id.
   *
   * @return array
   *   Returns an array of course info.
   */
  public function request(string $method, string $uri, array $args = [], int $school = 1, string $requestId = 'af56aae1d88ea4d75664bc721c0dcafd93690c7d') {
    $query = [
      'schools' => $school,
      'requestId' => $requestId,
    ];
    if (!empty($args)) {
      $query = array_merge($query, $args);
    }
    $data = [
      'query' => $query,
    ];
    try {
      $response = $this->client->request($method, $uri, $data);
      return Json::decode($response->getBody());
    }
    catch (GuzzleException $error) {
      /*
       * Using FormattableMarkup allows for the use of <pre/> tags,
       * giving a more readable log item.
       */
      $message = new FormattableMarkup(
        'API connection error. Error details are as follows:<pre>@response</pre>',
        ['@response' => $error->getMessage()]
          );
      // Log the error.
      $this->logger->error('Remote API Connection', [], $message);
    }
    /*
     * A non-Guzzle error occurred. T
     * The type of exception is unknown, so a generic log item is created.
     */
    catch (\Exception $error) {
      // Log the error.
      $this->logger->error(
        'Remote API Connection',
        [],
        $this->t(
          'An unknown error occurred while trying to connect to the remote API. \
          This is not a Guzzle error, nor an error in the remote API, rather a generic local error ocurred. \
          The reported error was @error',
          [
            '@error' => $error->getMessage(),
          ]
        )
      );
    }
    return FALSE;
  }

}
