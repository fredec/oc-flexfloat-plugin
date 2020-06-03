<?php namespace Diveramkt\Floatingbanner\Models;

use Model;

/**
 * Model
 */
class CapturaEmails extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;

    public $jsonable = ['colors'];
    // ,'margin'
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'diveramkt_floatingbanner_captura_emails';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    // public function getMarginOptions(){
    //     $retorno=array();
    //     $retorno['inteiro']='Inteiro';
    //     return $retorno;
    // }

}
