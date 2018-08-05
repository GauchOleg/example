<?php
/* @var $metaData \app\modules\dashboard\models\Producer @type array */
?>
<!-- Contact section start -->
<div id="contact" class="contact">
    <div class="section secondary-section">
        <div class="container">
            <div class="title">
                <h2><?php echo isset($metaData['contact_title']['meta_value']) ? $metaData['contact_title']['meta_value'] : ''?></h2>
                <p><?php echo isset($metaData['contact_address']['meta_value']) ? $metaData['contact_address']['meta_value'] : ''?></p>
                <p><?php echo isset($metaData['contact_phone']['meta_value']) ? $metaData['contact_phone']['meta_value'] : ''?></p>
            </div>
        </div>
        <div class="map-wrapper">
            <div class="map-canvas" >
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2565.3283735750347!2d36.24253377557608!3d49.98645272339257!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4127a08cd982aa13%3A0x29b96d156642b39c!2z0KfQtdGA0LLQvtC90L7RiNC60ZbQu9GM0L3QsCDQvdCw0LHQtdGA0LXQttC90LAsIDQsINCl0LDRgNC60ZbQsiwg0KXQsNGA0LrRltCy0YHRjNC60LAg0L7QsdC70LDRgdGC0YwsIDYxMDAw!5e0!3m2!1sru!2sua!4v1532158150299" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
            <div class="container">
                <div class="row-fluid">

                    <!--                    <div class="span5 contact-form centered">-->
                    <!--                        <h3>Say Hello</h3>-->
                    <!--                        <div id="successSend" class="alert alert-success invisible">-->
                    <!--                            <strong>Well done!</strong>Your message has been sent.</div>-->
                    <!--                        <div id="errorSend" class="alert alert-error invisible">There was an error.</div>-->
                    <!--                        <form id="contact-form" action="php/mail.php">-->
                    <!--                            <div class="control-group">-->
                    <!--                                <div class="controls">-->
                    <!--                                    <input class="span12" type="text" id="name" name="name" placeholder="* Your name..." />-->
                    <!--                                    <div class="error left-align" id="err-name">Please enter name.</div>-->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!--                            <div class="control-group">-->
                    <!--                                <div class="controls">-->
                    <!--                                    <input class="span12" type="email" name="email" id="email" placeholder="* Your email..." />-->
                    <!--                                    <div class="error left-align" id="err-email">Please enter valid email adress.</div>-->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!--                            <div class="control-group">-->
                    <!--                                <div class="controls">-->
                    <!--                                    <textarea class="span12" name="comment" id="comment" placeholder="* Comments..."></textarea>-->
                    <!--                                    <div class="error left-align" id="err-comment">Please enter your comment.</div>-->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!--                            <div class="control-group">-->
                    <!--                                <div class="controls">-->
                    <!--                                    <button id="send-mail" class="message-btn">Send message</button>-->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!--                        </form>-->
                    <!--                    </div>-->
                </div>
            </div>
        </div>
        <!--        <div class="container">-->
        <!--            <div class="span9 center contact-info">-->
        <!--                <p>123 Fifth Avenue, 12th,Belgrade,SRB 11000</p>-->
        <!--                <p class="info-mail">ourstudio@somemail.com</p>-->
        <!--                <p>+11 234 567 890</p>-->
        <!--                <p>+11 286 543 850</p>-->
        <!--                <div class="title">-->
        <!--                    <h3>We Are Social</h3>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="row-fluid centered">-->
        <!--                <ul class="social">-->
        <!--                    <li>-->
        <!--                        <a href="">-->
        <!--                            <span class="icon-facebook-circled"></span>-->
        <!--                        </a>-->
        <!--                    </li>-->
        <!--                    <li>-->
        <!--                        <a href="">-->
        <!--                            <span class="icon-twitter-circled"></span>-->
        <!--                        </a>-->
        <!--                    </li>-->
        <!--                    <li>-->
        <!--                        <a href="">-->
        <!--                            <span class="icon-linkedin-circled"></span>-->
        <!--                        </a>-->
        <!--                    </li>-->
        <!--                    <li>-->
        <!--                        <a href="">-->
        <!--                            <span class="icon-pinterest-circled"></span>-->
        <!--                        </a>-->
        <!--                    </li>-->
        <!--                    <li>-->
        <!--                        <a href="">-->
        <!--                            <span class="icon-dribbble-circled"></span>-->
        <!--                        </a>-->
        <!--                    </li>-->
        <!--                    <li>-->
        <!--                        <a href="">-->
        <!--                            <span class="icon-gplus-circled"></span>-->
        <!--                        </a>-->
        <!--                    </li>-->
        <!--                </ul>-->
        <!--            </div>-->
        <!--        </div>-->
    </div>
</div>

<!--<script async="" defer="" type="text/javascript" src="https://goo.gl/maps/2KdQ3BYUUSM2"></script>-->
<!--<script>-->
<!--    $('[data-id="cart"]').attr('href','/cart');-->
<!--</script>-->