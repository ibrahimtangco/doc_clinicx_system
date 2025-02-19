<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DailyPatientCapacity;

class AdminController extends Controller
{
    public function getTrends(Request $request)
    {
        $view = $request->input('view');
        $appointments = Appointment::query();

        if ($view == 'daily') {
            $appointments = $appointments->join('reservations', 'appointments.reservation_id', '=', 'reservations.id')
                ->selectRaw('DATE(reservations.date) as date, count(*) as total')
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
        } elseif ($view == 'weekly') {
            $appointments = $appointments->join('reservations', 'appointments.reservation_id', '=', 'reservations.id')
                ->selectRaw('YEAR(reservations.date) as year, WEEK(reservations.date) as week, count(*) as total')
                ->groupBy('year', 'week')
                ->orderBy('year', 'asc')
                ->orderBy('week', 'asc')
                ->get();
        } elseif ($view == 'monthly') {
            $appointments = $appointments->join('reservations', 'appointments.reservation_id', '=', 'reservations.id')
                ->selectRaw('YEAR(reservations.date) as year, MONTH(reservations.date) as month, count(*) as total')
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();
        }

        // Prepare data for the chart
        $labels = $appointments->map(function ($appointment) use ($view) {
            if ($view === 'daily') {
                // return $appointment->date->format('Y-m-d'); // Format for daily
                return Carbon::parse($appointment->date)->format('Y-m-d');
            } elseif ($view === 'weekly') {
                return "{$appointment->year}-W{$appointment->week}"; // Format for weekly
            } elseif ($view === 'monthly') {
                return "{$appointment->year}-" . str_pad($appointment->month, 2, '0', STR_PAD_LEFT); // Format for monthly
            }
        })->toArray();

        $data = $appointments->pluck('total')->toArray();

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }



    public function showAppointmentTrends()
    {
        // Fetch data from the database, aggregating appointment counts by date
        $appointmentTrends = Appointment::join('reservations', 'appointments.reservation_id', '=', 'reservations.id')
            ->selectRaw('DATE(reservations.date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Prepare Data and data for the chart
        $appointmentTrendsLabels = $appointmentTrends->pluck('date')->map(function ($date) {
            return \Carbon\Carbon::parse($date)->format('F j, Y'); // Format date as needed
        })->toArray();

        $appointmentTrendsData = $appointmentTrends->pluck('count')->toArray();

        return compact('appointmentTrendsLabels', 'appointmentTrendsData');
    }


    public function index()
    {
        $totalPatients = Patient::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

        $totalAppointments = Appointment::where('status', 'scheduled')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        $pendingReservations = Reservation::where('status', 'pending')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        $appointmentTrends = $this->showAppointmentTrends(); // Modify inside if needed

        $upcomingAppointments = Appointment::where('status', 'scheduled')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get();

        $totalTransactions = Transaction::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

        $totalPrescriptions = Prescription::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $productSalesData = DB::table('transaction_details')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->select(
                'products.name as product_name',
                DB::raw('SUM(transaction_details.total_amount) as total_sales'),
                DB::raw('SUM(transaction_details.quantity) as total_quantity')
            )
            ->whereMonth('transactions.created_at', $currentMonth)
            ->whereYear('transactions.created_at', $currentYear)
            ->groupBy('products.name')
            ->get();

        $productNames = $productSalesData->pluck('product_name')->toArray();
        $salesAmounts = $productSalesData->pluck('total_sales')->toArray();
        $quantities = $productSalesData->pluck('total_quantity')->toArray();

        $salesAmounts = array_map('floatval', $salesAmounts);

        return view('admin.dashboard', [
            'totalPatients' => $totalPatients,
            'totalAppointments' => $totalAppointments,
            'pendingReservations' => $pendingReservations,
            'appointmentTrendsLabels' => $appointmentTrends['appointmentTrendsLabels'],
            'appointmentTrendsData' => $appointmentTrends['appointmentTrendsData'],
            'upcomingAppointments' => $upcomingAppointments,
            'totalTransactions' => $totalTransactions,
            'totalPrescriptions' => $totalPrescriptions,
            'productNames' => $productNames,
            'salesAmounts' => $salesAmounts,
            'quantities' => $quantities,
        ])->with('title', 'Admin | Dashboard');
    }
}
