<?php

namespace App\View\Components;

use Illuminate\View\Component;

class JobFeed extends Component
{
    public $data;
    public $type = 1;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($data, $type = 1)
    {
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.job-feed', ['jobs' => $this->data, 'viewType' => $this->type]);
    }
}
