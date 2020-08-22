  <!-- footer_start  -->
  <?php

function get_extra_field()
{

    ?>
            <div>
                    <label for="name"><strong>Name :</strong></label>
                    <input class="input" type="text" required placeholder="Enter your name" name="name">
             </div>
            <div>
                    <label for="email"><strong>Email :</strong></label>
                    <input class="input" type="email" required placeholder="Enter your email" name="email">
            </div>
    <?php

}

?>
  <footer class="footer">
      <h1>GET IN TOUCH</h1>
      <div class="footer_wrapper">
          <div class="info_container">
              <div class="address">
                  <span><i class="fas fa-map-marked-alt"></i></span>
                  <h3>ADDRESS</h3>
                  <p>Weifield Group Contracting</p>
                  <p>6950 S. Jordan Road</p>
                  <p>Centennial, CO 80112</p>
              </div>
              <div class="phone">
                  <span><i class="fas fa-phone-alt"></i></span>
                  <h3>PHONE</h3>
                  <p>Weifield Group Contracting</p>
                  <p>Phone : 222-366-999</p>
                  <p>Phone : 222-366-588</p>
              </div>
              <div class="email">
                  <span><i class="fas fa-at"></i></span>
                  <h3>EMAIL</h3>
                  <p>Weifield Group Contracting</p>
                  <p>jhon_doe@gmail.com</p>
                  <p>Phone : 222-366-588</p>
              </div>
          </div>
          <div class="contact_container">
              <div class="contact_form">
                  <form id="oe-contact-us-form">
                      <input type="hidden" name="action" value="contact_us">
                      <span style="display:none;" class="sent-msg"></span>
                      <?php !is_user_logged_in() ? get_extra_field() : ""?>
                      <div class="textarea">
                          <label for="msg"><strong>Message :</strong></label>
                          <textarea required class="input" placeholder="Your message here..." name="msg" cols="30" rows="5"></textarea>
                      </div>
                      <input class="reg-btn" type="submit" value="Send">
                  </form>
              </div>
          </div>
          <div class="dev_info">
            <h4>Developed By : AR Arif</h4>
            <h4>Email : dev.dr.arif@gmail.com</h4>
          </div>
      </div>
  </footer>
  <!-- JS here -->
  <?php wp_footer()?>
  </body>

  </html>