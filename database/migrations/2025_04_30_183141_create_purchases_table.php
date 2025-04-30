<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('purchases', function (Blueprint $table) {
      $table->id();
      $table->foreignId('supplier_id')->constrained()->cascadeOnUpdate();
      $table->string('invoice_no')->unique();
      $table->date('purchase_date');
      $table->decimal('total_amount', 15, 2);
      $table->decimal('paid_amount', 15, 2)->default(0);
      $table->decimal('due_amount', 15, 2)->default(0);
      $table->string('payment_method')->nullable(); // e.g., Cash, Bank, Mobile Banking
      $table->boolean('status')->default(true); // active/processed
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
    Schema::dropIfExists('purchases');
  }
}
