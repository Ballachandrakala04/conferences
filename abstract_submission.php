<?php
// error_reporting(E_ALL);
// ini_set("display_errors", "1");
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
include 'db_connect.php';

if (isset($_POST['submit'])) {
    $ipaddress = $_SERVER['REMOTE_ADDR'];
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');

    if ($email && isset($_FILES['uploadfile']) && $_FILES['uploadfile']['error'] == UPLOAD_ERR_OK) {
        $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $fileType = $_FILES['uploadfile']['type'];
        
        if (in_array($fileType, $allowedTypes)) {
            // Prepare and execute the database insertion using prepared statements
            $stmt = $res->prepare("INSERT INTO abstract_submission (user, title, fname, city, country, email, phno, organization, session, interest, date, ipaddress) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
            $stmt->bind_param("sssssssssss", $user, $title, $fname, $city, $country, $email, $phone, $organization, $session, $interest, $ipaddress);

            $user = 'Vaccines R&D-2024';
            $title = $_POST['tittle'];
            $fname = $name;
            $city = $_POST['city'];
            $country = $_POST['country'];
            $phone = $_POST['phone'];
            $organization = $_POST['institution'];
            $session = $_POST['session'];
            $interest = $_POST['interest'];

            if ($stmt->execute()) {
                $ins_id = $stmt->insert_id;
                $uploaddir = "uploads/";
                $pic1name1 = $_FILES['uploadfile']['name'];
                if ($pic1name1 != "") {
                    $pic1arr1 = explode(".", $pic1name1);
                    $pic1new1 = $ins_id . "-Abstract." . end($pic1arr1);
                    move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploaddir . $pic1new1);
                    $stmt = $res->prepare("UPDATE abstract_submission SET attachment=? WHERE sno=?");
                    $stmt->bind_param("si", $pic1new1, $ins_id);
                    $stmt->execute();
                }

                chmod($uploaddir . $pic1new1, 0777);

                $fileatt = $uploaddir . $pic1new1;
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host       = 'email-smtp.us-east-1.amazonaws.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'AKIAQNQXNUWL2OILAUUA';
                    $mail->Password   = 'BKwqVJ8Ogv+e6peEH6uEQsi/ka3kFbI+wRwMQUwyxsTP';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;

                    $mail->setFrom('contact@unitedscientificgroup.net', 'Vaccine R&D-2024');
                    $mail->addAddress('vaccines@uniscigroup.org', 'Nishant');
                    $mail->addCC('ntoomula@uniscigroup.net');
                    $mail->AddCustomHeader('Reply-to:' . $email);
                    $mail->AddCustomHeader('Return-Path:contact@unitedscientificgroup.net');

                    $mail->addAttachment($fileatt);

                    $mail->isHTML(true);
                    $mail->Subject = "Vaccine R&D-2024 Abstract Received from: " . $_POST['tittle'] . " " . $name;
                    $mail->Body    = '<html><body>' . 
                                     "Title: " . $_POST['tittle'] . " " . $name . "<br/><br/>" .
                                     "Country: " . $_POST['country'] . "<br/><br/>" .
                                     "E-mail: " . $email . "<br/><br/>" .
                                     "Phone Number: " . $_POST['phone'] . "<br/><br/>" .
                                     "Interested In: " . $_POST['interest'] . "<br/><br/>" .
                                     "Session Name: " . $_POST['session'] . "<br/><br/>" .
                                     "Organization: " . $_POST['institution'] .
                                     '</body></html>';

                    $mail->send();
                    echo "<script>alert('Your abstract is submitted successfully. Our conference coordinator will contact you soon...');window.location.href = 'index.php';</script>";
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "<script>alert('Error in database insertion');window.location.href = 'abstract_submission.php';</script>";
            }
        } else {
            echo "<script>alert('Invalid file type. Only PDF, DOC, or DOCX are allowed.');window.location.href = 'abstract_submission.php';</script>";
        }
    } else {
        echo "<script>alert('Please enter a valid email address and ensure your file is uploaded correctly.');window.location.href = 'abstract_submission.php';</script>";
    }
}
?>

