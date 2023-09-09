<?php

namespace WebTheory\Pathagist\Config\Serializer;

use WebTheory\Pathagist\Interfaces\SerializerInterface;

class Version2Serializer implements SerializerInterface
{
    public function deserializePaths($obj)
    {
        return $obj['paths'];
    }

    public function serializePaths(array $paths)
    {
        sort($paths);

        return ['paths' => array_values(array_unique($paths))];
    }
}
