<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            //
            $table->unsignedTinyinteger('gender'); //0->other, 1->male 2->famale
            $table->unsignedInteger('age');
            $table->boolean('immigrant'); //0->地元, 1->移住者
            $table->year('start')->nullable();
            $table->year('end')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            //
            $table->dropColumn('gender');
            $table->dropColumn('age');
            $table->dropColumn('immigrant');
            $table->dropColumn('start');
            $table->dropColumn('end');
        });
    }
}
