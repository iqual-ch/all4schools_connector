<?php

namespace Drupal\all4schools_connector\Service;

use Drupal\Component\Serialization\Json;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Http\ClientFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *
 */
class All4SchoolsClient implements ContainerInjectionInterface {

  /**
   * The HTTP client to fetch the a4s data with.
   *
   * @var \GuzzleHttp\Client
   */
  protected $client;

  /**
   * Configuration for the A4S API information.
   */
  protected $config;

  /**
   * The client factory to create the client with the configuration.
   *
   * @var \Drupal\Core\Http\ClientFactory
   */
  protected $httpClientFactory;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
          $container->get('http_client_factory')
      );
  }

  /**
   * All4SchoolssClient constructor.
   *
   * @param \Drupal\Core\Http\ClientFactory $http_client_factory
   */
  public function __construct(ClientFactory $http_client_factory) {
    $this->config = \Drupal::config('all4schools_connector.settings');
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
   */
  protected function getConfig($name) {

    return $this->config->get($name);
  }

  /**
   * Get the offers from All4Schools.
   *
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
  public function request(string $uri, array $args = [], int $school = 1, string $requestId = 'af56aae1d88ea4d75664bc721c0dcafd93690c7d') {
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

    $response = $this->client->get($uri, $data);

    // @todo handle errors
    return Json::decode($response->getBody());
  }

}
