<?php
/**
 * Copyright
 */
namespace Timitao\BehatAggregateContainer;


use Interop\Container\ContainerInterface;

class Aggregate extends \ArrayObject implements ContainerInterface
{
    public function registerAggregate(ContainerInterface $container)
    {
        $this->append($container);
    }

    public function get($id)
    {
        $result = false;
        /** @var ContainerInterface $item */
        foreach ($this as $item) {
            if ($item->has($id)) {
                return $item->get($id);
            }
        }

        throw new \Exception(sprintf("Didn't find service '%s' in any container", $id));
    }

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