<?php

namespace Lupcom\RapidSkeletonBundle\Classes;

use Contao\Frontend;

class RapidSkeleton extends Frontend
{
    public static function print()
    {
        print_r('function print() in class RapidSkeleton');
    }
}
