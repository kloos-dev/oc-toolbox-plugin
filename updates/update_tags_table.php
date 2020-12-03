<?php namespace Kloos\Toolbox\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateTagsTable extends Migration
{
    public function up()
    {
        Schema::table('kloos_toolbox_tags', function (Blueprint $table) {
            $table->string('code');
        });
    }

    public function down()
    {
        Schema::table('kloos_toolbox_tags', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
}