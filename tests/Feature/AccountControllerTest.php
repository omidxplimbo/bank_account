<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Transfer;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_account()
    {
        // Creating
        DB::beginTransaction();
        $account = Account::create([
            'owner' => 'omid dehghan',
            'deposit_amount' => random_int(1000, 500000),
        ]);

        // Simulated get account
        $response = $this->json('get', route('account_show', ['id' => $account->id]));

        // Determine whether the account has been successful created and receive it
        $response->assertStatus(200);
        $response->assertJson($account->toArray());

        DB::rollBack();
    }

    public function test_create_transfer()
    {

        DB::beginTransaction();

        // update source
        $sourceAccount = Account::create([
            'owner' => 'omid dehghan',
            'deposit_amount' => random_int(1000, 500000),
        ]);

        $sourceAccount->update([
            'deposit_amount' => $sourceAccount->deposit_amount - 500,
        ]);

        // update destination
        $destinationAccount = Account::create([
            'owner' => 'omid dehghan',
            'deposit_amount' => random_int(1000, 500000),
        ]);
        $destinationAccount->update([
            'deposit_amount' => $destinationAccount->deposit_amount + 500,
        ]);


        // create transfer
        $transfer = Transfer::create([
            'source_account_id' => $sourceAccount->id,
            'destination_account_id' => $destinationAccount->id,
            'amount' => 500
        ]);

        $response = $this->json('get', route('account_transfers', ['id' => $transfer->id]));
        $response->assertStatus(200);
        DB::rollBack();
    }
}
