<?php namespace Diveramkt\Floatingbanner;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    	return [
    		'Diveramkt\FloatingBanner\Components\FloatPopup' => 'FloatPopup',
            'Diveramkt\FloatingBanner\Components\ExitFloatPopup' => 'ExitPopup',
            'Diveramkt\FloatingBanner\Components\CapturaEmailTel' => 'CapturaEmailTel',
    	];
    }

    public function registerPageSnippets()
    {
    	return [
    		'Diveramkt\FloatingBanner\Components\FloatPopup' => 'Popup',
            'Diveramkt\FloatingBanner\Components\ExitFloatPopup' => 'ExitPopup',
            // 'Diveramkt\FloatingBanner\Components\CapturaEmails' => 'CapturaEmails',
    	];
    }

    private function getPhpFunctions()
    {
        return [
            'prep_url' => function($url) {
                if(!strpos("[".$url."]", "http://") && !strpos("[".$url."]", "https://")) $url='http://'.$url;
                return $url;
            },
            'target' => function($link){
                if(!strpos("[".$link."]", $_SERVER['HTTP_HOST'])) return 'target="_blank"';
                else return 'target="_parent"';
            },

        ];
    }

    public function registerMarkupTags()
    {
        $filters = [];
        // add PHP functions
        $filters += $this->getPhpFunctions();

        return [
            'filters'   => $filters,
        ];
    }
}
