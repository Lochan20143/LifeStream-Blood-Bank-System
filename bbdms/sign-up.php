<?php 
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_POST['submit']))
{
    $fullname = $_POST['fullname'];
    $mobile = $_POST['mobileno'];
    $email = $_POST['emailid'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $bloodgroup = $_POST['bloodgroup'];
    $address = $_POST['address'];
    $message = $_POST['message'];
    $status = 1;
    $password = md5($_POST['password']);

    // Server-side validation
    if (!preg_match("/^[a-zA-Z\s]+$/", $fullname)) {
        echo "<script>alert('Full Name should contain only letters and spaces.');</script>";
    } elseif (!preg_match("/^\d{10}$/", $mobile)) {
        echo "<script>alert('Mobile Number should be exactly 10 digits.');</script>";
    } elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@(gmail|hotmail|rediffmail)\.com$/", $email)) {
        echo "<script>alert('Email must be a valid gmail.com, hotmail.com, or rediffmail.com address.');</script>";
    } elseif (!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $_POST['password'])) {
        echo "<script>alert('Password must be at least 8 characters long and contain at least one uppercase letter, one number, and one special character.');</script>";
    } else {
        // Check for existing email
        $ret = "select EmailId from tblblooddonars where EmailId=:email";
        $query = $dbh -> prepare($ret);
        $query-> bindParam(':email', $email, PDO::PARAM_STR);
        $query-> execute();
        $results = $query -> fetchAll(PDO::FETCH_OBJ);
        if($query -> rowCount() == 0)
        {
            $sql = "INSERT INTO tblblooddonars(FullName,MobileNumber,EmailId,Age,Gender,BloodGroup,Address,Message,status,Password) VALUES(:fullname,:mobile,:email,:age,:gender,:bloodgroup,:address,:message,:status,:password)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':fullname', $fullname, PDO::PARAM_STR);
            $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':age', $age, PDO::PARAM_STR);
            $query->bindParam(':gender', $gender, PDO::PARAM_STR);
            $query->bindParam(':bloodgroup', $bloodgroup, PDO::PARAM_STR);
            $query->bindParam(':address', $address, PDO::PARAM_STR);
            $query->bindParam(':message', $message, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if($lastInsertId)
            {
                echo "<script>alert('You have signed up successfully');</script>";
            }
            else
            {
                echo "<script>alert('Something went wrong. Please try again');</script>";
            }
        }
        else
        {
            echo "<script>alert('Email-id already exists. Please try again');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Blood Bank Donor Management System | Signup </title>
    <!-- Meta tag Keywords -->

    <script>
        function validateForm() {
            var fullname = document.forms["signup"]["fullname"].value;
            var mobileno = document.forms["signup"]["mobileno"].value;
            var email = document.forms["signup"]["emailid"].value;
            var password = document.forms["signup"]["password"].value;

            var fullnamePattern = /^[a-zA-Z\s]+$/;
            var mobilenoPattern = /^\d{10}$/;
            var emailPattern = /^[a-zA-Z0-9._%+-]+@(gmail|hotmail|rediffmail)\.com$/;
            var passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            if (!fullnamePattern.test(fullname)) {
                alert("Full Name should contain only letters and spaces.");
                return false;
            }

            if (!mobilenoPattern.test(mobileno)) {
                alert("Mobile Number should be exactly 10 digits.");
                return false;
            }

            if (!emailPattern.test(email)) {
                alert("Email must be a valid gmail.com, hotmail.com, or rediffmail.com address.");
                return false;
            }

            if (!passwordPattern.test(password)) {
                alert("Password must be at least 8 characters long and contain at least one uppercase letter, one number, and one special character.");
                return false;
            }

            return true;
        }
    </script>
    <!--// Meta tag Keywords -->

    <!-- Custom-Files -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- Bootstrap-Core-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!-- Style-CSS -->
    <link rel="stylesheet" href="css/fontawesome-all.css">
    <!-- Font-Awesome-Icons-CSS -->
    <!-- //Custom-Files -->

    <!-- Web-Fonts -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
        rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
        rel="stylesheet">
    <!-- //Web-Fonts -->

</head>

<body>
    <?php include('includes/header.php');?>

    <!-- banner 2 -->
    <div class="inner-banner-w3ls">
        <div class="container">
        </div>
    </div>
    <!-- page details -->
    <div class="breadcrumb-agile">
        <div aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Signup</li>
            </ol>
        </div>
    </div>
    <!-- //page details -->

    <!-- about -->
    <section class="about py-5">
        <div class="container py-xl-5 py-lg-3">
            <div class="login px-4 mx-auto mw-100">
                <h5 class="text-center mb-4">Register Now</h5>
                <form action="#" method="post" name="signup" onsubmit="return validateForm();">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <label>Mobile Number</label>
                        <input type="text" class="form-control" name="mobileno" id="mobileno" required="true" placeholder="Mobile Number" maxlength="10" pattern="[0-9]+">
                    </div>

                    <div class="form-group">
                        <label class="mb-2">Email Id</label>
                        <input type="email" name="emailid" class="form-control" placeholder="Email Id">
                    </div>
                    <div class="form-group">
                        <label class="mb-2">Age</label>
                        <input type="text" class="form-control" name="age" id="age" placeholder="Age" required="">
                    </div>
                    <div class="form-group">
                        <label class="mb-2">Gender</label>
                        <select name="gender" class="form-control" required>
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="mb-2">Blood Group</label>
                        <select name="bloodgroup" class="form-control" required>
                            <?php 
                            $sql = "SELECT * from tblbloodgroup ";
                            $query = $dbh -> prepare($sql);
                            $query->execute();
                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                            $cnt=1;
                            if($query->rowCount() > 0)
                            {
                                foreach($results as $result)
                                { ?>  
                                    <option value="<?php echo htmlentities($result->BloodGroup);?>"><?php echo htmlentities($result->BloodGroup);?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" id="address" required="true" placeholder="Address">
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea class="form-control" name="message" required> </textarea>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" id="password" required="">
                    </div>

                    <button type="submit" class="btn btn-primary submit mb-4" name="submit">Register</button>

                    <p class="account-w3ls text-center pb-4" style="color:#000">
                        Already Registered?
                        <a href="login.php">Signin now</a>
                    </p>
                </form>
            </div>
        </div>
    </section>
    <!-- //about -->

    <?php include('includes/footer.php');?>

    <!-- Js files -->
    <!-- JavaScript -->
    <script src="js/jquery-2.2.3.min.js"></script>
    <!-- Default-JavaScript-File -->

    <!-- banner slider -->
    <script src="js/responsiveslides.min.js"></script>
    <script>
        $(function () {
            $("#slider4").responsiveSlides({
                auto: true,
                pager: true,
                nav: true,
                speed: 1000,
                namespace: "callbacks",
                before: function () {
                    $('.events').append("<li>before event fired.</li>");
                },
                after: function () {
                    $('.events').append("<li>after event fired.</li>");
                }
            });
        });
    </script>
    <!-- //banner slider -->

    <!-- fixed navigation -->
    <script src="js/fixed-nav.js"></script>
    <!-- //fixed navigation -->

    <!-- smooth scrolling -->
    <script src="js/SmoothScroll.min.js"></script>
    <!-- move-top -->
    <script src="js/move-top.js"></script>
    <!-- easing -->
    <script src="js/easing.js"></script>
    <!-- necessary snippets for few javascript files -->
    <script src="js/medic.js"></script>

    <script src="js/bootstrap.js"></script>
    <!-- Necessary-JavaScript-File-For-Bootstrap -->

    <!-- //Js files -->

</body>

</html>
