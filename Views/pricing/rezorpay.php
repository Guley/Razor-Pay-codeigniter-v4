<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<button id="rzp-button1" style="display:none;">Pay with Razorpay</button>
<form name='razorpayform' id="razorpayform" action="<?php echo base_url().'/home/verify';?>" method="POST">
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
    <input type="hidden" name="razorpay_order_id"  id="razorpay_order_id" >
</form>
<script type="text/javascript">
    var options = <?php echo json_encode($data);?>;
</script>
