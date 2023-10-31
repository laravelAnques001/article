<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Business - Index</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('indexPage/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('indexPage/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('indexPage/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('indexPage/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('indexPage/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('indexPage/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('indexPage/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/swiper/swiper-bundle.min.css"  rel="stylesheet"/>
    <link href="{{ asset('assets/css/toastr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/toastr_coustom.css') }}" rel="stylesheet" type="text/css">

    <!-- Template Main CSS File -->
    <link href="{{ asset('indexPage/assets/css/style.css') }}" rel="stylesheet">
</head>

<body>

    <!-- ======= Header ======= -->

    <header id="header" class="fixed-top d-flex align-items-center header-transparent">
        <div class="container d-flex align-items-center justify-content-between">

            <div class="logo">
                <img src="{{ asset('indexPage/assets/img/Logo.png') }}" />
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="#system">About Us</a></li>
                    <li><a class="nav-link scrollto" href="#modules">Services</a></li>
                    <!-- <li><a class="nav-link scrollto" href="#advanced-features">Features</a></li> -->
                    <li><a class="nav-link scrollto" href="#interface">Interface</a></li>
                    <li><a class="nav-link scrollto" href="#download">Get App</a></li>
                    <!-- <li><a class="nav-link scrollto" href="#pricing">Pricing</a></li> -->
                    <!-- <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li> -->
                </ul>
                <div class="d-flex justify-content-center">
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </div>
            </nav><!-- .navbar -->
            <div class="navbar-get-button text-center text-lg-start">
                <a href="#inquiry" class="btn-get-started scrollto">Contact Us</a>
            </div>

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero">
      
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-6 pt-5 pt-lg-0 order-lg-2 d-flex align-items-center justify-content-center">
                    <div class="img-hero img-fluid animated w-75" data-aos="zoom-out">
                        <img class="icon-cool-icon" src="{{ asset('indexPage/assets/img/hero-main.png') }}"
                            alt="Admission Icon" />
                        <!-- <h1>Meet The #1 All-In-One <span>School Management</span> System With <span>50+ Modules</span></h1>
            <div class="text-center text-lg-start">
              <a href="#about" class="btn-get-started scrollto">Get Started</a>
            </div> -->
                    </div>
                </div>
                <div class="col-lg-6  order-lg-1  hero-img d-flex align-items-center" data-aos="zoom-out"
                    data-aos-delay="300">
                    <div class="number-icon align-items-center justify-content-center">
                        <h1>InnovateTech: <span>Empowering</span> Mobile Solutions </h1>
                        <p>Explore the cutting-edge world of mobile app technology with InnovateTech. Unleash the power
                            of seamless
                            connectivity, intuitive user experiences, and unparalleled innovation on your mobile device.
                            Stay ahead
                            with the latest advancements at your fingertips.
                        </p>
                        <div class="btn btn-get-started btn-light">Start now</div>
                    </div>
                    <!-- <img src="assets/img/main-banner-img.png" class="img-fluid animated" alt=""> -->
                </div>
            </div>
        </div>

        <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            viewBox="0 24 150 28 " preserveAspectRatio="none">
            <defs>
                <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
            </defs>
            <g class="wave1">
                <use xlink:href="#wave-path" x="50" y="3" fill="rgba(255,255,255, .1)">
            </g>
            <g class="wave2">
                <use xlink:href="#wave-path" x="50" y="0" fill="rgba(255,255,255, .2)">
            </g>
            <g class="wave3">
                <use xlink:href="#wave-path" x="50" y="9" fill="#fff">
            </g>
        </svg>

    </section><!-- End Hero -->

    <main id="main">
        <!-- ======= System Section ======= -->
        <section id="system" class="system">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="w-50" data-aos="zoom-out">
                        <h1>About Our App</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Viverra nunc ante velit vitae. Est
                            tellus vitae,
                            nullam lobortis enim. Faucibus amet etiam tincidunt rhoncus, ullamcorper velit. Ullamcorper
                            risus tempor,
                            ac nunc libero urna, feugiat.</p>
                    </div>
                    <div class="row">
                        <div class="col-md" data-aos="zoom-in" data-aos-delay="200">
                            <div class="card ">
                                <div class="icon-cool-icon-wrapper">
                                    <img class="icon-cool-icon"
                                        src="{{ asset('indexPage/assets/img/system-icon.svg') }}"
                                        alt="Admission Icon" />
                                </div>
                                <div class="feature-title-sec">Creative design</div>
                                <hr class="border-4" />
                                <div class="p">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Viverra nunc ante velit
                                    vitae. Est tellus
                                    vitae, nullam lobortis enim. Faucibus amet etiam tincidunt rhoncus, ullamcorper
                                    velit.
                                </div>
                            </div>
                        </div>
                        <div class="col-md" data-aos="zoom-in" data-aos-delay="100">
                            <div class="card ">
                                <div class="icon-cool-icon-wrapper">
                                    <img class="icon-cool-icon"
                                        src="{{ asset('indexPage/assets/img/system-icon.svg') }}"
                                        alt="Admission Icon" />
                                </div>
                                <div class="feature-title-sec">Easy to use</div>
                                <hr class="border-4" />
                                <div class="p">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Viverra nunc ante velit
                                    vitae. Est tellus
                                    vitae, nullam lobortis enim. Faucibus amet etiam tincidunt rhoncus, ullamcorper
                                    velit.
                                </div>
                            </div>
                        </div>
                        <div class="col-md" data-aos="zoom-in" data-aos-delay="200">
                            <div class="card ">
                                <div class="icon-cool-icon-wrapper">
                                    <img class="icon-cool-icon"
                                        src="{{ asset('indexPage/assets/img/system-icon.svg') }}"
                                        alt="Admission Icon" />
                                </div>
                                <div class="feature-title-sec">Best user experince</div>
                                <hr class="border-4" />
                                <div class="p">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Viverra nunc ante velit
                                    vitae. Est tellus
                                    vitae, nullam lobortis enim. Faucibus amet etiam tincidunt rhoncus, ullamcorper
                                    velit.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ======= system Section end======= -->
        <!-- ======= Powerfull modules Section ======= -->
        <section id="modules" class="modules">
            <div class="container">
                <div class="row justify-content-center">
                    <div data-aos="zoom-out">
                        <h1>Our service</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pharetra arcu at mi
                            <br> maximus,
                            id placerat turpis fringilla. Vivamus fringilla sem scelerisque auctor interdum.
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                            <div class="card border-0 align-items-left ">
                                <div class="icon-cool-icon-wrapper">
                                    <img class="icon-cool-icon" src="{{ asset('indexPage/assets/img/Design.svg') }}"
                                        alt="Admission Icon" />
                                </div>
                                <div class="feature-title-sec">Feed Layout</div>

                                <div class="p">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus hendrerit suscipit
                                    egestas. Nunc eget
                                    congue ante.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                            <div class="card border-0 align-items-left">
                                <div class="icon-cool-icon-wrapper">
                                    <img class="icon-cool-icon" src="{{ asset('indexPage/assets/img/article.svg') }}"
                                        alt="Admission Icon" />
                                </div>
                                <div class="feature-title-sec">Articles</div>

                                <div class="p">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus hendrerit suscipit
                                    egestas. Nunc eget
                                    congue ante.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                            <div class="card border-0 align-items-left">
                                <div class="icon-cool-icon-wrapper">
                                    <img class="icon-cool-icon" src="{{ asset('indexPage/assets/img/Hashtag.svg') }}"
                                        alt="Admission Icon" />
                                </div>
                                <div class="feature-title-sec">Viral Hastag</div>

                                <div class="p">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus hendrerit suscipit
                                    egestas. Nunc eget
                                    congue ante.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                            <div class="card border-0 align-items-left">
                                <div class="icon-cool-icon-wrapper">
                                    <img class="icon-cool-icon" src="{{ asset('indexPage/assets/img/Text.svg') }}"
                                        alt="Admission Icon" />
                                </div>
                                <div class="feature-title-sec">Caption Copywriting </div>

                                <div class="p">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus hendrerit suscipit
                                    egestas. Nunc eget
                                    congue ante.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- ======= powerfull Section end======= -->

        <!-- ======= Feature Section ======= -->
        <!-- <section id="features" class="features">
      <div class="container">
        <div class="row justify-content-center">
          <div data-aos="zoom-out">
            <h1>App Features</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pharetra arcu at mi <br> maximus,
              id placerat turpis fringilla. Vivamus fringilla sem scelerisque auctor interdum. </p>
          </div>
          <div class="row">
            <div class="col-lg-12" data-aos="zoom-in" data-aos-delay="200">
              <div class="card border-0 align-items-left ">
                <div class="icon-cool-icon-wrapper">
                  <img class="icon-cool-icon" src="{{ asset('indexPage/assets/img/Design.svg') }}" alt="Admission Icon" />
                </div>
                <h3>Feed Layout</h3>

                <div class="p">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus hendrerit suscipit egestas. Nunc eget
                  congue ante.
                </div>
              </div>
            </div>
            <div class="col-lg-12 d-flex" data-aos="zoom-in" data-aos-delay="200">
              <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="card border-0 align-items-left ">
                  <div class="icon-cool-icon-wrapper">
                    <img class="icon-cool-icon" src="{{ asset('indexPage/assets/img/Design.svg') }}" alt="Admission Icon" />
                  </div>
                  <h3>Feed Layout</h3>

                  <div class="p">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus hendrerit suscipit egestas. Nunc
                    eget
                    congue ante.
                  </div>
                </div>
                <div class="card border-0 align-items-left ">
                  <div class="icon-cool-icon-wrapper">
                    <img class="icon-cool-icon" src="{{ asset('indexPage/assets/img/Design.svg') }}" alt="Admission Icon" />
                  </div>
                  <h3>Feed Layout</h3>

                  <div class="p">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus hendrerit suscipit egestas. Nunc
                    eget
                    congue ante.
                  </div>
                </div>
              </div>
              <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="feature-flip d-flex align-items-center justify-content-center">
                  <img src="{{ asset('indexPage/assets/img/feature-flip.png') }}" alt="">
                </div>
              </div>
              <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="card border-0 align-items-left ">
                  <div class="icon-cool-icon-wrapper">
                    <img class="icon-cool-icon" src="{{ asset('indexPage/assets/img/Design.svg') }}" alt="Admission Icon" />
                  </div>
                  <h3>Feed Layout</h3>

                  <div class="p">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus hendrerit suscipit egestas. Nunc
                    eget
                    congue ante.
                  </div>
                </div>
                <div class="card border-0 align-items-left ">
                  <div class="icon-cool-icon-wrapper">
                    <img class="icon-cool-icon" src="{{ asset('indexPage/assets/img/Design.svg') }}" alt="Admission Icon" />
                  </div>
                  <h3>Feed Layout</h3>

                  <div class="p">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus hendrerit suscipit egestas. Nunc
                    eget
                    congue ante.
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-12" data-aos="zoom-in" data-aos-delay="200">
              <div class="card border-0 align-items-left ">
                <div class="icon-cool-icon-wrapper">
                  <img class="icon-cool-icon" src="{{ asset('indexPage/assets/img/Design.svg') }}" alt="Admission Icon" />
                </div>
                <h3>Feed Layout</h3>

                <div class="p">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus hendrerit suscipit egestas. Nunc eget
                  congue ante.
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section> -->
        <!-- ======= feature Section end======= -->

        <!-- ======= Checkout Our App Interface Look Section ======= -->
        <section id="interface" class="interface">
            <div class="container  justify-content-center" data-aos="fade-up">

                <div class="w-100" data-aos="zoom-out">
                    <h1>Checkout Our App Interface Look</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Viverra nunc ante velit vitae. Est
                        tellus vitae,
                        nullam lobortis enim. <br> Faucibus amet etiam tincidunt rhoncus, ullamcorper velit. Ullamcorper
                        risus
                        tempor, ac nunc libero urna, feugiat./p>
                </div>
                <div class="swiper mySwiper w-100">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="row event-item">
                                <div class="w-100">
                                    <img src="{{ asset('indexPage/assets/img/interface/01.png') }}" class="img-fluid"
                                        alt="">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="row event-item">
                                <div class="w-100">
                                    <img src="{{ asset('indexPage/assets/img/interface/02.png') }}" class="img-fluid"
                                        alt="">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="row event-item">
                                <div class="w-100">
                                    <img src="{{ asset('indexPage/assets/img/interface/03.png') }}" class="img-fluid"
                                        alt="">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="row event-item">
                                <div class="w-100">
                                    <img src="{{ asset('indexPage/assets/img/interface/04.png') }}" class="img-fluid"
                                        alt="">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="row event-item">
                                <div class="w-100">
                                    <img src="{{ asset('indexPage/assets/img/interface/05.png') }}" class="img-fluid"
                                        alt="">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="row event-item">
                                <div class="w-100">
                                    <img src="{{ asset('indexPage/assets/img/interface/06.png') }}" class="img-fluid"
                                        alt="">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="row event-item">
                                <div class="w-100">
                                    <img src="{{ asset('indexPage/assets/img/interface/07.png') }}" class="img-fluid"
                                        alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
        <!-- End Checkout Our App Interface Look Section -->





        <!-- ======= download our app Section ======= -->
        <section id="download" class="download">
            <div class="container" data-aos="fade-up">
                <div class="row d-flex justify-content-center text-center align-items-center">
                    <div class="col-lg-6 col-md-6 glass-card d-flex align-items-center">
                        <div class="number-icon align-items-right">
                            <div class="texthead">
                                <p>Download App</p>
                            </div>
                            <h3>Easy And Perfect Solution <br> For School Management</h3>
                            <p>Morbi sit egestas dignissim pharetra, sed amet. Tempus justo senectus risus ac vel,
                                velit, nunc. Eget
                                commodo eget in aliquam facilisi facilisi nec magna hendrerit. Placerat ipsum sit tellus
                                urna, faucibus
                                aenean lorem faucibus integer.</p>
                            <img class="star-icon" src="{{ asset('indexPage/assets/img/google-play.png') }}"
                                alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 " data-aos="fade-up" data-aos-delay="100">
                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <div class="about-img">
                                <img class="all-tools-main w-100"
                                    src="{{ asset('indexPage/assets/img/download-main.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ======= download our app Section end======= -->

        <!-- ======= Mobile Section ======= -->
        <!-- <div id="mobile">
      <div data-aos="fade-up" data-aos-delay="100">
        <p class="OurP">Our Product</p>
        <h1>School App, Parent App & Management App</h1>
      </div>
      <div class="container">
        <div class="row row-cols-2 row-cols-lg-3">
          <div class="col">
            <div class="card border-0 mt-3" data-aos="fade-left" data-aos-delay="100">
              <div class="card-body">
                <div class="media d-flex">
                  <div class="align-self-center">
                    <img src="{{ asset('indexPage/assets/img/mobile/1.png') }}" alt="Image" />
                  </div>
                  <div class="media-body text-left">
                    <h3 class="primary">Study Materials</h3>
                    <span>Add and distributed study materials to classes</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="left-side-card">
              <div class="card border-0 mt-5" data-aos="fade-left" data-aos-delay="100">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="align-self-center">
                      <img src="{{ asset('indexPage/assets/img/mobile/2.png') }}" alt="Image" />
                    </div>
                    <div class="media-body text-left">
                      <h3 class="primary">StudentManagement</h3>
                      <span>Manage student records sessions wise </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="left-side">
              <div class="card border-0 mt-5" data-aos="fade-left" data-aos-delay="100">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="align-self-center">
                      <img src="{{ asset('indexPage/assets/img/mobile/3.png') }}" alt="Image" />
                    </div>
                    <div class="media-body text-left">
                      <h3 class="primary">Accountant</h3>
                      <span>Manage fees, expense and income</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col text-center">
            <div class="mobile-img" data-aos="zoom-out">
              <img src="{{ asset('indexPage/assets/img/mobile-bizz.png') }}" alt="Image" />
            </div>
          </div>
          <div class="col">
            <div class="card border-0 mt-3" data-aos="fade-right" data-aos-delay="100">
              <div class="card-body">
                <div class="media d-flex">
                  <div class="align-self-center">
                    <img src="{{ asset('indexPage/assets/img/mobile/4.png') }}" alt="Image" />
                  </div>
                  <div class="media-body text-left">
                    <h3 class="primary">Exam Results</h3>
                    <span>Add and publish exam results</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="right-side-card">
              <div class="card border-0 mt-5" data-aos="fade-right" data-aos-delay="100">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="align-self-center">
                      <img src="{{ asset('indexPage/assets/img/mobile/5.png') }}" alt="Image" />
                    </div>
                    <div class="media-body text-left">
                      <h3 class="primary">Notice Board</h3>
                      <span>Display recent notices using widget</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="right-side">
              <div class="card border-0 mt-5" data-aos="fade-right" data-aos-delay="100">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="align-self-center">
                      <img src="{{ asset('indexPage/assets/img/mobile/6.png') }}" alt="Image" />
                    </div>
                    <div class="media-body text-left">
                      <h3 class="primary">Student dashboard</h3>
                      <span>Separate dashboard for students</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
        <!-- ======= Mobile Section end======= -->

        <!-- ======= pricing Section ======= -->
        <!-- <div id="pricing" class="pricing">
      <div class="container">
        <div class=" text-center" data-aos="zoom-up">
          <h1>Choose Plan That’s Right For You</h1>
          <p>Choose plan that works best for you, feel free to contact us</p>
          <div class="btn-group btn-toggle ">
            <button class="btn  btn-default">Monthly</button>
            <button class="btn  btn-primary active">Yearly</button>
          </div>
        </div>
        <div class="row justify-content-center align-items-center">
          <div class="col-md-6 col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="250">
            <div class="pricingTable">
              <div class="pricingTable-header">
                <i class="fa fa-adjust"></i>
                <div class="price-value"><span class="month">Basic</span>$99 <span class="month-text">/Per month </span>
                </div>
              </div>
              <div class="pricing-content">
                <ul class="g-2">
                  <li>
                    <img src="{{ asset('indexPage/assets/img/blue-pricing.svg') }}" alt=""> Up to 500 students
                  </li>
                  <li>
                    <img src="{{ asset('indexPage/assets/img/blue-pricing.svg') }}" alt=""> Admissions & Enrollment
                  </li>
                  <li>
                    <img src="{{ asset('indexPage/assets/img/blue-pricing.svg') }}" alt=""> Allow family access
                  </li>
                  <li>
                    <img src="{{ asset('indexPage/assets/img/blue-pricing.svg') }}" alt=""> Student & Family Information
                  </li>
                  <li>
                    <img src="{{ asset('indexPage/assets/img/blue-pricing.svg') }}" alt=""> Payments
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="100">
            <div class="pricingTable table-center">
              <div class="pricingTable-header">
                <i class="fa fa-adjust"></i>
                <div class="price-value"><span class="month">Pro</span>$199 <span class="month-text">/Per month </span>
                </div>
              </div>
              <div class="pricing-content">
                <ul>
                  <li>
                    <img src="{{ asset('indexPage/assets/img/white-pricing.svg') }}" alt=""> Up to 1,000 students
                  </li>
                  <li>
                    <img src="{{ asset('indexPage/assets/img/white-pricing.svg') }}" alt=""> Student & Family Information
                  </li>
                  <li>
                    <img src="{{ asset('indexPage/assets/img/white-pricing.svg') }}" alt=""> Admissions & Enrollment
                  </li>
                  <li>
                    <img src="{{ asset('indexPage/assets/img/white-pricing.svg') }}" alt=""> Allow family access
                  </li>
                  <li>
                    <img src="{{ asset('indexPage/assets/img/white-pricing.svg') }}" alt=""> Payments
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="250">
            <div class="pricingTable">
              <div class="pricingTable-header">
                <i class="fa fa-adjust"></i>
                <div class="price-value"><span class="month">Platinum</span>$399 <span class="month-text">/Per month
                  </span> </div>
              </div>
              <div class="pricing-content">
                <ul class="g-2">
                  <li>
                    <img src="{{ asset('indexPage/assets/img/blue-pricing.svg') }}" alt=""> Unlimited students
                  </li>
                  <li>
                    <img src="{{ asset('indexPage/assets/img/blue-pricing.svg') }}" alt=""> Admissions & Enrollment
                  </li>
                  <li>
                    <img src="{{ asset('indexPage/assets/img/blue-pricing.svg') }}" alt=""> Allow family access
                  </li>
                  <li>
                    <img src="{{ asset('indexPage/assets/img/blue-pricing.svg') }}" alt=""> Student & Family Information
                  </li>
                  <li>
                    <img src="{{ asset('indexPage/assets/img/blue-pricing.svg') }}" alt=""> Payments
                  </li>
                </ul>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div> -->
        <!-- ======= pricing Section end======= -->



        <!-- Quick Inquiry Section -->
        <section id="inquiry" class="inquiry">
            <div class="container" data-aos="fade-up">
                <div data-aos="zoom-out">
                    <h1>Quick <span>Inquiry</span></h1>
                    <p>Let Us help you Get The Information You Need</p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="wrapper">
                            <div class="row">

                                <div class="col-lg-7 col-md-7  d-flex align-items-stretch">
                                    <div class="contact-wrap w-100 p-md-5 p-4">
                                        <form method="POST" id="contactForm" action="{{ route('contactUs') }}"
                                            class="contactForm" data-aos="fade-left">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group">
                                                    <h5>Get in touch</h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="name"
                                                            id="name" placeholder="Name">
                                                    </div>
                                                    @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="email" class="form-control" name="email"
                                                            id="email" placeholder="Email">
                                                    </div>
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="subject"
                                                            id="subject" placeholder="Subject">
                                                    </div>
                                                    @error('subject')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <textarea name="message" class="form-control" id="message" cols="30" rows="4" placeholder="Message"></textarea>
                                                    </div>
                                                    @error('message')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 button-send">
                                                    <div class="form-group">
                                                        <div class="text-center text-lg-start">
                                                            <button type="submit"
                                                                class="btn-get-started scrollto">Send message</button>
                                                        </div>
                                                        <div class="submitting"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- <div class="col-lg-5 col-md-5 d-flex align-items-right">
              <img src="{{ asset('indexPage/assets/img/quick-inquiry-main.png') }}" alt="">
            </div> -->

                                <div class="col-lg-5 col-md-5 mobile d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('indexPage/assets/img/Inquiry-main.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- End Quick Inquiry Section -->

    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-info">
                            <div class="logo">
                                <img src="{{ asset('indexPage/assets/img/Logo.png') }}" />
                            </div>
                            <p class="pb-3">we are not here to sell you <br> products, we sell value through <br> our
                                expertise.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-4 footer-links">
                        <h4>Pages</h4>
                        <ul>
                            <li> <a href="#hero">Home</a></li>
                            <li> <a href="#system">About Us</a></li>
                            <li> <a href="#advanced-features">Features</a></li>
                            <li> <a href="#modules">Services</a></li>
                            <li> <a href="#download">Our Products</a></li>
                            <li> <a href="#pricing">Pricing</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-6 footer-links">
                        <h4>Services</h4>
                        <ul>
                            <li> <a href="#touch">Contact Us</a></li>
                            <li> <a href="#">Blog</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>contact</h4>
                        <ul>
                            <li><i class='bx bxs-phone px-2'></i> <a href="#">+91 8221004100</a></li>
                            <li> <i class='bx bxs-envelope px-2'></i> <a
                                    href="#">business.flip.help@gmail.com</a></li>
                            <li> <i class='bx bxs-map px-2'></i> <a href="#">Haryana</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-newsletter">
                        <h4>Social media </h4>
                        <div class="social-links">
                            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                        </div>
                        <!-- <form action="" method="post">
                <input type="email" name="email"><input type="submit" value="Subscribe">
              </form> -->

                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>Business-Flip</span></strong>. All Rights Reserved |
                <strong><span>Privacy
                        Policy</span></strong>
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i>
            <img src="{{ asset('indexPage/assets/img/back-to-top.svg') }}" alt="Image"
                class="client-img" /></i></a>
    <div id="preloader"></div>



    <!-- Vendor JS Files -->
    <script src="{{ asset('indexPage/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <!-- <script src="path/to/bootstrap.min.js"></script> -->
    <script src="{{ asset('indexPage/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('indexPage/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('indexPage/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('indexPage/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('indexPage/assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('indexPage/assets/js/main.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    {{--  <script type="text/javascript" src="{{asset('assets/js/core/libraries/jquery.min.js')}}"></script>  --}}
    {{--  <script>
        @if (Session::has('success'))
        toastr.success("{{Session::get('success') }}", 'Success');
        @php
        Session::forget('success')
        @endphp
        @endif
        @if (Session::has('error'))
        toastr.error("{{ Session::get('error') }}", 'Error');
        @php
        Session::forget('error')
        @endphp
        @endif
      </script>  --}}

</body>

</html>
-
