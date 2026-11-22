<?php
    include_once('hms/include/config.php');
    if(isset($_POST['submit']))
        {
            $name=$_POST['fullname'];
            $email=$_POST['emailid'];
            $mobileno=$_POST['mobileno'];
            $dscrption=$_POST['description'];
            $query=mysqli_query($con,"insert into tblcontactus(fullname,email,contactno,message) value('$name','$email','$mobileno','$dscrption')");
            echo "<script>alert('Your information succesfully submitted');</script>";
            echo "<script>window.location.href ='index.php'</script>";
        } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCare Hospital - Professional Healthcare Services</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981'
                    },
                    borderRadius: {
                        'none': '0px',
                        'sm': '4px',
                        DEFAULT: '8px',
                        'md': '12px',
                        'lg': '16px',
                        'xl': '20px',
                        '2xl': '24px',
                        '3xl': '32px',
                        'full': '9999px',
                        'button': '8px'
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #1f2937;
        }
        
        .smooth-scroll {
            scroll-behavior: smooth;
        }
        
        .fade-in {
            opacity: 0;
            transform: translateY(2rem);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .slide-in-left {
            opacity: 0;
            transform: translateX(-2rem);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        
        .slide-in-left.visible {
            opacity: 1;
            transform: translateX(0);
        }
        
        .slide-in-right {
            opacity: 0;
            transform: translateX(2rem);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        
        .slide-in-right.visible {
            opacity: 1;
            transform: translateX(0);
        }
        
        .scale-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .scale-hover:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .header-sticky {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -0.25rem;
            left: 0;
            width: 0;
            height: 2px;
            background: #3B82F6;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3B82F6, #1D4ED8);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #1D4ED8, #1E40AF);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }
        
        .form-input {
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        
        .form-input:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .accordion-content.active {
            max-height: 200px;
        }
        
        .carousel-container {
            overflow: hidden;
        }
        
        .carousel-track {
            display: flex;
            transition: transform 0.5s ease;
        }
        
        .hero-bg {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(16, 185, 129, 0.05));
        }
        
        .medical-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%233B82F6' fill-opacity='0.03'%3E%3Cpath d='M30 30c0-11.046-8.954-20-20-20s-20 8.954-20 20 8.954 20 20 20 20-8.954 20-20zm0 0c0 11.046 8.954 20 20 20s20-8.954 20-20-8.954-20-20-20-20 8.954-20 20z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .loading-spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
        
        .gallery-item {
            transition: transform 0.3s ease;
        }
        
        .gallery-item:hover {
            transform: scale(1.02);
        }
        
        .testimonial-card {
            min-width: 100%;
            transition: opacity 0.5s ease;
        }
        
        @media (min-width: 768px) {
            .testimonial-card {
                min-width: 50%;
            }
        }
        
        @media (min-width: 1024px) {
            .testimonial-card {
                min-width: 33.333%;
            }
        }
    </style>
</head>
<body class="smooth-scroll">
    <header id="header" class="fixed top-0 left-0 right-0 z-50 bg-white shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 flex items-center justify-center bg-primary text-white rounded-lg">
                        <i class="ri-hospital-line text-xl"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-900">MediCare</span>
                </div>
                
                <nav class="hidden lg:flex items-center space-x-8">
                    <a href="#home" class="nav-link text-sm font-medium text-gray-700 hover:text-primary">Home</a>
                    <a href="#about" class="nav-link text-sm font-medium text-gray-700 hover:text-primary">About</a>
                    <a href="#departments" class="nav-link text-sm font-medium text-gray-700 hover:text-primary">Departments</a>
                    <a href="#doctors" class="nav-link text-sm font-medium text-gray-700 hover:text-primary">Doctors</a>
                    <a href="#services" class="nav-link text-sm font-medium text-gray-700 hover:text-primary">Services</a>
                    <!-- <a href="#appointment" class="nav-link text-sm font-medium text-gray-700 hover:text-primary">Appointment</a> -->
                    <a href="#gallery" class="nav-link text-sm font-medium text-gray-700 hover:text-primary">Gallery</a>
                    <a href="#blog" class="nav-link text-sm font-medium text-gray-700 hover:text-primary">Blog</a>
                    <a href="#faq" class="nav-link text-sm font-medium text-gray-700 hover:text-primary">FAQ</a>
                    <a href="#contact" class="nav-link text-sm font-medium text-gray-700 hover:text-primary">Contact</a>
                </nav>
                
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex items-center space-x-2 text-sm">
                        <div class="w-8 h-8 flex items-center justify-center">
                            <i class="ri-phone-line text-primary"></i>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Emergency</div>
                            <div class="font-semibold text-gray-900">+1 (555) 123-4567</div>
                        </div>
                    </div>
                    <button id="mobile-menu-btn" class="lg:hidden w-8 h-8 flex items-center justify-center">
                        <i class="ri-menu-line text-xl text-gray-700"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div id="mobile-menu" class="lg:hidden bg-white border-t hidden">
            <div class="px-4 py-4 space-y-2">
                <a href="#home" class="block py-2 text-sm font-medium text-gray-700">Home</a>
                <a href="#about" class="block py-2 text-sm font-medium text-gray-700">About</a>
                <a href="#departments" class="block py-2 text-sm font-medium text-gray-700">Departments</a>
                <a href="#doctors" class="block py-2 text-sm font-medium text-gray-700">Doctors</a>
                <a href="#services" class="block py-2 text-sm font-medium text-gray-700">Services</a>
                <!-- <a href="#appointment" class="block py-2 text-sm font-medium text-gray-700">Appointment</a> -->
                <a href="#gallery" class="block py-2 text-sm font-medium text-gray-700">Gallery</a>
                <a href="#blog" class="block py-2 text-sm font-medium text-gray-700">Blog</a>
                <a href="#faq" class="block py-2 text-sm font-medium text-gray-700">FAQ</a>
                <a href="#contact" class="block py-2 text-sm font-medium text-gray-700">Contact</a>
            </div>
        </div>
    </header>

    <main>
        <section id="home" class="pt-16 lg:pt-20 min-h-screen relative bg-cover bg-center bg-no-repeat" style="background-image: linear-gradient(135deg, rgba(59, 130, 246, 0.8), rgba(16, 185, 129, 0.6)), url('https://readdy.ai/api/search-image?query=modern%20hospital%20interior%20with%20professional%20medical%20staff%2C%20doctors%20and%20nurses%20in%20white%20coats%2C%20clean%20bright%20medical%20environment%2C%20welcoming%20healthcare%20facility%2C%20natural%20lighting%2C%20professional%20medical%20background&width=1920&height=1080&seq=hero-bg&orientation=landscape');">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20 relative z-10">
                <div class="flex items-center justify-center min-h-[70vh]">
                    <div class="text-center fade-in">
                        <h1 class="text-4xl lg:text-6xl font-bold text-white mb-6">
                            Your Health, Our <span class="text-yellow-300">Priority</span>
                        </h1>
            
                        <p class="text-lg text-white mb-8 leading-relaxed max-w-2xl mx-auto">
                            Experience world-class healthcare with our team of dedicated professionals. We provide comprehensive medical services with compassion and excellence.
                        </p>
            
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="#login-panel">
                                <button class="btn-primary text-white px-8 py-3 !rounded-button font-semibold whitespace-nowrap">
                                    Login 
                                </button>
                            </a>
            
                            <!-- <button class="border-2 border-white text-white px-8 py-3 !rounded-button font-semibold hover:bg-white hover:text-primary transition-all duration-300 whitespace-nowrap">
                                Learn More
                            </button> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 bg-gray-50" id="login-panel">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="scale-hover bg-white rounded-xl p-8 text-center shadow-sm">
                        <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="ri-user-line text-2xl text-primary"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Patient Portal</h3>
                        <p class="text-sm text-gray-600 mb-4">Access your medical records, test results, and appointment history</p>
                        <a href="hms/user-login.php" target="_blank">
                            <button class="text-primary font-semibold text-sm hover:underline">Login as Patient</button>
                        </a>
                    </div>
                    
                    <div class="scale-hover bg-white rounded-xl p-8 text-center shadow-sm">
                        <div class="w-16 h-16 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="ri-stethoscope-line text-2xl text-secondary"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Doctor Portal</h3>
                        <p class="text-sm text-gray-600 mb-4">Manage patient appointments, medical records, and schedules</p>
                        <a href="hms/doctor" target="_blank">
                            <button class="text-secondary font-semibold text-sm hover:underline">Login as Doctor</button>
                        </a>
                    </div>
                    
                    <div class="scale-hover bg-white rounded-xl p-8 text-center shadow-sm">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="ri-admin-line text-2xl text-gray-700"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Admin Portal</h3>
                        <p class="text-sm text-gray-600 mb-4">Hospital management, staff coordination, and system administration</p>
                        <a href="hms/admin" target="_blank">
                            <button class="text-gray-700 font-semibold text-sm hover:underline">Login as Admin</button>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="about" class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-16 items-center">

                    <!-- About Content -->
                    <div class="slide-in-left">
                        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">About MediCare Hospital</h2>

                        <!-- Dynamic About Content from Database -->
                        <div class="space-y-6">
                            <div class="col-sm-6 abut-yoiu">
                                <!-- <h3 class="text-xl font-semibold text-gray-900 mb-3">About Our Hospital</h3> -->
                                <?php
                                $ret = mysqli_query($con, "select * from tblpage where PageType='aboutus' ");
                                while ($row = mysqli_fetch_array($ret)) {
                                ?>
                                <p class="text-sm text-gray-600 leading-relaxed mb-4">
                                    <?php echo nl2br($row['PageDescription']); ?>
                                </p>
                                <?php } ?>
                            </div>      

                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-3">Our Mission</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">
                                    To provide exceptional healthcare services with compassion, innovation, and excellence. We are committed to improving the health and well-being of our community through advanced medical care and personalized treatment.
                                </p>
                            </div>      

                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-3">Our Vision</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">
                                    To be the leading healthcare provider in the region, recognized for our clinical excellence, patient-centered care, and innovative medical solutions that transform lives and strengthen communities.
                                </p>
                            </div>      

                            <div class="grid grid-cols-3 gap-6 pt-6">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-primary">25+</div>
                                    <div class="text-xs text-gray-600">Years Experience</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-primary">150+</div>
                                    <div class="text-xs text-gray-600">Expert Doctors</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-primary">50K+</div>
                                    <div class="text-xs text-gray-600">Happy Patients</div>
                                </div>
                            </div>
                        </div>
                    </div>      

                    <!-- About Images -->
                    <div class="slide-in-right">
                        <div class="grid grid-cols-2 gap-4">
                            <img src="https://readdy.ai/api/search-image?query=modern%20hospital%20lobby%20with%20comfortable%20seating%20area%2C%20natural%20lighting%2C%20clean%20white%20and%20blue%20interior%20design%2C%20professional%20medical%20environment%2C%20welcoming%20atmosphere&width=300&height=400&seq=about1&orientation=portrait" 
                                 alt="Hospital Lobby" 
                                 class="rounded-lg object-cover w-full h-64 object-top">
                            <img src="https://readdy.ai/api/search-image?query=advanced%20medical%20equipment%20room%20with%20modern%20technology%2C%20clean%20sterile%20environment%2C%20white%20and%20blue%20color%20scheme%2C%20professional%20healthcare%20setting&width=300&height=400&seq=about2&orientation=portrait" 
                                 alt="Medical Equipment" 
                                 class="rounded-lg object-cover w-full h-64 object-top mt-8">
                        </div>
                    </div>
                </div>
            </div>
        </section>      


        <section id="departments" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-in">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Medical Departments</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Our comprehensive range of medical specialties ensures you receive the best care for all your health needs.
                    </p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <div class="scale-hover bg-white rounded-xl p-6 text-center shadow-sm">
                        <div class="w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="ri-heart-pulse-line text-xl text-red-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Cardiology</h3>
                        <p class="text-xs text-gray-600">Heart and cardiovascular care</p>
                    </div>
                    
                    <div class="scale-hover bg-white rounded-xl p-6 text-center shadow-sm">
                        <div class="w-12 h-12 mx-auto mb-4 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="ri-brain-line text-xl text-purple-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Neurology</h3>
                        <p class="text-xs text-gray-600">Brain and nervous system</p>
                    </div>
                    
                    <div class="scale-hover bg-white rounded-xl p-6 text-center shadow-sm">
                        <div class="w-12 h-12 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="ri-parent-line text-xl text-green-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Pediatrics</h3>
                        <p class="text-xs text-gray-600">Children's healthcare</p>
                    </div>
                    
                    <div class="scale-hover bg-white rounded-xl p-6 text-center shadow-sm">
                        <div class="w-12 h-12 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="ri-wheelchair-line text-xl text-blue-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Orthopedics</h3>
                        <p class="text-xs text-gray-600">Bone and joint care</p>
                    </div>
                    
                    <div class="scale-hover bg-white rounded-xl p-6 text-center shadow-sm">
                        <div class="w-12 h-12 mx-auto mb-4 bg-pink-100 rounded-full flex items-center justify-center">
                            <i class="ri-women-line text-xl text-pink-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Gynecology</h3>
                        <p class="text-xs text-gray-600">Women's health services</p>
                    </div>
                    
                    <div class="scale-hover bg-white rounded-xl p-6 text-center shadow-sm">
                        <div class="w-12 h-12 mx-auto mb-4 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="ri-eye-line text-xl text-yellow-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Ophthalmology</h3>
                        <p class="text-xs text-gray-600">Eye care and vision</p>
                    </div>
                    
                    <div class="scale-hover bg-white rounded-xl p-6 text-center shadow-sm">
                        <div class="w-12 h-12 mx-auto mb-4 bg-indigo-100 rounded-full flex items-center justify-center">
                            <i class="ri-lungs-line text-xl text-indigo-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Pulmonology</h3>
                        <p class="text-xs text-gray-600">Respiratory system care</p>
                    </div>
                    
                    <div class="scale-hover bg-white rounded-xl p-6 text-center shadow-sm">
                        <div class="w-12 h-12 mx-auto mb-4 bg-teal-100 rounded-full flex items-center justify-center">
                            <i class="ri-capsule-line text-xl text-teal-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Pharmacy</h3>
                        <p class="text-xs text-gray-600">Medication services</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="doctors" class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-in">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Our Expert Doctors</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Meet our team of highly qualified medical professionals dedicated to providing exceptional healthcare.
                    </p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    <div class="scale-hover bg-white rounded-xl overflow-hidden shadow-sm">
                        <img src="https://readdy.ai/api/search-image?query=professional%20female%20doctor%20in%20white%20coat%2C%20stethoscope%2C%20friendly%20smile%2C%20medical%20office%20background%2C%20confident%20healthcare%20professional%20portrait&width=300&height=300&seq=doctor1&orientation=squarish" alt="Dr. Sarah Johnson" class="w-full h-48 object-cover object-top">
                        <div class="p-6">
                            <h3 class="font-semibold text-gray-900 mb-1">Dr. Sarah Johnson</h3>
                            <p class="text-sm text-primary mb-2">Cardiologist</p>
                            <p class="text-xs text-gray-600 mb-4">15 years experience in cardiovascular medicine</p>
                            <div class="flex items-center justify-between">
                                <div class="flex space-x-2">
                                    <div class="w-6 h-6 flex items-center justify-center">
                                        <i class="ri-facebook-line text-sm text-gray-400 hover:text-primary cursor-pointer"></i>
                                    </div>
                                    <div class="w-6 h-6 flex items-center justify-center">
                                        <i class="ri-twitter-line text-sm text-gray-400 hover:text-primary cursor-pointer"></i>
                                    </div>
                                    <div class="w-6 h-6 flex items-center justify-center">
                                        <i class="ri-linkedin-line text-sm text-gray-400 hover:text-primary cursor-pointer"></i>
                                    </div>
                                </div>
                                <button class="text-xs text-primary font-semibold hover:underline">Book Appointment</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="scale-hover bg-white rounded-xl overflow-hidden shadow-sm">
                        <img src="https://readdy.ai/api/search-image?query=professional%20male%20doctor%20in%20white%20coat%2C%20stethoscope%2C%20warm%20smile%2C%20medical%20office%20background%2C%20experienced%20healthcare%20professional%20portrait&width=300&height=300&seq=doctor2&orientation=squarish" alt="Dr. Michael Chen" class="w-full h-48 object-cover object-top">
                        <div class="p-6">
                            <h3 class="font-semibold text-gray-900 mb-1">Dr. Michael Chen</h3>
                            <p class="text-sm text-primary mb-2">Neurologist</p>
                            <p class="text-xs text-gray-600 mb-4">12 years experience in neurology and brain surgery</p>
                            <div class="flex items-center justify-between">
                                <div class="flex space-x-2">
                                    <div class="w-6 h-6 flex items-center justify-center">
                                        <i class="ri-facebook-line text-sm text-gray-400 hover:text-primary cursor-pointer"></i>
                                    </div>
                                    <div class="w-6 h-6 flex items-center justify-center">
                                        <i class="ri-twitter-line text-sm text-gray-400 hover:text-primary cursor-pointer"></i>
                                    </div>
                                    <div class="w-6 h-6 flex items-center justify-center">
                                        <i class="ri-linkedin-line text-sm text-gray-400 hover:text-primary cursor-pointer"></i>
                                    </div>
                                </div>
                                <button class="text-xs text-primary font-semibold hover:underline">Book Appointment</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="scale-hover bg-white rounded-xl overflow-hidden shadow-sm">
                        <img src="https://readdy.ai/api/search-image?query=professional%20female%20pediatric%20doctor%20in%20white%20coat%2C%20stethoscope%2C%20caring%20smile%2C%20children%20hospital%20background%2C%20pediatric%20healthcare%20specialist%20portrait&width=300&height=300&seq=doctor3&orientation=squarish" alt="Dr. Emily Rodriguez" class="w-full h-48 object-cover object-top">
                        <div class="p-6">
                            <h3 class="font-semibold text-gray-900 mb-1">Dr. Emily Rodriguez</h3>
                            <p class="text-sm text-primary mb-2">Pediatrician</p>
                            <p class="text-xs text-gray-600 mb-4">10 years experience in children's healthcare</p>
                            <div class="flex items-center justify-between">
                                <div class="flex space-x-2">
                                    <div class="w-6 h-6 flex items-center justify-center">
                                        <i class="ri-facebook-line text-sm text-gray-400 hover:text-primary cursor-pointer"></i>
                                    </div>
                                    <div class="w-6 h-6 flex items-center justify-center">
                                        <i class="ri-twitter-line text-sm text-gray-400 hover:text-primary cursor-pointer"></i>
                                    </div>
                                    <div class="w-6 h-6 flex items-center justify-center">
                                        <i class="ri-linkedin-line text-sm text-gray-400 hover:text-primary cursor-pointer"></i>
                                    </div>
                                </div>
                                <button class="text-xs text-primary font-semibold hover:underline">Book Appointment</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="scale-hover bg-white rounded-xl overflow-hidden shadow-sm">
                        <img src="https://readdy.ai/api/search-image?query=professional%20male%20orthopedic%20surgeon%20in%20white%20coat%2C%20stethoscope%2C%20confident%20expression%2C%20hospital%20background%2C%20orthopedic%20specialist%20portrait&width=300&height=300&seq=doctor4&orientation=squarish" alt="Dr. James Wilson" class="w-full h-48 object-cover object-top">
                        <div class="p-6">
                            <h3 class="font-semibold text-gray-900 mb-1">Dr. James Wilson</h3>
                            <p class="text-sm text-primary mb-2">Orthopedic Surgeon</p>
                            <p class="text-xs text-gray-600 mb-4">18 years experience in orthopedic surgery</p>
                            <div class="flex items-center justify-between">
                                <div class="flex space-x-2">
                                    <div class="w-6 h-6 flex items-center justify-center">
                                        <i class="ri-facebook-line text-sm text-gray-400 hover:text-primary cursor-pointer"></i>
                                    </div>
                                    <div class="w-6 h-6 flex items-center justify-center">
                                        <i class="ri-twitter-line text-sm text-gray-400 hover:text-primary cursor-pointer"></i>
                                    </div>
                                    <div class="w-6 h-6 flex items-center justify-center">
                                        <i class="ri-linkedin-line text-sm text-gray-400 hover:text-primary cursor-pointer"></i>
                                    </div>
                                </div>
                                <button class="text-xs text-primary font-semibold hover:underline">Book Appointment</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="services" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-in">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Our Services</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Comprehensive healthcare services designed to meet all your medical needs with excellence and compassion.
                    </p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="scale-hover bg-white rounded-xl p-8 shadow-sm">
                        <div class="w-12 h-12 mb-6 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="ri-hospital-line text-xl text-primary"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Emergency Care</h3>
                        <p class="text-sm text-gray-600 mb-4">24/7 emergency medical services with rapid response team and advanced life support equipment.</p>
                        <button class="text-primary font-semibold text-sm hover:underline">Learn More</button>
                    </div>
                    
                    <div class="scale-hover bg-white rounded-xl p-8 shadow-sm">
                        <div class="w-12 h-12 mb-6 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="ri-surgical-mask-line text-xl text-secondary"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Surgery</h3>
                        <p class="text-sm text-gray-600 mb-4">Advanced surgical procedures with minimally invasive techniques and state-of-the-art operating rooms.</p>
                        <button class="text-primary font-semibold text-sm hover:underline">Learn More</button>
                    </div>
                    
                    <div class="scale-hover bg-white rounded-xl p-8 shadow-sm">
                        <div class="w-12 h-12 mb-6 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="ri-microscope-line text-xl text-purple-600"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Laboratory</h3>
                        <p class="text-sm text-gray-600 mb-4">Comprehensive diagnostic testing with accurate results and quick turnaround times.</p>
                        <button class="text-primary font-semibold text-sm hover:underline">Learn More</button>
                    </div>
                    
                    <div class="scale-hover bg-white rounded-xl p-8 shadow-sm">
                        <div class="w-12 h-12 mb-6 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="ri-scan-line text-xl text-red-600"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Radiology</h3>
                        <p class="text-sm text-gray-600 mb-4">Advanced imaging services including MRI, CT scan, X-ray, and ultrasound with expert radiologists.</p>
                        <button class="text-primary font-semibold text-sm hover:underline">Learn More</button>
                    </div>
                    
                    <div class="scale-hover bg-white rounded-xl p-8 shadow-sm">
                        <div class="w-12 h-12 mb-6 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="ri-medicine-bottle-line text-xl text-yellow-600"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Pharmacy</h3>
                        <p class="text-sm text-gray-600 mb-4">Full-service pharmacy with prescription medications, medical supplies, and patient counseling.</p>
                        <button class="text-primary font-semibold text-sm hover:underline">Learn More</button>
                    </div>
                    
                    <div class="scale-hover bg-white rounded-xl p-8 shadow-sm">
                        <div class="w-12 h-12 mb-6 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i class="ri-heart-add-line text-xl text-indigo-600"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Preventive Care</h3>
                        <p class="text-sm text-gray-600 mb-4">Comprehensive health screenings, vaccinations, and wellness programs for disease prevention.</p>
                        <button class="text-primary font-semibold text-sm hover:underline">Learn More</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- <section id="appointment" class="py-20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-in">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Schedule an Appointment</h2>
                    <p class="text-lg text-gray-600">
                        Book your appointment online and receive confirmation within 24 hours.
                    </p>
                </div>
                
                <div class="bg-white rounded-2xl shadow-xl p-8 lg:p-12">
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-medium text-gray-500">Step 1 of 3</span>
                            <span class="text-sm font-medium text-primary">Personal Information</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-primary h-2 rounded-full" style="width: 33%"></div>
                        </div>
                    </div>
                    
                    <form class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                <input type="text" class="form-input w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                <input type="text" class="form-input w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none">
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input type="email" class="form-input w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input type="tel" class="form-input w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none">
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                                <select class="form-input w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none pr-8">
                                    <option>Select Department</option>
                                    <option>Cardiology</option>
                                    <option>Neurology</option>
                                    <option>Pediatrics</option>
                                    <option>Orthopedics</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Doctor</label>
                                <select class="form-input w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none pr-8">
                                    <option>Select Doctor</option>
                                    <option>Dr. Sarah Johnson</option>
                                    <option>Dr. Michael Chen</option>
                                    <option>Dr. Emily Rodriguez</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Date</label>
                                <input type="date" class="form-input w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Time</label>
                                <select class="form-input w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none pr-8">
                                    <option>Select Time</option>
                                    <option>09:00 AM</option>
                                    <option>10:00 AM</option>
                                    <option>11:00 AM</option>
                                    <option>02:00 PM</option>
                                    <option>03:00 PM</option>
                                    <option>04:00 PM</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                            <textarea rows="4" class="form-input w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none resize-none" placeholder="Please describe your symptoms or reason for visit"></textarea>
                        </div>
                        
                        <button type="submit" class="btn-primary w-full text-white py-4 !rounded-button font-semibold text-lg whitespace-nowrap">
                            Book Appointment
                        </button>
                    </form>
                </div>
            </div>
        </section> -->

        <section id="gallery" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-in">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Hospital Gallery</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Take a virtual tour of our modern facilities and advanced medical equipment.
                    </p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="gallery-item">
                        <img src="https://readdy.ai/api/search-image?query=modern%20hospital%20reception%20area%20with%20comfortable%20seating%2C%20natural%20lighting%2C%20clean%20white%20and%20blue%20interior%20design%2C%20professional%20medical%20environment%2C%20welcoming%20atmosphere&width=400&height=300&seq=gallery1&orientation=landscape" alt="Hospital Reception" class="w-full h-64 object-cover rounded-lg object-top">
                    </div>
                    <div class="gallery-item">
                        <img src="https://readdy.ai/api/search-image?query=advanced%20medical%20equipment%20room%20with%20modern%20technology%2C%20clean%20sterile%20environment%2C%20white%20and%20blue%20color%20scheme%2C%20professional%20healthcare%20setting&width=400&height=300&seq=gallery2&orientation=landscape" alt="Medical Equipment" class="w-full h-64 object-cover rounded-lg object-top">
                    </div>
                    <div class="gallery-item">
                        <img src="https://readdy.ai/api/search-image?query=modern%20hospital%20patient%20room%20with%20comfortable%20bed%2C%20medical%20equipment%2C%20clean%20white%20interior%2C%20natural%20lighting%2C%20peaceful%20healthcare%20environment&width=400&height=300&seq=gallery3&orientation=landscape" alt="Patient Room" class="w-full h-64 object-cover rounded-lg object-top">
                    </div>
                    <div class="gallery-item">
                        <img src="https://readdy.ai/api/search-image?query=hospital%20operating%20room%20with%20advanced%20surgical%20equipment%2C%20sterile%20environment%2C%20modern%20medical%20technology%2C%20professional%20surgical%20setting&width=400&height=300&seq=gallery4&orientation=landscape" alt="Operating Room" class="w-full h-64 object-cover rounded-lg object-top">
                    </div>
                    <div class="gallery-item">
                        <img src="https://readdy.ai/api/search-image?query=hospital%20laboratory%20with%20modern%20diagnostic%20equipment%2C%20clean%20sterile%20environment%2C%20medical%20testing%20facility%2C%20professional%20lab%20setting&width=400&height=300&seq=gallery5&orientation=landscape" alt="Laboratory" class="w-full h-64 object-cover rounded-lg object-top">
                    </div>
                    <div class="gallery-item">
                        <img src="https://readdy.ai/api/search-image?query=hospital%20pharmacy%20with%20organized%20medicine%20shelves%2C%20clean%20professional%20environment%2C%20modern%20pharmaceutical%20setting%2C%20healthcare%20facility&width=400&height=300&seq=gallery6&orientation=landscape" alt="Pharmacy" class="w-full h-64 object-cover rounded-lg object-top">
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-in">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Patient Testimonials</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Read what our patients say about their experience with our healthcare services.
                    </p>
                </div>
                
                <div class="carousel-container">
                    <div id="testimonial-track" class="carousel-track">
                        <div class="testimonial-card px-4">
                            <div class="bg-white rounded-xl p-8 shadow-sm">
                                <div class="flex items-center mb-4">
                                    <img src="https://readdy.ai/api/search-image?query=happy%20middle-aged%20woman%20smiling%2C%20professional%20headshot%2C%20warm%20expression%2C%20clean%20background%2C%20satisfied%20patient%20portrait&width=60&height=60&seq=patient1&orientation=squarish" alt="Jennifer Martinez" class="w-12 h-12 rounded-full object-cover object-top mr-4">
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Jennifer Martinez</h4>
                                        <div class="flex text-yellow-400 text-sm">
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 italic">
                                    "The care I received at MediCare Hospital was exceptional. The staff was professional, caring, and the facilities are top-notch. Dr. Johnson explained everything clearly and made me feel comfortable throughout my treatment."
                                </p>
                            </div>
                        </div>
                        
                        <div class="testimonial-card px-4">
                            <div class="bg-white rounded-xl p-8 shadow-sm">
                                <div class="flex items-center mb-4">
                                    <img src="https://readdy.ai/api/search-image?query=happy%20elderly%20man%20smiling%2C%20professional%20headshot%2C%20warm%20expression%2C%20clean%20background%2C%20satisfied%20patient%20portrait&width=60&height=60&seq=patient2&orientation=squarish" alt="Robert Thompson" class="w-12 h-12 rounded-full object-cover object-top mr-4">
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Robert Thompson</h4>
                                        <div class="flex text-yellow-400 text-sm">
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 italic">
                                    "I had my surgery here and the experience was amazing. The surgical team was highly skilled and the recovery process was smooth. I highly recommend MediCare Hospital for anyone needing medical care."
                                </p>
                            </div>
                        </div>
                        
                        <div class="testimonial-card px-4">
                            <div class="bg-white rounded-xl p-8 shadow-sm">
                                <div class="flex items-center mb-4">
                                    <img src="https://readdy.ai/api/search-image?query=happy%20young%20woman%20smiling%2C%20professional%20headshot%2C%20warm%20expression%2C%20clean%20background%2C%20satisfied%20patient%20portrait&width=60&height=60&seq=patient3&orientation=squarish" alt="Lisa Anderson" class="w-12 h-12 rounded-full object-cover object-top mr-4">
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Lisa Anderson</h4>
                                        <div class="flex text-yellow-400 text-sm">
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                            <i class="ri-star-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 italic">
                                    "The pediatric department is wonderful. Dr. Rodriguez was so patient with my daughter and made her feel at ease. The entire staff went above and beyond to ensure we had a positive experience."
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-center mt-8 space-x-2">
                    <button class="w-3 h-3 rounded-full bg-primary"></button>
                    <button class="w-3 h-3 rounded-full bg-gray-300"></button>
                    <button class="w-3 h-3 rounded-full bg-gray-300"></button>
                </div>
            </div>
        </section>

        <section id="blog" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-in">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Health Blog</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Stay informed with the latest health tips, medical news, and wellness advice from our experts.
                    </p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <article class="scale-hover bg-white rounded-xl overflow-hidden shadow-sm">
                        <img src="https://readdy.ai/api/search-image?query=healthy%20heart%20diet%20with%20fresh%20fruits%20vegetables%20nuts%2C%20colorful%20nutritious%20food%20arrangement%2C%20clean%20white%20background%2C%20heart%20health%20concept&width=400&height=250&seq=blog1&orientation=landscape" alt="Heart Health" class="w-full h-48 object-cover object-top">
                        <div class="p-6">
                            <div class="text-xs text-gray-500 mb-2">November 15, 2024</div>
                            <h3 class="font-semibold text-gray-900 mb-3">10 Tips for a Healthy Heart</h3>
                            <p class="text-sm text-gray-600 mb-4">Discover simple lifestyle changes that can significantly improve your cardiovascular health and reduce the risk of heart disease.</p>
                            <button class="text-primary font-semibold text-sm hover:underline">Read More</button>
                        </div>
                    </article>
                    
                    <article class="scale-hover bg-white rounded-xl overflow-hidden shadow-sm">
                        <img src="https://readdy.ai/api/search-image?query=diabetes%20management%20with%20blood%20glucose%20meter%2C%20healthy%20food%2C%20medical%20supplies%2C%20clean%20white%20background%2C%20diabetes%20care%20concept&width=400&height=250&seq=blog2&orientation=landscape" alt="Diabetes Management" class="w-full h-48 object-cover object-top">
                        <div class="p-6">
                            <div class="text-xs text-gray-500 mb-2">November 12, 2024</div>
                            <h3 class="font-semibold text-gray-900 mb-3">Managing Diabetes Effectively</h3>
                            <p class="text-sm text-gray-600 mb-4">Learn about the latest approaches to diabetes management, including diet, exercise, and monitoring techniques.</p>
                            <button class="text-primary font-semibold text-sm hover:underline">Read More</button>
                        </div>
                    </article>
                    
                    <article class="scale-hover bg-white rounded-xl overflow-hidden shadow-sm">
                        <img src="https://readdy.ai/api/search-image?query=mental%20health%20wellness%20meditation%20yoga%20relaxation%2C%20peaceful%20serene%20environment%2C%20clean%20white%20background%2C%20mental%20wellness%20concept&width=400&height=250&seq=blog3&orientation=landscape" alt="Mental Health" class="w-full h-48 object-cover object-top">
                        <div class="p-6">
                            <div class="text-xs text-gray-500 mb-2">November 10, 2024</div>
                            <h3 class="font-semibold text-gray-900 mb-3">Mental Health Awareness</h3>
                            <p class="text-sm text-gray-600 mb-4">Understanding the importance of mental health and practical strategies for maintaining emotional well-being.</p>
                            <button class="text-primary font-semibold text-sm hover:underline">Read More</button>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section id="faq" class="py-20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-in">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                    <p class="text-lg text-gray-600">
                        Find answers to common questions about our services and procedures.
                    </p>
                </div>
                
                <div class="space-y-4">
                    <div class="bg-white rounded-xl shadow-sm">
                        <button class="accordion-btn w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none">
                            <span class="font-semibold text-gray-900">What are your visiting hours?</span>
                            <div class="w-6 h-6 flex items-center justify-center">
                                <i class="ri-add-line text-xl text-gray-400 transition-transform duration-300"></i>
                            </div>
                        </button>
                        <div class="accordion-content px-6 pb-4">
                            <p class="text-sm text-gray-600">Our visiting hours are Monday through Sunday from 8:00 AM to 8:00 PM. However, ICU visiting hours are restricted to 2:00 PM to 4:00 PM and 6:00 PM to 8:00 PM.</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm">
                        <button class="accordion-btn w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none">
                            <span class="font-semibold text-gray-900">How do I book an appointment?</span>
                            <div class="w-6 h-6 flex items-center justify-center">
                                <i class="ri-add-line text-xl text-gray-400 transition-transform duration-300"></i>
                            </div>
                        </button>
                        <div class="accordion-content px-6 pb-4">
                            <p class="text-sm text-gray-600">You can book an appointment online through our website, call our appointment hotline at +1 (555) 123-4567, or visit our reception desk. Online bookings are available 24/7.</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm">
                        <button class="accordion-btn w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none">
                            <span class="font-semibold text-gray-900">Do you accept insurance?</span>
                            <div class="w-6 h-6 flex items-center justify-center">
                                <i class="ri-add-line text-xl text-gray-400 transition-transform duration-300"></i>
                            </div>
                        </button>
                        <div class="accordion-content px-6 pb-4">
                            <p class="text-sm text-gray-600">Yes, we accept most major insurance plans including Blue Cross Blue Shield, Aetna, Cigna, UnitedHealth, and Medicare. Please contact our billing department to verify your coverage.</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm">
                        <button class="accordion-btn w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none">
                            <span class="font-semibold text-gray-900">What should I bring to my appointment?</span>
                            <div class="w-6 h-6 flex items-center justify-center">
                                <i class="ri-add-line text-xl text-gray-400 transition-transform duration-300"></i>
                            </div>
                        </button>
                        <div class="accordion-content px-6 pb-4">
                            <p class="text-sm text-gray-600">Please bring a valid photo ID, insurance card, list of current medications, previous medical records if applicable, and any referral letters from other healthcare providers.</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm">
                        <button class="accordion-btn w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none">
                            <span class="font-semibold text-gray-900">Is parking available?</span>
                            <div class="w-6 h-6 flex items-center justify-center">
                                <i class="ri-add-line text-xl text-gray-400 transition-transform duration-300"></i>
                            </div>
                        </button>
                        <div class="accordion-content px-6 pb-4">
                            <p class="text-sm text-gray-600">Yes, we offer free parking for patients and visitors. Our parking garage has over 500 spaces and is accessible 24/7. Valet parking is also available during business hours.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-in">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Contact Us</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Get in touch with us for any questions, concerns, or to schedule an appointment.
                    </p>
                </div>      

                <div class="grid lg:grid-cols-3 gap-12">
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl p-8 shadow-sm mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Contact Information</h3>
                            <div class="space-y-6">
                                <?php
                                $ret = mysqli_query($con, "select * from tblpage where PageType='contactus' ");
                                while ($row = mysqli_fetch_array($ret)) {
                                ?>
                                <div class="space-y-5">
                                    <!-- Address -->
                                    <div class="flex items-start space-x-3">
                                        <div class="w-6 h-6 flex items-center justify-center mt-1">
                                            <i class="ri-map-pin-line text-primary text-lg"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">Address</div>
                                            <div class="text-sm text-gray-600">
                                                <?php echo nl2br($row['PageDescription']); ?>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <!-- Phone -->
                                    <div class="flex items-start space-x-3">
                                        <div class="w-6 h-6 flex items-center justify-center mt-1">
                                            <i class="ri-phone-line text-primary text-lg"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">Phone</div>
                                            <div class="text-sm text-gray-600">
                                                <?php echo $row['MobileNumber']; ?>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <!-- Email -->
                                    <div class="flex items-start space-x-3">
                                        <div class="w-6 h-6 flex items-center justify-center mt-1">
                                            <i class="ri-mail-line text-primary text-lg"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">Email</div>
                                            <div class="text-sm text-gray-600">
                                                <a href="mailto:<?php echo $row['Email']; ?>" class="hover:underline text-blue-600">
                                                    <?php echo $row['Email']; ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <!-- Hours -->
                                    <div class="flex items-start space-x-3">
                                        <div class="w-6 h-6 flex items-center justify-center mt-1">
                                            <i class="ri-time-line text-primary text-lg"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">Hours</div>
                                            <div class="text-sm text-gray-600">
                                                <?php echo $row['OpenningTime']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>     

                        <div class="bg-white rounded-xl overflow-hidden shadow-sm">
                            <div class="h-64 bg-cover bg-center" style="background-image: url('https://public.readdy.ai/gen_page/map_placeholder_1280x720.png')"></div>
                        </div>
                    </div>      

                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl p-8 shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Send us a Message</h3>
                            <form id="contactForm" class="space-y-6">
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                        <input type="text" class="form-input w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                        <input type="text" class="form-input w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none">
                                    </div>
                                </div>      

                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                        <input type="email" class="form-input w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                        <input type="tel" class="form-input w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none">
                                    </div>
                                </div>      

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                                    <input type="text" class="form-input w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none">
                                </div>      

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                                    <textarea rows="6" class="form-input w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none resize-none" placeholder="Please describe how we can help you"></textarea>
                                </div>      

                                <button type="submit" class="btn-primary text-white px-8 py-3 !rounded-button font-semibold whitespace-nowrap">
                                    Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>      

        <!-- Toast Notification Script -->
        <script>
        document.getElementById("contactForm").addEventListener("submit", function(e) {
            e.preventDefault();
            showToast("Please login first to send a message.");
        });     

        function showToast(message) {
            let toast = document.createElement("div");
            toast.textContent = message;
            toast.style.position = "fixed";
            toast.style.bottom = "30px";
            toast.style.right = "30px";
            toast.style.background = "#333";
            toast.style.color = "#fff";
            toast.style.padding = "12px 24px";
            toast.style.borderRadius = "6px";
            toast.style.boxShadow = "0 2px 6px rgba(0,0,0,0.3)";
            toast.style.fontSize = "14px";
            toast.style.zIndex = "9999";
            toast.style.opacity = "0";
            toast.style.transition = "opacity 0.4s ease";
            document.body.appendChild(toast);
            setTimeout(() => { toast.style.opacity = "1"; }, 50);
            setTimeout(() => {
                toast.style.opacity = "0";
                setTimeout(() => toast.remove(), 400);
            }, 3000);
        }
        </script>       

    </main>

    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <div>
                    <div class="flex items-center space-x-2 mb-6">
                        <div class="w-10 h-10 flex items-center justify-center bg-primary text-white rounded-lg">
                            <i class="ri-hospital-line text-xl"></i>
                        </div>
                        <span class="text-xl font-bold">MediCare</span>
                    </div>
                    <p class="text-sm text-gray-400 mb-6">
                        Providing exceptional healthcare services with compassion, innovation, and excellence for over 25 years.
                    </p>
                    <div class="flex space-x-4">
                        <div class="w-8 h-8 flex items-center justify-center">
                            <i class="ri-facebook-fill text-lg text-gray-400 hover:text-primary cursor-pointer transition-colors"></i>
                        </div>
                        <div class="w-8 h-8 flex items-center justify-center">
                            <i class="ri-twitter-fill text-lg text-gray-400 hover:text-primary cursor-pointer transition-colors"></i>
                        </div>
                        <div class="w-8 h-8 flex items-center justify-center">
                            <i class="ri-instagram-fill text-lg text-gray-400 hover:text-primary cursor-pointer transition-colors"></i>
                        </div>
                        <div class="w-8 h-8 flex items-center justify-center">
                            <i class="ri-linkedin-fill text-lg text-gray-400 hover:text-primary cursor-pointer transition-colors"></i>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="font-semibold mb-6">Quick Links</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#about" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#departments" class="text-gray-400 hover:text-white transition-colors">Departments</a></li>
                        <li><a href="#doctors" class="text-gray-400 hover:text-white transition-colors">Our Doctors</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white transition-colors">Services</a></li>
                        <li><a href="#appointment" class="text-gray-400 hover:text-white transition-colors">Book Appointment</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold mb-6">Services</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Emergency Care</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Surgery</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Laboratory</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Radiology</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Pharmacy</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold mb-6">Newsletter</h3>
                    <p class="text-sm text-gray-400 mb-4">
                        Subscribe to receive health tips and hospital updates.
                    </p>
                    <form class="space-y-3">
                        <input type="email" placeholder="Your email address" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-primary text-sm">
                        <button type="submit" class="btn-primary w-full text-white py-2 !rounded-button font-semibold text-sm whitespace-nowrap">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <p class="text-sm text-gray-400">
                        © 2024 MediCare Hospital. All rights reserved.
                    </p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                        <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Terms of Service</a>
                        <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script id="header-scroll">
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('header');
            
            window.addEventListener('scroll', function() {
                if (window.scrollY > 100) {
                    header.classList.add('header-sticky');
                } else {
                    header.classList.remove('header-sticky');
                }
            });
        });
    </script>

    <script id="mobile-menu">
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        });
    </script>

    <script id="scroll-animations">
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, observerOptions);
            
            document.querySelectorAll('.fade-in, .slide-in-left, .slide-in-right').forEach(el => {
                observer.observe(el);
            });
        });
    </script>

    <script id="accordion">
        document.addEventListener('DOMContentLoaded', function() {
            const accordionBtns = document.querySelectorAll('.accordion-btn');
            
            accordionBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const content = this.nextElementSibling;
                    const icon = this.querySelector('i');
                    
                    accordionBtns.forEach(otherBtn => {
                        if (otherBtn !== this) {
                            const otherContent = otherBtn.nextElementSibling;
                            const otherIcon = otherBtn.querySelector('i');
                            otherContent.classList.remove('active');
                            otherIcon.classList.remove('ri-subtract-line');
                            otherIcon.classList.add('ri-add-line');
                        }
                    });
                    
                    content.classList.toggle('active');
                    if (content.classList.contains('active')) {
                        icon.classList.remove('ri-add-line');
                        icon.classList.add('ri-subtract-line');
                    } else {
                        icon.classList.remove('ri-subtract-line');
                        icon.classList.add('ri-add-line');
                    }
                });
            });
        });
    </script>

    <script id="testimonial-carousel">
        document.addEventListener('DOMContentLoaded', function() {
            const track = document.getElementById('testimonial-track');
            let currentIndex = 0;
            const totalSlides = 3;
            
            function moveCarousel() {
                currentIndex = (currentIndex + 1) % totalSlides;
                const translateX = -currentIndex * (100 / totalSlides);
                track.style.transform = `translateX(${translateX}%)`;
            }
            
            setInterval(moveCarousel, 5000);
        });
    </script>

    <script id="smooth-scroll">
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        const headerHeight = document.getElementById('header').offsetHeight;
                        const targetPosition = target.offsetTop - headerHeight;
                        
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>

    <script id="form-interactions">
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.textContent;
                    
                    submitBtn.innerHTML = '<span class="loading-spinner"></span> Processing...';
                    submitBtn.disabled = true;
                    
                    setTimeout(() => {
                        submitBtn.textContent = 'Success!';
                        submitBtn.classList.add('bg-green-600');
                        
                        setTimeout(() => {
                            submitBtn.textContent = originalText;
                            submitBtn.disabled = false;
                            submitBtn.classList.remove('bg-green-600');
                            this.reset();
                        }, 2000);
                    }, 2000);
                });
            });
        });
    </script>
</body>
</html>

