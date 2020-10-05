<?php

namespace EventEspresso\core\services\addon\api\v1;

/**
 * Class RegisterApi
 *
 * Abstract parent class for facilitating the registration of add-on components.
 * For example:
 *      Registering add-on widgets might use a class named "RegisterWidget"
 *      which would use these methods internally for managing the widget FQCNs.
 *      Then at the appropriate time, the widget classes could be instantiated (via the FQCNs)
 *      and allowed to run whatever logic is needed to hook into the rest of the system
 *
 * @package EventEspresso\core\services\addon\api\v1
 * @since   $VID:$
 */
abstract class RegisterApi implements RegisterApiInterface
{

    /**
     * Holds FQCNs for registered add-on classes
     *
     * @var array
     */
    private $FQCNs = [];


    /**
     * returns an array of FQCNs for:
     *      - ALL add-ons
     *      - one specific add-on; by supplying the $addon_ID
     *      - one specific component for an add-on; by supplying the $addon_ID AND $component ID
     *
     * @param string $addon_ID  [optional] a unique name or ID for the add-on being registered
     * @param string $component [optional] a unique name for the add-on component the $FQCNs belong to
     * @return array
     */
    protected function getFQCNs($addon_ID = '', $component = '')
    {
        if (is_string($addon_ID) && $addon_ID !== '') {
            if (is_string($component) && $component !== '') {
                // return component FQCNs if registered
                if (isset($this->FQCNs[ $addon_ID ][ $component ])) {
                    return $this->FQCNs[ $addon_ID ][ $component ];
                }
                // component not registered ? return nothing
                return [];
            }
            // return ALL component FQCNs if add-on registered
            if (isset($this->FQCNs[ $addon_ID ])) {
                return [];
            }
        }
        // did not request specific addon so return everything
        return $this->FQCNs;
    }


    /**
     * returns an array of FQCNs for a specific component type for ALL add-ons
     *
     * @param string $component a unique name for the add-on component the $FQCNs belong to
     * @return array
     */
    protected function getFQCNsForComponent($component)
    {
        $component_FQCNs = [];
        foreach ($this->FQCNs as $addon_ID => $components) {
            foreach ($components as $key => $FQCNs) {
                if ($key === $component) {
                    foreach ($FQCNs as $FQCN) {
                        $component_FQCNs[ $addon_ID ][] = $FQCN;
                    }
                }
            }
        }
        return $component_FQCNs;
    }


    /**
     * register a FQCN for an add-on component
     *
     * @param string $addon_ID      a unique name or ID for the add-on being registered
     * @param string $FQCN          Fully Qualified Class Name (or folder path)
     * @param string $component     [optional] a unique name for the add-on component the $FQCNs belong to
     */
    protected function addFQCN($addon_ID, $FQCN, $component = 'general')
    {
        if (is_string($FQCN) && $FQCN !== '') {
            $component = is_string($component) && $component !== '' ? $component : 'general';
            $this->FQCNs[ $addon_ID ][ $component ][] = $FQCN;
        }
    }


    /**
     * register am array of component FQCNs for an add-on
     *
     * @param string $addon_ID  a unique name or ID for the add-on being registered
     * @param array  $FQCNs     array of Fully Qualified Class Names (or folder paths to FQCNs)
     *                          to be loaded at the appropriate time for the particular component
     * @param string $component [optional] a unique name for the add-on component the $FQCNs belong to
     */
    protected function addFQCNs($addon_ID, array $FQCNs, $component = 'general')
    {
        foreach ($FQCNs as $FQCN) {
            $this->addFQCN($addon_ID, $component, $FQCN);
        }
    }


    /**
     * de-registers (clears)
     *      - ALL components for an add-on; by supplying the $addon_ID
     *      - one specific component for an add-on; by supplying the $addon_ID AND $component ID
     *
     * @param string $addon_ID  a unique name or ID for the add-on being registered
     * @param string $component [optional] a unique name for the add-on component the $FQCNs belong to
     * @return void
     */
    protected function removeComponent($addon_ID, $component = '')
    {
        if (is_string($addon_ID) && isset($this->FQCNs[ $addon_ID ])) {
            if (is_string($component) && isset($this->FQCNs[ $addon_ID ][ $component ])) {
                unset($this->FQCNs[ $addon_ID ][ $component ]);
                return;
            }
            unset($this->FQCNs[ $addon_ID ]);
        }
    }
}
