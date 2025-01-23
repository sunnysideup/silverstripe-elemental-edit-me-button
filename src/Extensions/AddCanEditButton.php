<?php

namespace Sunnysideup\ElementalEditMeButton\Extensions;

use DNADesign\Elemental\Extensions\ElementalPageExtension;
use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Convert;
use SilverStripe\Core\Extension;
use SilverStripe\Security\Permission;
use SilverStripe\View\Requirements;
use Page;
use PageController;
use SilverStripe\Security\Security;

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
        $user = Security::getCurrentUser();
        if ($user && Permission::check('CMS_ACCESS_CMSMain', 'any', $user)) {
            $page = $this->owner->data();
            if ($page && $page->hasExtension(ElementalPageExtension::class)) {
                $elements = $page->ElementalArea()?->Elements();
                if ($elements && $elements->exists()) {
                    //we assume that if you can edit one, you can edit all ...
                    $elementIds = [];
                    foreach ($elements as $element) {
                        if ($element->canEdit()) {
                            $elementIds[$element->ID] = $element->getAnchor();
                        }
                    }
                    if (!empty($elementIds)) {
                        Requirements::customScript(
                            '
                                const ElementalEditMeButtonIds = ' . json_encode($elementIds) . ';
                                const ElementalEditMeButtonPageID = ' . $page->ID . ';',
                            'ElementalEditMeButton_ids'
                        );
                        Requirements::javascript('sunnysideup/elemental-edit-me-button: client/AddCanEditButton.js');
                        Requirements::css('sunnysideup/elemental-edit-me-button: client/AddCanEditButton.css');
                    }
                }
            }
        }
    }
}
