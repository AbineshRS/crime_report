<?php include("Nav.php") ?>


<!-- contact section -->
<section class="contact_section layout_padding">
  <div class="container-fluid">
    <div class="row g-4 align-items-stretch">
      <!-- Map Column -->
      <div class="col-md-6 px-4">
        <div id="map" class="h-100 w-100 rounded-3 overflow-hidden shadow">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.0198106742353!2d-122.42067958468193!3d37.77492927975986!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80858064df3d5e1b%3A0x8f1c3f503c752c56!2sSan%20Francisco%2C%20CA!5e0!3m2!1sen!2sus!4v1681243186402!5m2!1sen!2sus" 
            width="100%" 
            height="400" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy">
          </iframe>
        </div>
      </div>

      <!-- Contact Form Column -->
      <div class="col-md-6 px-4">
        <div class="contact_box p-4 bg-light rounded-3 shadow">
          <form action="">
            <input type="text" class="form-control mb-3" placeholder="Your Name">
            <input type="email" class="form-control mb-3" placeholder="Email">
            <input type="text" class="form-control mb-3" placeholder="Phone Number">
            <textarea class="form-control mb-3" placeholder="Message" rows="4"></textarea>
            <div>
              <button type="submit" class="btn btn-primary w-100">
                Submit
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- end contact section -->

<?php include("Footer.php") ?>