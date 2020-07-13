<!DOCTYPE html>
<html>
    <head>
        <title>Phone Verification</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" media="all" href="https://cdnjs.cloudflare.com/ajax/libs/authy-form-helpers/2.3/form.authy.min.css">
    </head>

    <body>
        <header class="site-home-header">
            <div class="outer site-header-background no-image">        
                <div class="inner">
                    <div class="site-header-content">
                        <h1 class="site-title">
                            <img class="site-logo" src="https://blog.tiniyo.com/content/images/2020/03/logo.png" alt="Tiniyo Phone Verification">
                        </h1>
                        <h2 class="site-description">Phone Verification</h2>
                        <p class="site-sub-description">How to use Tiniyo <a id="tiniyo-link" href="https://tiniyo.com/dist/index-verify.html#section/Introduction"> VERIFICATION API </a> in real time.</p> 
                    </div>
                </div>
            </div>
        </header>
        <form action="verify.php" accept-charset="UTF-8" method="POST">
            <div class="container">
                <ul>
                    <li>
                        <div>
                        <select name="cc" id="authy-countries"  data-show-as="text"></select>
                        </div>
                    </li>
                    <li>
                        <div>
                        <input type="tel" id="phone_number" placeholder="Phone Number" name="pn" />
                        </div>
                    </li>
                    <li>
                        <div>
                        <select class="select" id="channel" name="ch">
                            <option value="sms">Sms</option>
                            <option value="call">Call</option>
                            <option value="all" selected>All</option>
                        </select>
                        </div>
                    </li>
                    <li>
                        <div>
                        <select class="select" id="length" name="l">
                            <option value="4">4</option>
                            <option value="6" selected>6</option>
                            <option value="8">8</option>
                        </select>
                        </div>
                    </li>
                    <li>
                        <button name="button" type="submit">Verify</button>
                    </li>
                </ul>
            </div>
        </form> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/authy-form-helpers/2.3/form.authy.min.js"></script>
    </body>
</html>
