  <!-- footer_start  -->
  <footer class="footer">
      <h1>GET IN TOUCH</h1>
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
              <form action="">
                    <div>
                      <label for="name"><strong>Name :</strong></label>
                      <input type="text" name="name">
                    </div>
                    <div>
                      <label for="email"><strong>Email :</strong></label>
                      <input type="email" name="email" >
                    </div>
                    <div>
                      <label for="msg"><strong>Message :</strong></label>
                      <textarea name="msg" cols="30" rows="10"></textarea>
                    </div>
                </form>
          </div>
          <div class="mapouter">
              <div class="gmap_canvas">
                  <iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=university%20of%20san%20francisco&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
              </div>
              <style>
                  .mapouter {
                      position: relative;
                      text-align: right;
                      height: 500px;
                      width: 600px;
                  }

                  .gmap_canvas {
                      overflow: hidden;
                      background: none !important;
                      height: 500px;
                      width: 600px;
                  }
              </style>
          </div>

      </div>
  </footer>
  <!-- JS here -->
  <?php wp_footer()?>
  </body>

  </html>