<?php

use Contao\Backend;
use Contao\DataContainer;
use Contao\Files;
use Contao\FilesModel;
use Contao\StringUtil;
use Lupcom\RapidSkeletonBundle\Models\RapidSkeletonModel;

/**
 * Table tl_rapidskeleton
 */
$strTable = "tl_rapidskeleton";

$GLOBALS['TL_DCA'][$strTable] = array(
    'config' => array(
        'dataContainer' => Contao\DC_Table::class,
        'enableVersioning' => 'true',
        'sql'                => array(
            'keys'        => array(
                'id'        => 'primary',
            )
        ),
    ),
    'list' => [
        'sorting'        => array(
            "mode" => 0,
            'fields' => ['sorting'],
            "flag" => 11,
            "disableGrouping" => true,
            "headerFields" => "",
            "panelLayout" => "search",
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
            'edit'        => array(
                'label'    => &$GLOBALS['TL_LANG']['tl_content']['edit'],
                'href'    => 'act=edit',
                'icon'    => 'edit.gif',
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
            )
        )
    ],


    'palettes' => [
        'default' => "
            {main_legend},name;
            {generate_legend},inputFile,output,button;            
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
        'inputFile'     => [
            'label'     => &$GLOBALS['TL_LANG'][$strTable]['inputFile'],
            'inputType' => 'fileTree',
            'eval'      => array('filesOnly' => true, 'fieldType' => 'radio', 'files' => true, 'mandatory' => true, 'submitOnChange' => true),
            'sql'       => "binary(16) NULL"
        ],
        'button' => [
            'input_field_callback'    => [$strTable, 'generateButton'],
        ]
    ]
);

/**
 * Class tl_rapidskeleton
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @package Controller
 */
class tl_rapidskeleton extends Backend
{
    private static $strTable = "tl_rapidskeleton";

    public function generateButton(DataContainer $dc)
    {
        $inputFile = FilesModel::findByUuid(RapidSkeletonModel::findById($dc->id)->inputFile);
        if ($inputFile) {
            $strContent = $this->generateJs($inputFile);
            $strContent  .= '
            <div class="widget">
            <h3>Konvertieren</h3>
            <div>
            <div class="tl_submit tl_text" id="convert" onclick="generateSCSSfromFigma();" style="text-align:center;">Convert!</div>
            </div>  
            <p class="tl_help tl_tip">Beim Konvertieren der Datei wird eine SCSS-Datei erzeugt, die unter files/tpl/SCSS/_rapidskeleton_variables.scss abgespeichert und in die main.scss importiert wird.</p>
            </div>  
        ';
        } else {
            $strContent = '';
        }
        return $strContent;
    }
    public function generateJs($inputFile)
    {
        return
            '<script>
                function generateSCSSfromFigma() {          
                    const fetchPromise = fetch("/_figmatoscss?path="+encodeURIComponent(\'' . $inputFile->path . '\'));         
                    fetchPromise.then(response => {
                        return response.json();
                    }).then(content => {
                        console.log(content.content);
                        document.getElementById("scss-output").value=content.content;
                    });
                }
            </script>';
    }
    /**
     * Auto-generate an article alias if it has not been set yet
     *
     * @param mixed                $varValue
     * @param Contao\DataContainer $dc
     *
     * @return string
     *
     * @throws Exception
     */
    public function generateAlias($varValue, Contao\DataContainer $dc)
    {
        $aliasExists = function (string $alias) use ($dc): bool {
            return $this->Database->prepare("SELECT id FROM " . $dc->table . "  WHERE alias=? AND id!=?")->execute($alias, $dc->id)->numRows > 0;
        };

        // Generate an alias if there is none
        if (!$varValue) {
            $varValue = Contao\System::getContainer()->get('contao.slug')->generate($dc->activeRecord->name, ['locale' => 'de'], $aliasExists, "id-");
        } elseif (preg_match('/^[1-9]\d*$/', $varValue)) {
            throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasNumeric'], $varValue));
        } elseif ($aliasExists($varValue)) {
            throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
        }

        return $varValue;
    }

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

        $this->Database->prepare("UPDATE {$this::$strTable} SET tstamp=?, published=? WHERE id=?")
            ->execute([$time, $blnVisible, $intId]);
    }
}
