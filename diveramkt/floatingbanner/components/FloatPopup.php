<?php namespace Diveramkt\FloatingBanner\Components;

use Cache;
use Cms\Classes\ComponentBase;

use Diveramkt\FloatingBanner\Models\Popup;

class FloatPopup extends ComponentBase
{

	public function componentDetails(){
		return [
			'name' => 'Floating Popup',
			'description' => 'A popup to open over the page content'
		];
	}

	public function defineProperties(){
		return [

		];
	}

	public function onRun(){

		if($_SERVER['REDIRECT_URL'] == '/boletim-especial-2019') return;

		$this->popup = $this->getPopup();
		if(isset($this->popup[0])) $this->popup=$this->popup[0];

		if(isset($this->popup->attributes) && isset($this->popup->attributes['dias_oculto']) && $this->popup->attributes['dias_oculto'] > 0){

			$name='banner_float_'.serialize($this->popup->attributes);
			$name= preg_replace("/[^a-zA-Z0-9]/", "", $name);

			if (Cache::has($name)) {
				$veri=Cache::get($name);
				$this->popup='';
			}else{
				Cache::pull($name);
				$dias=$this->popup->attributes['dias_oculto']*(24*60);
				Cache::add($name, 'carregado', $dias);
			}

		}

		if(isset($this->popup->attributes)){
			$this->popup->attributes['target']='_parent';
			$url=$this->popup->attributes['link'];
			if(!strpos("[".$url."]", "http://") && !strpos("[".$url."]", "https://")) $url='http://'.$url;
			$this->popup->attributes['link']=$url;

			if(!strpos("[".$this->popup->attributes['link']."]", $_SERVER['HTTP_HOST'])) $this->popup->attributes['target']='_blank';
		}
		
	}

	protected function getPopup(){
		// return Popup::first();

		$retorno=Popup::where('data_entrada','<=',date('Y-m-d H:i:s'))->whereNull('data_saida')
		->orWhere('data_entrada','<=',date('Y-m-d H:i:s'))->where('data_saida','0000-00-00')
		->orWhere('data_entrada','<=',date('Y-m-d H:i:s'))->where('data_saida','>',date('Y-m-d H:i:s'))
		->get();

		$veri_link=explode($_SERVER['HTTP_HOST'], $retorno[0]->link); $veri_link=end($veri_link);
		if($_SERVER['REDIRECT_URL'] == $veri_link) $retorno=false;

		return $retorno;
	}

	public $popup;
}