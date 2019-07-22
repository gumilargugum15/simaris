<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\komentar;
use Illuminate\Support\Facades\Auth; 

class AppComposer
{

    protected $belumdilihat;
    
    public function __construct()
    {
        $user = Auth::user();
        $roles = Auth::user()->roles;
        //dd($roles);
        $this->belumdilihat = komentar::where('nik',$user->userid)->where('read',0)->get();
    }

    public function compose(View $view)
    {
        $blmdilihat = $this->belumdilihat->count();
        $notif = $blmdilihat;
        $with = array(
            'blmdilihat'=>$blmdilihat);
        $view->with($with);
    }
}