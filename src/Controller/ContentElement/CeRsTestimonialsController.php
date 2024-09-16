<?php

namespace Lupcom\RapidSkeletonBundle\Controller\ContentElement;

use Contao\BackendTemplate;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\ContentModel;
use Contao\System;
use Contao\Template;
use Contao\FrontendTemplate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Lupcom\RapidSkeletonBundle\Models\TestimonialsModel;
use Lupcom\RapidSkeletonBundle\Models\TestimonialsCategoriesModel;

#[AsContentElement(name: 'ce_rs_testimonials', category: 'rapidskeleton', template: 'ce_rs_testimonials')]
class CeRsTestimonialsController extends AbstractContentElementController
{
    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        if (System::getContainer()->get('contao.routing.scope_matcher')->isFrontendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create(''))) {
            // FRONTEND
            $GLOBALS['TL_CSS']['ce_rs_testimonials_css']        = 'bundles/rapidskeleton/frontend/css/ce_rs_testimonials.css';
            $GLOBALS['TL_BODY']['testimonials_slider_js']       = FrontendTemplate::generateScriptTag('bundles/rapidskeleton/frontend/js/testimonials_slider.js', false, null);

            // dd($model->testimonial_category);
            if ($model->testimonial_category == 'all') {
                $objTestimonials = TestimonialsModel::findAll(["having" => "published = '1'", "order" => "sorting ASC"]);
            } else {
                $objTestimonials = TestimonialsModel::findAll(["having" => "published = '1' and pid = '" . $model->testimonial_category . "'", "order" => "sorting ASC"]);
            }
            $template->testimonials = $objTestimonials;
        } else {
            // BACKEND
            $template             = new BackendTemplate("be_wildcard");
            $template->wildcard   = "Kategorie: " . TestimonialsCategoriesModel::findAll(["id = '" . $model->testimonial_category . "'"])->name;
        }

        return $template->getResponse();
    }
}
