<?php namespace Diveramkt\Floatingbanner\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDiveramktFloatingbannerPopup5 extends Migration
{
    public function up()
    {
        Schema::table('diveramkt_floatingbanner_popup', function($table)
        {
            $table->text('link_youtube')->nullable();
            $table->text('infos')->nullable();
            $table->string('movie', 255)->nullable();
            $table->integer('enabled')->default(1)->change();
            $table->integer('dias_oculto')->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('diveramkt_floatingbanner_popup', function($table)
        {
            $table->dropColumn('link_youtube');
            $table->dropColumn('infos');
            $table->dropColumn('movie');
            $table->integer('enabled')->default(NULL)->change();
            $table->integer('dias_oculto')->default(NULL)->change();
        });
    }
}