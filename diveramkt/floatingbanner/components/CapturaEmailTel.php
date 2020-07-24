<?php namespace Diveramkt\FloatingBanner\Components;

use Cms\Classes\ComponentBase;

use Diveramkt\FloatingBanner\Models\CapturaEmails;
// use Indikator\News\Models\Subscribers;
use Diveramkt\FloatingBanner\Models\Subscribers;

use Diveramkt\FloatingBanner\Components\FloatPopup;
use Diveramkt\FloatingBanner\Components\ExitFloatPopup;

use Lang;
use App;
use Validator;
// use Indikator\News\Classes\SubscriberService;
use Diveramkt\FloatingBanner\Classes\SubscriberService;
use Request;
use session;
use stdclass;

// use Diveramkt\WhatsappFloat\Classes\formContato;

class CapturaEmailTel extends ComponentBase
{
	use SubscriberService;

	public function componentDetails(){
		return [
			'name' => 'Captura Emails/Telefones',
			'description' => 'Um pop para capturar emails ou telefone'	
		];
	}

	public function defineProperties(){
		return [

		];
	}

	// public function link($url) {
	// 	if(!strpos("[".$url."]", "http://") && !strpos("[".$url."]", "https://")) $url='http://'.$url;
	// 	return $url;
	// }

	// public function target($link){
	// 	if(!strpos("[".$link."]", $_SERVER['HTTP_HOST'])) return '_blank';
	// 	else return '_parent';
	// }

		    // VERIFICAR DIFERENCA DE TEMPO HORA/MINUTOS/SEGUNDO EM DOIS TEMPOS DIFERENTES (DATA HORARIO)
	public function horas_datas($data1, $data2){
    // $data1='2017-01-25 00:22:15';
    // $data2='2017-04-27 01:00:00';

		if(function_exists('date_diff')){
			$datetime1 = date_create($data1);
			$datetime2 = date_create($data2);
			$diff = date_diff($datetime1, $datetime2);
		}else{
			$date1=explode(' ', $data1); $date1[0]=explode('-', $date1[0]); $date1[1]=explode(':', $date1[1]);
			$date2=explode(' ', $data2); $date2[0]=explode('-', $date2[0]); $date2[1]=explode(':', $date2[1]);
			$diff=new stdclass;
			$diff->y=0;$diff->m=0;$diff->d=0;$diff->h=0;$diff->i=0;$diff->s=0;

			if($date2[0][0] >= $date1[0][0]) $diff->y=$date2[0][0]-$date1[0][0];
			if($date2[0][1] >= $date1[0][1]) $diff->m=$date2[0][1]-$date1[0][1];
			if($date2[0][2] >= $date1[0][2]) $diff->d=$date2[0][2]-$date1[0][2];
			if($date2[1][0] >= $date1[1][0]) $diff->h=$date2[1][0]-$date1[1][0];
			if($date2[1][1] >= $date1[1][1]) $diff->i=$date2[1][1]-$date1[1][1];
			if($date2[1][2] >= $date1[1][2]) $diff->s=$date2[1][2]-$date1[1][2];

// CALCULANDO SEGUNDOS TOTAIS
			$s1=$date1[1][2]+($date1[1][1]*60)+($date1[1][0]*3600);
			$s2=$date2[1][2]+($date2[1][1]*60)+($date2[1][0]*3600);
			$s=$s2-$s1;

    // CALCULANDO HORAS
			$diff->h=$s/3600; $diff->h=explode('.', $diff->h); $diff->h=$diff->h[0]; $s-=(3600*$diff->h);
    // CALCULANDO HORAS

    // CALCULANDO MINUTOS
			$diff->i=$s/60; $diff->i=explode('.', $diff->i); $diff->i=$diff->i[0]; $s-=(60*$diff->i);
    // CALCULANDO MINUTOS

			$diff->s=$s;

			$diff->invert=0;

			$data1=explode(' ', $data1);
			$data1=$data1[0];
			$data2=explode(' ', $data2);
			$data2=$data2[0];

			$diff->days=cal_days_interval($data1, $data2);
		}


		$retorno=new stdclass;
		$retorno->horas = $diff->h + ($diff->days * 24);
		$retorno->minutos=$diff->i;
		$retorno->segundos=$diff->s;

		$retorno->minutos_totais=$retorno->minutos;
		if($retorno->horas > 0) $retorno->minutos_totais+=($retorno->horas*60);
		return $retorno;
	}
    // VERIFICAR DIFERENCA DE TEMPO HORA/MINUTOS/SEGUNDO EM DOIS TEMPOS DIFERENTES (DATA HORARIO)

