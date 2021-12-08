<?php

namespace Sunnysideup\ElementalEditMeButton\Extensions;

use DNADesign\Elemental\Extensions\ElementalPageExtension;
use SilverStripe\Core\Convert;
use SilverStripe\Core\Extension;
use SilverStripe\View\Requirements;

class AddCanEditButton extends Extension
{
    public function onAfterInit()
    {
        if ($this->owner->dataRecord->hasExtension(ElementalPageExtension::class)) {
            $elementArea = $this->owner->ElementalArea();
            $elements = $elementArea->Elements();
            $element = $elements->first();
            $elementIds = [];
            //we assume that if you can edit one, you can edit all ...
            if ($element && $element->canEdit()) {
                $elementIds = $elements->column('ID');
                if (count($elementIds) > 0) {
                    $js = $this->getButton();
                    Requirements::customScript(
                        'let ElementalEditMeButtonIds = ' . Convert::array2json($elementIds) . ';
                        ' . $js,
                        'ElementalEditMeButton_ids'
                    );
                }
            }
        }
    }

    public function getButton(): string
    {
        return $this->owner->renderWith(AddCanEditButton::class . 'AsJs');
    }
}
