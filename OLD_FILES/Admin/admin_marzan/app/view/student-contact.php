<div id="content">
	<div class="row">
		<h1>Contact Us</h1>
		<form action="sendContactForm" method="post"  class="sends-email ctc-form" >
			<label><span class="ctc-hide">Name</span>
				<input type="text" name="name" placeholder="Name:">
			</label>
			<label><span class="ctc-hide">Address</span>
				<input type="text" name="address" placeholder="Address:">
			</label>
			<label><span class="ctc-hide">Email</span>
				<input type="text" name="email" placeholder="Email:">
			</label>
			<label><span class="ctc-hide">Phone</span>
				<input type="text" name="phone" placeholder="Phone:">
			</label>
			<label><span class="ctc-hide">Message</span>
				<textarea name="message" cols="30" rows="10" placeholder="Message:"></textarea>
			</label>
			<label for="g-recaptcha-response"><span class="ctc-hide">Recaptcha</span></label>
			<div class="g-recaptcha"></div>
			<label>
				<input type="checkbox" name="consent" class="consentBox">I hereby consent to having this website store my submitted information so that they can respond to my inquiry.
			</label><br>
			<?php if( $this->siteInfo['policy_link'] ): ?>
			<label>
				<input type="checkbox" name="termsConditions" class="termsBox"/> I hereby confirm that I have read and understood this website's <a href="<?php $this->info("policy_link"); ?>" target="_blank">Privacy Policy.</a>
			</label>
			<?php endif ?>
			<button type="submit" class="ctcBtn" disabled>Submit</button>
		</form>
	</div>
</div>


