<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFcmUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fcm_users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->text('fcm_id');
            $table->string('device_id');
            $table->integer('type')->comment('1 = Android, 2 = IOS');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fcm_users');
    }
}
