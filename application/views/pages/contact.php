<!-- Start contact-page Area -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/linearicons.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/linearicons.css">

<section class="contact-page-area">
    <div class="container">
        <div class="row">
            <div class="map-wrap" style="width:100%; height: 445px;" id="map"></div>
            <?php
                if(isset($error)){
                    ?>
                    <div class="col-sm-12 col-md-12">
                        <div class="alert alert-danger">
                            <strong>Error!</strong> <span><?php echo $error; ?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <?php
                }

                if(isset($success)){
                    ?>
                    <div class="col-sm-12 col-md-12">
                        <div class="alert alert-success">
                            <strong>Success!</strong> <span><?php echo $success; ?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <?php
                }

                if(isset($info)){
                    ?>
                    <div class="col-sm-12 col-md-12">
                        <div class="alert alert-info">
                            <strong>Info!</strong> <span><?php if(isset($info)){ echo $info; } ?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <?php
                }
            ?>
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
                <form class="form-area " id="myForm" action="<?php echo base_url(); ?>pages
                /queryMail" method="post" class="contact-form text-right">
                    <div class="row">	
                        <div class="col-lg-6 form-group">
                            <input name="name" placeholder="Enter your name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" class="common-input mb-20 form-control" required="" type="text">
                        
                            <input name="email" placeholder="Enter email address" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" class="common-input mb-20 form-control" required="" type="email">

                            <input name="subject" placeholder="Enter your subject" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your subject'" class="common-input mb-20 form-control" required="" type="text">
                            <div class="mt-20 alert-msg" style="text-align: left;"></div>
                        </div>
                        <div class="col-lg-6 form-group">
                            <textarea class="common-textarea form-control" name="message" placeholder="Messege" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Messege'" required=""></textarea>
                            <button class="primary-btn mt-20 text-white" style="float: right;">Send Message</button>
                                                                    
                        </div>
                    </div>
                </form>	
            </div>
        </div>
    </div>	
</section>
<!-- End contact-page Area -->

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPdIJSVZPvHbRyewVKTfd6GoYnzuXOtyU"></script>
<script>
    (function () {
        // The location of cords
        var cords = {lat: 21.6183614, lng: 78.4993452};
        // The map, centered at cords
        var map = new google.maps.Map(
            document.getElementById('map'), {zoom: 14, center: cords});
        // The marker, positioned at cords
        var marker = new google.maps.Marker({position: cords, map: map});
    }());
</script>
