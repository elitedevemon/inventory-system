<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseItemsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('purchase_items', function (Blueprint $table) {
      $table->id();
      $table->foreignId('purchase_id')->constrained()->cascadeOnUpdate();
      $table->foreignId('product_id')->constrained()->cascadeOnUpdate();
      $table->integer('quantity');
      $table->decimal('unit_price', 15, 2);
      $table->decimal('total_price', 15, 2);
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
    Schema::dropIfExists('purchase_items');
  }
}
