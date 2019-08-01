<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Order;

class PaysonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createCheckout($id)
    {

        $product = Product::findOrFail($id);
        $user    = \Auth::user();
        $quantity = (isset($_GET['quantity']) && ! empty($_GET['quantity'])) ? floatval($_GET['quantity']) : 1;

        try {
            // Include library
            include(app_path() . '/Libraries/paysonpayments/include.php');
            
            $agentId = env('PAYSON_AGENT_ID');
            $apiKey  = env('PAYSON_API_KEY');
            $apiUrl  = \Payson\Payments\Transport\Connector::TEST_BASE_URL;

            // Init the connector
            $connector = \Payson\Payments\Transport\Connector::init($agentId, $apiKey, $apiUrl);
            // Create the client
            $checkoutClient = new \Payson\Payments\CheckoutClient($connector);
            // Get protocol for URLs
            $protocol = 'http://';
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                $protocol = 'https://';
            }
            
            // Checkout dataproduct
            $checkoutData = array(
                'customer' => array(
                    'identityNumber' => '4605092222',
                    'postalCode'     => '99999',
                    'email'          => $user->email,
                    'firstName'      => $user->name,
                ),
                'order' => array(
                    'currency' => 'eur',
                    'items' => array(
                        array(
                            'name'      => $product->title,
                            'quantity'  => $quantity,
                            'unitPrice' => $product->price,
                            'taxRate'   => 0.25
                        ), 
                    )
                ),
                'merchant' => array(
                    'termsUri'        => str_replace(basename($_SERVER['PHP_SELF']), 'terms', $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']),
                    'checkoutUri'     => "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
                    'confirmationUri' => $protocol . $_SERVER['HTTP_HOST'] . '/checkout/confirmation' . '?ref=co2',
                    'notificationUri' => $protocol . $_SERVER['HTTP_HOST'] . '/checkout/notification' . '?ref=co2'
                ),
                'gui' => array(
                    'colorScheme' => 'White',
                    'locale'      => 'en'
                )
            );

            // Create checkout
            $paysonCheckout = $checkoutClient->create($checkoutData);
            
            // Save checkout ID (token) in cookie for use on confirmation page
            setcookie('checkoutId', $paysonCheckout['id'], time()+60*60*24*365, '/');
            setcookie('checkoutQuantity', $quantity, time()+60*60*24*365, '/');
            
            return view('checkout', [
                'paysonCheckout' => $paysonCheckout
            ]);

        } catch(\Exception $e) {
            // Print error message and error code
            print($e->getMessage() . $e->getCode());
        }
    }

    public function confirmation()
    {

        try {
            if (isset($_COOKIE['checkoutId']) && $_COOKIE['checkoutId'] != '') {
                $checkoutId = $_COOKIE['checkoutId'];
                $checkoutQuantity = $_COOKIE['checkoutQuantity'];
                
                // Reset cookie
                unset($_COOKIE['checkoutId']);
                unset($_COOKIE['checkoutQuantity']);
                setcookie('checkoutId', '', time()-60*60*24*365, '/');
                setcookie('checkoutQuantity', '', time()-60*60*24*365, '/');
                    
                // Include library
                include(app_path() . '/Libraries/paysonpayments/include.php');
                        
                $agentId = env('PAYSON_AGENT_ID');
                $apiKey  = env('PAYSON_API_KEY');
                $apiUrl  = \Payson\Payments\Transport\Connector::TEST_BASE_URL;

                // Init the connector
                $connector = \Payson\Payments\Transport\Connector::init($agentId, $apiKey, $apiUrl);
            
                if (isset($_GET['ref']) && $_GET['ref'] == 'co2') {
                    // Query parameter ref is for this example only
                    // Handle Payson Checkout 2.0 confirmation
                    // Create the client
                    $checkoutClient = new \Payson\Payments\CheckoutClient($connector);
                    
                    // Get checkout
                    $paysonCheckout = $checkoutClient->get(array('id' => $checkoutId));
                    
                    switch ($paysonCheckout['status']) {
                        case 'readyToShip':
                            Order::create([
                                'checkout_id' => $checkoutId,
                                'count'       => $checkoutQuantity,
                                'user_id'     => \Auth::user()->id,
                            ]);
                            return view('confirmation', [
                                'paysonCheckout' => $paysonCheckout
                            ]);
                            break;
                        case 'created':
                        case 'readyToPay':
                        case 'denied':
                        case 'canceled':
                        case 'expired':
                        case 'shipped':
                        case 'paidToAccount':
                        case 'denied':
                        default:
                            throw new \Exception('Unable to show confirmation! Status: ' . $paysonCheckout['status']);
                    }
                    
                } elseif (isset($_GET['ref']) && $_GET['ref'] == 'prs') {
                    // Query parameter ref is for this example only
                    // Handle subscription confirmation
                    // Create the client
                    $recurringSubscriptionClient = new \Payson\Payments\RecurringSubscriptionClient($connector);
                    
                    // Get recurring subscription checkout
                    $recurringSubscriptionCheckout = $recurringSubscriptionClient->get(array('id' => $checkoutId));
                    
                    switch ($recurringSubscriptionCheckout['status']) {
                        case 'customerSubscribed':
                            // Print recurring subscription checkout ID
                            print('<h3 style="text-align:center;">Subscription ID: ' . $recurringSubscriptionCheckout['id'] . '</h3><hr />');
                            
                            // Print the recurring subscription checkout snippet
                            print_r($recurringSubscriptionCheckout['snippet'], false);
                            break;
                        case 'created':
                        case 'awaitingSubscription':
                        case 'customerUnsubscribed':
                        case 'canceled':
                        case 'expired':
                        default:
                            throw new \Exception('Unable to show confirmation! Status: ' . $recurringSubscriptionCheckout['status']);
                    }
                } else {
                    throw new \Exception('Unknown ref! ');
                }
            } else {
                return redirect('catalog');
            }
            
        } catch(\Exception $e) {
            // Print error message and error code
            print($e->getMessage() . $e->getCode());
        }
    }

}
