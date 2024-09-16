<?php

use Contao\Backend;
use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\Database;
use Contao\DataContainer;
use Contao\Input;
use Contao\System;

$strName = 'tl_content';

$GLOBALS['TL_DCA'][$strName]['palettes']['__selector__'][] = 'addButton';

$GLOBALS['TL_DCA'][$strName]['palettes']['rapidskeleton']       = '{rapidskeleton_legend};{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA'][$strName]['palettes']['ce_rs_text']          = '{type_legend},type,headline;{text_legend},text;{button_legend},addButton;{layout_legend},mirror,layout_style,full_width,v_center,center_text,dark_mode;{protected_legend:hide},protected;{expert_legend:hide},cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA'][$strName]['palettes']['ce_rs_text_image']    = '{type_legend},type,headline;{text_image_legend},side_text,side_image;{button_legend},addButton;{layout_legend},mirror,full_width,v_center,center_text,dark_mode;{protected_legend:hide},protected;{expert_legend:hide},cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA'][$strName]['palettes']['ce_rs_cards']         = '{type_legend},type,headline;
                                                                    {text_legend},optional_text;
                                                                    {button_legend},addButton;
                                                                    {cards_legend},card_1_icon,card_2_icon,card_3_icon,card_4_icon,card_1_headline,card_2_headline,card_3_headline,card_4_headline,card_1_text,card_2_text,card_3_text,card_4_text,card_1_button_label,card_2_button_label,card_3_button_label,card_4_button_label,card_1_button_link,card_2_button_link,card_3_button_link,card_4_button_link,card_1_button_type,card_2_button_type,card_3_button_type,card_4_button_type,card_1_button_target,card_2_button_target,card_3_button_target,card_4_button_target;
                                                                    {layout_legend},mirror,full_width,center_text,dark_mode;
                                                                    {protected_legend:hide},protected;
                                                                    {expert_legend:hide},cssID;
                                                                    {invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA'][$strName]['palettes']['ce_rs_slider']        = '{type_legend},type,headline;{text_legend},optional_text;{button_legend},addButton;
                                                                    {source_legend},multiSRC, customImageSize;{slider_legend},slide_count_mobile,slide_count_tablet,slide_count_desktop;
                                                                    {layout_legend},full_width,center_text,dark_mode;{protected_legend:hide},protected;
                                                                    {expert_legend:hide},cssID;{invisible_legend:hide},invisible,start,stop';
                                                                    
$GLOBALS['TL_DCA'][$strName]['palettes']['ce_rs_testimonials']  = '{type_legend},type,headline;{text_legend},optional_text;{button_legend},addButton;{testimonial_legend},testimonial_category;{layout_legend},mirror,full_width,v_center,center_text,dark_mode;{protected_legend:hide},protected;{expert_legend:hide},cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA'][$strName]['palettes']['ce_rs_quickbooker']   = '{type_legend},type;{quickbooker_legend},quickbooker_style,quickbooker_url,quickbooker_target;{layout_legend},full_width,center_text,dark_mode;{protected_legend:hide},protected;{expert_legend:hide},cssID;{invisible_legend:hide},invisible,start,stop';


$GLOBALS['TL_DCA'][$strName]['subpalettes']['addButton']        = 'button_label,button_link,button_type,button_target';

