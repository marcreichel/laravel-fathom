<?php

declare(strict_types=1);

namespace MarcReichel\LaravelFathom\Models;

use Illuminate\Support\Collection;

final class Aggregation extends Model
{
    private string $entity;
    private string $entityId;
    private array $aggregates;

    private ?string $dateGrouping;
    private ?string $fieldGrouping;
    private ?string $sortBy;
    private ?string $timezone;
    private ?string $dateFrom;
    private ?string $dateTo;
    private ?int $limit;
    private Collection $filters;

    public function __construct(string $entity, string $entityId, array $aggregates)
    {
        parent::__construct();

        $this->entity = $entity;
        $this->entityId = $entityId;
        $this->aggregates = $aggregates;

        $this->filters = new Collection();
    }

    public function groupByHour(): self
    {
        $this->groupByDate('hour');

        return $this;
    }

    public function groupByDay(): self
    {
        $this->groupByDate('day');

        return $this;
    }

    public function groupByMonth(): self
    {
        $this->groupByDate('month');

        return $this;
    }

    public function groupByYear(): self
    {
        $this->groupByDate('year');

        return $this;
    }

    private function groupByDate(string $value): void
    {
        $this->dateGrouping = $value;
    }

    public function groupByField(string $field): self
    {
        $this->fieldGrouping = $field;

        return $this;
    }

    public function orderBy(string $field, string $direction = 'asc'): self
    {
        $this->sortBy = $field . ':' . $direction;

        return $this;
    }

    public function timezone(string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function fromDate(string $timestamp): self
    {
        $this->dateFrom = $timestamp;

        return $this;
    }

    public function toDate(string $timezone): self
    {
        $this->dateTo = $timezone;

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function where(string $field, string $operator, string $value): self
    {
        $this->filters->push([
            'property' => $field,
            'operator' => $operator,
            'value' => $value,
        ]);

        return $this;
    }

    public function get(): array|null
    {
        $query = $this->buildQuery();
        $key = 'aggregations.' . sha1($query);
        return $this->resolveResponse($this->client->get('aggregations?' . $query), $key);
    }

    private function buildQuery(): string
    {
        return http_build_query(collect([
            'entity' => $this->entity,
            'entity_id' => $this->entityId,
            'aggregates' => collect($this->aggregates)->join(','),
            'date_grouping' => $this->dateGrouping ?? null,
            'field_grouping' => $this->fieldGrouping ?? null,
            'sort_by' => $this->sortBy ?? null,
            'timezone' => $this->timezone ?? null,
            'date_from' => $this->dateFrom ?? null,
            'date_to' => $this->dateTo ?? null,
            'limit' => $this->limit ?? null,
            'filters' => $this->filters->isNotEmpty() ? $this->filters->filter()->toJson() : null,
        ])->filter()->toArray());
    }
}
