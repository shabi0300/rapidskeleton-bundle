<?php

namespace Lupcom\RapidSkeletonBundle\Controller\ContentElement;

use Contao\BackendTemplate;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\ContentModel;
use Contao\StringUtil;
use Contao\System;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(name: 'ce_rs_cards', category: 'rapidskeleton', template: 'ce_rs_cards')]
class CeRsCardsController extends AbstractContentElementController
{
    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        if (System::getContainer()->get('contao.routing.scope_matcher')->isFrontendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create(''))) {
            // FRONTEND
            $GLOBALS['TL_CSS']['ce_rs_cards_css']        = 'bundles/rapidskeleton/frontend/css/ce_rs_cards.css';

            $cards = [];
            $cards[1]['icon'] = $model->card_1_icon;
            $cards[1]['headline'] = $model->card_1_headline;
            $cards[1]['text'] = $model->card_1_text;
            $cards[1]['button_label'] = $model->card_1_button_label;
            $cards[1]['button_target'] = $model->card_1_button_target;
            $cards[1]['button_type'] = $model->card_1_button_type;
            $cards[1]['button_link'] = $model->card_1_button_link;
            $cards[2]['icon'] = $model->card_2_icon;
            $cards[2]['headline'] = $model->card_2_headline;
            $cards[2]['text'] = $model->card_2_text;
            $cards[2]['button_label'] = $model->card_2_button_label;
            $cards[2]['button_target'] = $model->card_2_button_target;
            $cards[2]['button_type'] = $model->card_2_button_type;
            $cards[2]['button_link'] = $model->card_2_button_link;
            $cards[3]['icon'] = $model->card_3_icon;
            $cards[3]['headline'] = $model->card_3_headline;
            $cards[3]['text'] = $model->card_3_text;
            $cards[3]['button_label'] = $model->card_3_button_label;
            $cards[3]['button_target'] = $model->card_3_button_target;
            $cards[3]['button_type'] = $model->card_3_button_type;
            $cards[3]['button_link'] = $model->card_3_button_link;
            $cards[4]['icon'] = $model->card_4_icon;
            $cards[4]['headline'] = $model->card_4_headline;
            $cards[4]['text'] = $model->card_4_text;
            $cards[4]['button_label'] = $model->card_4_button_label;
            $cards[4]['button_target'] = $model->card_4_button_target;
            $cards[4]['button_type'] = $model->card_4_button_type;
            $cards[4]['button_link'] = $model->card_4_button_link;
            $template->cards = $cards;
        } else {
            // BACKEND
            $template             = new BackendTemplate("be_wildcard");
            $template->title = StringUtil::deserialize($model->headline)['value'];
            $template->wildcard = $model->text;
        }

        return $template->getResponse();
    }
}
