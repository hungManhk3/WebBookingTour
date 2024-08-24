<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome($ten, $tuoi = ''): void
    {
        echo "heheeh - $ten $tuoi";
    }
}
