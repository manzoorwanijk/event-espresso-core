<?php

namespace EventEspresso\core\domain\services\graphql\data\loaders;

use EE_Error;
use EEM_Base;
use EEM_Price;
use EventEspresso\core\exceptions\InvalidDataTypeException;
use EventEspresso\core\exceptions\InvalidInterfaceException;
use InvalidArgumentException;

/**
 * Class PriceLoader
 */
class PriceLoader extends AbstractLoader
{
    /**
     * @return EEM_Base
     * @throws EE_Error
     * @throws InvalidArgumentException
     * @throws InvalidDataTypeException
     * @throws InvalidInterfaceException
     */
    protected function getQuery()
    {
        return EEM_Price::instance();
    }

    /**
     * @param array $keys
     * @return array
     */
    protected function getWhereParams(array $keys)
    {
        return [
            'PRC_ID' => ['IN', $keys],
        ];
    }
}