<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{

    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idpat');
            $table->string('surname', 111);
            $table->string('name', 111);
            $table->string('address', 111)->nullable()->default(' ');
            $table->string('city', 111)->nullable()->default(' '); 
            $table->string('dni', 18);
            $table->string('tel1', 18)->nullable()->default(' ');
            $table->string('tel2', 18)->nullable()->default(' ');
            $table->string('tel3', 18)->nullable()->default(' ');
            $table->string('sex', 9)->nullable()->default(' ');
            $table->date('birth')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('surname');
            $table->index('name');
            $table->unique('dni'); 	
       	});
    }

    public function down()
    {
        Schema::drop('patients');
    }
    
}
