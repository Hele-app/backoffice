<?php

namespace App\View\Components\Widgets;

use App\Http\Wrapper\HeleApiWrapper;
use Illuminate\View\Component;

class YoungsWidget extends Component
{
    /**
     * An instance of HeleApiWrapper.
     *
     * @var HeleApiWrapper
     */
    private $hele = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->hele = new HeleApiWrapper();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $users = $this->hele->call('users.youngs_index', []);

        return view('components.widgets.count-widget', [
            'count' => $users['rowCount'],
            'entity' => __('Jeunes'),
        ]);
    }
}
