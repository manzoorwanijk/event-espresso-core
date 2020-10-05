<?php

namespace EventEspresso\core\services\addon\api\v1;

use EventEspresso\core\exceptions\InvalidInterfaceException;
use EventEspresso\core\services\collections\Collection;
use EventEspresso\core\services\graphql\connections\ConnectionCollection;

class AddonCollection extends Collection
{

    const COLLECTION_NAME = 'espresso_v1_addons';

    /**
     * @throws InvalidInterfaceException
     */
    public function __construct()
    {
        parent::__construct(
            'EventEspresso\core\services\addon\api\v1\AddonInterface',
            ConnectionCollection::COLLECTION_NAME
        );
    }
}
