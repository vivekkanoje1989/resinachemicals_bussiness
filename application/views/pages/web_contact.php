<!-- start banner Area -->
<section class="banner-area relative" id="home">	
    <div class="overlay overlay-bg"></div>
    <div class="container">
        <div class="row d-flex align-items-center justify-content-center">
            <div class="about-content col-lg-12">
                <h1 class="text-white">
                    Contact Us
                </h1>	
                <p class="text-white link-nav"><a href="<?php echo base_url(); ?>pages/loadView/web_home">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="<?php echo base_url(); ?>pages/loadView/web_contact"> Contact Us</a></p>
            </div>											
        </div>
    </div>
</section>
<!-- End banner Area -->	

<!-- Start contact-page Area -->
<section class="contact-page-area section-gap">
    <div class="container">
        <div class="row">
            <div class="map-wrap" style="width:100%; height: 445px;" id="map"></div>
            
            <div class="col-lg-4 d-flex flex-column address-wrap">
                <div class="single-contact-address d-flex flex-row">
                    <div class="icon">
                        <span class="lnr lnr-home"></span>
                    </div>
                    <div class="contact-details">
                        <h5>KH. No. 501/9,</h5>
                        <p>Mordongri,</p>
                        <p>Nagpur - Bhopal Highway Road,</p>
                        <p>Pandhurna, Madhya Pradesh 480334</p>
                    </div>
                </div>
                <div class="single-contact-address d-flex flex-row">
                    <div class="icon">
                        <span class="lnr lnr-phone-handset"></span>
                    </div>
                    <div class="contact-details">
                        <h5>0 99222 33445</h5>
                        <h5>0 97307 68629</h5>
                        <p>10am to 8 pm</p>
                    </div>
                </div>
                <div class="single-contact-address d-flex flex-row">
                    <div class="icon">
                        <span class="lnr lnr-envelope"></span>
                    </div>
                    <div class="contact-details"
                        <h5>resinachemicals@gmail.com</h5>
                        <p>Send us your query anytime!</p>
                    </div>
                </div>														
            </div>
            <div class="col-lg-8">
                <form class="form-area contact-form text-right" id="idContactForm" action="<?php echo base_url(); ?>pages/queryMail" method="post">
                    <div class="row">	
                        <div class="col-lg-6 form-group">
                            <input type="text" id="idClientName" name="name" placeholder="Enter your name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" class="common-input mb-20 form-control" required >
                        
                            <input type="email" id="idClientEmail" name="email" placeholder="Enter email address" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" class="common-input mb-20 form-control" required >

                            <input type="text" id="idEmailSubject" name="subject" placeholder="Enter your subject" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your subject'" class="common-input mb-20 form-control" required >
                            <div class="mt-20 alert-msg" style="text-align: left; color: #d61453;"></div>
                        </div>
                        <div class="col-lg-6 form-group">
                            <textarea class="common-textarea form-control" id="idEmailMsg" name="message" placeholder="Messege" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Messege'" required></textarea>
                            <button class="primary-btn mt-20 text-white submit-btn" style="float: right;">Send Message</button>
                        </div>
                    </div>
                </form>	
            </div>
        </div>
    </div>	
</section>
<!-- End contact-page Area -->
