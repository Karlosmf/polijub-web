<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Models\Flavor;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        // Calculate some stats (mocked data if no orders yet)
        $totalRevenue = Order::sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();
        
        $recentOrders = Order::with('user', 'branch')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', [
            'productsCount' => Product::count(),
            'flavorsCount' => Flavor::count(),
            'usersCount' => User::count(),
            'totalRevenue' => $totalRevenue,
            'pendingOrders' => $pendingOrders,
            'recentOrders' => $recentOrders,
        ]);
    }
}