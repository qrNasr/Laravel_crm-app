<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   return new class extends Migration
   {
       /**
        * Run the migrations.
        *
        * @return void
        */
       public function up()
       {
            Schema::create('interactions', function (Blueprint $table) {
               $table->id();
               $table->foreignId('customer_id')->constrained()->onDelete('cascade');
               $table->string('type');
               $table->text('notes')->nullable();
               $table->dateTime('interaction_date');
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
           Schema::dropIfExists('interactions');
       }
   };