<?php
$pagetitle = "Call for Abstract | International Vaccines Conferences 2024 | Immunology Conferences| Vaccines Research Conferences";
$meta_keywords = "";
$meta_description = "";
?>

              <?php if (!isset($_POST['submit'])) { ?>
                <form action="#" method="post" name="form1" class="abstractform" enctype="multipart/form-data">
                  <div class="abformTitle"><strong>Title</strong></div>
                  <div class="abformTitle">
                    <select class="abInput1" name="tittle" required>
                      <option value="Dr.">Dr.</option>
                      <option value="Mr.">Mr.</option>
                      <option value="Mrs.">Mrs.</option>
                      <option value="Ms.">Ms.</option>
                    </select>
                  </div>
                  <div style="clear:both;"></div>
                  <div class="abformTitle"><strong>Name</strong></div>
                  <div class="abformTitle">
                    <input class="abInput" type="text" placeholder="Enter your name" name="name" required />
                  </div>
                  <div style="clear:both;"></div>
                  <div class="abformTitle"><strong>Email</strong></div>
                  <div class="abformTitle">
                    <input class="abInput" type="email" placeholder="Enter your email" name="email" required />
                  </div>
                  <div style="clear:both;"></div>
                  <div class="abformTitle"><strong>Organization</strong></div>
                  <div class="abformTitle">
                    <input class="abInput" type="text" placeholder="Organization/institution" name="institution" required />
                  </div>
                  <div style="clear:both;"></div>
                  <div class="abformTitle"><strong>Telephone</strong></div>
                  <div class="abformTitle">
                    <input class="abInput" type="text" placeholder="Enter your phone number" name="phone" required />
                  </div>
                  <div style="clear:both;"></div>
                  <div class="abformTitle"><strong>City</strong></div>
                  <div class="abformTitle">
                    <input class="abInput" type="text" placeholder="Enter your city name" name="city" required />
                  </div>
                  <div style="clear:both;"></div>
                  <div class="abformTitle"><strong>Country</strong></div>
                  <div class="abformTitle">
                    <select class="abInput1" name="country" data-country="US" required>
                      <option value="Select Any" selected="selected">Select country</option>
                      <option value="United States">United States</option>
                      <option value="United Kingdom">United Kingdom</option>
                      <option value="Afghanistan">Afghanistan</option>
                      <option value="Albania">Albania</option>
                      <option value="Algeria">Algeria</option>
                      <option value="American Samoa">American Samoa</option>
                      <option value="Andorra">Andorra</option>
                      <option value="Angola">Angola</option>
                      <option value="Anguilla">Anguilla</option>
                      <option value="Antarctica">Antarctica</option>
                      <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                      <option value="Argentina">Argentina</option>
                      <option value="Armenia">Armenia</option>
                      <option value="Aruba">Aruba</option>
                      <option value="Australia">Australia</option>
                      <option value="Austria">Austria</option>
                      <option value="Azerbaijan">Azerbaijan</option>
                      <option value="Bahamas">Bahamas</option>
                      <option value="Bahrain">Bahrain</option>
                      <option value="Bangladesh">Bangladesh</option>
                      <option value="Barbados">Barbados</option>
                      <option value="Belarus">Belarus</option>
                      <option value="Belgium">Belgium</option>
                      <option value="Belize">Belize</option>
                      <option value="Benin">Benin</option>
                      <option value="Bermuda">Bermuda</option>
                      <option value="Bhutan">Bhutan</option>
                      <option value="Bolivia">Bolivia</option>
                      <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                      <option value="Botswana">Botswana</option>
                      <option value="Bouvet Island">Bouvet Island</option>
                      <option value="Brazil">Brazil</option>
                      <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                      <option value="Brunei Darussalam">Brunei Darussalam</option>
                      <option value="Bulgaria">Bulgaria</option>
                      <option value="Burkina Faso">Burkina Faso</option>
                      <option value="Burundi">Burundi</option>
                      <option value="Cambodia">Cambodia</option>
                      <option value="Cameroon">Cameroon</option>
                      <option value="Canada">Canada</option>
                      <option value="Canadian Nunavut Territory">Canadian Nunavut Territory</option>
                      <option value="Cape Verde">Cape Verde</option>
                      <option value="Cayman Islands">Cayman Islands</option>
                      <option value="Central African Republic">Central African Republic</option>
                      <option value="Chad">Chad</option>
                      <option value="Chile">Chile</option>
                      <option value="China">China</option>
                      <option value="Christmas Island">Christmas Island</option>
                      <option value="Cocos (Keeling Islands)">Cocos (Keeling Islands)</option>
                      <option value="Colombia">Colombia</option>
                      <option value="Comoros">Comoros</option>
                      <option value="Congo">Congo</option>
                      <option value="Cook Islands">Cook Islands</option>
                      <option value="Costa Rica">Costa Rica</option>
                      <option value="Cote D'Ivoire (Ivory Coast)">Cote D'Ivoire (Ivory Coast)</option>
                      <option value="Croatia (Hrvatska)">Croatia (Hrvatska)</option>
                      <option value="Cuba">Cuba</option>
                      <option value="Cyprus">Cyprus</option>
                      <option value="Czech Republic">Czech Republic</option>
                      <option value="Denmark">Denmark</option>
                      <option value="Djibouti">Djibouti</option>
                      <option value="Dominica">Dominica</option>
                      <option value="Dominican Republic">Dominican Republic</option>
                      <option value="East Timor">East Timor</option>
                      <option value="Ecuador">Ecuador</option>
                      <option value="Egypt">Egypt</option>
                      <option value="El Salvador">El Salvador</option>
                      <option value="Equatorial Guinea">Equatorial Guinea</option>
                      <option value="Eritrea">Eritrea</option>
                      <option value="Estonia">Estonia</option>
                      <option value="Ethiopia">Ethiopia</option>
                      <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                      <option value="Faroe Islands">Faroe Islands</option>
                      <option value="Fiji">Fiji</option>
                      <option value="Finland">Finland</option>
                      <option value="France">France</option>
                      <option value="France, Metropolitan">France, Metropolitan</option>
                      <option value="French Guiana">French Guiana</option>
                      <option value="French Polynesia">French Polynesia</option>
                      <option value="French Southern Territories">French Southern Territories</option>
                      <option value="Gabon">Gabon</option>
                      <option value="Gambia">Gambia</option>
                      <option value="Georgia">Georgia</option>
                      <option value="Germany">Germany</option>
                      <option value="Ghana">Ghana</option>
                      <option value="Gibraltar">Gibraltar</option>
                      <option value="Greece">Greece</option>
                      <option value="Greenland">Greenland</option>
                      <option value="Grenada">Grenada</option>
                      <option value="Guadeloupe">Guadeloupe</option>
                      <option value="Guam">Guam</option>
                      <option value="Guatemala">Guatemala</option>
                      <option value="Guinea">Guinea</option>
                      <option value="Guinea-Bissau">Guinea-Bissau</option>
                      <option value="Guyana">Guyana</option>
                      <option value="Haiti">Haiti</option>
                      <option value="Heard and McDonald Islands">Heard and McDonald Islands</option>
                      <option value="Honduras">Honduras</option>
                      <option value="Hong Kong">Hong Kong</option>
                      <option value="Hungary">Hungary</option>
                      <option value="Iceland">Iceland</option>
                      <option value="India">India</option>
                      <option value="Indonesia">Indonesia</option>
                      <option value="Iran">Iran</option>
                      <option value="Iraq">Iraq</option>
                      <option value="Ireland">Ireland</option>
                      <option value="Israel">Israel</option>
                      <option value="Italy">Italy</option>
                      <option value="Jamaica">Jamaica</option>
                      <option value="Japan">Japan</option>
                      <option value="Jordan">Jordan</option>
                      <option value="Kazakhstan">Kazakhstan</option>
                      <option value="Kenya">Kenya</option>
                      <option value="Kiribati">Kiribati</option>
                      <option value="Korea (North)">Korea (North)</option>
                      <option value="Korea (South)">Korea (South)</option>
                      <option value="Kuwait">Kuwait</option>
                      <option value="Kyrgyzstan">Kyrgyzstan</option>
                      <option value="Laos">Laos</option>
                      <option value="Latvia">Latvia</option>
                      <option value="Lebanon">Lebanon</option>
                      <option value="Lesotho">Lesotho</option>
                      <option value="Liberia">Liberia</option>
                      <option value="Libya">Libya</option>
                      <option value="Liechtenstein">Liechtenstein</option>
                      <option value="Lithuania">Lithuania</option>
                      <option value="Luxembourg">Luxembourg</option>
                      <option value="Macau">Macau</option>
                      <option value="Macedonia">Macedonia</option>
                      <option value="Madagascar">Madagascar</option>
                      <option value="Malawi">Malawi</option>
                      <option value="Malaysia">Malaysia</option>
                      <option value="Maldives">Maldives</option>
                      <option value="Mali">Mali</option>
                      <option value="Malta<">Malta</option>
                      <option value="Marshall Islands">Marshall Islands</option>
                      <option value="Martinique">Martinique</option>
                      <option value="Mauritania">Mauritania</option>
                      <option value="Mauritius">Mauritius</option>
                      <option value="Mayotte">Mayotte</option>
                      <option value="Mexico">Mexico</option>
                      <option value="Micronesia">Micronesia</option>
                      <option value="Moldova">Moldova</option>
                      <option value="Monaco">Monaco</option>
                      <option value="Mongolia">Mongolia</option>
                      <option value="Montserrat">Montserrat</option>
                      <option value="Morocco">Morocco</option>
                      <option value="Mozambique">Mozambique</option>
                      <option value="Myanmar">Myanmar</option>
                      <option value="Namibia">Namibia</option>
                      <option value="Nauru">Nauru</option>
                      <option value="Nepal">Nepal</option>
                      <option value="Netherlands">Netherlands</option>
                      <option value="Netherlands Antilles">Netherlands Antilles</option>
                      <option value="New Caledonia">New Caledonia</option>
                      <option value="New Zealand">New Zealand</option>
                      <option value="Nicaragua">Nicaragua</option>
                      <option value="Niger">Niger</option>
                      <option value="Nigeria">Nigeria</option>
                      <option value="Niue">Niue</option>
                      <option value="Norfolk Island">Norfolk Island</option>
                      <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                      <option value="Norway">Norway</option>
                      <option value="Oman">Oman</option>
                      <option value="Pakistan">Pakistan</option>
                      <option value="Palau">Palau</option>
                      <option value="Panama">Panama</option>
                      <option value="Papua New Guinea">Papua New Guinea</option>
                      <option value="Paraguay">Paraguay</option>
                      <option value="Peru">Peru</option>
                      <option value="Philippines">Philippines</option>
                      <option value="Pitcairn">Pitcairn</option>
                      <option value="Poland">Poland</option>
                      <option value="Portugal">Portugal</option>
                      <option value="Qatar">Qatar</option>
                      <option value="Reunion">Reunion</option>
                      <option value="Romania">Romania</option>
                      <option value="Russian Federation">Russian Federation</option>
                      <option value="Rwanda">Rwanda</option>
                      <option value="S. Georgia and S. Sandwich Isls.">S. Georgia and S. Sandwich Isls.</option>
                      <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                      <option value="Saint Lucia">Saint Lucia</option>
                      <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                      <option value="Samoa">Samoa</option>
                      <option value="San Marino">San Marino</option>
                      <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                      <option value="Saudi Arabia">Saudi Arabia</option>
                      <option value="Senegal">Senegal</option>
                      <option value="Seychelles">Seychelles</option>
                      <option value="Sierra Leone">Sierra Leone</option>
                      <option value="Singapore">Singapore</option>
                      <option value="Slovak Republic">Slovak Republic</option>
                      <option value="Slovenia">Slovenia</option>
                      <option value="Solomon Islands">Solomon Islands</option>
                      <option value="Somalia">Somalia</option>
                      <option value="South Africa">South Africa</option>
                      <option value="Spain">Spain</option>
                      <option value="Sri Lanka">Sri Lanka</option>
                      <option value="St. Helena">St. Helena</option>
                      <option value="St. Pierre and Miquelon">St. Pierre and Miquelon</option>
                      <option value="Sudan">Sudan</option>
                      <option value="Suriname">Suriname</option>
                      <option value="Svalbard and Jan Mayen Islands">Svalbard and Jan Mayen Islands</option>
                      <option value="Swaziland">Swaziland</option>
                      <option value="Sweden">Sweden</option>
                      <option value="Switzerland">Switzerland</option>
                      <option value="Syria">Syria</option>
                      <option value="Taiwan">Taiwan</option>
                      <option value="Tajikistan">Tajikistan</option>
                      <option value="Tanzania">Tanzania</option>
                      <option value="Thailand">Thailand</option>
                      <option value="Togo">Togo</option>
                      <option value="Tokelau">Tokelau</option>
                      <option value="Tonga">Tonga</option>
                      <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                      <option value="Tunisia">Tunisia</option>
                      <option value="Turkey">Turkey</option>
                      <option value="Turkmenistan">Turkmenistan</option>
                      <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                      <option value="Tuvalu">Tuvalu</option>
                      <option value="US Minor Outlying Islands">US Minor Outlying Islands</option>
                      <option value="Uganda">Uganda</option>
                      <option value="Ukraine">Ukraine</option>
                      <option value="United Arab Emirates">United Arab Emirates</option>
                      <option value="United Kingdom">United Kingdom</option>
                      <option value="United States">United States</option>
                      <option value="Uruguay">Uruguay</option>
                      <option value="Uzbekistan">Uzbekistan</option>
                      <option value="Vanuatu">Vanuatu</option>
                      <option value="Vatican City State (Holy See)">Vatican City State (Holy See)</option>
                      <option value="Venezuela">Venezuela</option>
                      <option value="Viet Nam">Viet Nam</option>
                      <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                      <option value="Wallis and Futuna Islands">Wallis and Futuna Islands</option>
                      <option value="Western Sahara">Western Sahara</option>
                      <option value="Yemen">Yemen</option>
                      <option value="Yugoslavia">Yugoslavia</option>
                      <option value="Zaire">Zaire</option>
                      <option value="Zambia">Zambia</option>
                      <option value="Zimbabwe">Zimbabwe</option>
                    </select>
                  </div>
                  <div style="clear:both;"></div>
                  <div class="abformTitle"><strong>Interested in</strong></div>
                  <div class="abformTitle">
                    <select class="abInput1" name="interest" required>
                      <option value="Keynote"> Keynote </option>
                      <option value="Podium"> Podium </option>
                      <option value="Poster"> Poster </option>
                      <option value="Panel discussion"> Panel discussion </option>
                      <option value="Symposium"> Symposium </option>
                      <option value="Others"> Others </option>
                    </select>
                  </div>
                  <div style="clear:both;"></div>
                  <div class="abformTitle"><strong>Sessions</strong></div>
                  <div class="abformTitle">
                    <select class="abInput1" name="session" required>
                      <option selected>Select</option>
                      <option value="Novel approaches for vaccine development">Novel approaches for vaccine development</option>
                      <option value="COVID vaccines">COVID vaccines</option>
                      <option value="Cancer vaccines">Cancer vaccines</option>
                      <option value="HIV vaccines">HIV vaccines</option>
                      <option value="Emerging diseases (Coronavirus, Zika, Dengue, Ebola, Nipah, others)">Emerging Diseases (Coronavirus, Zika, Dengue, Ebola, Nipah, others)</option>
                      <option value="Influenza / respiratory vaccines">Influenza / respiratory vaccines</option>
                      <option value="Fungal / bacterial / AMR / parasitic / STD vaccines">Fungal / bacterial / AMR / parasitic / STD vaccines</option>
                      <option value="Adjuvants">Adjuvants</option>
                      <option value="Vaccine delivery technology">Vaccine delivery technology</option>
                      <option value="Immune response">Immune response</option>
                      <option value="Clinical trials and development">Clinical trials and development</option>
                      <option value="Thermo stabilized vaccines">Thermo stabilized vaccines</option>
                      <option value="Vaccine production">Vaccine production</option>
                      <option value="Antigen design">Antigen design</option>
                      <option value="Veterinary vaccines">Veterinary vaccines</option>
                      <option value="Clinical trials and vaccine responsiveness">Clinical trials and vaccine responsiveness</option>
                      <option value="Vaccine process development and production">Vaccine process development and production</option>
                      <option value="Structure-based vaccine design">Structure-based vaccine design</option>
                      <option value="Malaria vaccines">Malaria vaccines</option>
                      <option value="Bacterial vaccines">Bacterial vaccines</option>
                      <option value="Viral vaccines">Viral vaccines</option>
                      <option value="Influenza">Influenza</option>
                      <option value="Clinical assays / high-throughput real-time virus neutralization assays">Clinical assays / high-throughput real-time virus neutralization assays</option>
                      <option value="HPV">HPV</option>
                      <option value="Lipid nanoparticles LNP">Lipid nanoparticles LNP</option>

                    </select>
                  </div>
                  <div style="clear:both;"></div>
                  <div class="abformTitle"><strong>Attach file</strong></div>
                  <div class="abformTitle">
                    <input class="abInput" type="file" name="uploadfile" required />
                  </div>
                  <div style="clear:both;"></div>
                  <div class="abformTitle"><strong>Sample abstract file</strong></div>
                  <div class="abformTitle1 sa"><a href="Abstract_Template.docx">Abstract template</a></div>
                  <div style="clear:both;"></div>
                  <div>
                    <input type="submit" name="submit" value="Submit" class="abButtons" style="cursor:pointer;" />
                  </div>
                  <br />
                  <!--<div class="abformTitle"><input type="reset" name="reset" value="Reset" class="abButtons" /></div>-->
                </form>
              <?php } ?>
          
