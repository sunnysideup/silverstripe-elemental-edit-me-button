<?php

namespace Sunnysideup\ElementalEditMeButton\Form;

use DNADesign\Elemental\Models\BaseElement;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;

class GridFieldDetailFormItemRequestExtension extends Extension
{
    public function updateFormActions(FieldList $actions)
    {
        if (is_subclass_of($this->owner->record, BaseElement::class, true)) {
            $link = str_replace('?', '?stage=Stage&', $this->owner->record->PreviewLink());
            $actions->push(
                LiteralField::create(
                    'EditMeButton',
                    '<div class="btn action preview-element-action btn btn-primary">
                        <a href="' . $link . '" style="color: white;">Preview</a>
                    </div>'
                )
            );
        }
    }
}
