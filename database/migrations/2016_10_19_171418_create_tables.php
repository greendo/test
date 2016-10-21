<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    public function up() {
        Schema::create('referal', function (Blueprint $table) {
            $table->integer('inviter_id');
            $table->string('link_one')->nullable();
            $table->integer('time_one')->nullable();
            $table->string('link_two')->nullable();
            $table->integer('time_two')->nullable();
        });
    }

    public function down() {}
}
