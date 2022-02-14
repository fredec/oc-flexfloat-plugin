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

    /**
     * @var array Validation rules
     */
    public $rules = [
        'title' => 'required',
        'image' => 'required',
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

}
