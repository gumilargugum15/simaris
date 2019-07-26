<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\komentar;
use App\Komentar_detail;
use Illuminate\Support\Facades\Auth; 

class AppComposer
{

    protected $belumdibaca;
    
    public function __construct()
    {
        $user = Auth::user();
        $roles = Auth::user()->roles;
        // dd($user);
        $this->belumdibaca = komentar_detail::where('nik',$user->nik)->where('baca',0)->get();
    }

    public function compose(View $view)
    {
        $blmdibaca = $this->belumdibaca->count();
        $notif = $blmdibaca;
        $with = array(
            'notif'=>$notif,
            'blmdibaca'=>$blmdibaca);
        $view->with($with);
    }
}