<?php

use App\Calculator;



it('adds normally', function () {
   $calculator = new Calculator();

   $result = $calculator->add(1, 2);

   expect($result)->toBe(3);
});

it('normally adds inversely', function () {
   $calculator = new Calculator();

   $result = $calculator->add(2, 1);

   expect($result)->toBe(3);
});

it('adds long number', function () {
   $calculator = new Calculator();

   $result = $calculator->add(2456494981131654, 4586312315947985);

   expect($result)->toBe(7042807297079639);
});

it('adds one negative number', function () {
   $calculator = new Calculator();

   $result = $calculator->add(-5, 10);

   expect($result)->toBe(5);
});

it('adds one negative number inverserly', function () {
   $calculator = new Calculator();

   $result = $calculator->add(20, -10);

   expect($result)->toBe(10);
});

it('adds two negative number', function () {
   $calculator = new Calculator();

   $result = $calculator->add(-20, -10);

   expect($result)->toBe(-30);
});


test('divides normally', function () {
    $calculator = new Calculator();
    $result = $calculator->divide(10, 2);

    expect($result)->toBe(5.0);
});

test('throws exception on division by zero', function () {
    $calculator = new Calculator();

    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('Division by zero');

    $calculator->divide(10, 0);
});