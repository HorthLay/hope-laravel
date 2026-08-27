<?php

namespace App\Livewire;

use Livewire\Component;

class FaqAccordion extends Component
{
    /** @var array  All FAQ items passed in as a prop */
    public array $items = [];

    /** @var string  Currently open item key (null = all closed) */
    public ?string $openKey = null;

    /** @var string  Live search term */
    public string $search = '';

    /** @var string  Active category filter */
    public string $activeCategory = 'all';

    /** @var string  Accent color theme: 'orange' or 'blue' */
    public string $theme = 'orange';

    /** @var array  Category list for the sidebar */
    public array $categories = [];

    /**
     * Toggle a FAQ item open/closed.
     */
    public function toggle(string $key): void
    {
        $this->openKey = ($this->openKey === $key) ? null : $key;
    }

    /**
     * Set the active category filter.
     */
    public function setCategory(string $category): void
    {
        $this->activeCategory = $category;
        $this->openKey = null; // Close open item when changing category
    }

    /**
     * Computed: filtered list of FAQ items based on search + category.
     */
    public function getFilteredItemsProperty(): array
    {
        return array_filter($this->items, function ($item) {
            $matchSearch = !$this->search
                || str_contains(strtolower($item['question']), strtolower($this->search))
                || str_contains(strtolower($item['answer']), strtolower($this->search));

            $matchCategory = $this->activeCategory === 'all'
                || ($item['category'] ?? 'general') === $this->activeCategory;

            return $matchSearch && $matchCategory;
        });
    }

    public function render()
    {
        return view('livewire.faq-accordion', [
            'filteredItems' => $this->filteredItems,
        ]);
    }
}
