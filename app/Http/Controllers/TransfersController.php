<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Models\Account;
use App\Models\Transfer;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class TransfersController extends Controller
{
    public function store(TransferRequest $request)
    {
        // create valid payload
        $payload = $request->only(
            [
                'source_account_id',
                'destination_account_id',
                'amount'
            ]
        );

        try {
            DB::beginTransaction();

            // update source
            $sourceAccount = Account::find($payload['source_account_id']);
            if ($sourceAccount->deposit_amount < $payload['amount']) {
                return Response::json([
                    'result' => 'Source account has not enough credit!'
                ]);
            }
            $sourceAccount->update([
                'deposit_amount' => $sourceAccount->deposit_amount - $payload['amount'],
                'updated_at' => Carbon::now()
            ]);

            // update destination
            $destinationAccount = Account::find($payload['destination_account_id']);
            $destinationAccount->update([
                'deposit_amount' => $destinationAccount->deposit_amount + $payload['amount'],
                'updated_at' => Carbon::now()
            ]);


            // create transfer
            $transfer = Transfer::create($payload);

            DB::commit();
            return $transfer;

        } catch (\Exception $exception) {
            DB::rollBack();
            throw new HttpResponseException(response()->json($exception->getMessage(), 501));
        }
    }
}
