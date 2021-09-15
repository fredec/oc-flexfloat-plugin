<?php namespace Diveramkt\Floatingbanner;

use System\Classes\PluginBase;
use Request;

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
                $base = 'http' . ((Request::server('HTTPS') == 'on') ? 's' : '') . '://' . Request::server('HTTP_HOST') . str_replace('//', '/', dirname(Request::server('SCRIPT_NAME')) . '/');
                if(!strpos("[".$url."]", "http://") && !strpos("[".$url."]", "https://")){
                    $veri=str_replace('www.','',Request::server('HTTP_HOST'). str_replace('//', '/', dirname(Request::server('SCRIPT_NAME'))));
                    if(!strpos("[".$url."]", ".") && !strpos("[".$veri."]", "https://")){
                        $url='http' . ((Request::server('HTTPS') == 'on') ? 's' : '') . '://www.'.str_replace(array('//','\/'),array('/','/'),$veri.'/'.$url);
                    }else $url='http://'.$url;
                }
                return str_replace('//www.','//',$url);
            },
            'target' => function($link){
                $url = 'http' . ((Request::server('HTTPS') == 'on') ? 's' : '') . '://' . Request::server('HTTP_HOST');
                $link=str_replace('//www.','//',$link); $url=str_replace('//www.','//',$url);
                if(!strpos("[".$link."]", $url)) return 'target="_blank"';
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
