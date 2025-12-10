<?php

namespace Antlion\ElementAccordion\Elements;

use DNADesign\Elemental\Models\BaseElement;
use Antlion\ElementAccordion\Models\AccordionPanel;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use App\Schema\SchemaProvider;
use SilverStripe\Forms\CheckboxField;

/**
 * @property string $Content
 *
 * @method \SilverStripe\ORM\HasManyList Panels()
 */
class ElementAccordion extends BaseElement implements SchemaProvider

{
   
    private static $icon = 'font-icon-block-accordion';
    private static $table_name = 'ElementAccordion';

    private static $db = [
        'Content' => 'HTMLText',
        'EnableFAQSchema' => 'Boolean',
    ];

    private static $has_many = array(
        'Panels' => AccordionPanel::class,
    );

    private static $owns = [
        'Panels',
    ];

    private static $inline_editable = false;

    /**
     * @param bool $includerelations
     * @return array
     */
    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);

        $labels['Content'] = _t(__CLASS__.'.ContentLabel', 'Intro');
        $labels['Panels'] = _t(__CLASS__ . '.PanelsLabel', 'Panels');

        return $labels;
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {
            /* @var FieldList $fields */
            $fields->removeByName(array(
                'Sort',
            ));

            $fields->dataFieldByName('Content')
                ->setDescription(_t(
                    __CLASS__.'.ContentDescription',
                    'optional. Add introductory copy to your accordion.'
                ))
                ->setRows(5);
            
            if ($this->ID) {
                /** @var GridField $panels */
                $panels = $fields->dataFieldByName('Panels');
                $panels->setTitle($this->fieldLabel('Panels'));

                $fields->removeByName('Panels');

                $config = $panels->getConfig();
                $config->addComponent(new GridFieldOrderableRows('Sort'));
                $config->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
                $config->removeComponentsByType(GridFieldDeleteAction::class);

                $fields->addFieldToTab('Root.Main', $panels);
            }
        });

        return parent::getCMSFields();
    }

    /**
     * @return DBHTMLText
     */
    public function getSummary()
    {
        $count = $this->Panels()->count();
        $label = _t(
            AccordionPanel::class . '.PLURALS',
            '{count} Accordion Panel|{count} Accordion Panels',
            [ 'count' => $count ]
        );
        return DBField::create_field('HTMLText', $label)->Summary(20);
    }

    /**
     * @return array
     */
    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        $blockSchema['content'] = $this->getSummary();
        return $blockSchema;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return _t(__CLASS__.'.BlockType', 'Accordion');
    }

    public function provideSchema(): array
    {
       if (!$this->EnableFAQSchema) return [];

        $out = [];
        $pageURL = $this->getPage()?->AbsoluteLink();
        if (!$pageURL) {
            return $out;
        }

        // preserve author order if you have a Sort field on panels
        $panels = $this->Panels()->sort('Sort');
        foreach ($panels as $panel) {
            $q = trim((string) $panel->Title);
            $a = trim($panel->dbObject('Content')->Plain());
            if ($q === '' || $a === '') continue;

            $out[] = [
                '@type' => 'Question',
                '@id'   => rtrim($pageURL, '/') . '/#q-' . $this->ID . '-' . $panel->ID,
                'name'  => $q,
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $a],
            ];
        }

        return $out;
    }
}
