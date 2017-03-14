<?php
/**
 * Copyright
 */
namespace Timitao\BehatAggregateContainer;


use Interop\Container\ContainerInterface;
use Timitao\BehatAggregateContainer\Exception\BehatAggregateContainerException;

class Aggregate extends \ArrayObject implements ContainerInterface
{
    public function registerAggregate(ContainerInterface $container)
    {
        $this->append($container);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws BehatAggregateContainerException
     */
    public function get($id)
    {
        /** @var ContainerInterface $item */
        foreach ($this as $item) {
            if ($item->has($id)) {
                return $item->get($id);
            }
        }

        throw new BehatAggregateContainerException(sprintf("Didn't find service '%s' in any container", $id));
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        $result = false;
        /** @var ContainerInterface $item */
        foreach ($this as $item) {
            if ($item->has($id)) {
                $result = true;
            }
        }

        return $result;
    }
}