<?php

namespace Sunnysideup\ElementalEditMeButton\Control;

class CanEdit extends Controller
{

    public function test()
    {
        $value = false;
        $obj = Elemental::get()->first();
        if($obj) {
            $value = true;
        }
        return '{"canEdit": '.$value.'}';
    }

}
