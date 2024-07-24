<?php

namespace SaKanjo;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use ValueError;

trait EasyEnum
{
    // --- Translatable ---

    private function getNamespace(): string
    {
        $class = static::class;

        return "enums.$class.$this->name";
    }

    private function defaultLabel(): string
    {
        return Str::of($this->name)
            ->headline()
            ->lower()
            ->ucfirst();
    }

    private function translated(): string
    {
        return Lang::get($this->getNamespace());
    }

    public function getLabel(): string
    {
        return Lang::has($this->getNamespace())
            ? $this->translated()
            : $this->defaultLabel();
    }

    // --- Equality ---

    public function is(mixed $value): bool
    {
        return $this === $value;
    }

    public function isNot(mixed $value): bool
    {
        return ! $this->is($value);
    }

    public function in(array $values): bool
    {
        return in_array($this, $values);
    }

    public function notIn(array $values): bool
    {
        return ! $this->in($values);
    }

    // --- Serialization ---

    public static function tryFromName(string $name): ?static
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }

        return null;
    }

    public static function fromName(string $name): static
    {
        $case = self::tryFromName($name);

        return $case
            ?: throw new ValueError($name.' is not a valid case for enum '.self::class);
    }

    // --- cases ---

    public static function names(): array
    {
        return array_column(static::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(bool $translated = false): array
    {
        return $translated
            ? Arr::mapWithKeys(self::cases(), fn (self $case) => [
                $case->getLabel() => $case->value,
            ])
            : array_column(self::cases(), 'value', 'name');
    }

    // --- Htmlable ---

    public function toHtml(): string
    {
        return $this->getLabel();
    }
}
