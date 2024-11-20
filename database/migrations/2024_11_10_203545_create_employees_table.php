<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();                      //Unique employee ID
            $table->string('firstname');       //Employee's First name
            $table->string('lastname');        //Employee's Last name
            $table->string('password');        //Employee's Hashed Password
            $table->foreignid('department_id')->constrained()->onDelete('cascade');     //Employee's department in the departments table
            $table->integer('totalaccess');    //Employee's successful accesses count
            $table->string('type');            //Employee type
            //$table->timestamps();
        });

        DB::statement('ALTER TABLE employees AUTO_INCREMENT = 1000000'); //Makes Employees IDs to start from 1000000

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
