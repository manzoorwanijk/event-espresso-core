<?php

namespace EventEspresso\core\domain\entities\gutenberg;

use EventEspresso\core\exceptions\InvalidInterfaceException;
use EventEspresso\core\services\collections\Collection;

defined('EVENT_ESPRESSO_VERSION') || exit;



/**
 * Class GutenbergBlockCollection
 * a Collection of GutenbergBlock objects
 *
 * @package EventEspresso\core\services\gutenberg
 * @author  Brent Christensen
 * @since   $VID:$
 */
class GutenbergBlockCollection extends Collection
{

    /**
     * Collection constructor
     *
     * @throws InvalidInterfaceException
     */
    public function __construct()
    {
        parent::__construct('EventEspresso\core\domain\entities\gutenberg\GutenbergBlockInterface');
    }


    /**
     * unRegisterBlock
     * finds block in the Collection based on the identifier that was set using addObject()
     * and calls unRegisterBlock() on it. Returns block if successful and false if block was not found.
     * PLZ NOTE: the pointer is reset to the beginning of the collection afterwards
     *
     * @param mixed $identifier
     * @return boolean
     */
    public function unRegisterBlock($identifier)
    {
        $this->rewind();
        while ($this->valid()) {
            if ($identifier === $this->getInfo()) {
                $object = $this->current();
                $this->rewind();
                return $object->unRegisterBlock();
            }
            $this->next();
        }
        return false;
    }


    /**
     * unRegisterAllBlocks
     * calls unRegisterBlock() on all blocks in Collection.
     * PLZ NOTE: the pointer is reset to the beginning of the collection afterwards
     *
     * @return void
     */
    public function unRegisterAllBlocks()
    {
        $this->rewind();
        while ($this->valid()) {
            $this->current()->unRegisterBlock();
            $this->next();
        }
        $this->rewind();
    }
}