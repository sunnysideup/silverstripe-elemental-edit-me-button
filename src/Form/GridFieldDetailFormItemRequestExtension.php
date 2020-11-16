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
            $actions->push(
                LiteralField::create(
                    'EditMeButton',
                    '<div class="btn action preview-element-action btn btn-primary">
                        <a href="'.$this->owner->record->PreviewLink().'" style="color: white;">Preview</a>
                    </div>'
                )
            );
        }
    }
}
