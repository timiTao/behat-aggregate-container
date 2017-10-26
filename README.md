# Behat Aggregate extension

Starting from [Behat 3.3](https://github.com/Behat/Behat/pull/974), is available to hold container implementing [Psr\Container\ContainerInterface](https://github.com/container-interop/container-interop).
This library is to aggregate of containers implementing `Psr\Container\ContainerInterface`.

# Configuration

        default:
          suites:
            default:
              contexts:
                # ...
                services: "@aggregate_container_extension.aggregate_id"
            # ...
            extensions:
                TimiTao\BehatAggregateExtension\ServiceContainer\Extension: ~

For connecting with other containers, for now, is available via tag ``aggregate_container_extension.aggregate_tag`` and extension.

## Versioning

Staring version ``0.1.0``, will follow [Semantic Versioning v2.0.0](http://semver.org/spec/v2.0.0.html).

## Contributors

* [Tomasz Kunicki - TimiTao](https://github.com/timiTao) 