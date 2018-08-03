# Wegmeister.SimpleCaptcha
*Tested with Flow 4.0.x*

Neos-Plugin to integrate a simple time based Captcha into Forms

(c) Benjamin Klix, die wegmeister gmbh


## Installation

Require the package using composer:
```
    composer require wegmeister/simplecaptcha
```

Then you can simply add the new form element to your form definition renderables:
```yaml
type: 'Neos.Form:Form'
identifier: someIdentifier
label: Label
renderables:
  -
    type: 'Neos.Form:Page'
    identifier: page-one
    renderables:
      -
        type: 'Wegmeister.SimpleCaptcha:SimpleCaptcha'
        identifier: captcha
        properties:
          # Required waiting time before form can successfully be submitted:
          waitTime: 5
        # optionally change the translationPackage
        # if you want to adjust the error message
        #renderingOptions:
        #  validationErrorTranslationPackage: 'Wegmeister.SimpleCaptcha'
finishers:
  -
   <Your finishers here>
```
## Using with [Neos.Form.Builder](https://github.com/neos/form-builder)

Install Neos.Form.Builder
```
composer require neos/form-builder
```

Add Simple Captcha form element to your form

Configure Simple Captcha wait time.

### I18N

English and German are the only supported languages at the moment. Feel free to send a pull request for another language so we can add it to the plugin.



