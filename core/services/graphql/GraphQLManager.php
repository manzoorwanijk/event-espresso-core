<?php

namespace EventEspresso\core\services\graphql;

use EventEspresso\core\services\collections\CollectionDetailsException;
use EventEspresso\core\services\collections\CollectionLoaderException;

/**
 * Class GraphQLManager
 * Loads and initializes all of the components required for integrating EE with GraphQL
 *
 * @package EventEspresso\core\services\graphql
 * @author  Brent Christensen
 * @since   $VID:$
 */
class GraphQLManager
{

    /**
     * @var TypesManager $types_manager
     */
    protected $types_manager;

    /**
     * @var InputsManager $inputs_manager
     */
    protected $inputs_manager;

    /**
     * @var EnumsManager $enums_manager
     */
    protected $enums_manager;

    /**
     * @var ConnectionsManager $connections_manager
     */
    protected $connections_manager;


    /**
     * GraphQLManager constructor.
     *
     * @param TypesManager $types_manager
     * @param InputsManager $inputs_manager
     * @param EnumsManager $enums_manager
     * @param ConnectionsManager $connections_manager
     */
    public function __construct(
        TypesManager $types_manager,
        InputsManager $inputs_manager,
        EnumsManager $enums_manager,
        ConnectionsManager $connections_manager
    )
    {
        $this->types_manager = $types_manager;
        $this->inputs_manager = $inputs_manager;
        $this->enums_manager = $enums_manager;
        $this->connections_manager = $connections_manager;
    }


    /**
     * @throws CollectionDetailsException
     * @throws CollectionLoaderException
     * @since $VID:$
     */
    public function init()
    {
        $this->types_manager->init();
        $this->inputs_manager->init();
        $this->enums_manager->init();
        $this->connections_manager->init();
    }
}
