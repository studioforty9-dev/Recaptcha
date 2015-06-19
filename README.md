# ReCaptcha

[![Build Status](https://travis-ci.org/StudioForty9/Recaptcha.svg?branch=master)](https://travis-ci.org/StudioForty9/Recaptcha)
[![TripleCheck Grade](http://triplecheck.io/badge/grade/241)](http://triplecheck.io/details/241)

## Features

The reCAPTCHA extension uses Google's reCAPTCHA widget [(read more)](https://www.google.com/recaptcha/intro/index.html) to lower the friction when identifying real people and provide powerful protection against spam with front-end forms in Magento, we currently support the following forms:

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

1. Once you've got the extension installed, sign into your Google account and visit https://www.google.com/recaptcha.
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

Again under `/app/design/frontend/base/default/template/studioforty9/recaptcha/samples/` - take a look at `/base/persistent/customer/form/register.phtml`. The template is an exact copy of the base customer registration form template with our extension code already installed in the correct place. Just drop the file into your custom theme. It uses the `explicit` block which gives you javascript validation on the recaptcha widget by default.

### Using reCAPTCHA on the Send to Friend Page

You guessed it, under `/app/design/frontend/base/default/template/studioforty9/recaptcha/samples/` - take a look at `base/sendfriend/send.phtml`. The template is an exact copy of the base send to friend form template but with our extension code already installed in the correct place. Just drop the file into your custom theme. It uses the `explicit` block which gives you javascript validation on the recaptcha widget by default.

### Using reCAPTCHA/Magento Contact Form on a CMS Page

Open up the cms page in Magento and go to the Design Tab and paste the following under 'Layout Update XML':

```xml
<reference name="content">
  <block type="core/template" name="contactForm" template="contacts/form.phtml">
    <action method="setFormAction"><value>/contacts/index/post</value></action>
    <block type="studioforty9_recaptcha/explicit" name="studioforty9.recaptcha.explicit" template="studioforty9/recaptcha/explicit.phtml">
      <action method="setAllow"><value>true</value></action>
    </block>
  </block>
</reference>
```

### Using the reCAPTCHA widget on other pages

The reCAPTCHA widget is set up as a Magento Block, if you are trying to display it on a form but it's not showing up, it's typically one of the following:

1. Your custom Layout XML for the recaptcha block is incorrect.
2. Your custom Layout XML is referencing the wrong parent block.
3. You haven't told the block to allow itself to be displayed.
4. You haven't added the call to `$this->getChildHtml('studioforty9.recaptcha.explicit')` to the template

Unfortunately, we can't possibly know if your Layout XML is incorrect without seeing it, so make sure you've got something like the following:

```xml
<block type="studioforty9_recaptcha/explicit" name="studioforty9.recaptcha.explicit" template="studioforty9/recaptcha/explicit.phtml">
  <action method="setAllow"><value>true</value></action>
</block>
```

You also have to know which parent block to include the reCAPTCHA block on, usually that means the block which includes the form.

Out of the box, we set up the reCAPTCHA widget to display on certain pages, product review, send to friend, contacts and customer registration, if you need to include it on a page that isn't one of those then you need to set the 'allow' flag on the block:

```xml
<action method="setAllow"><value>true</value></action>
```

Of course, the widget cannot display at all if you don't tell the template to display it, find the template of the form you want to add reCAPTCHA to and add the following snippet of PHP.

```php
<?php echo $this->getChildHtml('studioforty9.recaptcha.explicit'); ?>
```

### Using reCAPTCHA with themes and other extensions

Some extensions out there will completely overwrite layout blocks to suit their own needs, we can't do anything about that, except  encourage other extension developers to more mindful of the Magento community, here are some known conflicts with other vendors:

#### Ebizmarts_MageMonkey:

Includes the following html which removes the built-in review form:

```xml
<review_product_list>
<reference name="product.info.product_additional_data">
    <remove name="product.review.form"/>
    <block type="ebizmarts_autoresponder/review_form" name="product.review.form.autoresponder" as="review_form"/>
    <block type="page/html_wrapper" name="product.review.form.fields.before" as="form_fields_before" translate="label"/>
    <label>Review Form Fields Before</label>
    <action method="setMayBeInvisible">
        <value>1</value>
    </action>
</reference>
</review_product_list>
```
You can fix this by replacing it with the following XML.

```xml
<review_product_list>
  <reference name="product.info.product_additional_data">
    <remove name="product.review.form"/>
    <block type="ebizmarts_autoresponder/review_form" name="product.review.form.autoresponder" as="review_form">
      <block type="studioforty9_recaptcha/explicit" name="studioforty9.recaptcha.explicit" template="studioforty9/recaptcha/explicit.phtml"/>
    </block>
    <block type="page/html_wrapper" name="product.review.form.fields.before" as="form_fields_before" translate="label"/>
    <label>Review Form Fields Before</label>
    <action method="setMayBeInvisible">
        <value>1</value>
    </action>
  </reference>
</review_product_list>
```

#### Ultimo Theme by Infortis

The review form is included on a tab on the product page with this theme, [click here for an example](http://ultimo.infortis-themes.com/demo/default/phone3.html)

Since we are no longer on the default review page, we have to add some code to Layout XML to get this working, Under `<catalog_product_view>`, you can add the following in your local.xml file for your theme:

```xml
<catalog_product_view>
  ... more XML above ...
  <reference name="tabreviews">
    <block type="review/form" name="product.review.form" as="review_form">
      <block type="studioforty9_recaptcha/explicit" name="studioforty9.recaptcha.explicit" template="studioforty9/recaptcha/explicit.phtml">
        <action method="setAllow"><value>true</value></action>
      </block>
      <block type="page/html_wrapper" name="product.review.form.fields.before" as="form_fields_before" translate="label">
        <label>Review Form Fields Before</label>
        <action method="setMayBeInvisible"><value>1</value></action>
      </block>
    </block>
  </reference>
  ... more XML below ...
</catalog_product_view>
```

## Developers

If you want to integrate your own extension and add the reCAPTCHA widget to a form, simply add the observer to your own extension config.xml:

```xml
<config>
    <frontend>
        <events>
            <controller_action_predispatch_yourcontroller_action_method>
                <observers>
                    <studioforty9_recaptcha>
                        <class>studioforty9_recaptcha/observer</class>
                        <method>onPostPreDispatch</method>
                    </studioforty9_recaptcha>
                </observers>
            </controller_action_predispatch_yourcontroller_action_method>
        </events>
    </frontend>
</config>
```
    
Next, include the block in your layout XML:

```xml
<your_layout_handle>
    <reference name="your.form.template">
        <block type="studioforty9_recaptcha/explicit" name="studioforty9.recaptcha.explicit" template="studioforty9/recaptcha/explicit.phtml">
          <action method="setAllow"><value>true</value></action>
        </block>
    </reference>
</your_layout_handle>
```

Finally, add the block to your form template code:

```php
<?php echo $this->getChildHtml('studioforty9.recaptcha.explicit'); ?>
```

## Contributing

[see CONTRIBUTING file](https://github.com/studioforty9/recaptcha/blob/master/CONTRIBUTING.md)

## Licence

BSD 3 Clause [see LICENCE file](https://github.com/studioforty9/recaptcha/blob/master/LICENCE)
