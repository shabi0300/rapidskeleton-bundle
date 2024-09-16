<?php

namespace Lupcom\RapidSkeletonBundle\Controller\ContentElement;

use Contao\BackendTemplate;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\ContentModel;
use Contao\FrontendTemplate;
use Contao\StringUtil;
use Contao\System;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(name: 'ce_rs_slider', category: 'rapidskeleton', template: 'ce_rs_slider')]
class CeRsSliderController extends AbstractContentElementController
{
    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        if (System::getContainer()->get('contao.routing.scope_matcher')->isFrontendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create(''))) {
            // FRONTEND
            $GLOBALS['TL_CSS']['ce_rs_slider_css']  = 'bundles/rapidskeleton/frontend/css/ce_rs_slider.css';
            // $GLOBALS['TL_BODY']['ce_rs_slider_js']    = 'bundles/rapidskeleton/frontend/js/ce_rs_slider.js';
            $GLOBALS['TL_BODY']['ce_rs_slider_js']    = FrontendTemplate::generateScriptTag('bundles/rapidskeleton/frontend/js/ce_rs_slider.js', false, null);
            $template->multiSRC = StringUtil::deserialize($model->multiSRC);
        } else {
            // BACKEND
            $template             = new BackendTemplate("be_wildcard");
            $template->title = StringUtil::deserialize($model->headline)['value'];
            $template->wildcard = $model->text;
        }

        return $template->getResponse();
    }
}
