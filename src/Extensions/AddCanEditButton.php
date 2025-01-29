<?php

namespace Sunnysideup\ElementalEditMeButton\Extensions;

use DNADesign\Elemental\Extensions\ElementalPageExtension;
use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Convert;
use SilverStripe\Core\Extension;
use SilverStripe\View\Requirements;
use Page;
use PageController;

/**
 * Class \Sunnysideup\ElementalEditMeButton\Extensions\AddCanEditButton
 *
 * @property PageController|AddCanEditButton $owner
 */
class AddCanEditButton extends Extension
{
    public function onAfterInit()
    {
        /** @var Page $page */
        $page = $this->owner->data();
        if ($page && $page->hasExtension(ElementalPageExtension::class)) {
            $elements = $page->ElementalArea()?->Elements();
            if ($elements->exists()) {
                //we assume that if you can edit one, you can edit all ...
                $elementIds = [];
                foreach ($elements as $element) {
                    if ($element->canEdit()) {
                        $elementIds[$element->ID] = $element->getAnchor();
                    }
                }
                if (count($elementIds) > 0) {
                    $js = $this->getButton();
                    Requirements::customScript(
                        'const ElementalEditMeButtonIds = ' . json_encode($elementIds) . ';
                        ' . $js,
                        'ElementalEditMeButton_ids'
                    );
                    Requirements::customCSS(
                        '

                        .edit-me-button {
                            transition: all 0.3s;
                            z-index: 999;
                            position: absolute;
                            top: 10px;
                            right: 10px;
                            background-color: #f3f4ee;
                            height: 45px;
                            width: 45px;
                            border-radius: 50px;
                            border: 1px solid #ccc;
                            -webkit-transform: rotateY(180deg);
                            transform: rotateY(180deg);
                        }
                        .edit-me-button a {
                            display: block;
                            text-decoration: none;
                            width: 100%;
                            height: 100%;
                            text-decoration: none;
                            border-bottom: none;
                        }
                        .edit-me-button a span {
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            -webkit-transform: translate(-50%,-50%);
                            transform: translate(-50%,-50%);
                            -ms-transform: translate(-50%,-50%);
                            color: #333;
                        }
                        .edit-me-button a:hover span {
                            color: green!important;
                        }
                        .edit-me-button.hovered {
                            z-index: 9999;
                        }

                        ',
                        'ElementalEditMeButton_css'
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
