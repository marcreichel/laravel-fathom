<?php

namespace MarcReichel\LaravelFathom\Traits;

trait HasPagination
{
    protected int|null $limit;
    protected string|null $starting_after;
    protected string|null $ending_before;

    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function after(string $cursor): self
    {
        $this->starting_after = $cursor;

        return $this;
    }

    public function before(string $cursor): self
    {
        $this->ending_before = $cursor;

        return $this;
    }

    protected function paginationQuery(): string
    {
        return http_build_query(collect([
            'limit' => $this->limit ?? null,
            'starting_after' => $this->starting_after ?? null,
            'ending_before' => $this->ending_before ?? null,
        ])->filter()->toArray());
    }
}
