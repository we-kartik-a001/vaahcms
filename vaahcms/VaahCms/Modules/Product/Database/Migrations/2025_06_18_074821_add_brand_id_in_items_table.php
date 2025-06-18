<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBrandIdInItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('items', function (Blueprint $table) {

            $table->integer('brand_id')->nullable()->after('id');
            //----/common fields

        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
          Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('brand_id');
        });
    }
}
