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
            $link = $this->owner->record->PreviewLink();
            $actions->push(
                LiteralField::create(
                    'PreviewLive',
                    '<div class="btn action preview-element-action btn btn-primary">
                        <a href="' . $link . '" style="color: white;">View Live Version</a>
                    </div>'
                )
            );
            if (! strpos($link, '?')) {
                $link .= '?';
            }
            $link = str_replace('?', '?stage=Stage&', $link);
            $actions->push(
                LiteralField::create(
                    'PreviewDraftVersion',
                    '<div class="btn action preview-element-action btn btn-primary">
                        <a href="' . $link . '" style="color: white;">Preview Draft</a>
                    </div>'
                )
            );
        }
    }
}
