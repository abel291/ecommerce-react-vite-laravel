<?php

namespace App\Traits;

trait WithSorting
{
    public $search = '';

    public $sortBy = 'id';

    public $sortDirection = 'desc';

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortBy === $field
            ? $this->reverseSort()
            : 'asc';

        $this->sortBy = $field;
    }

    public function reverseSort()
    {
        return $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';
    }

    public function resetList()
    {
        $this->search = '';
        $this->sortDirection = 'desc';
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
