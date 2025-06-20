<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNoColumnInProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

       Schema::table('product', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->integer('stock')->after('description');
            $table->decimal('price', 8, 2)->after('stock');
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
         Schema::table('product', function (Blueprint $table) {
            $table->dropColumn(['description', 'stock', 'price']);
        });
    }
}
