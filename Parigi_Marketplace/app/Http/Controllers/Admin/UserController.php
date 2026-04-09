<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function index() {
        return Inertia::render('Admin/Users/Index', ['users' => $this->userService->getAllUsers()]);
    }
}
