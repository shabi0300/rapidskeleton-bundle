<?php

use Contao\Backend;
use Contao\DataContainer;
use Contao\Files;
use Contao\Image;
use Contao\FilesModel;
use Contao\Input;
use Contao\StringUtil;
use Lupcom\RapidSkeletonBundle\Models\TestimonialsModel;

/**
 * Table tl_testimonials
 */
$strTable = "tl_testimonials";

$GLOBALS['TL_DCA'][$strTable] = array(
    'config' => array(
        'dataContainer' => Contao\DC_Table::class,
        'enableVersioning'    => 'true',
        'ptable'  => 'tl_testimonials_categories',
        'sql'                => array(
            'keys'        => array(
                'id'        => 'primary',
                'pid'        => "index",
            )
        ),
    ),
    'list' => [
        'sorting'        => array(
            "mode" => 4,
            'fields' => ['sorting'],
            "flag" => 11,
            "disableGrouping" => false,
            "headerFields" => "",
            "panelLayout" => "search",

            'headerFields' => array('name'),
            'panelLayout'   => 'filter;sort,search,limit'
        ),
        'label'        => array(
            'fields'    => array('customer_firstname', 'customer_familyname', 'testimonal_rating'),
            'format'    => '%s %s | %s/5',
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
            'edit'          => array(
                'label' => &$GLOBALS['TL_LANG']['tl_content']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif',
            ),
            "copy" => [
                'href'                => 'act=copy',
                'icon'                => 'copy.svg',
                'button_callback'     => array($strTable, 'copyItem')
            ],
            'delete'        => array(
                'label'    => &$GLOBALS['TL_LANG']['tl_content']['delete'],
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
                'label'    => &$GLOBALS['TL_LANG']['tl_content']['show'],
                'href'    => 'act=show',
                'icon'    => 'show.gif',
                'attributes'    => 'style="margin: 0 3px;"'
            ),
        )
    ],

    'palettes' => [
        'default' => "
            {customer_legend},customer_firstname,customer_familyname,customer_description,customer_image;
            {testimonal_legend},testimonal_headline,testimonal_description,testimonal_rating;
            {publish_legend}, published;
        "
    ],


    'fields' => [
        'id' => ['sql' => "int(10) unsigned NOT NULL auto_increment"],
        'pid' => ['sql' => "int(10) unsigned NOT NULL"],
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
        'customer_firstname' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['customer_firstname'],
            'search' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'maxlength' => 200, 'allowHtml' => false, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''"
        ],
        'customer_familyname' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['customer_familyname'],
            'search' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'maxlength' => 200, 'allowHtml' => false, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''"
        ],
        'customer_description' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['customer_description'],
            'search' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => false, 'maxlength' => 200, 'allowHtml' => false, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''"
        ],
        'customer_image' => [
            'label'                 => &$GLOBALS['TL_LANG'][$strTable]['customer_image'],
            'inputType'             => 'fileTree',
            'eval'                  => array('filesOnly' => true, 'fieldType' => 'radio', 'mandatory' => true, 'tl_class' => 'w50 widget'),
            'sql'                   => "binary(16) NULL"
        ],
        'testimonal_headline' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['testimonal_headline'],
            'search' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'maxlength' => 200, 'allowHtml' => false, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''"
        ],
        'testimonal_description' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['testimonal_description'],
            'inputType'               => 'textarea',
            'eval'                    => array('mandatory' => true, 'rte' => 'tinyMCE', "tl_class" => 'clr long'),
            'sql'                     => "mediumtext NULL"
        ],
        'testimonal_rating' => [
            'label' => &$GLOBALS['TL_LANG'][$strTable]['testimonal_rating'],
            'search' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'maxlength' => 200, 'rgxp' => 'natural', 'minval' => 1, 'maxval' => 5, 'allowHtml' => false, 'tl_class' => 'w50'],
            'sql' => "int(1) NOT NULL default 5"
        ],
    ],
);


/**
 * Class tl_testimonials
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @package Controller
 */
class tl_testimonials extends Backend
{
    private static $strTable = "tl_testimonials";

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
        return '<a href="' . $this->addToUrl($href . '&amp;id=' . $row['id']) . '" name="' . StringUtil::specialchars($title) . '"' . $attributes . '>' . Contao\Image::getHtml($icon, $label) . '</a> ';
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
        $tid = Input::get('tid') ?? null;
        $state = Input::get('state') ?? 0;

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
        $image = Image::getHtml($icon, $label);
        $name = StringUtil::specialchars($name);

