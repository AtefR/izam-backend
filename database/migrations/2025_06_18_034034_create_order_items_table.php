<?php

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('quantity');
            $table->decimal('price');
            $table->decimal('total');

            $table->foreignIdFor(Order::class)
                ->constrained('orders')
                ->cascadeOnDelete();
            $table->foreignIdFor(Product::class)
                ->constrained('products')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
