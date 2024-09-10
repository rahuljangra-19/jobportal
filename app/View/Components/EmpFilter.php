<?php

namespace App\View\Components;

use App\Models\JobIndustry;
use Illuminate\View\Component;

class EmpFilter extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $data;
    public function __construct()
    {
        $this->data['industries'] = JobIndustry::where('status', 1)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        
        return view('components.emp-filter',  $this->data);
    }
}
