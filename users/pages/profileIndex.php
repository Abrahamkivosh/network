<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4>Profile</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php
            include_once "./includes/messages.php";
            ?>
        </div>

    <div class="row">
        <form name="updateprofileForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="updateprofileForm" method="post" class="needs-validation" novalidate>
            <div class="accordion col-md-12" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                            USER INFORMATION
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                        <div class="accordion-body row">
                           
                                <div class="mb-3 col-md-4">
                                    <label for="username" class="form-label ">Username <span class="is-required"></span> </label>
                                    <input type="text" class="form-control" disabled id="username" value="<?php echo $userInfo->username; ?>" readonly>
                                </div>

                                <div class="mb-3 col-md-4">
                                    <label for="firstname" class="form-label">First Name <span class="is-required"></span> </label>
                                    <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $userInfo->firstname; ?>"  required >
                                    <div class="invalid-feedback">
                                        Please Enter a valid first name
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4">
                                    <label for="lastname" class="form-label">Last Name <span class="is-required"></span> </label>
                                    <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $userInfo->lastname; ?>" required >
                                    <div class="invalid-feedback">
                                        Please Enter a valid last name
                                    </div>
                                </div>


                                <div class="mb-3 col-md-4">
                                    <label for="email" class="form-label">Email </label>
                                    <input type="text" class="form-control" name="email" id="email" value="<?php echo $userInfo->email; ?>" required >
                                    <div class="invalid-feedback">
                                        Please Enter a valid email
                                    </div>
                                    <div class="form-text">We'll never share your email/phone with anyone else.</div>

                                </div>

                                <div class="mb-3 col-md-4">
                                    <label for="workphone">Main Phone <span class="is-required"></span> </label>
                                    <input type="text" class="form-control " name="workphone" 
                                    pattern="(\254|0)[1-9]\d{8}" 
                                    title="Please enter a valid Kenyan phone number (e.g., 254712345678 or 0712345678)." 
                                    value="<?php echo $userInfo->workphone; ?>" id="workphone" required >
                                    <div class="invalid-feedback">
                                        Please Enter a valid phone number
                                    </div>
                                    <div class="form-text">We'll never share your email/phone with anyone else.</div>

                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="mobilephone">Alternative Phone <span class="is-required"></span> </label>
                                    <input type="text" class="form-control " name="mobilephone" 
                                    pattern="(\254|0)[1-9]\d{8}" 
                                    title="Please enter a valid Kenyan phone number (e.g., 254712345678 or 0712345678)." 
               
                                  
                                    value="<?php echo $userInfo->mobilephone; ?>" id="mobilephone" required >
                                    <div class="invalid-feedback">
                                        Please Enter a valid phone number
                                    </div>
                                    <div class="form-text">We'll never share your email/phone with anyone else.</div>
                                </div>

                                <div class="mb-3 col-md-4">
                                    <label for="company" class="form-label">Company/ Home/ Street <span class="is-required"></span> </label>
                                    <input type="text" class="form-control" name="company" id="company" value="<?php echo $userInfo->company; ?>" required >
                                    <div class="invalid-feedback">
                                        Please Enter a valid Company or Home or Street name
                                    </div>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="city" class="form-label">Location Name <span class="is-required"></span> </label>
                                    <input type="text" class="form-control" name="city" id="city" value="<?php echo $userInfo->city; ?>" required >

                                    <div class="invalid-feedback">
                                        Please Enter a valid City Name
                                    </div>

                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="state" class="form-label">County <span class="is-required"></span> </label>
                                    <input type="text" class="form-control" id="state" name="state" value="<?php echo $userInfo->state; ?>" required >

                                </div>
                            

                               



                           
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="true" aria-controls="panelsStayOpen-collapseThree">
                                UPDATE PASSWORD
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseThree" class="accordion-collapse " aria-labelledby="panelsStayOpen-headingThree">
                            <div class="accordion-body">
                                <div class="col-md-6 offset-3">
                                    <div class="mb-3 ">
                                        <label for="currentpassword" class="form-label">Current Password <span class="is-required"></span> </label>
                                        <input class="form-control" id="currentpassword" name="currentpassword" type="password" ></input>
                                        <div class="invalid-feedback">
                                        Please Enter a valid Current Password
                                    </div>
                                    </div>
                                    <div class="mb-3 ">
                                        <label for="newpassword" class="form-label">New password</label>
                                        <input class="form-control" id="newpassword" name="newpassword"></input>
                                        <div class="invalid-feedback">
                                        Please Enter a valid New Password
                                    </div>
                                    </div>
                                    <div class="mb-3 ">
                                        <label for="confirmpassword" class="form-label">Confirm password</label>
                                        <input class="form-control" id="confirmpassword" name="confirmpassword"></input>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="mb-3 d-grid gap-2">
                    <input type="submit" value="submit" class="btn btn-primary " >
                </div>
            </div>

        </form>

    </div>