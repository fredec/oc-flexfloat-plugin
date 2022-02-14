<?php namespace Diveramkt\Floatingbanner\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDiveramktFloatingbannerPopup3 extends Migration
{
    public function up()
    {
        Schema::table('diveramkt_floatingbanner_popup', function($table)
        {
            $table->string('title', 255)->nullable()->change();
            $table->integer('enabled')->nullable()->change();
            $table->integer('dias_oculto')->nullable()->change();
            $table->integer('tempo_inativo')->nullable()->change();
            $table->integer('tipo_banner')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('diveramkt_floatingbanner_popup', function($table)
        {
            $table->string('title', 255)->nullable(false)->change();
            $table->integer('enabled')->nullable(false)->change();
            $table->integer('dias_oculto')->nullable(false)->change();
            $table->integer('tempo_inativo')->nullable(false)->change();
            $table->integer('tipo_banner')->nullable(false)->change();
        });
    }
}
