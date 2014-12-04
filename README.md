# ReCaptcha

## Installation

### Modman

### Composer

## Configuration

1. Once you've got the module installed, sign into your Google account and visit https://www.google.com/recaptcha.
2. Hit the "Get reCAPTCHA" link and you'll be taken to your account overview page. Register a new site by adding a label and any domains you want to allow for this specific reCAPTCHA widget.
3. Under 'Adding reCAPTCHA to your site' you should see 'Keys', specifically your 'Site Key' and 'Secret Key', copy and paste both keys into their respective configuration fields under 'System -> Configuration -> General -> ReCaptcha'.

The Contacts module that ships with Magento is fairly rudimentary and hasn't been much work done to allow developers to integrate with that so unfortunately, we haven't yet found a nice way to add your ReCaptcha block to the form automatically for you. Instead, you're going to have to do it manually, luckily however, its a simple 2-step process:

1. Open your local.xml file for your theme and paste in the following:
    
    <contacts_index_index>
      <reference name="contactForm">
        <block name="sstudioforty9_recaptcha/autorender" name="studioforty9.recaptcha.autorender" template="studioforty9/recaptcha/autorender.phtml"/>
      </reference>
    </contacts_index_index>
    
2. Next, copy the /contacts/form.phtml template over to your theme, if you haven't already done so, just above the `buttons-set` div paste in the following code:

    <?php echo $this->getChildHtml('studioforty9.recaptcha.autorender'); ?>

## Contributing

## Licence