<?php

namespace Antlion\ElementAccordion\Models;

use Antlion\ElementAccordion\Elements\ElementAccordion;
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\LinkField\Models\Link;
use SilverStripe\LinkField\Form\MultiLinkField;
use SilverStripe\AssetAdmin\Forms\UploadField;

/**
 * Class AccordionPanel
 * @package App\Models
 *
 * @property int $Sort
 *
 * @property int AccordionID
 * @method ElementAccordion Accordion()
 */
class AccordionPanel extends DataObject
{
    private static $singular_name = 'accordion panel';
    private static $plural_name = 'accordion panels';
    private static $description = 'A panel for a accordion element';
    private static $table_name = 'AccordionPanel';

    private static $db = [
        'Sort' => 'Int',
        'Title' => 'Varchar(255)',
        'Content' => 'HTMLText',
    ];


    private static $has_one = [
        'Accordion' => ElementAccordion::class,
        'Image' => Image::class,
    ];
    
    private static $has_many = [
        'Links' => Link::class . '.Owner',
    ];
    // Own assets/links so they publish with the element
    private static $owns = [
        'Image',
        'Links',
    ];
   
    private static $defaults = [
        'ShowTitle' => true,
    ];

    private static $default_sort = 'Sort';

    public function getCMSFields(): FieldList
    {
        $fields = parent::getCMSFields();

        // We’ll re-add these in our preferred order
        $fields->removeByName(['AccordionID','Sort','Title','Content','Image','Links']);

        $fields->addFieldsToTab('Root.Main', [
           TextField::create('Title', 'Title')->setMaxLength(255),
           HTMLEditorField::create('Content', 'Content')->setRows(8),
            UploadField::create('Image', 'Image')
                    ->setFolderName('Uploads/Elements/Accordion')
                    ->setAllowedFileCategories('image/supported'),
            MultiLinkField::create('Links', 'Button Links'),
        ]);

        return $fields;
    }
}
