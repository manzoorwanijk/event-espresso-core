<?php

namespace EventEspresso\core\services\addon;

use EventEspresso\core\services\addon\api\legacy\AddonCollection as LegacyAddons;
use EventEspresso\core\services\addon\api\legacy\AddonRegistrar as LegacyAPI;
use EventEspresso\core\services\addon\api\v1\AddonCollection as V1Addons;
use EventEspresso\core\services\addon\api\v1\AddonRegistrar as V1API;

/**
 * Class AddonManager
 * Handles high-level add-on registration using multiple add-on API versions
 *
 * @package EventEspresso\core\services\addon
 * @since   $VID:$
 */
class AddonManager
{
    /**
     * @var LegacyAddons $legacy_addons
     */
    private $legacy_addons;

    /**
     * @var LegacyAPI $legacy_api
     */
    private $legacy_api;

    /**
     * @var V1Addons $v1_addons
     */
    private $v1_addons;

    /**
     * @var V1API $v1_api
     */
    private $v1_api;


    /**
     * AddonManager constructor.
     *
     * @param LegacyAddons $legacy_addons
     * @param LegacyAPI    $legacy_api
     * @param V1Addons     $v1_addons
     * @param V1API        $v1_api
     */
    public function __construct(
        LegacyAddons $legacy_addons,
        LegacyAPI $legacy_api,
        V1Addons $v1_addons,
        V1API $v1_api
    ) {
        $this->legacy_addons    = $legacy_addons;
        $this->legacy_api = $legacy_api;
        $this->v1_addons        = $v1_addons;
        $this->v1_api     = $v1_api;
        add_action('AHEE__EE_System__load_espresso_addons', [$this, 'registerAddons']);
    }


    /**
     * registers add-ons with the appropriate api version
     */
    public function registerAddons()
    {
        $this->legacy_api->deactivateIncompatibleAddons();
        do_action(
            'AHEE__EventEspresso_core_services_addon_AddonManager__registerAddons__v1',
            $this->v1_api
        );
        /*
         * If future changes can not maintain backwards compatibility,
         * then just register those add-ons using an additional newer API version
         * instead of complicating the existing API with conditional logic
         *
         *  do_action(
         *      'AHEE__EventEspresso_core_services_addon_AddonManager__registerAddons__v2',
         *      $this->v2_api
         *  );
        */
    }
}
