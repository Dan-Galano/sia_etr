<!DOCTYPE html>
<html lang="en" class="no-js">

<head>

    <!--- basic page needs
    ================================================== -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to PSUnify!</title>

    <script>
        document.documentElement.classList.remove('no-js');
        document.documentElement.classList.add('js');
    </script>

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <!-- favicons
    ================================================== -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/PSUnifylogo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/scrollbar.css') }}">
</head>


<body id="top">


    <!-- preloader
    ================================================== -->
    <div id="preloader">
        <div id="loader"></div>
    </div>


    <!-- page wrap
    ================================================== -->
    <div id="page" class="s-pagewrap">


        <!-- # site header
        ================================================== -->
        <header class="s-header">

            <div class="row s-header__inner">

                <div class="s-header__block">
                    <div class="s-header__logo">
                        <a class="logo" href="{{ route('landing') }}">
                            <img src="images/PSUnifylogo.png" alt="Homepage">
                        </a>
                    </div>

                    <a class="s-header__menu-toggle" href="#0"><span>Menu</span></a>
                </div> <!-- end s-header__block -->

                <nav class="s-header__nav">

                    <ul class="s-header__menu-links">
                        <li class="current"><a href="#intro" class="smoothscroll">Home</a></li>
                        <li><a href="#about" class="smoothscroll">About</a></li>
                        <li><a href="#services" class="smoothscroll">Services</a></li>
                        <li><a href="#folio" class="smoothscroll">Features</a></li>
                        <li><a href="#footer" class="smoothscroll">Contact</a></li>
                    </ul> <!-- s-header__menu-links -->

                    <ul class="s-header__social" style="align-items: center;">
                        <li>
                            <a href="{{ route('signin') }}" style="color: white; margin-right: 10px; "
                                onmouseover="this.style.color='rgb(230, 157, 1)'" onmouseout="this.style.color='white'">
                                SIGN IN
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('signup') }}"
                                style="background-color: rgb(230, 157, 1); color:white; padding: 10px 20px"
                                onmouseover="this.style.color='#051e42'" onmouseout="this.style.color='white'">
                                GET STARTED
                            </a>
                        </li>
                    </ul> <!-- s-header__social -->

                </nav> <!-- end s-header__nav -->

            </div> <!-- end s-header__inner -->

        </header> <!-- end s-header -->


        <!-- # site-content
        ================================================== -->
        <section id="content" class="s-content">


            <!-- intro
            ----------------------------------------------- -->
            <section id="intro" class="s-intro target-section">

                <div class="s-intro__bg"></div>

                <div class="row s-intro__content">

                    <div class="s-intro__content-bg"></div>

                    <div class="column lg-12 s-intro__content-inner">

                        <h1 class="s-intro__content-title">
                            Empowering Leaders, <br> Enabling Progress
                        </h1>

                        <div class="s-intro__content-buttons">
                            <a href="#about" class="btn btn--stroke s-intro__content-btn smoothscroll">Learn More</a>
                            <a href="https://www.youtube.com/embed/2cXjamzRnHM?si=tYDulGCBO25XBOb9"
                                class="s-intro__content-video-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                    <path d="M7 6v12l10-6z"></path>
                                </svg>
                            </a>
                        </div>

                    </div> <!-- s-intro__content-inner -->

                </div> <!-- s-intro__content -->

                <div class="s-intro__scroll-down">
                    <a href="#about" class="smoothscroll">
                        <span>Scroll Down</span>
                    </a>
                </div> <!-- s-intro__scroll-down -->

            </section> <!-- end s-intro -->


            <!-- about
            ----------------------------------------------- -->
            <section id="about" class="s-about target-section">

                <div class="row section-header" data-num="01">
                    <h3 class="column lg-12 section-header__pretitle pretitle text-pretitle">Who We Are</h3>
                    <div class="column lg-6 stack-on-1100 section-header__primary">
                        <h2 class="title text-display-1">
                            A platform designed to support the vibrant student organizations of Pangasinan State
                            University. We are committed to empowering leaders and members by providing innovative tools
                            that simplify management, enhance communication, and foster collaboration.
                        </h2>
                    </div>
                    <div class="column lg-6 stack-on-1100 section-header__secondary">
                        <p class="desc">
                            Our goal is to bridge the gap between organizations and the university, creating a thriving
                            campus environment where students can connect, grow, and achieve their goals. At our core,
                            we celebrate leadership, teamwork, and the pursuit of excellence.
                        </p>
                    </div>
                </div> <!-- end section-header -->

                <div class="row process-list list-block show-ctr block-lg-one-half block-tab-whole">

                    <div class="column list-block__item">
                        <div class="list-block__title">
                            <h3 class="h5">Empower</h3>
                        </div>
                        <div class="list-block__text">
                            <p>
                                We're all about giving you the tools to take charge. PSUnify puts the power in your
                                hands, so you can plan events, engage members, and run your group like a pro.
                            </p>
                        </div>
                    </div> <!-- end list-block__item -->

                    <div class="column list-block__item">
                        <div class="list-block__title">
                            <h3 class="h5">Engage</h3>
                        </div>
                        <div class="list-block__text">
                            <p>
                                Let's bring your organization closer to others. Build collaborations, strengthen bonds,
                                and be part of a thriving campus community.
                            </p>
                        </div>
                    </div> <!-- end list-block__item -->

                    <div class="column list-block__item">
                        <div class="list-block__title">
                            <h3 class="h5">Innovate</h3>
                        </div>
                        <div class="list-block__text">
                            <p>
                                We're always looking for new ways to make things better. PSUnify is packed with cool
                                features and simple designs to make your life easier and your student experience more
                                awesome.
                            </p>
                        </div>
                    </div> <!-- end list-block__item -->

                    <div class="column list-block__item">
                        <div class="list-block__title">
                            <h3 class="h5">Inspire</h3>
                        </div>
                        <div class="list-block__text">
                            <p>
                                We're here to spark creativity and encourage you to dream big. Together, let's make your
                                campus experience more dynamic and impactful.
                            </p>
                        </div>
                    </div> <!-- end list-block__item -->

                </div> <!-- end process-list -->

            </section> <!-- end s-about -->


            <!-- services
            ----------------------------------------------- -->
            <section id="services" class="s-services target-section">

                <div class="row section-header" data-num="02">
                    <h3 class="column lg-12 section-header__pretitle text-pretitle">What We Do</h3>
                    <div class="column lg-6 stack-on-1100 section-header__primary">
                        <h2 class="title text-display-1">
                            At PSUnify, empowering student organizations through streamlined management, enhanced
                            collaboration, and
                            seamless communication, we provide an all-in-one platform to simplify tasks, connect
                            members, and support leaders.
                        </h2>
                    </div>
                    <div class="column lg-6 stack-on-1100 section-header__secondary">
                        <p class="desc">
                            Our mission is to enhance the way student organizations operate, helping them thrive and
                            contribute to a vibrant campus community. Whether you're managing events, accessing
                            resources, or building connections, the portal is your partner in creating a dynamic and
                            unified student experience.
                        </p>
                    </div>
                </div> <!-- end section-header -->

                <div class="row services-list list-block block-lg-one-half block-tab-whole">

                    <div class="column list-block__item">
                        <div class="list-block__title">
                            <div class="list-block__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                    <path
                                        d="m6.516 14.323-1.49 6.452a.998.998 0 0 0 1.529 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082a1 1 0 0 0-.59-1.74l-5.701-.454-2.467-5.461a.998.998 0 0 0-1.822 0L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.214 4.107zm2.853-4.326a.998.998 0 0 0 .832-.586L12 5.43l1.799 3.981a.998.998 0 0 0 .832.586l3.972.315-3.271 2.944c-.284.256-.397.65-.293 1.018l1.253 4.385-3.736-2.491a.995.995 0 0 0-1.109 0l-3.904 2.603 1.05-4.546a1 1 0 0 0-.276-.94l-3.038-2.962 4.09-.326z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="h5">Organization Management</h3>
                        </div>
                        <div class="list-block__text">
                            <p>
                                Managing your organization is now effortless with the PSU Student Organization Portal.
                                Easily update your organization's profile, including its vision, mission, and
                                objectives, while maintaining an organized membership roster. Securely store essential
                                documents like constitutions and bylaws for quick access. The portal also streamlines
                                event planning, enabling you to create, promote, and manage events to keep your
                                organization thriving.
                            </p>
                        </div>
                    </div> <!-- end list-block__item -->

                    <div class="column list-block__item">
                        <div class="list-block__title">
                            <div class="list-block__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                    <path
                                        d="m21.406 6.086-9-4a1.001 1.001 0 0 0-.813 0l-9 4c-.02.009-.034.024-.054.035-.028.014-.058.023-.084.04-.022.015-.039.034-.06.05a.87.87 0 0 0-.19.194c-.02.028-.041.053-.059.081a1.119 1.119 0 0 0-.076.165c-.009.027-.023.052-.031.079A1.013 1.013 0 0 0 2 7v10c0 .396.232.753.594.914l9 4c.13.058.268.086.406.086a.997.997 0 0 0 .402-.096l.004.01 9-4A.999.999 0 0 0 22 17V7a.999.999 0 0 0-.594-.914zM12 4.095 18.538 7 12 9.905l-1.308-.581L5.463 7 12 4.095zM4 16.351V8.539l7 3.111v7.811l-7-3.11zm9 3.11V11.65l7-3.111v7.812l-7 3.11z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="h5">Communication</h3>
                        </div>
                        <div class="list-block__text">
                            <p>
                                Effective communication is at the heart of every successful organization. Through the
                                portal, you can keep your members informed with timely announcements and updates.
                                Discussion forums provide a space for interactive conversations, where members can
                                exchange ideas, collaborate on initiatives, and foster a sense of belonging within the
                                organization.
                            </p>
                        </div>
                    </div> <!-- end list-block__item -->

                    <div class="column list-block__item">
                        <div class="list-block__title">
                            <div class="list-block__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                    <path
                                        d="M6 14c-2.206 0-4 1.794-4 4s1.794 4 4 4a4.003 4.003 0 0 0 3.998-3.98H10V16h4v2.039h.004A4.002 4.002 0 0 0 18 22c2.206 0 4-1.794 4-4s-1.794-4-4-4h-2v-4h2c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4v2h-4V5.98h-.002A4.003 4.003 0 0 0 6 2C3.794 2 2 3.794 2 6s1.794 4 4 4h2v4H6zm2 4c0 1.122-.879 2-2 2s-2-.878-2-2 .879-2 2-2h2v2zm10-2c1.121 0 2 .878 2 2s-.879 2-2 2-2-.878-2-2v-2h2zM16 6c0-1.122.879-2 2-2s2 .878 2 2-.879 2-2 2h-2V6zM6 8c-1.121 0-2-.878-2-2s.879-2 2-2 2 .878 2 2v2H6zm4 2h4v4h-4v-4z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="h5">Networking and Collaboration</h3>
                        </div>
                        <div class="list-block__text">
                            <p>
                                Collaboration is the key to growth and innovation. The portal connects organizations
                                across the campus, allowing you to discover opportunities to work together on impactful
                                projects and events. By building partnerships with other organizations, you can expand
                                your reach, pool resources, and create a stronger, more united campus community.
                            </p>
                        </div>
                    </div> <!-- end list-block__item -->

                    <div class="column list-block__item">
                        <div class="list-block__title">
                            <div class="list-block__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                    <path
                                        d="M20 3H4c-1.103 0-2 .897-2 2v11c0 1.103.897 2 2 2h4l-1.8 2.4 1.6 1.2 2.7-3.6h3l2.7 3.6 1.6-1.2L16 18h4c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zM4 16V5h16l.001 11H4z">
                                    </path>
                                    <path d="M6 12h4v2H6z"></path>
                                </svg>
                            </div>
                            <h3 class="h5">Resources</h3>
                        </div>
                        <div class="list-block__text">
                            <p>
                                Access to essential resources is crucial for smooth operations. The PSU Student
                                Organization Portal provides comprehensive access to university policies and procedures
                                related to student organizations. These resources ensure that your organization remains
                                compliant and well-informed, enabling leaders and members to focus on achieving their
                                goals with confidence.
                            </p>
                        </div>
                    </div> <!-- end list-block__item -->





                </div> <!-- end process-list -->

            </section> <!-- end s-services -->


            <!-- portfolio
            ----------------------------------------------- -->
            <section id="folio" class="s-folio target-section">

                <div class="row section-header light-on-dark" data-num="03">
                    <h3 class="column lg-12 section-header__pretitle text-pretitle">PSUnify Features</h3>
                    <div class="column lg-6 stack-on-1100 section-header__primary">
                        <h2 class="title text-display-1">
                            PSUnify simplifies organization management and enhances student engagement.
                        </h2>
                    </div>
                    <div class="column lg-6 stack-on-1100 section-header__secondary">
                        <p class="desc">
                            We are dedicated to enhancing the experience of managing and participating in student
                            organizations. Our platform is built around four main features that ensure streamlined
                            operations, effective communication, and meaningful collaboration.
                        </p>
                    </div>
                </div> <!-- end section-header -->

                <div id="bricks" class="row bricks">
                    <div class="column lg-12 masonry">
                        <div class="bricks-wrapper">

                            <div class="grid-sizer"></div>

                            <article class="brick brick--double entry">
                                <a href="#modal-01" class="entry__link">
                                    <div class="entry__thumb">
                                        <img src="images/folio/white_turban@2x.png" alt="">
                                    </div>
                                    <div class="entry__info">
                                        <div class="entry__cat">FEATURE</div>
                                        <h4 class="entry__title">Account Creation</h4>
                                    </div>
                                </a>
                            </article> <!-- entry -->

                            <article class="brick brick--double entry">
                                <a href="#modal-02" class="entry__link">
                                    <div class="entry__thumb">
                                        <img src="images/folio/caffeine_and_tulips@2x.png" alt="">
                                    </div>
                                    <div class="entry__info">
                                        <div class="entry__cat">FEATURE</div>
                                        <h4 class="entry__title">Join & Engage</h4>
                                    </div>
                                </a>
                            </article> <!-- entry -->

                            <article class="brick entry">
                                <a href="#modal-03" class="entry__link">
                                    <div class="entry__thumb">
                                        <img src="images/folio/grayscale@2x.png" alt="">
                                    </div>
                                    <div class="entry__info">
                                        <div class="entry__cat">FEATURE</div>
                                        <h4 class="entry__title">Post Viewing & Interaction</h4>
                                    </div>
                                </a>
                            </article> <!-- entry -->

                            <article class="brick entry">
                                <a href="#modal-04" class="entry__link">
                                    <div class="entry__thumb">
                                        <img src="images/folio/lamp@2x.png" alt="">
                                    </div>
                                    <div class="entry__info">
                                        <div class="entry__cat">FEATURE</div>
                                        <h4 class="entry__title">Chat Functionality</h4>
                                    </div>
                                </a>
                            </article> <!-- entry -->

                            <article class="brick entry">
                                <a href="#modal-05" class="entry__link">
                                    <div class="entry__thumb">
                                        <img src="images/folio/tropical@2x.png" alt="">
                                    </div>
                                    <div class="entry__info">
                                        <div class="entry__cat">FEATURE</div>
                                        <h4 class="entry__title">Profile Customization</h4>
                                    </div>
                                </a>
                            </article> <!-- entry -->

                            <article class="brick entry">
                                <a href="#modal-06" class="entry__link">
                                    <div class="entry__thumb">
                                        <img src="images/folio/woodcraft@2x.png" alt="">
                                    </div>
                                    <div class="entry__info">
                                        <div class="entry__cat">FEATURE</div>
                                        <h4 class="entry__title">Reporting Functionality</h4>
                                    </div>
                                </a>
                            </article> <!-- entry -->

                        </div> <!-- end bricks-wrapper -->
                    </div> <!-- end masonry -->
                </div> <!-- end bricks -->


                <!-- modal templates popup
                -------------------------------------------- -->
                <div id="modal-01" hidden>
                    <div class="modal-popup">
                        <img src="images/folio/gallery/g-turban.jpg" alt="">

                        <div class="modal-popup__desc">
                            <h5>Account Creation</h5>
                            <p>Easily create accounts for students and organizers, simplifying access to PSUnify's
                                features.</p>
                        </div>

                    </div>
                </div> <!-- end modal -->

                <div id="modal-02" hidden>
                    <div class="modal-popup">
                        <img src="images/folio/gallery/g-tulips.jpg" alt="">

                        <div class="modal-popup__desc">
                            <h5>Join & Engage</h5>
                            <p>Explore and participate in student organizations seamlessly, connecting with like-minded
                                peers.</p>
                        </div>

                    </div>
                </div> <!-- end modal -->

                <div id="modal-03" hidden>
                    <div class="modal-popup">
                        <img src="images/folio/gallery/g-grayscale.png" alt="">

                        <div class="modal-popup__desc">
                            <h5>Post Viewing & Interaction</h5>
                            <p>Stay updated with organization posts and interact with content through likes and
                                comments.</p>
                        </div>

                    </div>
                </div> <!-- end modal -->

                <div id="modal-04" hidden>
                    <div class="modal-popup">
                        <img src="images/folio/gallery/g-lamp.png" alt="">

                        <div class="modal-popup__desc">
                            <h5>Chat Functionality</h5>
                            <p>Communicate instantly with members through PSUnify's chat feature, fostering community
                                interaction.</p>
                        </div>

                    </div>
                </div> <!-- end modal -->

                <div id="modal-05" hidden>
                    <div class="modal-popup">

                        <img src="images/folio/gallery/g-tropical.png" alt="">

                        <div class="modal-popup__desc">
                            <h5>Profile Customization</h5>
                            <p>Personalize your profile to showcase your interests and accomplishments, enhancing your
                                PSUnify experience.</p>
                        </div>

                    </div>
                </div> <!-- end modal -->

                <div id="modal-06" hidden>
                    <div class="modal-popup">
                        <img src="images/folio/gallery/g-woodcraft.png" alt="">

                        <div class="modal-popup__desc">
                            <h5>Reporting Functionality</h5>
                            <p>Ensure a safe and inclusive community by reporting inappropriate behavior for prompt
                                action.</p>
                        </div>

                    </div>
                </div> <!-- end modal -->



            </section> <!-- end s-folio -->


            <!-- testimonials
            ----------------------------------------------- -->
            <section id="testimonials" class="s-testimonials">

                <div class="row s-testimonials__content">
                    <div class="column lg-12">

                        <div class="swiper-container s-testimonials__slider">

                            <div class="swiper-wrapper">

                                <div class="s-testimonials__slide swiper-slide">
                                    <div class="s-testimonials__author">
                                        <img src="images/avatars/user-02.png" alt="Author image"
                                            class="s-testimonials__avatar">
                                        <cite class="s-testimonials__cite">
                                            <strong>Juan Dela Cruz</strong>
                                            <span>BS Computer Engineering</span>
                                        </cite>
                                    </div>
                                    <p>
                                        Sobrang cool ng PSUnify! Dito, madali kaming nakakapag-plano at nakakapag-usap
                                        ng mga kasama sa org. Solid, salamat sa PSUnify sa support!
                                    </p>
                                </div> <!-- end s-testimonials__slide -->

                                <div class="s-testimonials__slide swiper-slide">
                                    <div class="s-testimonials__author">
                                        <img src="images/avatars/user-03.jpg" alt="Author image"
                                            class="s-testimonials__avatar">
                                        <cite class="s-testimonials__cite">
                                            <strong>Mae Santos</strong>
                                            <span>BS Civil Engineering.</span>
                                        </cite>
                                    </div>
                                    <p>
                                        Ang galing ng PSUnify! Nakakatuwa kasi mas madali na naming napaplano ang mga
                                        activities namin sa org. Solid ng features, sulit na sulit!
                                    </p>
                                </div> <!-- end s-testimonials__slide -->

                                <div class="s-testimonials__slide swiper-slide">
                                    <div class="s-testimonials__author">
                                        <img src="images/avatars/user-01.png" alt="Author image"
                                            class="s-testimonials__avatar">
                                        <cite class="s-testimonials__cite">
                                            <strong>John Smith</strong>
                                            <span>AB English</span>
                                        </cite>
                                    </div>
                                    <p>
                                        Grabe, sobrang helpful ng PSUnify! Hindi na kami nalilito sa pag-organize ng mga
                                        events sa org namin. Ang saya lang!
                                    </p>
                                </div> <!-- end s-testimonials__slide -->

                                <div class="s-testimonials__slide swiper-slide">
                                    <div class="s-testimonials__author">
                                        <img src="images/avatars/user-06.jpg" alt="Author image"
                                            class="s-testimonials__avatar">
                                        <cite class="s-testimonials__cite">
                                            <strong>Maria Garcia</strong>
                                            <span>BS Information Technology</span>
                                        </cite>
                                    </div>
                                    <p>
                                        Astig ng PSUnify! Sobrang dali ng paggamit, pati mga kasama sa org, mas nagiging
                                        active dahil dito. Salamat, PSUnify!
                                    </p>
                                </div> <!-- end s-testimonials__slide -->

                            </div> <!-- end swiper-wrapper -->

                            <div class="swiper-pagination"></div>

                        </div> <!-- end swiper-container -->

                    </div> <!-- end column -->
                </div> <!-- end s-testimonials__content -->

            </section> <!-- end testimonials -->

        </section>  <!-- end content -->


        <!-- # site-footer
        ================================================== -->
        <footer id="footer" class="s-footer target-section">

            <div class="row section-header" data-num="04">
                <h3 class="column lg-12 section-header__pretitle text-pretitle">Get In Touch</h3>
                <div class="column lg-6 stack-on-1100 section-header__primary">
                    <h2 class="title text-display-1">
                        Got suggestions, feedback, or ideas to improve PSUnify? Reach out to us at <a
                            href="mailto:psunify@gmail.com" title="psunify@gmail.com">psunify@gmail.com</a> and let's
                        collaborate and make PSUnify even better together!
                    </h2>
                </div>
                <div class="column lg-6 stack-on-1100 section-header__secondary">

                    <div class="contact-block">
                        <h6>Where To Find Us</h6>
                        <p>
                            McArthur Highway, Brgy. San Vicente,<br>
                            Urdaneta City, Pangasinan<br>
                            2428
                        </p>
                    </div>

                    <div class="contact-block">
                        <h6>Contact Info</h6>
                        <ul class="contact-list">
                            <li><a href="tel:09123456789">0912-345-6789</a></li>
                        </ul>
                    </div>

                </div>
            </div> <!-- end section-header -->


            <div class="row s-footer__bottom">

                <div class="column lg-4 tab-12 s-footer__bottom-left">
                    <ul class="s-footer__social">
                        <li>
                            <span>Alvaro | Salcedo | Cayaban | <br>Tomas | Galano</span><br>
                        </li>
                    </ul>
                </div>

                <div class="column lg-4 tab-12 s-footer__bottom-left">
                    <li>
                        <span>BSIT 4A | A.Y. 2024-2025</span><br>
                    </li>
                </div>

                <div class="column lg-4 tab-12 s-footer__bottom-right">
                    <div class="ss-copyright">
                        <span>© For Educational Purposes Only</span>
                        <span>Credits to <a href="https://www.styleshout.com/">Mueller</a></span>
                    </div>
                </div>

            </div> <!-- s-footer__bottom -->

            <div class="ss-go-top">
                <a class="smoothscroll" title="Back to Top" href="#top">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        style="fill: rgba(7, 48, 75, 1);transform: ;msFilter:;">
                        <path d="M6 4h12v2H6zm5 10v6h2v-6h5l-6-6-6 6z"></path>
                    </svg>
                </a>
            </div> <!-- end ss-go-top -->

        </footer> <!-- end footer -->


        <!-- Java Script
    ================================================== -->
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
</body>

</html>
