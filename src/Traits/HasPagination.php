<?php

declare(strict_types=1);

namespace MarcReichel\LaravelFathom\Traits;

trait HasPagination
{
    protected ?int $limit;
    protected ?string $starting_after;
    protected ?string $ending_before;

    final public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    final public function after(string $cursor): self
    {
        $this->starting_after = $cursor;

        return $this;
    }

    final public function before(string $cursor): self
    {
        $this->ending_before = $cursor;

        return $this;
    }

    final protected function paginationQuery(): string
    {
        return http_build_query(collect([
            'limit' => $this->limit ?? null,
            'starting_after' => $this->starting_after ?? null,
            'ending_before' => $this->ending_before ?? null,
        ])->filter()->toArray());
    }
}
