<?php

namespace App\Http\Controllers;

class CriteriaController extends Controller
{
    /**
     * Determinate if criteria configuration is OK and display values
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $total  = 0;
        $config = config('project.criteria');
        $keys   = [];
        foreach ($config as $key => $value)
        {
            $weight     = (int) (is_array($value)) ? $value['weight'] : $value;
            $keys[$key] = $weight;
            $total     += $weight;
        }

        if($total === 100)
        {
            $color = 'success';
        } else {
            $color = 'danger';
        }

        return view('pages.criteria', [
            'total'  => $total,
            'color'  => $color,
            'config' => $keys,
        ]);
    }
}
