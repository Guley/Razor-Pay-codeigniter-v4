<?php namespace App\Controllers;
require_once(APPPATH."Libraries/razorpay/razorpay-php/Razorpay.php");
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
class Home extends BaseController
{

    public function index() {
        $data['page_desc'] = 'Pricing';
        $data['template_file'] = 'pricing/pricing';
        return $this->load_view($data);
    }
    public function buynow($price){
    	
        $api = new Api(RAZOR_KEY, RAZOR_SECRET_KEY);
        /**
         * You can calculate payment amount as per your logic
         * Always set the amount from backend for security reasons
         */
        $razorpayPricing = $api->order->create(array(
            'receipt'         => rand(),
            'amount'          => $price*100, // 2000 rupees in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ));

        $amount = $razorpayPricing['amount'];
        $razorpayOrderId = $razorpayPricing['id'];

        $postData=['name'=>'Sample','email'=>'sample@email.com','contact'=>'9876543210'];
        $pricingDetails = ['title'=>'Subscription'];
        $data = $this->prepareData($amount,$razorpayOrderId,$postData,$pricingDetails);

        //save data in database here;

        $data['template_file'] = 'inc/rezorpay';
        $data['page_title'] = 'Pay Now';
        $data['page_desc'] = 'Pay Now';
        $data['data'] = $data;
        $data['add_custom_js'] = "
options.handler = function (response){
    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
    document.getElementById('razorpay_signature').value = response.razorpay_signature;
    document.getElementById('razorpay_order_id').value = '".$razorpayOrderId."';
    document.razorpayform.submit();
};

// Boolean whether to show image inside a white frame. (default: true)
options.theme.image_padding = false;

options.modal = {
    ondismiss: function() {
        console.log('This code runs when the popup is closed');
    },
    backdropclose: false
};

var rzp = new Razorpay(options);
$(document).ready(function(e){
    console.log('window loaded');
      $('#rzp-button1').click();
    rzp.open();
    event.preventDefault();
});
     ";
        return $this->load_view($data, 'layout');

    }
    /**
     * This function verifies the payment,after successful payment
     */
    public function verify()
    {
        //log_message('error','post==='.json_encode($_POST));
        $success = true;
        $error = "payment_failed";
        if (empty($_POST['razorpay_payment_id']) === false) {
            $api = new Api(RAZOR_KEY, RAZOR_SECRET_KEY);
        try {
                $attributes = array(
                    'razorpay_order_id' => $_POST['razorpay_order_id'],
                    'razorpay_payment_id' => $_POST['razorpay_payment_id'],
                    'razorpay_signature' => $_POST['razorpay_signature']
                );
                $result = $api->utility->verifyPaymentSignature($attributes);
                 //log_message('error','result==='.json_encode($result));
            } catch(SignatureVerificationError $e) {
                $success = false;
                $result = $e->getMessage();
                log_message('error','error==='.json_encode($result));
            }
        }
        if ($success === true) {
            /**
             * Call this function from where ever you want
             * to save save data before of after the payment
             */
            //redirectsuccess
            $this->setSession(['razorpay_order_id'=>$_POST['razorpay_order_id']]);
            return redirect()->to(base_url('home/success'));
        }
        else {
            //redirect failed
           return redirect()->to(base_url('home/failed'));
        }
    }

    /**
     * This function preprares payment parameters
     * @param $amount
     * @param $razorpayOrderId
     * @return array
     */
    public function prepareData($amount,$razorpayOrderId,$postData,$pricingDetails)
    {

        $data = array(
            "key" => RAZOR_KEY,
            "amount" => $amount,
            "name" => $pricingDetails['title'],
            "description" => "Pay for subscription",
            "image" => "",
            "prefill" => array(
                "name"  => $postData['name'],
                "email"  => $postData['email'],
                "contact" => $postData['contact']
            ),
            "notes"  => array(
                "address"  => "Mohali,India",
                "merchant_order_id" => rand(),
            ),
            "theme"  => array(
                "color"  => "#F37254"
            ),
            "order_id" => $razorpayOrderId,
        );
        return $data;
    }
    /**
     * This is a function called when payment successfull,
     * and shows the success message
     */
    public function success()
    {
    	if(!$this->session->has('razorpay_order_id')){
    		return redirect()->to(base_url());
    	}
    	$data['razorpay_order_id'] = $this->isSession('razorpay_order_id');
    	$this->session->remove('razorpay_order_id');
        $data['template_file'] = 'pricing/success';
        $data['page_title'] = 'Success';
        $data['page_desc'] = 'Success';
        return $this->load_view($data, 'layout');
    }
    /**
     * This is a function called when payment failed,
     * and shows the error message
     */
    public function paymentFailed()
    {
        $data['template_file'] = 'pricing/error';
        $data['page_title'] = 'Success';
        $data['page_desc'] = 'Success';
        return $this->load_view($data, 'layout');
    }
    
}