$GLOBALS['TL_DCA'][$strName]['fields']['optional_text'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['optional_text'],
    'search'                => true,
    'inputType'             => 'textarea',
    'eval'                  => array('mandatory' => false, 'basicEntities' => true, 'rte' => 'tinyMCE', 'helpwizard' => true),
    'explanation'           => 'insertTags',
    'sql'                   => "mediumtext NULL"
];
$GLOBALS['TL_DCA'][$strName]['fields']['side_text'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['side_text'],
    'search'                => true,
    'inputType'             => 'textarea',
    'eval'                  => array('mandatory' => true, 'basicEntities' => true, 'rte' => 'tinyMCE', 'helpwizard' => true, 'tl_class' => 'clr w50 widget'),
    'explanation'           => 'insertTags',
    'sql'                   => "mediumtext NULL"
];
$GLOBALS['TL_DCA'][$strName]['fields']['side_image'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['side_image'],
    'inputType'             => 'fileTree',
    'eval'                  => array('filesOnly' => true, 'fieldType' => 'radio', 'mandatory' => true, 'tl_class' => 'w50 widget'),
    'sql'                   => "binary(16) NULL"
];
$GLOBALS['TL_DCA'][$strName]['fields']['addButton'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['addButton'],
    'inputType'             => 'checkbox',
    'eval'                  => array('submitOnChange' => true),
    'sql'                   => array('type' => 'boolean', 'default' => false)
];
$GLOBALS['TL_DCA'][$strName]['fields']['button_label'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['button_label'],
    'search'                => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
    'sql'                   => "varchar(255) NOT NULL default ''"
];
$GLOBALS['TL_DCA'][$strName]['fields']['button_link'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['button_link'],
    'search'                => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory' => true, 'rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 2048, 'dcaPicker' => true, 'tl_class' => 'w50'),
    'sql'                   => "text NULL"
];
$GLOBALS['TL_DCA'][$strName]['fields']['button_type'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['button_type'],
    'inputType'             => 'select',
    'options'               => array('button' => 'normal', 'text-button' => 'Text-Button'),
    'eval'                  => array('mandatory' => true, 'tl_class' => 'w50 clr'),
    'sql'                   => "varchar(32) COLLATE ascii_bin NOT NULL default 'button'"
];
$GLOBALS['TL_DCA'][$strName]['fields']['button_target'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['button_target'],
    'inputType'             => 'select',
    'options'               => array('_self' => 'normal', '_blank' => 'neues Fenster'),
    'eval'                  => array('mandatory' => true, 'tl_class' => 'w50'),
    'sql'                   => "varchar(32) COLLATE ascii_bin NOT NULL default '_self'"
];
$GLOBALS['TL_DCA'][$strName]['fields']['layout_style'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['layout_style'],
    'inputType'             => 'radioTable',
    'sql'                   => "varchar(32) COLLATE ascii_bin NULL default ''",
    'input_field_callback'  => ['tl_content_rapidskeleton', 'build_radio'],
];
$GLOBALS['TL_DCA'][$strName]['fields']['full_width'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['full_width'],
    'inputType'             => 'checkbox',
    'sql'                   => array('type' => 'boolean', 'default' => false),
    'eval'                  => array('mandatory' => false, 'tl_class' => 'w50'),
];
$GLOBALS['TL_DCA'][$strName]['fields']['mirror'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['mirror'],
    'inputType'             => 'checkbox',
    'sql'                   => array('type' => 'boolean', 'default' => false),
    'eval'                  => array('mandatory' => false, 'tl_class' => 'w50'),
];
$GLOBALS['TL_DCA'][$strName]['fields']['v_center'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['v_center'],
    'inputType'             => 'checkbox',
    'sql'                   => array('type' => 'boolean', 'default' => false),
    'eval'                  => array('mandatory' => false, 'tl_class' => 'w50'),
];
$GLOBALS['TL_DCA'][$strName]['fields']['center_text'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['center_text'],
    'inputType'             => 'checkbox',
    'sql'                   => array('type' => 'boolean', 'default' => false),
    'eval'                  => array('mandatory' => false, 'tl_class' => 'w50'),
];
$GLOBALS['TL_DCA'][$strName]['fields']['dark_mode'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['dark_mode'],
    'inputType'             => 'checkbox',
    'sql'                   => array('type' => 'boolean', 'default' => false),
    'eval'                  => array('mandatory' => false, 'tl_class' => 'w50'),
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_1_icon'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_1_icon'],
    'inputType'             => 'fileTree',
    'eval'                  => array('filesOnly' => true, 'fieldType' => 'radio', 'tl_class' => 'clr w25 widget'),
    'sql'                   => "binary(16) NULL"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_2_icon'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_2_icon'],
    'inputType'             => 'fileTree',
    'eval'                  => array('filesOnly' => true, 'fieldType' => 'radio', 'tl_class' => 'w25 widget'),
    'sql'                   => "binary(16) NULL"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_3_icon'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_3_icon'],
    'inputType'             => 'fileTree',
    'eval'                  => array('filesOnly' => true, 'fieldType' => 'radio', 'tl_class' => 'w25 widget'),
    'sql'                   => "binary(16) NULL"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_4_icon'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_4_icon'],
    'inputType'             => 'fileTree',
    'eval'                  => array('filesOnly' => true, 'fieldType' => 'radio', 'tl_class' => 'w25 widget'),
    'sql'                   => "binary(16) NULL"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_1_headline'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_1_headline'],
    'search'                => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory' => false, 'maxlength' => 255, 'tl_class' => 'clr w25'),
    'sql'                   => "varchar(255) NOT NULL default ''"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_2_headline'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_2_headline'],
    'search'                => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w25'),
    'sql'                   => "varchar(255) NOT NULL default ''"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_3_headline'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_3_headline'],
    'search'                => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w25'),
    'sql'                   => "varchar(255) NOT NULL default ''"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_4_headline'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_4_headline'],
    'search'                => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w25'),
    'sql'                   => "varchar(255) NOT NULL default ''"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_1_text'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_1_text'],
    'search'                => true,
    'inputType'             => 'textarea',
    'eval'                  => array('mandatory' => false, 'basicEntities' => true, 'rte' => 'tinyMCE', 'helpwizard' => true, 'tl_class' => 'clr w25 widget'),
    'explanation'           => 'insertTags',
    'sql'                   => "mediumtext NULL"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_2_text'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_2_text'],
    'search'                => true,
    'inputType'             => 'textarea',
    'eval'                  => array('mandatory' => false, 'basicEntities' => true, 'rte' => 'tinyMCE', 'helpwizard' => true, 'tl_class' => 'w25 widget'),
    'explanation'           => 'insertTags',
    'sql'                   => "mediumtext NULL"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_3_text'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_3_text'],
    'search'                => true,
    'inputType'             => 'textarea',
    'eval'                  => array('mandatory' => false, 'basicEntities' => true, 'rte' => 'tinyMCE', 'helpwizard' => true, 'tl_class' => 'w25 widget'),
    'explanation'           => 'insertTags',
    'sql'                   => "mediumtext NULL"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_4_text'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_4_text'],
    'search'                => true,
    'inputType'             => 'textarea',
    'eval'                  => array('mandatory' => false, 'basicEntities' => true, 'rte' => 'tinyMCE', 'helpwizard' => true, 'tl_class' => 'w25 widget'),
    'explanation'           => 'insertTags',
    'sql'                   => "mediumtext NULL"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_1_button_label'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_1_button_label'],
    'search'                => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory' => false, 'maxlength' => 255, 'tl_class' => 'clr w25'),
    'sql'                   => "varchar(255) NOT NULL default ''"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_2_button_label'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_2_button_label'],
    'search'                => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w25'),
    'sql'                   => "varchar(255) NOT NULL default ''"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_3_button_label'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_3_button_label'],
    'search'                => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w25'),
    'sql'                   => "varchar(255) NOT NULL default ''"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_4_button_label'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_4_button_label'],
    'search'                => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w25'),
    'sql'                   => "varchar(255) NOT NULL default ''"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_1_button_link'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_1_button_link'],
    'search'                => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory' => false, 'rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 2048, 'dcaPicker' => true, 'tl_class' => 'clr w25'),
    'sql'                   => "text NULL"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_2_button_link'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_2_button_link'],
    'search'                => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory' => false, 'rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 2048, 'dcaPicker' => true, 'tl_class' => 'w25'),
    'sql'                   => "text NULL"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_3_button_link'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_3_button_link'],
    'search'                => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory' => false, 'rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 2048, 'dcaPicker' => true, 'tl_class' => 'w25'),
    'sql'                   => "text NULL"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_4_button_link'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_4_button_link'],
    'search'                => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory' => false, 'rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 2048, 'dcaPicker' => true, 'tl_class' => 'w25'),
    'sql'                   => "text NULL"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_1_button_type'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_1_button_type'],
    'inputType'             => 'select',
    'options'               => array('button' => 'normal', 'text-button' => 'Text-Button'),
    'eval'                  => array('mandatory' => false, 'tl_class' => 'clr w25'),
    'sql'                   => "varchar(32) COLLATE ascii_bin NOT NULL default 'button'"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_2_button_type'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_2_button_type'],
    'inputType'             => 'select',
    'options'               => array('button' => 'normal', 'text-button' => 'Text-Button'),
    'eval'                  => array('mandatory' => false, 'tl_class' => 'w25'),
    'sql'                   => "varchar(32) COLLATE ascii_bin NOT NULL default 'button'"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_3_button_type'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_3_button_type'],
    'inputType'             => 'select',
    'options'               => array('button' => 'normal', 'text-button' => 'Text-Button'),
    'eval'                  => array('mandatory' => false, 'tl_class' => 'w25'),
    'sql'                   => "varchar(32) COLLATE ascii_bin NOT NULL default 'button'"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_4_button_type'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_4_button_type'],
    'inputType'             => 'select',
    'options'               => array('button' => 'normal', 'text-button' => 'Text-Button'),
    'eval'                  => array('mandatory' => false, 'tl_class' => 'w25'),
    'sql'                   => "varchar(32) COLLATE ascii_bin NOT NULL default 'button'"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_1_button_target'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_1_button_target'],
    'inputType'             => 'select',
    'options'               => array('_self' => 'normal', '_blank' => 'neues Fenster'),
    'eval'                  => array('mandatory' => false, 'tl_class' => 'clr w25'),
    'sql'                   => "varchar(32) COLLATE ascii_bin NOT NULL default '_self'"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_2_button_target'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_2_button_target'],
    'inputType'             => 'select',
    'options'               => array('_self' => 'normal', '_blank' => 'neues Fenster'),
    'eval'                  => array('mandatory' => false, 'tl_class' => 'w25'),
    'sql'                   => "varchar(32) COLLATE ascii_bin NOT NULL default '_self'"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_3_button_target'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_3_button_target'],
    'inputType'             => 'select',
    'options'               => array('_self' => 'normal', '_blank' => 'neues Fenster'),
    'eval'                  => array('mandatory' => false, 'tl_class' => 'w25'),
    'sql'                   => "varchar(32) COLLATE ascii_bin NOT NULL default '_self'"
];
$GLOBALS['TL_DCA'][$strName]['fields']['card_4_button_target'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['card_4_button_target'],
    'inputType'             => 'select',
    'options'               => array('_self' => 'normal', '_blank' => 'neues Fenster'),
    'eval'                  => array('mandatory' => false, 'tl_class' => 'w25'),
    'sql'                   => "varchar(32) COLLATE ascii_bin NOT NULL default '_self'"
];
$GLOBALS['TL_DCA'][$strName]['fields']['slide_count_mobile'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['slide_count_mobile'],
    'search'                => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory' => true, 'maxlength' => 1, 'minval' => 1, 'maxval' => 6, 'tl_class' => 'w50'),
    'sql'                   => "int(1) NOT NULL default 1"
];
$GLOBALS['TL_DCA'][$strName]['fields']['slide_count_tablet'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['slide_count_tablet'],
    'search'                => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory' => true, 'maxlength' => 1, 'minval' => 1, 'maxval' => 6, 'tl_class' => 'w50'),
    'sql'                   => "int(1) NOT NULL default 1"
];
$GLOBALS['TL_DCA'][$strName]['fields']['slide_count_desktop'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['slide_count_desktop'],
    'search'                => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory' => true, 'maxlength' => 1, 'minval' => 1, 'maxval' => 6, 'tl_class' => 'w50'),
    'sql'                   => "int(1) NOT NULL default 1"
];
$GLOBALS['TL_DCA'][$strName]['fields']['testimonial_category'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['testimonial_category'],
    'inputType'             => 'select',
    'options_callback'      => array('tl_content_functions', 'getTestimonialCategories'),
    'eval'                  => array('tl_class' => 'w50', 'mandatory' => true),
    'sql'                   => "varchar(128) COLLATE utf8_bin NOT NULL default 'all'"
];
$GLOBALS['TL_DCA'][$strName]['fields']['quickbooker_style'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['quickbooker_style'],
    'inputType'             => 'select',
    'options'               => array('quickbooker' => 'normal'),
    'eval'                  => array('mandatory' => true, 'tl_class' => 'clr w25'),
    'sql'                   => "varchar(32) COLLATE ascii_bin NOT NULL default 'quickbooker'"
];
$GLOBALS['TL_DCA'][$strName]['fields']['quickbooker_url'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['quickbooker_url'],
    'search'                => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory' => true, 'rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 2048, 'dcaPicker' => true, 'tl_class' => 'w50'),
    'sql'                   => "text NULL"
];
$GLOBALS['TL_DCA'][$strName]['fields']['quickbooker_target'] = [
    'label'                 => &$GLOBALS['TL_LANG'][$strName]['quickbooker_target'],
    'inputType'             => 'select',
    'options'               => array('_self' => 'normal', '_blank' => 'neues Fenster'),
    'eval'                  => array('mandatory' => true, 'tl_class' => 'w25'),
    'sql'                   => "varchar(32) COLLATE ascii_bin NOT NULL default '_self'"
];

