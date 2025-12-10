<?php

namespace Antlion\ElementAccordion\Extension;

use SilverStripe\Core\Extension;

class FAQSchemaExtension extends Extension
{
    public function updateSchemaGraph(array &$graph, string &$pageAbsURL): void
    {
        $questions = [];
        $rest = [];
        foreach ($graph as $node) {
            if (is_array($node) && (($node['@type'] ?? null) === 'Question')) {
                $questions[] = $node;
            } else {
                $rest[] = $node;
            }
        }
        if (count($questions) >= 2) {
            $rest[] = [
                '@type'      => 'FAQPage',
                '@id'        => rtrim($pageAbsURL, '/') . '/#faq',
                'mainEntity' => array_values($questions),
            ];
        }
        $graph = $rest;
    }
}