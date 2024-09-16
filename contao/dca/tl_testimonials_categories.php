<?php

use Contao\Backend;
use Contao\StringUtil;

/**
 * Table tl_testimonials_categories
 */
$strTable = "tl_testimonials_categories";

$GLOBALS['TL_DCA'][$strTable] = array(
    'config'        => array(
        'dataContainer' => Contao\DC_Table::class,
        'ctable'  => array('tl_testimonials'),
        'enableVersioning'  => 'true',
        'sql'               => array(
            'keys'      => array(
                'id'        => 'primary'
            )
        ),
    ),
    'list' => [
        'sorting'        => array(
            "mode" => 0,
            'fields' => ['sorting'],
            "flag" => 0,
            "disableGrouping" => false,
            "headerFields" => "",
            "panelLayout" => "search",
            'fields'    => array('name'),
            'panelLayout'   => 'filter;sort,search,limit'
        ),
        'label'        => array(
            'fields'    => array('name'),
            'format'    => '%s',
        ),
        'global_operations' => array(
            'all'        => array(
                'label'        => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'        => 'act=select',
                'class'     => 'header_edit_all',
                'attributes'    => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array(
            'edit'      => array(
                'label' => &$GLOBALS['TL_LANG'][$strTable]['edit'],
                'href'  => 'table=tl_testimonials',
                'icon'  => 'edit.gif',
            ),
            'editheader' => array(
                'label'               => &$GLOBALS['TL_LANG'][$strTable]['editheader'],
                'href'                => 'act=edit',
                'icon'                => 'header.gif',
            ),
            "copy" => array(
                'label'               => &$GLOBALS['TL_LANG'][$strTable]['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.svg',
                'button_callback'     => array($strTable, 'copyItem')
            ),
            'delete'        => array(
                'label'    => &$GLOBALS['TL_LANG'][$strTable]['delete'],
                'href'    => 'act=delete',
                'icon'    => 'delete.gif',
                'attributes'    => 'onclick="if(!confirm(\'' . "Wirklich löschen?" . '\'))return false;Backend.getScrollOffset()"'
            ),
            'toggle' => array(
                'icon'                => 'visible.svg',
                'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback'     => array($strTable, 'toggleIcon'),
                "attributes"          => "style='margin-right: 3px;'"
            ),
            'show'        => array(
                'label'    => &$GLOBALS['TL_LANG'][$strTable]['show'],
                'href'    => 'act=show',
                'icon'    => 'show.gif',
                'attributes'    => 'style="margin: 0 3px;"'
            ),
        )
    ],

    'palettes' => [
        'default' => "
            {detail_legend},name;
            {publish_legend},published;
        "
    ],


    'fields' => [
        'id' => ['sql' => "int(10) unsigned NOT NULL auto_increment"],
        'sorting' => ['sql' => "int(10) unsigned NOT NULL default '0'"],
        'tstamp' => ['sql' => "int(10) unsigned NOT NULL default '0'"],
        'published' => array(
            'label' => &$GLOBALS['TL_LANG'][$strTable]['published'],
            'filter' => true,
            'flag' => 2,
            'inputType' => 'checkbox',
            'eval' => array('doNotCopy' => true, 'tl_class' => 'w50'),
            'sql' => "char(1) NOT NULL default 0"
        ),
        'name' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['name'],
            'search' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'maxlength' => 200, 'allowHtml' => false, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''"
        ],
    ]
);

/**
 * Class tl_testimonials_categories
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @package Controller
 */
class tl_testimonials_categories extends \Contao\Backend
{
    private static $strTable = "tl_testimonials_categories";

    /**
     * Return the copy category button
     *
     * @param array  $row
     * @param string $href
     * @param string $label
     * @param string $title
     * @param string $icon
     * @param string $attributes
     *
     * @return string
     */
    public function copyItem($row, $href, $label, $title, $icon, $attributes)
    {
        return '<a href="' . $this->addToUrl($href . '&amp;id=' . $row['id']) . '" name="' . Contao\StringUtil::specialchars($title) . '"' . $attributes . '>' . Contao\Image::getHtml($icon, $label) . '</a> ';
    }

    /**
     * Return the "toggle visibility" button
     *
     * @param array  $row
     * @param string $href
     * @param string $label
     * @param string $title
     * @param string $icon
     * @param string $attributes
     *
     * @return string
     */
    public function toggleIcon($row, $href, $label, $name, $icon, $attributes)
    {
        $tid = Contao\Input::get('tid') ?? null;
        $state = Contao\Input::get('state') ?? 0;

        // Read GET-Parameters
        if (isset($tid)) {
            $this->updateVisibility($tid, $state);
            $this->redirect($this->getReferer()); //--> navigate back to overview
        }

        if (!$row['published']) {
            $icon = 'invisible.svg';
        }

        // Set GET-Parameters
        $href .= '&amp;tid=' . $row['id'] . '&amp;state=' . $row['published'];

        $href = $this->addToUrl($href);
        $image = \Contao\Image::getHtml($icon, $label);
        $name = \Contao\StringUtil::specialchars($name);

        return "<a href='{$href}' $attributes name='{$name}'>$image</a>";
    }

    public function updateVisibility(int $intId, bool $blnVisible)
    {
        $time = time();
        $blnVisible = $blnVisible ? 0 : 1;
        // dd("UPDATE {$this::$strTable} SET tstamp=?, published=? WHERE id=?");
        $this->Database->prepare("UPDATE {$this::$strTable} SET tstamp=?, published=? WHERE id=?")
            ->execute($time, $blnVisible, $intId);
    }
}