$GLOBALS['TL_DCA'][$strName]['fields']['customImageSize'] = array
(
    'label'                   => &$GLOBALS['TL_LANG'][$strName]['customImageSize'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback'        => array('get_tl_image_size', 'getImageSizes'),
    'eval'                    => array('includeBlankOption'=>true, 'blankOptionLabel'=>'Please choose an image size', 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);



class tl_content_functions extends Backend
{

    /**
     * Returns the options for the "leadStore" field.
     *
     * @param $dc
     *
     * @return array
     */
    public function getTestimonialCategories($dc)
    {

        $arrFields = array();
        $objFields = Database::getInstance()->prepare("SELECT * FROM tl_testimonials_categories WHERE name!='' AND published='1' ORDER BY sorting ")->execute();
        $arrFields['all'] = 'Alle';
        while ($objFields->next()) {
            $arrFields[$objFields->id] = $objFields->name;
        }

        return $arrFields;
    }
}

















class tl_content_rapidskeleton extends Backend
{
    function build_radio(DataContainer $dc)
    {
        if (Input::post('FORM_SUBMIT')) {
            $value = Input::post($dc->field);
            Database::getInstance()->prepare("UPDATE tl_content SET layout_style=? WHERE id=?")->execute($value, $dc->id);
            return $value;
        } else {
            $radioWidget = '<div class="widget w50"><h3>Layout-Stil</h3><div>';
            $radioWidget .= '<table id="ctrl_layout_style" class="tl_radio_table"><tbody><tr>';
            for ($i = 1; $i <= 2; $i++) {
                $checked = ($dc->getCurrentRecord()['layout_style'] == 'layout-' . $i) ? 'checked' : '';
                $radioWidget .= '<td><input type="radio" name="layout_style" id="layout-' . $i . '" class="tl_radio" value="layout-' . $i . '" ' . $checked . ' /> <label for="layout-' . $i . '"><img src="bundles/rapidskeleton/frontend/icons/layout-' . $i . '.svg" width="100" height="50"/></label></td>';
            }
            $radioWidget .= '</tr></tbody></table>';
            $radioWidget .= '</div></div>';
            return $radioWidget;
        }
    }
};




class get_tl_image_size extends Backend {
    function getImageSizes(DataContainer $dc) {
        $db = Database::getInstance();
        $imageSizes = array();

        // Fetch image sizes from the tl_image_size table
        $result = $db->prepare("SELECT * FROM tl_image_size")->execute();

        while ($result->next()) {
            $imageSizes[$result->id] = $result->name; 
        }

        return $imageSizes;
    }
}