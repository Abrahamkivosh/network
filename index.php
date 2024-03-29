<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InstantNet - Your Gateway to High-Speed Internet</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/index_styles.css">
</head>

<body>
    <!-- Bootstrap Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-default navbar-fixed-top">
        <a class="navbar-brand" href="./">InstantNet</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#our_services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./users">Login (Customer)</a>
                </li>

            </ul>
        </div>
    </nav>
    <!-- <section>
        <header class="">
            <div class="row">
                <div class="col-md-12">
                    <h1>Welcome to InstantNet</h1>
                    <h2>Your Gateway to High-Speed Internet</h2>
                </div>
            </div>
        </header>
    </section> -->

    <section id="why-choose">
        <div class="container">
            <div class="row">
                <div class="col-md-6 explain">
                    <h2>Why Choose InstantNet?</h2>
                    <p class="lead">We're dedicated to providing you with the best internet experience. Here's why you should choose us:</p>
                    <ul>
                        <li><i class="fas fa-check"></i> Lightning-Fast Speeds: Stream, game, and work without interruptions.</li>
                        <li><i class="fas fa-check"></i> Reliable Connection: Say goodbye to downtime and lag.</li>
                        <li><i class="fas fa-check"></i> Affordable Plans: Enjoy high-speed internet at competitive prices.</li>
                        <li><i class="fas fa-check"></i> 24/7 Customer Support: Our team is here to assist you round the clock.</li>
                        <li><i class="fas fa-check"></i> Local Expertise: We understand the unique needs of our Kenyan customers.</li>
                    </ul>
                </div>
                <div class="col-md-6 getConnected">
                    <h2 class="text text-center">Get Connected</h2>
                    <form action="" class="row" method="post">
                        <div class="form-group col-md-6">
                            <label for="">Select Your Town Area</label>
                            <select class="form-control" name="" id="">
                                <option value="Kangundo">Kangundo</option>
                                <option>Tala</option>
                                <option>Nguluni</option>
                                <option>Komarock</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="estate">Enter Estate/Building name</label>
                            <input type="text" name="estate" id="estate" class="form-control" placeholder="Enter Estate/Building name">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="landmark">Enter Closest Landmark</label>
                            <input type="text" name="landmark" id="landmark" class="form-control" placeholder="Enter Closest Landmark">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="phone">Your Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Your Phone Number">
                        </div>
                        <div class="form-group col-md-12">
                            <button
                            
                             type="submit" class="btn btn-block submit-btn">Submit</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </section>


    <section class="our_services" id="our_services">
        <div class="container mt-2">
            <div class="row">
                <div class="col-md-12">
                    <h2>Our Services</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card h-100 service-card">
                        <img src="data:image/jpeg;base64,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" class="img-fluid card-img-top" alt="Service 1 Image">
                        <div class="card-body">
                            <h5 class="card-title">Residential Internet</h5>
                            <p class="card-text">Stay connected with family and friends, stream your favorite shows, and game online with ease. Choose from our range of home internet plans to find the perfect fit for your household.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 service-card">
                        <img src="data:image/jpeg;base64,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" class="img-fluid card-img-top" alt="Service 2 Image">
                        <div class="card-body">
                            <h5 class="card-title">Business Solutions</h5>
                            <p class="card-text">Boost productivity and efficiency in your workplace with our business internet packages. From small businesses to large enterprises, we have the right solution for you.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 service-card ">
                        <img src="data:image/jpeg;base64,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" class="img-fluid card-img-top" alt="Service 3 Image">
                        <div class="card-body">
                            <h5 class="card-title">Fiber Optic Internet</h5>
                            <p class="card-text">Experience the future of internet connectivity with our high-speed fiber optic plans. Enjoy ultra-fast speeds for all your online activities.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="cta">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>Join the InstantNet Family Today!</h2>
                    <p>Ready to upgrade your internet experience? Join the InstantNet family and enjoy high-speed internet like never before.</p>
                </div>
                <div class="col-md-6">

                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modelId">
                        Get Started
                    </button>

                    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Contact Us</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form action="./contact_submit.php" id="contact_us_form" method="post">
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label for="name">Your Name</label>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Your Full Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Your Phone Number</label>
                                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Your Phone Number">
                                        </div>
                                        <div class="form-group">
                                            <label for="message">Message</label>
                                            <textarea class="form-control" name="message" id="message" placeholder="Message here......" rows="3"></textarea>
                                        </div>

                                    </div>
                                    <div class="modal-footer d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary  submit-btn">Sent Message</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h4>Contact Us</h4>
                    <address>
                        <p>123 Main Street</p>
                        <p>Nairobi, Kenya</p>
                        <p>Email: <a href="mailto:info@instantnet.co.ke">info@instantnet.co.ke</a> </p>
                        <p><a class="phoneNumber" href="tel:+254707585566">+2547 0758 5566</a></p>
                    </address>
                </div>
                <div class="col-md-4">
                    <h4>Follow Us</h4>
                    <ul class="list-unstyled">
                        <li><a href="#"><i class="fab fa-facebook"></i> Facebook</a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h4>Quick Links</h4>
                    <ul class="list-unstyled">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="./login.php">Admin Login</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>&copy; <?php echo date("Y") ?> InstantNet. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>


    <!-- Add Bootstrap JS scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#contact_us_form").on("submit", function(e) {
                e.preventDefault();

            })
        });
    </script>
</body>

</html>