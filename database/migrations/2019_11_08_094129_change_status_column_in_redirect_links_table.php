<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStatusColumnInRedirectLinksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(' ALTER TABLE redirect_links MODIFY status  TINYINT(1) DEFAULT 1 NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('redirect_links', function (Blueprint $table) {
            $table->enum('status', array('ACTIVE','INACTIVE'))->default('ACTIVE')->change();
        });
    }
}
