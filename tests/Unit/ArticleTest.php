<?php

use App\Article;

it('instantiate an article', function () {
    expect(fn() => new Article("Le Saint Coran", "Le Saint Coran description", -1))
    ->toThrow(InvalidArgumentException::class, "The price must be greather than 0");

    expect(fn() => new Article("Le Saint Coran", "Le Saint Coran description", -145165.85))
    ->toThrow(InvalidArgumentException::class, "The price must be greather than 0");

    expect(new Article("Le Saint Coran", "Le Saint Coran description", 15.0))->toBeInstanceOf(Article::class);
});

it("truncate the price", function () {
    $article = new Article("Le Saint Coran", "Le Saint Coran description", 15.558);
    expect($article->get_price_ht())->toEqual(15.55);

    $article = new Article("Le Saint Coran", "Le Saint Coran description", 15.559);
    expect($article->get_price_ht())->toEqual(15.55);

    $article = new Article("Le Saint Coran", "Le Saint Coran description", 15.555);
    expect($article->get_price_ht())->toEqual(15.55);

    $article = new Article("Le Saint Coran", "Le Saint Coran description", 15.551);
    expect($article->get_price_ht())->toEqual(15.55);

        $article = new Article("Le Saint Coran", "Le Saint Coran description", 15.5515948965);
    expect($article->get_price_ht())->toEqual(15.55);
});
