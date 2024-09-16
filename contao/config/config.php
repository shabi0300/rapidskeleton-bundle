
<?php
/**
 * Backend modules
 */

use Lupcom\RapidSkeletonBundle\Models\RapidSkeletonModel;
use Lupcom\RapidSkeletonBundle\Models\TestimonialsModel;
use Lupcom\RapidSkeletonBundle\Models\TestimonialsCategoriesModel;

$GLOBALS['BE_MOD']['rapidskeleton']['rapidskeleton_module'] = [
    'tables' => ['tl_rapidskeleton'],
];
$GLOBALS['BE_MOD']['rapidskeleton']['testimonials_module'] = [
    'tables' => ['tl_testimonials_categories', 'tl_testimonials'],
];

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_rapidskeleton'] = RapidSkeletonModel::class;
$GLOBALS['TL_MODELS']['tl_testimonials'] = TestimonialsModel::class;
$GLOBALS['TL_MODELS']['tl_testimonials_categories'] = TestimonialsCategoriesModel::class;
