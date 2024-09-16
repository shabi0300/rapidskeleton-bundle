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

#[AsContentElement(name: 'ce_rs_quickbooker', category: 'rapidskeleton', template: 'ce_rs_quickbooker')]
class CeRsQuickbookerController extends AbstractContentElementController
{
    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        if (System::getContainer()->get('contao.routing.scope_matcher')->isFrontendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create(''))) {
            // FRONTEND
            $GLOBALS['TL_CSS']['ce_rs_quickbooker_css']     = 'bundles/rapidskeleton/frontend/css/ce_rs_quickbooker.css';
            // $GLOBALS['TL_CSS']['easypick']                  = 'bundles/rapidskeleton/frontend/css/easypick.min.css';
            $GLOBALS['TL_BODY']['easypick']                 = FrontendTemplate::generateScriptTag('bundles/rapidskeleton/frontend/js/easypick.min.js', false, null);
            $GLOBALS['TL_BODY']['ce_rs_quickbooker_js']     = FrontendTemplate::generateScriptTag('bundles/rapidskeleton/frontend/js/ce_rs_quickbooker.js', false, null);
        } else {
            // BACKEND
            $template           = new BackendTemplate("be_wildcard");
            $template->title    = 'Quickbooker';
        }

        return $template->getResponse();
    }
}
