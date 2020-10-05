<?php

namespace EventEspresso\core\services\addon\api\v1;

class AddonRegistrar extends RegisterApi
{
    /**
     * @var AddonCollection $addons
     */
    private $addons;


    /**
     * AddonManager constructor.
     *
     * @param AddonCollection $addons
     */
    public function __construct(AddonCollection $addons)
    {
        $this->addons = $addons;
    }


    /**
     * Used to register FQCNs for an add-on component with EE core.
     *
     * @param string $addon_ID  a unique name or ID for the add-on being registered
     * @param array  $data      a single or multidimensional array of Fully Qualified Class Names (or folders)
     *                          to be loaded at the appropriate time for one or more add-on components
     * @return void
     */
    public function register($addon_ID, array $data)
    {
        foreach ($data as $component => $FQCNs) {
            $this->addFQCNs($addon_ID, $FQCNs, $component);
        }
    }


    /**
     * Used to deregister an add-on component with EE core.
     *
     * @param string $addon_ID a unique name or ID for the add-on being deregistered
     * @return void
     */
    public function deregister($addon_ID)
    {
        $this->removeComponent($addon_ID);
    }
}
