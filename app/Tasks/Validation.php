<?php

namespace App\Tasks;

use Exception;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class Validation
{
    const EMPTY = 'EMPTY';

    const DUPLICATE = 'DUPLICATE';

    const VALIDATE_EMPTY = 'VALIDATE_EMPTY';

    const VALIDATE_DUPLICATE = 'VALIDATE_DUPLICATE';

    const VALIDATE_DUPLICATE_WITH_NULLS = 'VALIDATE_DUPLICATE_WITH_NULLS';

    const PARAM_GROUP = 'PARAM_GROUP';

    /**
     * @var Collection<int|string, Collection<int|string, Collection<string, mixed>>>
     */
    private Collection $bag;

    public function __construct()
    {
        $this->clearValidationBag();
    }

    public function clearValidationBag(): void
    {
        $this->bag = collect();
    }

    /**
     * @param  Collection<int, Collection<int|string, int|string|null|bool>>  $data
     * @param  array<string, array<string, array<string>>>  $parameters
     *
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function validate(Collection $data, array $parameters): void
    {
        $this->clearValidationBag();

        $fixedArray = [];

        foreach ($parameters as $column => $validations) {
            foreach ($validations as $validation => $params) {
                $fixedArray[$validation][$column] = $params;
            }
        }

        $this->bag = collect($fixedArray)->mapWithKeys(
            function (array $columns, $validation) use ($data) {
                return [
                    $validation => collect($columns)->mapWithKeys(
                        function (array $params, $column) use ($validation, $data) {
                            return [
                                $column => match ($validation) {
                                    self::VALIDATE_EMPTY => $this->validateEmpty($data, $column),
                                    self::VALIDATE_DUPLICATE => $this->validateDuplicate($data, $column, $params, false),
                                    self::VALIDATE_DUPLICATE_WITH_NULLS => $this->validateDuplicate($data, $column, $params, true),
                                    default => collect()
                                },
                            ];
                        }
                    ),
                ];
            }
        );

        if ($this->getFilteredBag()->isNotEmpty()) {
            throw new Exception($this->getPlainTextBag(), 1);
        }
    }

    /**
     * @param  Collection<int, Collection<int|string, int|string|null|bool>>  $data
     * @return Collection<string, mixed> $data
     *
     * @throws InvalidArgumentException
     */
    private function validateEmpty(Collection $data, string $column): Collection
    {
        $result = $data->filter(
            fn (Collection $row) => is_null($row->get($column)) || str((string) $row->get($column))->trim()->value() === ''
        )->mapWithKeys(
            function (Collection $row, int $index) use ($column) {
                $key = 'ROW_'.($index + 2);
                $value = $row->get($column);

                return [$key => $value];
            }
        );

        return $result;
    }

    /**
     * @param  Collection<int, Collection<int|string, int|string|null|bool>>  $data
     * @param  array<string>  $group
     * @param  bool  $allowNulls
     * @return Collection<string, mixed> $data
     *
     * @throws InvalidArgumentException
     */
    private function validateDuplicate(Collection $data, string $column, $group = [], $allowNulls = false): Collection
    {
        $columns = collect($group)->merge([$column])->unique();

        $items = collect();

        if (count($columns) > 1) {
            $items = $data->unique(function (Collection $item) use ($columns) {
                return $columns->map(function ($column) use ($item) {
                    return $item->get($column);
                })->join(' ');
            });
        } else {
            $items = $data;
        }

        // dd($items);

        $results = $allowNulls ?
            $items->filter(
                fn ($item) => ! is_null($item->get($column))
            )->duplicates($column, true) :
            $items->duplicates($column, true);

        return $results->flatMap(function ($value, $key) {
            // return "Duplicate value in row: " . ($key + 2) . ", value: " . $value;
            return collect([('ROW_'.($key + 2)) => $value]);
            // return $value;
        });
    }

    /**
     * @return Collection<int|string, Collection<int|string, Collection<string, mixed>>>
     */
    public function getBag(): Collection
    {
        return $this->bag;
    }

    /**
     * @return Collection<int|string, Collection<int|string, Collection<string, mixed>>>
     */
    public function getFilteredBag(): Collection
    {
        $bagArray = [];

        foreach ($this->bag as $validation => $columns) {
            foreach ($columns as $column => $results) {
                if ($results->isNotEmpty()) {
                    $bagArray[$validation][$column] = $results->toArray();
                }
            }
        }

        return collect($bagArray)->mapWithKeys(
            fn ($columns, $validation) => [
                $validation => collect($columns)->mapWithKeys(
                    fn ($results, $column) => [
                        $column => collect($results)->mapWithKeys(
                            fn (mixed $value, string $index) => [$index => $value]
                        ),
                    ]
                ),
            ]
        );
    }

    public function getJsonBag(): string
    {
        return $this->getFilteredBag()->toJson();
    }

    public function getPlainTextBag(): string
    {
        return $this->getFilteredBag()
            ->map(
                fn (Collection $bag, $validationType) => (
                    str(' '.$validationType.' ')
                        ->wrap('***')
                        ->newLine()
                        ->newLine()
                        ->append(
                            $bag->map(
                                fn ($items, $col) => str($col.':')
                                    ->newLine()
                                    ->append(
                                        $items->map(
                                            fn ($value, $row) => "Duplicate row {$row}, value: ".($value ?? 'null')
                                        )->join(str('')->newLine())
                                    )
                            )->join(str('')
                                ->newLine()
                                ->newLine())
                        )
                )
            )->implode(str('')
            ->newLine()
            ->newLine());
    }
}
