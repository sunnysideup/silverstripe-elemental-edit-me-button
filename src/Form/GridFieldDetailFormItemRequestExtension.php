<?php

namespace Sunnysideup\ElementalEditMeButton\Form;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldDetailForm_ItemRequest;
use SilverStripe\Forms\LiteralField;

/**
 * Class \Sunnysideup\ElementalEditMeButton\Form\GridFieldDetailFormItemRequestExtension
 *
 * @property GridFieldDetailForm_ItemRequest|GridFieldDetailFormItemRequestExtension $owner
 */
class GridFieldDetailFormItemRequestExtension extends Extension
{
    public function updateFormActions(FieldList $actions)
    {
        if ($this->getOwner()->record->exists()) {
            /** @var GridFieldDetailForm_ItemRequest $owner */
            $owner = $this->owner;
            /** @var BaseElement $obj */
            $obj = $owner->record;
            if (is_subclass_of($obj, BaseElement::class, true)) {
                $previewLink = $obj->PreviewLink();
                $page = $obj->getPage();
                if ($page && $page instanceof SiteTree) {
                    $link = $page->CMSEditLink();
                    $actions->push(
                        LiteralField::create(
                            'BackToPage',
                            '<a href="' . $link . '" class="btn action back-to-page-action btn-outline-primary">
                                <span style="color: #317c33">Back to Page</span>
                            </a>'
                        )
                    );
                }
                if ($obj->isPublished()) {
                    $actions->push(
                        LiteralField::create(
                            'PreviewLive',
                            '<div class="btn action preview-element-action btn-primary">
                                <a href="' . $previewLink . '" style="color: white;">View Live Version</a>
                            </div>'
                        )
                    );
                }
                if (!strpos((string) $previewLink, '?')) {
                    $previewLink .= '?';
                }
                $previewLink = str_replace('?', '?stage=Stage&', $previewLink);
                $actions->push(
                    LiteralField::create(
                        'PreviewDraftVersion',
                        '<div class="btn action preview-element-action btn btn-primary">
                            <a href="' . $previewLink . '" style="color: white;">Preview Draft</a>
                        </div>'
                    )
                );
            }
        }
    }
}