        return "<a href='{$href}' $attributes name='{$name}'>$image</a>";
    }

    public function updateVisibility(int $intId, bool $blnVisible)
    {
        $time = time();
        $blnVisible = $blnVisible ? 0 : 1;

        $this->Database->prepare("UPDATE {$this::$strTable} SET tstamp=?, published=? WHERE id=?")
            ->execute($time, $blnVisible, $intId);
    }
    /**
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

    // public function sortingUp($row, $href, $label, $title, $icon, $attributes)
    // {
    //     if ($this->Input->get('sortId') and $this->Input->get('sorting') == "up") {
    //         $thisId = $this->Input->get('sortId');
    //         $dbObj = $this->Database->prepare("SELECT * FROM tl_press ORDER BY sorting ASC")->execute();

    //         if ($dbObj->numRows == NULL)
    //             return false;

    //         $allData = $dbObj->fetchAllAssoc();
    //         foreach ($allData as $key => $data) {
    //             if ($data['id'] == $thisId) {
    //                 $temp = $data;
    //                 $newPosition = $key - 1;
    //                 unset($allData[$key]);
    //             }
    //         }

    //         if ($newPosition < 0)
    //             $newPosition = 0;

    //         if ($newPosition > count($allData))
    //             $newPosition = count($allData);

    //         $newPosition = intval($newPosition);

    //         $allData = array_values($allData);

    //         $newSorting = array();
    //         $counter = 0;
    //         foreach ($allData as $key => $data) {
    //             if ($key == $newPosition) {
    //                 $this->Database->prepare("UPDATE tl_press SET sorting=? WHERE id=?")->execute($counter, $temp['id']);
    //                 $counter++;
    //             }

    //             $this->Database->prepare("UPDATE tl_press SET sorting=? WHERE id=?")->execute($counter, $data['id']);

    //             $counter++;
    //         }

    //         $this->redirect($this->getReferer());
    //     }

    //     $dbObj = $this->Database->prepare("SELECT * FROM tl_press ORDER BY sorting ASC")->execute();
    //     $anzObj = $dbObj->numRows;
    //     if ($anzObj != NULL) {
    //         $counter = 0;
    //         while ($dbObj->next()) {
    //             if ($dbObj->id == $row['id']) {
    //                 if ($counter == 0) {
    //                     return '<span>' . $this->generateImage('demagnify.gif', $label) . '</span> ';
    //                 } else {
    //                     $href .= '&amp;sortId=' . $row['id'] . '&amp;sortValue=' . $row['sorting'];
    //                     return '<a href="' . $this->addToUrl($href) . '" title="' . specialchars($title) . '"' . $attributes . '>' . $this->generateImage($icon, $label) . '</a> ';
    //                 }
    //             }
    //             $counter++;
    //         }
    //     }
    // }

    // public function sortingDown($row, $href, $label, $title, $icon, $attributes)
    // {
    //     if ($this->Input->get('sortId') and $this->Input->get('sorting') == "down") {
    //         $thisId = $this->Input->get('sortId');
    //         $dbObj = $this->Database->prepare("SELECT * FROM tl_press ORDER BY sorting ASC")->execute();

    //         if ($dbObj->numRows == NULL)
    //             return false;

    //         $allData = $dbObj->fetchAllAssoc();

    //         foreach ($allData as $key => $data) {
    //             if ($data['id'] == $thisId) {
    //                 $temp = $data;
    //                 $newPosition = $key + 1;
    //                 unset($allData[$key]);
    //             }
    //         }

    //         if ($newPosition < 0)
    //             $newPosition = 0;

    //         if ($newPosition > count($allData))
    //             $newPosition = count($allData);

    //         $newPosition = intval($newPosition);

    //         $allData = array_values($allData);

    //         $newSorting = array();
    //         $counter = 0;
    //         foreach ($allData as $key => $data) {
    //             if ($key == $newPosition) {
    //                 $this->Database->prepare("UPDATE tl_press SET sorting=? WHERE id=?")->execute($counter, $temp['id']);
    //                 $counter++;
    //             }

    //             $this->Database->prepare("UPDATE tl_press SET sorting=? WHERE id=?")->execute($counter, $data['id']);

    //             $counter++;
    //         }

    //         $this->redirect($this->getReferer());
    //     }
    //     $dbObj = $this->Database->prepare("SELECT * FROM tl_press ORDER BY sorting ASC")->execute();
    //     $anzObj = $dbObj->numRows;

    //     if ($anzObj != NULL) {
    //         $counter = 0;
    //         while ($dbObj->next()) {
    //             if ($dbObj->id == $row['id']) {
    //                 if ($counter == $anzObj - 1) {
    //                     /* Last */
    //                     return '<span>' . $this->generateImage('demagnify.gif', $label) . '</span> ';
    //                 } else {
    //                     $href .= '&amp;sortId=' . $row['id'] . '&amp;sortValue=' . $row['sorting'];
    //                     return '<a href="' . $this->addToUrl($href) . '" title="' . specialchars($title) . '"' . $attributes . '>' . $this->generateImage($icon, $label) . '</a> ';
    //                 }
    //             }
    //             $counter++;
    //         }
    //     }
    // }
}
