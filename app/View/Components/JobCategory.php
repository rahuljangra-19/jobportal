<?php

namespace App\View\Components;

use App\Models\JobCategory as ModelsJobCategory;
use Illuminate\View\Component;

class JobCategory extends Component
{
    public $categories;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->categories = ModelsJobCategory::where('status', 1)->withCount('jobs')->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.job-category', ['categories' => $this->categories]);
    }
}
