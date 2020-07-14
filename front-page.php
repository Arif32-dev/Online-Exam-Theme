<?php get_header('header.php')?>
<div class="banner">
    <div class="overlay"></div>
    <div class="info">
        <h1>Gurudayal University</h1>
        <h2>A dream university to read</h2>
        <button>Read More</button>
    </div>
</div>

<section class='dept_wrap'>
    <h1>Our Departments</h1>
    <div class="department">
        <a>Mathmatics</a>
        <a>Physics</a>
        <a>Biology</a>
        <a>English</a>
        <a>Bangla</a>
        <a>Religion</a>
        <a>Chemistry</a>
        <a>Economics</a>
    </div>
</section>
<section class="teacher-wrap">
    <h1>Our Teacher's</h1>
    <div class="teacher_container">
        <div class="teacher_info">
            <div class="side_logo">
                <img src="<?php echo get_template_directory_uri() . '/public/assets/img/avatar.png' ?>" alt="">
            </div>
            <div class="teacher_details">
                <div class="row">
                    <span><strong>Name :</strong>Arifur Rahman Arif</span>
                    <span><strong>Department :</strong>Computer Science</span>
                    <span><strong>Phone :</strong>01874127669</span>
                </div>
                <button>View Teacher</button>
            </div>
        </div>
        <div class="teacher_info">
            <div class="side_logo">
                <img src="<?php echo get_template_directory_uri() . '/public/assets/img/avatar.png' ?>" alt="">
            </div>
            <div class="teacher_details">
                <div class="row">
                    <span><strong>Name :</strong>Arifur Rahman Arif</span>
                    <span><strong>Department :</strong>Computer Science</span>
                    <span><strong>Phone :</strong>01874127669</span>
                </div>
                <button>View Teacher</button>
            </div>
        </div>
        <div class="teacher_info">
            <div class="side_logo">
                <img src="<?php echo get_template_directory_uri() . '/public/assets/img/avatar.png' ?>" alt="">
            </div>
            <div class="teacher_details">
                <div class="row">
                    <span><strong>Name :</strong>Arifur Rahman Arif</span>
                    <span><strong>Department :</strong>Computer Science</span>
                    <span><strong>Phone :</strong>01874127669</span>
                </div>
                <button>View Teacher</button>
            </div>
        </div>
        <div class="teacher_info">
            <div class="side_logo">
                <img src="<?php echo get_template_directory_uri() . '/public/assets/img/avatar.png' ?>" alt="">
            </div>
            <div class="teacher_details">
                <div class="row">
                    <span><strong>Name :</strong>Arifur Rahman Arif</span>
                    <span><strong>Department :</strong>Computer Science</span>
                    <span><strong>Phone :</strong>01874127669</span>
                </div>
                <button>View Teacher</button>
            </div>
        </div>
        <div class="teacher_info">
            <div class="side_logo">
                <img src="<?php echo get_template_directory_uri() . '/public/assets/img/avatar.png' ?>" alt="">
            </div>
            <div class="teacher_details">
                <div class="row">
                    <span><strong>Name :</strong>Arifur Rahman Arif</span>
                    <span><strong>Department :</strong>Computer Science</span>
                    <span><strong>Phone :</strong>01874127669</span>
                </div>
                <button>View Teacher</button>
            </div>
        </div>

    </div>
</section>
<section class="notice">
    <h1>Notice Board</h1>
    <div class="notice_container">
        <div href="http://www.facebook.com" class="upcoming">
            <h2>Upcoming Exam's</h2>
            <a href="http://www.facebook.com">
                <h3>Department : Biology</h3>
                <h3>Exam Name : Biology Exam</h3>
                <span><strong>Date :</strong>10/07/2020</span>
            </a>

        </div>
        <div class="previous">
            <h2>Previous Exam's</h2>
            <a>
                <h3>Department : Mathmatics</h3>
                <h3>Exam Name : Math Exam</h3>
                <span><strong>Date :</strong>10/07/2020</span>
            </a>
            <a>
                <h3>Department : Mathmatics</h3>
                <h3>Exam Name : Math Exam</h3>
                <span><strong>Date :</strong>10/07/2020</span>
            </a>
            <a>
                <h3>Department : Mathmatics</h3>
                <h3>Exam Name : Math Exam</h3>
                <span><strong>Date :</strong>10/07/2020</span>
            </a>
        </div>
    </div>
</section>
<section class="oe_google_map">
    <h1>Our Location</h1>
    <div class="mapouter">
        <div class="gmap_canvas">
            <iframe  id="gmap_canvas" src="https://maps.google.com/maps?q=university%20of%20san%20francisco&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
        </div>
    </div>
</section>
<?php get_footer('footer.php')?>