	public function onRun(){
		$class=get_declared_classes();


		 // or !in_array('Indikator\News\Controllers\Subscribers', $class)
		if(!in_array('Indikator\News\Plugin', $class)) return;
		
		$this->capturaemails = $this->getCapturaEmails();
		if(!isset($this->capturaemails->id) or !$this->capturaemails->id) return;

		if(isset($this->capturaemails->colors[0])) $this->capturaemails->colors=$this->capturaemails->colors[0];

		$name='popup_diveramkt_floating_captar_email_entrada';
		if(isset($this->capturaemails->tipo) && $this->capturaemails->tipo == 'entrada'){
			$veri=new FloatPopup();
			$veri=$veri->getPopup();
			$name='popup_diveramkt_floating_captar_email_entrada';
		}elseif(isset($this->capturaemails->tipo) && $this->capturaemails->tipo == 'saida'){
			$veri=new ExitFloatPopup();
			$veri=$veri->getExitPopup();
			$name='popup_diveramkt_floating_captar_email_saida';
		}
		if(isset($veri[0])) return;
		
		if($this->capturaemails->time_cache <= 0) $this->capturaemails->time_cache=1;

		// Session::forget($name);
		if(Session::get($name)) {
			 // && Session::get($name.'_quant')
			 // && Session::get($name.'_quant') == $this->capturaemails->time_cache
			$horas_dia=$this->capturaemails->time_cache*24;

			$value = Session::get($name);
			$veri=$this->horas_datas($value, date('Y-m-d H:i:s'));
			$horas=$veri->horas;

			if($horas >= $horas_dia){
				Session::forget($name);
				// Session::put($name, date('Y-m-d H:i:s'));
				// Session::put($name.'_quant', $this->capturaemails->time_cache);
			}else return;
			
		}

		$this->addCss('/plugins/diveramkt/floatingbanner/assets/style.css?atualizado');
		$this->addJs('/plugins/diveramkt/floatingbanner/assets/scripts.js?atualizado1');

		if($this->capturaemails->load_font_awesome) $this->addCss('/plugins/diveramkt/floatingbanner/assets/css/font-awesome.min.css');

		// if(isset($this->capturaemails->margin[0])) $this->capturaemails->margin=$this->capturaemails->margin[0];
		if(!$this->capturaemails->margin) $this->capturaemails->margin='inteiro';
		// print_r($this->capturaemails->margin);
		// if(isset($this->capturaemails->margin)){
			// if(isset($this->capturaemails->margin['left'])) $this->capturaemails->margin['left']=0;
			// if(isset($this->capturaemails->margin['right'])) $this->capturaemails->margin['right']=0;
			// if(isset($this->capturaemails->margin['top'])) $this->capturaemails->margin['top']=0;
			// if(isset($this->capturaemails->margin['bottom'])) $this->capturaemails->margin['bottom']=0;
		// }

		// $this->addJs('/plugins/diveramkt/whatsappfloat/assets/scripts.js?atualizado2');
		if(!$this->capturaemails->title) $this->capturaemails->title='Cadastre seu email';
	}

	public function onSessionBanner(){
		$this->capturaemails = $this->getCapturaEmails();

		$name='popup_diveramkt_floating_captar_email_entrada';
		if(isset($this->capturaemails->tipo) && $this->capturaemails->tipo == 'entrada'){
			$name='popup_diveramkt_floating_captar_email_entrada';
		}elseif(isset($this->capturaemails->tipo) && $this->capturaemails->tipo == 'saida'){
			$name='popup_diveramkt_floating_captar_email_saida';
		}
		Session::put($name, date('Y-m-d H:i:s'));
		// $arquivo = "gerar_session_banner.txt";
		// $fp = fopen($arquivo, "w+");
		// fwrite($fp, 'teste '.time());
		// fclose($fp);
	}

	// protected function getCapturaEmails(){
	public function getCapturaEmails(){
		return CapturaEmails::where('enabled',1)->first();
	}

	public function onSubscriptionFloating(){
		$this->capturaemails = $this->getCapturaEmails();
        // Get data from form
		$data = post();

		if($this->capturaemails->enabled_name) $required_name='required|between:2,64';
		else $required_name='';

		if($this->capturaemails->select_campo == 'email') $required_email='required|email|between:8,64';
		else $required_email='required|between:8,64';

		$rules = [
			'name'     => $required_name,
			'email'    => $required_email,
			// 'category' => 'array'
		];

		$validation = Validator::make($data, $rules);
		if ($validation->fails()) {
			throw new ValidationException($validation);
		}

		$email = post('email');
		
		if(post('name')) $name  = post('name');
		else $name=' ';

		$categories = post('category', []);

        // looking for existing subscriber
		$subscriberResult = Subscribers::email($email);

		if ($subscriberResult->count() > 0) {
			$subscriber = $subscriberResult->first();
            // Update the name
			$subscriber->name = $name;
		}
		else {

			if($this->capturaemails->select_campo == 'email') $status=3;
			else $status=1;

            // Register new one
			$subscriber = Subscribers::create([
				'name'          => $name,
				'email'         => $email,
				// 'common'        => '',
				'locale'        => App::getLocale(),
				'created'       => 2,
				'statistics'    => 0,
				'created_at'    => date('Y-m-d H:i:s'),
				'updated_at'    => date('Y-m-d H:i:s'),
				'registered_at' => now(),
				'registered_ip' => Request::ip(),
				// 'status'        => 3
				'status'        => $status
			]);
		}

		$this->onSessionBanner();
		$this->onSubscriberRegister($subscriber, $categories);
	}

	public $capturaemails;

}