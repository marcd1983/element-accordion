# ElementAccordion

Elemental Accordion block for SilverStripe.

## Install

```bash
composer require antlion/element-accordion
```

## Requirements

PHP 8.1+

SilverStripe ^5 || ^6

dnadesign/silverstripe-elemental ^5 || ^6

## What it does

Adds an Accordion Elemental block you can place on pages.

Create multiple panels, reorder them, and toggle defaults (open/closed) via the CMS.

Outputs accessible markup suitable for your frontend JS/CSS.

## Usage

Ensure your project uses Elemental on the page type(s) you want.

In the CMS, edit a page → Elements tab → Add Block → Accordion.

Add Panels, fill in titles/content, save & publish.

Template/CSS/JS are intentionally minimal—style or enhance as needed in your theme.

## Templating (optional)

Override the default templates in your project theme by copying and editing:

templates/Antlion/ElementAccordion/Elements/ElementAccordion.ss

templates/Antlion/ElementAccordion/Includes/AccordionPanel.ss

Flush after changing templates by appending ?flush=all to a site URL, e.g.:

`https://yoursite.test/?flush=all`
