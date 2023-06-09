<?php namespace Diveramkt\Floatingbanner\Models;

use Model;

/**
 * Model
 */
class Popup extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    public $jsonable = ['infos'];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'title' => 'required',
        'image' => 'required_if:tipo_banner,0',
        'script_embed' => 'required_if:tipo_banner,1',
        'movie' => 'required_if:tipo_banner,2',
        'link_youtube' => 'required_if:tipo_banner,3',
    ];

    // public $messages = [
    //     'image.required' => 'Imagem é obrigatória',
    // ];
    // $messages = [
    //     'email.required' => 'We need to know your e-mail address!',
    // ];

    public $attachOne = [
        // 'movie' => 'System\Models\File',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'diveramkt_floatingbanner_popup';

    public $hasMany = [
        'pages' => [
            'Diveramkt\Floatingbanner\Models\Pagesbanner',
            'key' => 'banner_id',
            'scope' => 'popup'
        ],
    ];

    public function beforeSave($model=false){
        $infos=$this->infos;
        if(!is_array($infos)) $infos=[];
        foreach ($this->attributes as $key => $value) {
            if(!\Schema::hasColumn($this->table, $key)){
                $infos[$key]=$value;
                unset($this->$key);
            }
        }
        $this->infos=$infos;
    }

    public function getExtensionMovieAttribute(){
        $infos=pathinfo($this->movie);
        if(isset($infos['extension'])) return $infos['extension'];
    }
    public function getEmbedLinkYoutubeAttribute(){
        if($this->link_youtube){
            $url=$this->link_youtube;
            $autoplay=0;
            if(strpos("[".$url."]", "youtu.be/") || strpos("[".$url."]", "youtube")){
                if(strpos("[".$url."]", "&feature")){
                    preg_match_all("#&feature(.*?)&#s", $url, $result);
                    if(isset($result[0][0])) $url=str_replace($result[0][0], '&', $url);
                    else{
                        $url=explode('&feature', $url);
                        $url=$url[0];
                    }
                }
                $retorno='';

                if(strpos("[".$url."]", "&")){
                    $exp=explode('&', $url);
                    foreach ($exp as $key => $value) {
                        if($key > 0) $url=str_replace('&'.$value,'', $url);
                    }
                }

                if(strpos("[".$url."]", "watch?v=")) $retorno=str_replace('/watch?v=', '/embed/', str_replace('&feature=youtu.be','',$url));
                elseif(strpos("[".$url."]", "youtu.be/")){
                    $exp=explode('youtu.be/', $url);
                    if(isset($exp[1])){
                        $retorno='https://www.youtube.com/embed/'.$exp[1];
                    }else $retorno=$url;
                }else $retorno=$url;


                return $retorno.'?controls=0&amp;start=1&amp;autoplay='.$autoplay.'&amp;loop=1&amp;background=1';
            }elseif(strpos("[".$url."]", "vimeo.com")){
                $par=explode('/', $url);
                return 'https://player.vimeo.com/video/'.end($par).'?autoplay='.$autoplay.'&loop=1&background=1';
            }
            return $url;
        }
    }

}
