<?php

declare(strict_types=1);

namespace Bosta\Utils;

use Bosta\Utils\PackageDetails;



class Specs
{


    public function __construct(PackageDetails $packageDetails)
    {
        $this->specs = new \stdClass();
        $this->specs->packageDetails  = $packageDetails->packageDetails;
       
    }
}
