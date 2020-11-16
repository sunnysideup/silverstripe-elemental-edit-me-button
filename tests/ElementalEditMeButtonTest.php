<?php

namespace SunnysideUp\ElementalEditMeButton;

use SilverStripe\Dev\SapphireTest;

class ElementalEditMeButtonTest extends SapphireTest
{
    /**
     * @var boolean
     */
    protected $usesDatabase = false;

    /**
     * @var array
     */
    protected $requiredExtensions = [];

    /**
     * Test the dev build
     */
    public function TestDevBuild()
    {
        $exitStatus = shell_exec('php framework/cli-script.php dev/build flush=all  > dev/null; echo $?');
        $exitStatus = intval(trim($exitStatus));
        $this->assertSame(0, $exitStatus);
    }
}
