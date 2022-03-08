<?php

namespace Nylas\Scheduler;

use Nylas\Utilities\API;
use Nylas\Utilities\Helper;
use Nylas\Utilities\Options;
use Nylas\Utilities\Validator as V;

/**
 * ----------------------------------------------------------------------------------
 * Nylas Scheduler API
 * ----------------------------------------------------------------------------------
 *
 * @see https://developer.nylas.com/docs/api/scheduler/#overview
 *
 * @author MatthewLoffredo
 */
class SchedulingPage
{
  // ------------------------------------------------------------------------------

  /**
   * @var \Nylas\Utilities\Options
   */
  private Options $options;

  // ------------------------------------------------------------------------------

  /**
   * SchedulingPage constructor.
   *
   * @param \Nylas\Utilities\Options $options
   */
  public function __construct(Options $options)
  {
    $options->setServer('scheduler');
    $this->options = $options;
  }

  // ------------------------------------------------------------------------------

  /**
   * get scheduling pages list
   * 
   * @see https://developer.nylas.com/docs/api/scheduler/#get/manage/pages
   *
   * @param array $params
   *
   * @return array
   */
  public function returnAllSchedulingPages(array $params = []): array
  {
    return $this->options
      ->getSync()
      ->setQuery($params)
      ->setHeaderParams($this->options->getAuthorizationHeader())
      ->get(API::LIST['schedulingPages']);
  }

  // ------------------------------------------------------------------------------

  /**
   * Creates a scheduling page
   *
   * @see https://developer.nylas.com/docs/api/scheduler/#post/manage/pages
   *
   * @param array $params
   *
   * @return array
   */
  public function createASchedulingPage(array $params): array
  {
    V::doValidate(Validation::getSchedulingPageRules(), $params);

    return $this->options
      ->getSync()
      ->setFormParams($params)
      ->setHeaderParams($this->options->getAuthorizationHeader())
      ->post(API::LIST['schedulingPages']);
  }

  // ------------------------------------------------------------------------------

  /**
   * Returns a scheduling page by ID.
   *
   * @see https://developer.nylas.com/docs/api/scheduler/#get/manage/pages/page_id
   *
   * @param mixed $schedulingPageId
   *
   * @return array
   */
  public function returnASchedulingPage(mixed $schedulingPageId): array
  {
    $schedulingPageId = Helper::fooToArray($schedulingPageId);

    V::doValidate(V::simpleArray(V::stringType()->notEmpty()), $schedulingPageId);

    $queues = [];

    foreach ($schedulingPageId as $id) {
      $request = $this->options
        ->getAsync()
        ->setPath($id)
        ->setHeaderParams($this->options->getAuthorizationHeader());

      $queues[] = static function () use ($request) {
        return $request->get(API::LIST['oneSchedulingPage']);
      };
    }

    $pools = $this->options->getAsync()->pool($queues, false);

    return Helper::concatPoolInfos($schedulingPageId, $pools);
  }

  // ------------------------------------------------------------------------------

  /**
   * Updates a scheduling page
   *
   * @see https://developer.nylas.com/docs/api/scheduler/#put/manage/pages/page_id
   *
   * @param string $schedulingPageId
   * @param array  $params
   *
   * @return array
   */
  public function updateASchedulingPage(string $schedulingPageId, array $params): array
  {
    V::doValidate(Validation::getSchedulingPageRules(), $params);
    V::doValidate(V::stringType()->notEmpty(), $schedulingPageId);

    return $this->options
      ->getSync()
      ->setPath($schedulingPageId)
      ->setFormParams($params)
      ->setHeaderParams($this->options->getAuthorizationHeader())
      ->put(API::LIST['oneSchedulingPage']);
  }

  // ------------------------------------------------------------------------------

  /**
   * Deletes a scheduling page.
   *
   * @see https://developer.nylas.com/docs/api/scheduler/#delete/manage/pages/page_id
   *
   * @param string $schedulingPageId
   *
   * @return array
   */
  public function deleteASchedulingPage(mixed $schedulingPageId): array
  {
    $schedulingPageId = Helper::fooToArray($schedulingPageId);

    V::doValidate(V::simpleArray(V::stringType()->notEmpty()), $schedulingPageId);

    $queues = [];

    foreach ($schedulingPageId as $id) {
      $request = $this->options
        ->getAsync()
        ->setPath($id)
        ->setHeaderParams($this->options->getAuthorizationHeader());

      $queues[] = static function () use ($request) {
        return $request->delete(API::LIST['oneSchedulingPage']);
      };
    }

    $pools = $this->options->getAsync()->pool($queues, false);

    return Helper::concatPoolInfos($schedulingPageId, $pools);
  }

  // ------------------------------------------------------------------------------
}
