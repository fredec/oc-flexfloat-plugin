<?php namespace Diveramkt\Floatingbanner\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDiveramktFloatingbannerPopup2 extends Migration
{
    public function up()
    {
        Schema::table('diveramkt_floatingbanner_popup', function($table)
        {
            $table->integer('tempo_inativo')->default(0);
            $table->boolean('enabled')->default(0)->change();
            $table->integer('dias_oculto')->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('diveramkt_floatingbanner_popup', function($table)
        {
            $table->dropColumn('tempo_inativo');
        });
    }
}
