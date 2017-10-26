<?php
/**
 * Copyright
 */

namespace Timitao\BehatAggregateContainer;

use Psr\Container\ContainerInterface;
use Timitao\BehatAggregateContainer\Exception\BehatAggregateContainerException;

class Aggregate implements ContainerInterface
{
    /**
     * @var \ArrayObject
     */
    private $list;

    /**
     * Aggregate constructor.
     */
    public function __construct()
    {
        $this->list = new \ArrayObject();
    }


    /**
     * @param ContainerInterface $container
     */
    public function registerAggregate(ContainerInterface $container)
    {
        $this->list->append($container);
    }

    /**
     * @param string $id
     *
     * @return mixed
     *
     * @throws BehatAggregateContainerException
     */
    public function get($id)
    {
        /** @var ContainerInterface $item */
        foreach ($this->list as $item) {
            if ($item->has($id)) {
                return $item->get($id);
            }
        }

        throw new BehatAggregateContainerException(
            sprintf("Didn't find service '%s' in any container", $id)
        );
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function has($id)
    {
        /** @var ContainerInterface $item */
        foreach ($this->list as $item) {
            if ($item->has($id)) {
                return true;
            }
        }

        return false;
    }
}
