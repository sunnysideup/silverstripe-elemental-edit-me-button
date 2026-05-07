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
            $link = null;
            /** @var GridFieldDetailForm_ItemRequest $owner */
            $owner = $this->getOwner();
            /** @var BaseElement $obj */
            $obj = $owner->record;
            if (is_subclass_of($obj, BaseElement::class, true)) {
                $previewLinkLive = $obj->PreviewLink();
                $page = $obj->getPage();
                if ($page && $page instanceof SiteTree) {
                    $link = $page->getCMSEditLink();
                    $random = rand(100000, 999999);
                    $actions->push(
                        LiteralField::create(
                            'BackToPage',
                            '<a href="' . $link . '" class="btn action back-to-page-action btn-outline-primary" id="back-to-page-action-' . $random . '">
                                <span style="color: var(--bs-btn-color);">Back to Page</span>
                            </a>
                            <style>
                                #back-to-page-action-' . $random . ':hover span {
                                    color: #fff !important;
                                }
                                .btn.action.preview-element-action.btn-primary:hover,
                                .btn.action.preview-element-action.btn-primary:hover a {
                                    text-decoration: none!important;
                                }

                            </style>'
                        )
                    );
                }

                if ($obj->isPublished()) {
                    $actions->push(
                        LiteralField::create(
                            'PreviewLive',
                            '<div class="btn action preview-element-action btn-primary">
                                <a href="' . $previewLinkLive . '" style="color: white;">View Published Version</a>
                            </div>'
                        )
                    );
                }

                if (! strpos((string) $previewLinkLive, '?')) {
                    $previewLinkLive .= '?';
                }

                $previewLinkDraft = str_replace('?', '?stage=Stage&', $previewLinkLive);

                if ($link) {

                    $link = str_replace('?', '?stage=Stage&', $link);
                    $actions->push(
                        LiteralField::create(
                            'PreviewDraftVersion',
                            '<div class="btn action preview-element-action btn btn-primary">
                                <a href="' . $previewLinkDraft . '" style="color: white;">Preview Draft</a>
                            </div>'
                        )
                    );
                }
            }
        }
    }
}
