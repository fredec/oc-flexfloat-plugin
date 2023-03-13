<?php namespace Diveramkt\Floatingbanner\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDiveramktFloatingbannerPopup4 extends Migration
{
    public function up()
    {
        Schema::table('diveramkt_floatingbanner_popup', function($table)
        {
            $table->string('image_mobile', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('diveramkt_floatingbanner_popup', function($table)
        {
            $table->dropColumn('image_mobile');
        });
    }
}
