<?php

namespace MarcReichel\LaravelFathom\Models;

use Illuminate\Support\Collection;

class Aggregation extends Model
{
    protected string $entity;
    protected string $entityId;
    protected array $aggregates;
    protected array $settings;

    protected string|null $dateGrouping;
    protected string|null $fieldGrouping;
    protected string|null $sortBy;
    protected string|null $timezone;
    protected string|null $dateFrom;
    protected string|null $dateTo;
    protected int|null $limit;
    protected Collection $filters;

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

    protected function groupByDate(string $value): void
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

    protected function buildQuery(): string
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
