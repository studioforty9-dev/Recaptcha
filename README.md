# ReCaptcha

[![Build Status](https://travis-ci.org/StudioForty9/Recaptcha.svg?branch=master)](https://travis-ci.org/StudioForty9/Recaptcha)

## Features

Add the Google ReCaptcha widget to front-end forms in Magento, we currently support the following forms:

- Contact page form
- Product Review form
- Customer Registration form
- Product Send to friend form

## Installation

### Composer

Add the package to your require list:

```json
"require": {
    "studioforty9/recaptcha": "dev-master"
}
```

Add the repository to your project composer.json file:

```json
"repositories": [
    {"type": "composer", "url": "http://packages.firegento.com"}
],
```

## Configuration

1. Once you've got the module installed, sign into your Google account and visit https://www.google.com/recaptcha.
2. Hit the "Get reCAPTCHA" link and you'll be taken to your account overview page. Register a new site by adding a label and any domains you want to allow for this specific reCAPTCHA widget.
3. Under 'Adding reCAPTCHA to your site' you should see 'Keys', specifically your 'Site Key' and 'Secret Key', copy and paste both keys into their respective configuration fields under 'System -> Configuration -> Sales -> Google API -> Google ReCaptcha'.
4. Copy the /contacts/form.phtml template over to your theme, if you haven't already done so, just above the `buttons-set` div paste in the following code:

#### Explicit
```php
<?php echo $this->getChildHtml('studioforty9.recaptcha.explicit'); ?>
```

#### Autorender

```php
<?php echo $this->getChildHtml('studioforty9.recaptcha.autorender'); ?>
```

Note: The default block in the layout XML file is `explicit`.

### Autorender vs Explicit Blocks

The `autorender` block is the simplest form of the recaptcha widget, you get only what Google provide out of the box. The `explicit` block enables the ReCaptcha Javascript API and by default we've added some front-end validation. You can extend the Javascript to do anything you need or if you're happy with the default functionality, you can leave it alone and it will work perfectly.

### Using reCAPTCHA on the Contacts Page

We've provided some samples under `/app/design/frontend/base/default/template/studioforty9/recaptcha/samples/` - take a look at `base/contacts/form.phtml`. The template is an exact copy of the base contact form template with our extension code already installed in the correct place. You can drop that into your custom theme and you're good to go. It uses the `explicit` block which gives you javascript validation on the recaptcha widget by default.

### Using reCAPTCHA on the Product Reviews Page

You can check out the file under `/app/design/frontend/base/default/template/studioforty9/recaptcha/samples/` - take a look at `base/review/form.phtml`. The template is an exact copy of the base review form template but with our extension code already installed in the correct place. Drop the file into your custom theme and you're good to go. It also uses the `explicit` block which gives you javascript validation on the recaptcha widget by default.

### Using reCAPTCHA on the Account Registration Page

Again under `/app/design/frontend/base/default/template/studioforty9/recaptcha/samples/` - take a look at `base/persistent/form/register.phtml`. The template is an exact copy of the base customer registration form template with our extension code already installed in the correct place. Just drop the file into your custom theme. It uses the `explicit` block which gives you javascript validation on the recaptcha widget by default.

### Using reCAPTCHA on the Send to Friend Page

You guessed it, under `/app/design/frontend/base/default/template/studioforty9/recaptcha/samples/` - take a look at `base/sendfriend/send.phtml`. The template is an exact copy of the base send to friend form template but with our extension code already installed in the correct place. Just drop the file into your custom theme. It uses the `explicit` block which gives you javascript validation on the recaptcha widget by default.

### Using reCAPTCHA/Magento Contact Form on a CMS Page

Open up the cms page in Magento and go to the Design Tab and paste the following under 'Layout Update XML':

    <reference name="content">
      <block type="core/template" name="contactForm" template="contacts/form.phtml">
        <action method="setFormAction"><value>/contacts/index/post</value></action>
        <block type="studioforty9_recaptcha/explicit" name="studioforty9.recaptcha.explicit" template="studioforty9/recaptcha/explicit.phtml"/>
      </block>
    </reference>


## Contributing

[see CONTRIBUTING file](https://github.com/studioforty9/recaptcha/blob/master/CONTRIBUTING.md)

## Licence

BSD 3 Clause [see LICENCE file](https://github.com/studioforty9/recaptcha/blob/master/LICENCE)
