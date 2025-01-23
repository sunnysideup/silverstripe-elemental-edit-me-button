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
            if ($elements && $elements->exists()) {
                //we assume that if you can edit one, you can edit all ...
                $elementIds = [];
                foreach ($elements as $element) {
                    if ($element->canEdit()) {
                        $elementIds[] = $element->getAnchor();
                    }
                }
                if (count($elementIds) > 0) {
                    $js = $this->getButton();
                    Requirements::customScript(
                        'const ElementalEditMeButtonIds = ' . json_encode(array_unique($elementIds)) . ';
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
