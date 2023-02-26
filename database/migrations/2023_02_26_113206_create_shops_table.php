<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id'); /**店舗ID */
            $table->string('name'); /**店舗名 */
            $table->text('open'); /**営業時間 */
            $table->string('address'); /**住所 */
            $table->string('urls'); /**店舗URL */
            $table->string('img_path'); /**店舗写真 */
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
        Schema::dropIfExists('shops');
    }
}