<style>
  .abformTitle {
    float: left;
    padding: 5px;
    width: 220px;
  }

  .abformTitle1 {
    float: left;
    padding: 5px;
    width: 150px;
  }

  .abInput {
    font-style: italic;
    color: #999;
    padding: 2px 2px 2px 5px;
    border-radius: 3px;
    border: 1px solid #999;
    line-height: 28px;
    width: 256px;
  }

  .abInput1 {
    font-style: italic;
    color: #999;
    padding: 6px;
    border-radius: 3px;
    border: 1px solid #999;
    line-height: 20px;
    width: 254px;
  }

  .abstractform .sa a:link,
  .abstractform .sa a:visited {
    color: #004080;
    text-decoration: none;
    background: url(images/arrow-link.png) no-repeat left;
    -webkit-transition: all .3s ease-in-out;
    -moz-transition: all .3s ease-in-out;
    -o-transition: all .3s ease-in-out;
    transition: all .3s ease-in-out;
    padding: 0 0 0 1px;
    border: none;
    font-size: 16px;
    float: left;
    width: 170px;
    margin: 6px 0;
  }

  .abstractform .sa a:hover {
    color: #ff6600;
    text-decoration: underline;
    background: url(images/arrow-hover.png) no-repeat left;
    padding-left: 20px;
    -webkit-transition: all .3s ease-in-out;
    -moz-transition: all .3s ease-in-out;
    -o-transition: all .3s ease-in-out;
    transition: all .3s ease-in-out;
  }

  .abButtons {
    width: 150px;
    height: 50px;
    margin-top: 20px;
    display: block;
    margin-left: 100px;
  }

  .abHeading {
    text-align: left;
    padding: 5px;
  }

  @media (max-width:768px) {

    .abformTitle,
    .abformTitle1,
    .abInput,
    .abInput1 {
      width: 100%;
    }
  }
</style>
