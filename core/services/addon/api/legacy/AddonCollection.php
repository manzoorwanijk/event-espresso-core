<?php

namespace EventEspresso\core\services\addon\api\legacy;

use EventEspresso\core\exceptions\InvalidInterfaceException;
use EventEspresso\core\services\collections\Collection;
use EventEspresso\core\services\graphql\connections\ConnectionCollection;

class AddonCollection extends Collection
{

    const COLLECTION_NAME = 'espresso_legacy_addons';

    /**
     * @throws InvalidInterfaceException
     */
    public function __construct()
    {
        parent::__construct(
            'EE_Addon',
            ConnectionCollection::COLLECTION_NAME
        );
    }
}
