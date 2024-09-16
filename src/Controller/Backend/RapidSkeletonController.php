<?php

namespace Lupcom\RapidSkeletonBundle\Controller\Backend;

use Config;
use Contao\BackendUser;
use Contao\Config as ContaoConfig;
use Contao\Input;
use Contao\System;
use Lupcom\RapidSkeletonBundle\Classes\RapidSkeletonClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Terminal42\ServiceAnnotationBundle\Annotation\ServiceTag;
use http\Client;



// /**
//  * @Route("/_figmatoscss", name=RapidSkeletonController::class, defaults={"_scope" = "backend", "_token_check" = false})
//  * @ServiceTag("controller.service_arguments")
//  */


#[Route('/_figmatoscss', name: RapidSkeletonController::class, defaults: ['_scope' => 'backend', '_token_check' => false])]

class RapidSkeletonController
{
    public function __invoke(Request $request): Response
    {
        $container = System::getContainer();
        $blnBackend = $container->get('contao.security.token_checker')->hasBackendUser();
        if ($blnBackend === false) {
            return new Response('Bad Request', Response::HTTP_BAD_REQUEST);
        }
        $path    = urldecode(Input::get('path'));

        // $response   = $this->doJSONRequest(path: $path);
        $response   = $this->doCSSRequest(path: $path);
        return new Response($response, Response::HTTP_OK);
    }
    private function doCSSRequest(string $path): string
    {
        $search_mediaQueries = [' ', '/*992-1399*//*768-991*//*0-767*/', ';/*992-1399*//*', '*//*992-1399*//*', ';/*768-991*//*', ';/*0-767*//*',];
        $replace_mediaQueries = ['', '', ';}@media(min-width:992px){/*', '*/}@media(min-width:992px){/*', ';}@media(min-width:768px){/*', ';}@media(min-width:0px){/*',];
        $search_colorMode = ['/*ColorMode*//*Light*//*color*/', '/*Dark*//*color*/', '/*Fonts*/}',];
        $replace_colorMode = ['}div:not([mode="dark"]),div:not([mode="dark"]) *{', '}div[mode="dark"],div[mode="dark"] *{', '',];
        // OPEN file
        $str = file_get_contents($path);
        // REMOVE linebreaks
        $str = str_replace(array("\r\n", "\r", "\n"), '', $str);
        // REMOVE :root{*}
        $str = preg_replace('/(:root {(.[^}]*))(})+/', '$2', $str);
        // REPLACE /*media query*/ with real media-queries
        $str = str_replace($search_mediaQueries, $replace_mediaQueries, $str) . '}';
        // REPLACE /*color modes*/ with real css-classes
        $str = str_replace($search_colorMode, $replace_colorMode, $str) . '}';
        // REMOVE /***/ 
        $str = preg_replace('/(\/\*)(.[^\*\/]*)(\*\/)/', '', $str);
        // EXTRACT media-queries and css-classes and write them in correct order to $cssContent 
        $regxMatches = [];
        $cssContent = ':root{';
        preg_match_all('/(@media\(min-width:0px\){(.[^}]*))(})+/', $str, $regxMatches['0']);
        foreach ($regxMatches['0'][0] as &$mediaQueryMatch) {
            $cssContent .= preg_replace('/(@media\(min-width:0px\){(.[^}]*))(})+/', '$2', $mediaQueryMatch);
        }
        $cssContent .= '@media(min-width:768px){';
        preg_match_all('/(@media\(min-width:768px\){(.[^}]*))(})+/', $str, $regxMatches['768']);
        foreach ($regxMatches['768'][0] as &$mediaQueryMatch) {
            $cssContent .= preg_replace('/(@media\(min-width:768px\){(.[^}]*))(})+/', '$2', $mediaQueryMatch);
        }
        $cssContent .= '}';
        $cssContent .= '@media(min-width:992px){';
        preg_match_all('/(@media\(min-width:992px\){(.[^}]*))(})+/', $str, $regxMatches['992']);
        foreach ($regxMatches['992'][0] as &$mediaQueryMatch) {
            $cssContent .= preg_replace('/(@media\(min-width:992px\){(.[^}]*))(})+/', '$2', $mediaQueryMatch);
        }
        $cssContent .= '}';
        preg_match_all('/(div:not\(\[mode\=\"dark\"\]\),div:not\(\[mode\=\"dark\"\]\) \*{(.[^}]*))(})+/', $str, $regxMatches['lightmode']);
        foreach ($regxMatches['lightmode'][0] as &$mediaQueryMatch) {
            $cssContent .= $mediaQueryMatch;
        }
        preg_match_all('/(div\[mode\=\"dark\"\],div\[mode\=\"dark\"\] \*{(.[^}]*))(})+/', $str, $regxMatches['darkmode']);
        foreach ($regxMatches['darkmode'][0] as &$mediaQueryMatch) {
            $cssContent .= $mediaQueryMatch;
        }
        // WRITE the new css-file
        file_put_contents('files/tpl/scss/_rapidskeleton_variables.scss', $cssContent);
        $arrReturn = [
            "content" =>  $str,
        ];
        $strReturn = json_encode($arrReturn);
        return $strReturn;
    }
}
