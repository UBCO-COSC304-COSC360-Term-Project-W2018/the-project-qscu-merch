<?php
/**
 * Created by PhpStorm.
 * User: Rachelle
 * Date: 2018-11-12
 * Time: 1:37 PM
 */
$headerSet = 1;
include "header.php";

?>

<!--HTML contact us page for shop.qscu.org-->
<!DOCTYPE HTML>
<html>
<!--    Head-->

<head lang="en">
    <meta charset="utf-8">
    <title>QSCU Merch Store</title>
    <link rel="stylesheet" href="css/contact.css" />
	<?php include 'includes/headerFooterHead.php'?>

    <ul class="breadcrumb">
        <a href = "homeWithoutTables.php">Home</a> &gt; &gt;
        <a >Contact Us</a>
    </ul>
</head>

<!--    Body-->

<body>
<!-- Inseart Header Here-->


<div class="bigboi">
    <div class ="container">
        <div class ="contactInfo flex-item">
            <h1>Get in Touch</h1>
            <p> Please fill otu the quick from and will be in touch with lightening speed! </p>
            <h2>Connect with us</h2>
            <p> For support or any questions, emails us at <a href="mailto:qscu.ubco@gmail.com?Subject=QSCU%20Shop" target="_top">qscu.ubco@gmail.com</a></p>

            <div class= "address">
                <p class="qscu"> Quantative Sciences Course Union (QSCU)</p>
                <p>Okanagan Campus
                    <br>3187 University Way
                    <br>Kelowna, BC Canada V1V 1V7<p>
            </div>
            <!-- <p>Since 2011, the <a href="http://qscu.org">Quantitative Science Course Union</a> has been representing UBC Okanagan students in Mathematics, Computer Science, Statistics, and Physics and Data Science. The QSCU organizes both fun and educational events while also assisting first-year students in their courses. These events are usually held on campus. The course union strives to bring students and professors together in a casual atmosphere in hopes of creating social networking and research opportunities. -->
            </p>


        </div>


        <form id="contactForm" method="post" action="http://www.randyconnolly.com/tests/process.php" class="flex-item">
            <fieldset>
                <!-- legend -->
                <legend id="contactTitle">Contact Us</legend>

                <!-- First Name input -->
                <div class="formElement">
                    <input type="text" name="firstName" id="firstNameInput" placeholder="First Name" required>
                </div>

                <!-- Last Name input -->
                <div class="formElement">
                    <input type="text" name="lastName" id="lastNameInput" placeholder="Last Name" required>
                </div>

                <!-- Email input -->
                <div class="formElement">
                    <input type="email" name="email" id="emailInput" placeholder="Email" required>
                </div>

                <!-- Message input -->
                <div class="formElement">
                    <!-- max lenght is 200 chars and there are 3 rows -->
                    <textarea id="messageInput" name="message" placeholder="Your Message" rows="4" maxlength="200"required></textarea>
                </div>

                <div class="formElement">
                    <button type="submit" id="SubmitButton">Submit</button>
                </div>

            </fieldset>
        </form>
    </div>
</div>

<!-- Insert Footer Here-->
</body>

</html>
