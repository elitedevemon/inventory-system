<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('sales', function (Blueprint $table) {
      $table->id();
      $table->foreignId('customer_id')->constrained()->cascadeOnUpdate();
      $table->foreignId('product_id')->constrained()->cascadeOnUpdate();
      $table->string('invoice_no')->unique();
      $table->date('sale_date');
      $table->decimal('total_amount', 15, 2);
      $table->decimal('paid_amount', 15, 2);
      $table->decimal('due_amount', 15, 2)->default(0);
      $table->string('payment_method')->nullable(); // e.g., cash, card, mobile
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
    Schema::dropIfExists('sales');
  }
}
