<?php namespace Diveramkt\Floatingbanner\Models;

use Model;
use Cms\Classes\Page;
use Cms\Classes\Theme;

/**
 * Model
 */
class Pagesbanner extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'diveramkt_floatingbanner_pages_banner';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function scopePopup($query){
        return $query->where('type_banner','popup');
    }

    public function getPageIdOptions(){

        $currentTheme = Theme::getEditTheme();
        $allPages = Page::listInTheme($currentTheme, true);

        $pages['']='Selecionar Página';
        foreach ($allPages as $pg) {
            if(isset($pags[$pg->id]) && $pg->id != $this->page) continue;
            $pages[$pg->id]=ucfirst($pg->title).' - '.$pg->url;
        }

        return $pages;
    }

    public function beforeSave(){
        if($this->type_url == 'page'){
            $currentTheme = Theme::getEditTheme();
            $allPages = Page::listInTheme($currentTheme, true);

            foreach ($allPages as $pg) {
                if($this->page_id == $pg->id) $this->url=$pg->url;
                else continue;
            }
        }
        if(!$this->page_id) $this->page_id=0;
        if(!isset($this->type_banner) || !$this->type_banner) $this->type_banner='popup';
    }

}
