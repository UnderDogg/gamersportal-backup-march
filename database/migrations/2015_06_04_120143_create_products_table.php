<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			/**
			 * Basic product info
			 */
			$table->increments('id');

			$table->string('name')->index();
			$table->integer('category_id')->unsigned()->nullable();

			// Active in store
			$table->boolean('active')->default(false);
			$table->string('slug', 255)->unique();

			// New label
			$table->boolean('new')->default(false);

			$table->decimal('price', 8, 2);
			$table->string('image')->nullable()->default('img/product-no-image.jpg');
			$table->string('image_thumb')->nullable()->default('img/product-no-image.jpg');

			// Discounted price, NULL if there's no discount
			$table->decimal('discounted_price', 8, 2)->nullable();

			/**
			 * Stock related info
			 */
			$table->string('sku')->unique();
			$table->integer('quantity')->nullable();
			$table->decimal('weight', 8, 2);

			$table->text('description');

			$table->timestamps();

			/**
			 * Indices and keys
			 */
			$table->foreign('category_id')
				->references('id')->on('categories')
				->onDelete('set null')
				->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}
