<?php

namespace EventEspresso\core\services\addon\api\v1;

/**
 * Interface RegisterApiInterface
 * replacement for /core/libraries/plugin_api/EEI_Plugin_API.lib.php
 *
 * @package EventEspresso\core\services\addon\api
 * @since   $VID:$
 */
interface RegisterApiInterface
{

    /**
     * Used to register FQCNs for an add-on component with EE core.
     *
     * @param string $addon_ID  a unique name or ID for the add-on being registered
     * @param array $data       a single or multidimensional array of Fully Qualified Class Names (or folders)
     *                          to be loaded at the appropriate time for one or more add-on components
     * @return void
     */
    public function register($addon_ID, array $data);


    /**
     * Used to deregister an add-on component with EE core.
     *
     * @param string $addon_ID  a unique name or ID for the add-on being deregistered
     * @return void
     */
    public function deregister($addon_ID);

}
