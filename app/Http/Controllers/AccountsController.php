<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Models\Account;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Response;

class AccountsController extends Controller
{
    public function store(AccountRequest $request)
    {
        // create valid payload
        $payload = $request->only(['deposit_amount', 'owner']);

        try {
            return Account::create($payload);
        } catch (\Exception $exception) {
            throw new HttpResponseException(response()->json($exception->getMessage(), 422));
        }
    }

    public function show($id)
    {
        $account = Account::find($id);
        if (!$account){
            return Response::json([
                'result'=>'Account not found!'
            ]);
        }
        return $account;
    }

    public function transfers($id)
    {
        $account = Account::with(['transfersFrom','transfersTo'])->find($id);
        if (!$account){
            return Response::json([
                'result'=>'Account not found!'
            ]);
        }
        return $account;
    }
}
