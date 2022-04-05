<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovedCommentIdFromNicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nices', function (Blueprint $table) {
            //
            $table->bigInteger('post_id')->nullable(false)->change();
            $table->bigInteger('user_id')->nullable(false)->change();
            $table->string('ip', 255)->nullable(false)->change();
            $table->dropColumn('comment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nices', function (Blueprint $table) {
            //
            $table->bigInteger('post_id')->nullable()->change();
            $table->bigInteger('user_id')->nullable()->change();
            $table->string('ip', 255)->nullable()->change();
            $table->bigInteger('comment_id');
        });
    }
}
