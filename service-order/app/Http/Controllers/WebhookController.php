<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\PaymentLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WebhookController extends Controller
{
    public function midtransHandler(Request $request){
        $data = $request->all();
        $signatureKey = $data['signature_key'];
        $orderId = $data['order_id'];
        $statusCode = $data['status_code'];
        $grossAmount = $data['gross_amount'];
        $transactionStatus = $data['transaction_status'];
        $paymentType = $data['payment_type'];
        $transactionStatus = $data['transaction_status'];
        $fraudStatus = $data['fraud_status'];
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $mySignatureKey = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);
        
        // return $mySignatureKey;
        
        if($signatureKey !== $mySignatureKey){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid signature.'
            ], 400);
        }

        $realOrderId = explode('-', $orderId);
        $order = Order::find($realOrderId)->first();
        
        if(!$order){
            return response()->json([
                'status' => 'error',
                'message' => 'Order data not available.'
            ], 404);
        }

        // return $order;

        if($order->status === 'success'){
            return response()->json([
                'status' => 'error',
                'message' => 'Operation not permitted.'
            ], 405);
        }

        if ($transactionStatus == 'capture') {
            if ($paymentType == 'credit_card'){
              if($fraudStatus == 'challenge'){
                $order->update(['status' => 'challenge']);
                }
                else {
                $order->update(['status' => 'success']);
            }
              }
        } else if ($transactionStatus == 'settlement'){
            $order->update(['status' => 'success']);
        } else if($transactionStatus == 'pending'){
            $order->update(['status' => 'pending']);
        } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $order->update(['status' => 'failure']);
        }

        $logData = [
            'status' => $transactionStatus,
            'raw_response' => json_encode($data),
            'order_id' => $realOrderId[0],
            'payment_type' => $paymentType
        ];

        $paymentLog = PaymentLog::create($logData);

        return response()->json([
            'order' => $order,
            'logData' => $paymentLog
        ]);

        if($order->status === 'success'){
            createPremiumAccess([
                'user_id' => $order->user_id,
                'course_id' => $order->course_id,
            ]);
        }

        return response()->json('Ok');
    }
}
