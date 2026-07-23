<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // ===========================
        // SUPER ADMIN
        // ===========================
        if (Auth::user()->role == 'superadmin') {

            $totalRevenue = Transaction::whereIn('status', [
                'settlement',
                'success'
            ])->sum('total_price');

            $ticketsSold = Transaction::whereIn('status', [
                'settlement',
                'success'
            ])->count();

            $activeEvents = Event::where('date', '>=', now())->count();

            $pendingOrders = Transaction::where('status', 'pending')->count();

            $recentTransactions = Transaction::with('event')
                ->latest()
                ->take(5)
                ->get();

            $totalOrganizers = User::where('role', 'organizer')->count();
        }

        // ===========================
        // ORGANIZER
        // ===========================
        else {

            $totalRevenue = Transaction::whereHas('event', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->whereIn('status', ['settlement', 'success'])
            ->sum('total_price');

            $ticketsSold = Transaction::whereHas('event', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->whereIn('status', ['settlement', 'success'])
            ->count();

            $activeEvents = Event::where('user_id', Auth::id())
                ->where('date', '>=', now())
                ->count();

            $pendingOrders = Transaction::whereHas('event', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->where('status', 'pending')
            ->count();

            $recentTransactions = Transaction::with('event')
                ->whereHas('event', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->latest()
                ->take(5)
                ->get();

            $totalOrganizers = null;
        }

        return view('admin.dashboard', compact(
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'pendingOrders',
            'recentTransactions',
            'totalOrganizers'
        ));
    }
}