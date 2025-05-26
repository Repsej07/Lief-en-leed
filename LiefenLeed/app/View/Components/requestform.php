<?
namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Requestform extends Component
{
    public $gebeurtenissen;

    public function __construct($gebeurtenissen)
    {
        $this->gebeurtenissen = $gebeurtenissen;
    }

    public function render(): View|Closure|string
    {
        return view('components.requestform');
    }
}
