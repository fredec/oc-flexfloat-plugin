<?php namespace Diveramkt\FloatingBanner\Components;

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
		$this->popup = $this->getPopup();
	}

	protected function getPopup(){
		return Popup::first();
	}

	public $popup;
}