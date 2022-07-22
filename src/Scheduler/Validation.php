<?php

namespace Nylas\Scheduler;

use DateTimeZone;
use Nylas\Utilities\Validator as V;

/**
 * ----------------------------------------------------------------------------------
 * Nylas Scheduler API Validation
 * ----------------------------------------------------------------------------------
 *
 * @see https://developer.nylas.com/docs/api/scheduler/#overview
 *
 * @author MatthewLoffredo
 */
class Validation
{
  // ------------------------------------------------------------------------------

  /**
   * get scheduling page base rules
   *
   * @return V
   */
  public static function getSchedulingPageRules(): V
  {
    return V::keySet(
      V::keyOptional('access_tokens', V::simpleArray(V::stringType()->notEmpty())),
      V::keyOptional('config', V::alwaysValid()),
      V::keyOptional('name', V::stringType()->notEmpty()),
      V::keyOptional('slug', V::stringType()->notEmpty()),
    );
  }

  // ------------------------------------------------------------------------------

  /**
   * scheduling page config validate rules
   *
   * @return \Nylas\Utilities\Validator
   */
  public static function getConfigRules(): V
  {
    // TODO: finish config validation rules
    return V::keySet(
      V::key('appearance', self::getAppearanceRules()),
      V::key('booking', V::alwaysValid()), // not done
      V::keyOptional('calendar_ids', V::alwaysValid()), // not done
      V::key('event', V::alwaysValid()), // not done
      V::keyOptional('expire_after', V::alwaysValid()), // not done
      V::keyOptional('disable_emails', V::boolType()),
      V::keyOptional('locale', V::stringType()->notEmpty()),
      V::keyOptional('locale_for_guests', V::stringType()->notEmpty()),
      V::key('reminders', V::alwaysValid()), // not done
      V::key('timezone', V::stringType()->notEmpty()),
    );
  }

  // ------------------------------------------------------------------------------

  /**
   * scheduling page appearance validate rules
   *
   * @return \Nylas\Utilities\Validator
   */
  public static function getAppearanceRules(): V
  {
    return V::keySet(
      V::keyOptional('color', V::stringType()->notEmpty()),
      V::keyOptional('company_name', V::stringType()->notEmpty()),
      V::keyOptional('logo', V::stringType()->notEmpty()),
      V::keyOptional('privacy_policy_redirect', V::stringType()->notEmpty()),
      V::keyOptional('show_autoschedule', V::boolType()),
      V::key('show_nylas_branding', V::boolType()),
      V::keyOptional('show_timezone_options', V::boolType()),
      V::keyOptional('show_week_view', V::boolType()),
      V::keyOptional('submit_text', V::stringType()->notEmpty()),
      V::keyOptional('thank_you_redirect', V::stringType()->notEmpty()),
      V::keyOptional('thank_you_text', V::stringType()->notEmpty()),
      V::keyOptional('thank_you_text_secondary', V::stringType()->notEmpty()),
    );
  }
}
