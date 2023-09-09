<?php

namespace WebTheory\Pathagist\Interfaces;

interface SerializerInterface
{
    public function deserializePaths($obj);

    public function serializePaths(array $paths);
}
