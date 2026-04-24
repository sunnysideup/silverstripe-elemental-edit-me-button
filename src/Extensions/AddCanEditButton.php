<?php

namespace Sunnysideup\ElementalEditMeButton\Extensions;

use DNADesign\Elemental\Extensions\ElementalPageExtension;
use Page;
use PageController;
use SilverStripe\Core\Extension;
use SilverStripe\Security\Permission;
use SilverStripe\Security\Security;
use SilverStripe\View\Requirements;

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
            $page = $this->getOwner()->data();
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

                    if ($elementIds !== []) {
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
