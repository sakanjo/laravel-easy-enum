<?php

use SaKanjo\EasyEnum\Tests\Enums\ExampleEnum;

use function PHPUnit\Framework\assertEquals;

it('returns correct label using `getLabel`', function (ExampleEnum $enum, string $expected) {
    assertEquals($enum->getLabel(), $expected);
})
    ->with([
        [ExampleEnum::USD, 'USD'],
        [ExampleEnum::EURO, 'EURO'],
        [ExampleEnum::NOPE, 'N o p e'],
    ]);

it('compares correctly using `is`', function (ExampleEnum $a, ExampleEnum $b, bool $expected) {
    assertEquals($a->is($b), $expected);
})
    ->with([
        [ExampleEnum::USD, ExampleEnum::USD, true],
        [ExampleEnum::USD, ExampleEnum::EURO, false],
        [ExampleEnum::USD, ExampleEnum::NOPE, false],
    ]);

it('compares correctly using `isNot`', function (ExampleEnum $a, ExampleEnum $b, bool $expected) {
    assertEquals($a->isNot($b), $expected);
})
    ->with([
        [ExampleEnum::USD, ExampleEnum::USD, false],
        [ExampleEnum::USD, ExampleEnum::EURO, true],
        [ExampleEnum::USD, ExampleEnum::NOPE, true],
    ]);

it('returns correct case using `tryFromName`', function (string $case, ?ExampleEnum $expected) {
    assertEquals(ExampleEnum::tryFromName($case), $expected);
})
    ->with([
        ['USD', ExampleEnum::USD],
        ['Oops', null],
        ['EURO', ExampleEnum::EURO],
    ]);

it('returns correct case using `fromName` and throws error if not', function (string $case, ?ExampleEnum $expected) {
    try {
        assertEquals(ExampleEnum::fromName($case), $expected);
    } catch (ValueError $_) {
        assertEquals($expected, null);
    }
})
    ->with([
        ['USD', ExampleEnum::USD],
        ['Oops', null],
        ['EURO', ExampleEnum::EURO],
    ]);

it('returns correct names using `names`', function () {
    assertEquals(ExampleEnum::names(), [
        'USD',
        'EURO',
        'NOPE',
    ]);
});

it('returns correct values using `values`', function () {
    assertEquals(ExampleEnum::values(), [
        0,
        1,
        2,
    ]);
});

it('returns correct options using `options`', function (bool $translated, array $expected) {
    assertEquals(ExampleEnum::options($translated), $expected);
})
    ->with([
        [false, [
            'USD' => 0,
            'EURO' => 1,
            'NOPE' => 2,
        ]],
        [true, [
            'USD' => 0,
            'EURO' => 1,
            'N o p e' => 2,
        ]],
    ]);
