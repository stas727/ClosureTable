<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class {{entity_class}}Migration extends Migration
{
    public function up()
    {
        Schema::create('{{entity_table}}', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('position', false, true);
            $table->integer('real_depth', false, true);
            $table->softDeletes();

            $table->foreign('parent_id')
                ->references('id')
                ->on('{{entity_table}}')
                ->onDelete('set null');
        });

        Schema::create('{{closure_table}}', function (Blueprint $table) {
            $table->increments('closure_id');

            $table->integer('ancestor', false, true);
            $table->integer('descendant', false, true);
            $table->integer('depth', false, true);

            $table->foreign('ancestor')
                ->references('id')
                ->on('{{entity_table}}')
                ->onDelete('cascade');

            $table->foreign('descendant')
                ->references('id')
                ->on('{{entity_table}}')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('{{closure_table}}', function (Blueprint $table) {
            Schema::dropIfExists('{{closure_table}}');
        });

        Schema::table('{{entity_table}}', function (Blueprint $table) {
            Schema::dropIfExists('{{entity_table}}');
        });
    }
}
