
<div class="container">
	<div class="row">
		<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
			<div class="card card-signin my-5">
				<div class="card-body">
					<center>
						<h5 class="card-title text-center">Payment successful !</h5>
						<p>Your order ID : <?php echo $razorpay_order_id;?></p>
						<a href="<?php echo base_url();?>" class="btn btn-primary">New Payment</a>
					</center>
				</div>
			</div>
		</div>
	</div>
</div>