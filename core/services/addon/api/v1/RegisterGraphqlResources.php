<?php

namespace EventEspresso\core\services\addon\api\v1;

/**
 * Class RegisterGraphqlResources
 *
 * @package EventEspresso\core\services\addon\api
 * @since   $VID:$
 */
class RegisterGraphqlResources extends RegisterApi
{
    /**
     * RegisterGraphqlResources constructor.
     */
    public function __construct()
    {
        add_action('AHEE__EE_System__load_espresso_addons__complete', [$this, 'registerResources']);
    }


    /**
     * Used to register FQCNs for an add-on component with EE core.
     *
     * @param string $addon_ID  a unique name or ID for the add-on being registered
     * @param array  $data      an array of Fully Qualified Class Names (or folder)
     *                          to be loaded at the appropriate time for the particular component
     * @return void
     */
    public function register($addon_ID, array $data)
    {
        foreach ($data as $component => $FQCNs) {
            if (is_string($component)) {
                $this->addFQCNs($addon_ID, $FQCNs, $component);
            } else {
                $this->addFQCNs($addon_ID, $FQCNs);
            }
        }
    }


    /**
     * Used to deregister an add-on component with EE core.
     *
     * @param string $addon_ID a unique name or ID for the add-on being registered
     * @return void
     */
    public function deregister($addon_ID)
    {
        $data = $this->getFQCNs($addon_ID);
        foreach ($data as $component => $FQCNs) {
            $this->removeComponent($addon_ID, $component);
        }
    }


    /**
     * @since $VID:$
     */
    public function registerResources()
    {
        add_filter(
            'FHEE__EventEspresso_core_services_graphql_TypeCollection__loadCollection__collection_FQCNs',
            [$this, 'registerTypes']
        );
        add_filter(
            'FHEE__EventEspresso_core_services_graphql_ConnectionCollection__loadCollection__collection_FQCNs',
            [$this, 'registerConnections']
        );
        add_filter(
            'FHEE__EventEspresso_core_services_graphql_DataLoaderCollection__loadCollection__collection_FQCNs',
            [$this, 'registerDataLoaders']
        );
    }


    /**
     * @param array $collection_FQCNs
     * @return array
     * @since $VID:$
     */
    public function registerTypes(array $collection_FQCNs = [])
    {
        $types = $this->getFQCNsForComponent('types');
        foreach ($types as $addon_ID => $FQCNs) {
            foreach ($FQCNs as $FQCN) {
                $collection_FQCNs[] = $FQCN;
            }
        }
        return $collection_FQCNs;
    }


    /**
     * @param array $collection_FQCNs
     * @return array
     * @since $VID:$
     */
    public function registerConnections(array $collection_FQCNs = [])
    {
        $connections = $this->getFQCNsForComponent('connections');
        foreach ($connections as $addon_ID => $FQCNs) {
            foreach ($FQCNs as $FQCN) {
                $collection_FQCNs[] = $FQCN;
            }
        }
        return $collection_FQCNs;
    }


    /**
     * @param array $collection_FQCNs
     * @return array
     * @since $VID:$
     */
    public function registerDataLoaders(array $collection_FQCNs = [])
    {
        $domains = $this->getFQCNsForComponent('domains');
        foreach ($domains as $addon_ID => $FQCNs) {
            foreach ($FQCNs as $FQCN) {
                $collection_FQCNs[] = $FQCN;
            }
        }
        return $collection_FQCNs;
    }
}
