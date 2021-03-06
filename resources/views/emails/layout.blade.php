<style type="text/css">
    h1 {
        font-size: 24px;
        text-transform: uppercase;
    }

    h2 {
        font-size: 16px;
        text-transform: uppercase;
    }

    .dbr-mail-message {
        background-color: #eff2f7;
        margin: 0 !important;
        padding: 20px;
        font-family: Arial, sans-serif;
        font-size: 15px;
        color: #23496d;
        word-break: break-word;
        text-align: center;
    }

    .container {
        max-width: 600px;
        margin: 0 auto;
        border: 1px solid #5f4eaa;
        background: white;
        overflow: hidden;
    }

    .container .banner {
        width: 100%;
    }

    .container .banner img {
        width: 100%;
    }

    .links {
        padding-top: 40px;
        padding-bottom: 63px;
        border-bottom: 1px solid #5f4eaa;
    }

    .links .link {
        width: 33.33%;
        float: left;
        text-align: center;
        font-size: 18px;
        line-height: 175%;
    }

    .links .link a {
        color: #5e50ac;
        font-weight: bold;
        text-decoration: none;
    }

    .section {
        padding: 10px;
    }

    a.btn {
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        font-size: 15px;
        color: #ffffff;
        word-break: break-word;
        border-radius: 10px;
        background-color: #5e50ac;
        padding: 12px;
        text-decoration: none;
        font-weight: bold;
        max-width: 200px;
        display: block;
        margin: 0 auto;
    }

    .footer .footer-links {
        padding-bottom: 20px;
    }

    .footer .footer-links img {
        outline: none;
        text-decoration: none;
        border: none;
        width: auto !important;
        height: 25px !important;
    }

    .footer .info {
        background: #eff2f7;
        font-size: 12px;
        padding-bottom: 20px;
        padding-top: 20px;
    }

    .splitter {
        width: 350px;
        margin: 0 auto 20px;
        padding-top: 20px;
        height: 1px;
        border-bottom: 1px #5f4eaa solid;
    }

</style>

<div class="dbr-mail-message">
    <div class="container">
        <div class="header">
            <div class="banner">
                <img data-imagetype="External"
                     src="https://hs-8195567.f.hubspotemail.net/hub/8195567/hubfs/szablon.png?width=1196&amp;upscale=true&amp;name=szablon.png"
                     alt="szablon" width="598" align="middle"
                     style="outline:none; text-decoration:none; border:none; max-width:100%; font-size:16px"
                >
            </div>
            <div class="links">
                <div class="link">
                    <a href="https://dbr77.com" target="_blank">DBR77</a>
                </div>
                <div class="link">
                    <a href="https://platform.dbr77.com" target="_blank">PLATFORMA</a>
                </div>
                <div class="link">
                    <a href="https://www.youtube.com/watch?v=tJWqyTp-KFk&ab_channel=DBR77" target="_blank">O NAS</a>
                </div>
            </div>
        </div>
        <div class="section">
            @yield('content')
        </div>
        <div class="splitter"></div>
        <div class="footer">
            <div class="section footer-links">
                <img
                    src="https://hs-8195567.f.hubspotemail.net/hs/hsstatic/TemplateAssets/static-1.24/img/hs_default_template_images/modules/Follow+Me+-+Email/facebook_circle_color.png"
                    alt="Facebook">
                <img data-imagetype="External"
                     src="https://hs-8195567.f.hubspotemail.net/hs/hsstatic/TemplateAssets/static-1.24/img/hs_default_template_images/modules/Follow+Me+-+Email/linkedin_circle_color.png"
                     alt="LinkedIn">
                <img data-imagetype="External"
                     src="https://hs-8195567.f.hubspotemail.net/hs/hsstatic/TemplateAssets/static-1.24/img/hs_default_template_images/modules/Follow+Me+-+Email/website_circle_color.png"
                     alt="Witryna internetowa">
                <img data-imagetype="External"
                     src="https://hs-8195567.f.hubspotemail.net/hs/hsstatic/TemplateAssets/static-1.24/img/hs_default_template_images/modules/Follow+Me+-+Email/youtube_circle_color.png"
                     alt="YouTube">

            </div>
            <div class="section info">
                <div class="company-info">
                    <p>{{ __('emails.main.mistake_info') }}</p>
                    <p>DBR77 Robotics Sp. z o.o., ??????kiewskiego, 31, 87-100 Toru??, NIP 8792725331</p>
                </div>
            </div>
        </div>
    </div>
</div>
