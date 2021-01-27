<?php

declare(strict_types=1);

namespace Bosta\Utils;

class PackageDetails
{

    public function __construct($itemCount, $description = false,  $document = false)
    {

        $this->packageDetails = new \stdClass();
        $this->packageDetails->itemsCount = $itemCount;
        if ($description)
            $this->packageDetails->description = $description;
        if ($document)
            $this->packageDetails->document = $document;
    }
}
