<?php

namespace Closet\Http\Controllers\User;

use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Models\Product;

class NoteController extends Controller
{
  public function index()
  {
    return view('user.note.index');
  }
}
