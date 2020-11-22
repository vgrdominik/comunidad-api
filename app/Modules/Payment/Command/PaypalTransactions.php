<?php

namespace App\Modules\Payment\Command;

use Illuminate\Console\Command;

class PaypalTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paystat:paypal_transaction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recover the last week transactions and update database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function getPaypalAccessToken()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api-m.sandbox.paypal.com/v1/oauth2/token");
        // SSL important
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, env('PAYPAL_CLIENT_ID') . ':' . env('PAYPAL_SECRET'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Accept-Language: en_US',
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS , 'grant_type=client_credentials');

        $output = json_decode(curl_exec($ch));
        curl_close($ch);

        return $output->access_token;
    }

    protected function getLastTransactions($accessToken)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api-m.sandbox.paypal.com/v1/reporting/transactions?start_date=2020-11-01T00:00:00-0700&end_date=2020-11-30T23:59:59-0700");
        // SSL important
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Authorization: Bearer ' . $accessToken,
        ));

        $output = json_decode(curl_exec($ch));
        curl_close($ch);

        return $output;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Init getting transactions from paypal...');

        $paypalAccessToken = $this->getPaypalAccessToken();
        $this->info('Access token obtained.');

        $lastTransactions = $this->getLastTransactions($paypalAccessToken);
        var_dump($lastTransactions);

        $this->info('End getting transactions from paypal...');
    }
}
