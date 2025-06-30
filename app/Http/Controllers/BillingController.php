<?php

namespace App\Http\Controllers;

use App\Models\DoctorCommission;
use App\Models\Admission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BillingController extends Controller
{
    public function index()
    {
        // Fetch the commission rate for each doctor from the doctor_commissions table
        $doctorCommissionRates = DoctorCommission::pluck('commission_amount', 'doctor_id');

        // Filter for unpaid admissions
        $admissions = Admission::with(['patient', 'room', 'doctorCommissions.doctor'])
            ->whereNotNull('discharge_date')
            ->where('payment_status', '!=', 'paid') // This line filters for unpaid bills
            ->get();

        $billings = $admissions->map(function ($admission) {
            $totalRoomBill = $this->calculateTotalRoomBill($admission);
            $totalCommission = $this->calculateTotalCommission($admission);

            // Ensure payment_status is always set, defaulting to 'pending' if not set
            $paymentStatus = $admission->payment_status ?? 'pending';

            return [
                'admission' => $admission,
                'daysStayed' => Carbon::parse($admission->admission_date)->diffInDays($admission->discharge_date ?? now()),
                'totalBill' => $totalRoomBill + $totalCommission,
                'paymentStatus' => $paymentStatus,
            ];
        });

        return view('billing.index', compact('billings'));
    }

    public function selectPaymentMethod($id)
    {
        $admission = Admission::findOrFail($id);
        return view('billing.selectPaymentMethod', compact('admission'));
    }

    public function processSelectedPayment(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,e_cash',
        ]);

        $admission = Admission::findOrFail($id);
        DB::beginTransaction();
        try {
            $totalRoomBill = $this->calculateTotalRoomBill($admission);
            $totalCommission = $this->calculateTotalCommission($admission);
            $totalBill = $totalRoomBill + $totalCommission;

            $method = $request->input('payment_method');
            Log::info('Payment successful for Admission ID: ' . $admission->id . ', Amount: ' . $totalBill . ', Method: ' . $method);

            // Update payment status and total bill
            $admission->update([
                'payment_status' => 'paid',
                'total_bill' => $totalBill,
            ]);

            DB::commit();
            return redirect()->route('billing.index')->with('success', 'Payment processed successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Payment processing error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Error processing payment: ' . $e->getMessage());
        }
    }

    private function calculateTotalRoomBill($admission)
    {
        $dischargeDate = Carbon::parse($admission->discharge_date ?? now());
        $admissionDate = Carbon::parse($admission->admission_date);
        $daysStayed = $admissionDate->diffInDays($dischargeDate);
        return $daysStayed * $admission->room->price;
    }

    private function calculateTotalCommission($admission)
    {
        $totalCommission = 0;
        foreach ($admission->doctorCommissions as $commission) {
            $visitCount = $admission->inpatientMedicalRecords()
                ->where('doctor_id', $commission->doctor_id)
                ->distinct('patient_id')
                ->count();
            $totalCommission += $visitCount * $commission->commission_amount;
        }
        return $totalCommission;
    }
}