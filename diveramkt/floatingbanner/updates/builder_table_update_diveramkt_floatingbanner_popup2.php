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
            $table->string('tipo_link', 255)->nullable();
            $table->integer('tipo_banner')->default(0);
            $table->text('script_embed')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('diveramkt_floatingbanner_popup', function($table)
        {
            $table->dropColumn('tempo_inativo');
            $table->dropColumn('tipo_link');
            $table->dropColumn('tipo_banner');
            $table->dropColumn('script_embed');
        });
    }
}