<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Get all payments (ទាញយកការទូទាត់ទាំងអស់ រួមជាមួយព័ត៌មាន Order)
    public function show()
    {
        $payments = Payment::with('order')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Payments retrieved successfully',
            'data' => $payments
        ], 200);
    }

    // Get payment by ID
    public function search($id)
    {
        $payment = Payment::with('order')->find($id);

        if ($payment === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment not found!!!',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Payment retrieved successfully',
            'data' => $payment
        ], 200);
    }

    // Post (Create new Payment record)
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id'       => 'required|integer|exists:orders,id',
            'method'         => 'required|string', // e.g., 'aba_payway', 'khqr', 'visa', 'cash_on_delivery'
            'amount'         => 'required|numeric|min:0',
            'status'         => 'nullable|string|in:pending,completed,failed,refunded',
            'transaction_id' => 'nullable|string|unique:payments,transaction_id',
            'paid_at'        => 'nullable|date',
        ]);
        // កំណត់ Status ជា pending ប្រសិនបើគ្មានការផ្ញើមក
        $data['status'] = $data['status'] ?? 'pending';

        // ប្រសិនបើ status គឺ completed ហើយ paid_at មិនបានផ្ញើមកទេ ឱ្យ Back-end ដាក់ម៉ោងបច្ចុប្បន្នស្វ័យប្រវត្ត
        if (isset($data['status']) && $data['status'] === 'completed' && empty($data['paid_at'])) {
            $data['paid_at'] = now();
        }

        $payment = Payment::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Payment recorded successfully!!!',
            'data' => $payment->load('order')
        ], 201);
    }

    // Put (Update payment status or details)
    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);

        if ($payment === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment not found!!!',
                'data' => []
            ], 404);
        }

        $data = $request->validate([
            'order_id'       => 'required|integer|exists:orders,id',
            'method'         => 'required|string',
            'amount'         => 'required|numeric|min:0',
            'status'         => 'required|string|in:pending,completed,failed,refunded',
            'transaction_id' => 'nullable|string|unique:payments,transaction_id,' . $id,
            'paid_at'        => 'nullable|date',
        ]);

        // ប្រសិនបើកែប្រែ status ទៅជា completed ហើយគ្មាន paid_at ទេ ឱ្យចាប់យកម៉ោងបច្ចុប្បន្ន
        if ($data['status'] === 'completed' && empty($data['paid_at'])) {
            $data['paid_at'] = now();
        }

        $payment->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Payment updated successfully!!!!',
            'data' => $payment->load('order')
        ], 200);
    }

    // Delete (Remove payment record)
    public function destroy($id)
    {
        $payment = Payment::find($id);

        if ($payment === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment not found!!!',
                'data' => []
            ], 404);
        }

        $payment->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Payment deleted successfully!!!!'
        ], 200);
    }
}
