<?php namespace Diveramkt\FloatingBanner\Components;

use Cms\Classes\ComponentBase;

use Diveramkt\FloatingBanner\Models\ExitPopup;

class ExitFloatPopup extends ComponentBase
{

	public function componentDetails(){
		return [
			'name' => 'Exit Popup',
			'description' => 'A popup to open when the user is about to exit'
		];
	}

	public function defineProperties(){
		return [

		];
	}

	public function onRun(){
		$this->exitpopup = $this->getExitPopup();
	}

	protected function getExitPopup(){
		return ExitPopup::first();
	}

	public $exitpopup;
}