# Symfony Template Bundle

This package is used across various TYPO3 Symfony Applications to ensure a streamlined visual experience and reduced maintenance.

- [Symfony Template Bundle](#symfony-template-bundle)
- [Installation](#installation)
- [Configuration](#configuration)
  - [Encore](#encore)
  - [Extending Menus](#extending-menus)
- [Page Template](#page-template)
  - [Available Blocks](#available-blocks)
    - [`title`](#title)
    - [`headline`](#headline)
    - [`body`](#body)
    - [`footer`](#footer)
    - [`stylesheets`](#stylesheets)
    - [`javascripts`](#javascripts)
- [EMail Template](#email-template)
  - [Available Blocks](#available-blocks-1)
    - [`email_subject`](#email_subject)
    - [`email_plaintext`](#email_plaintext)
    - [`email_html_preview`](#email_html_preview)
    - [`email_html_body`](#email_html_body)
- [Utilities](#utilities)
  - [AvatarUtility::getAvatar(string $email, int $size)](#avatarutilitygetavatarstring-email-int-size)
  - [AvatarUtility::getAvatarUrl(string $email, int $size)](#avatarutilitygetavatarurlstring-email-int-size)
- [Twig Extensions](#twig-extensions)
  - [AutolinkExtension](#autolinkextension)
    - [`autolink`](#autolink)
  - [AvatarExtension](#avatarextension)
    - [`avatar`](#avatar)
  - [IconExtension](#iconextension)
    - [`icon`](#icon)
  - [MarkdownExtension](#markdownextension)
    - [`markdown`](#markdown)
  - [TemplateExtension](#templateextension)
    - [`template_function_exist`](#template_function_exist)
    - [`template_function_call`](#template_function_call)
  - [DateTimeExtension](#datetimeextension)
    - [`to_datetime`](#to_datetime)
    - [`localdate`](#localdate)
    - [`localdatetime`](#localdatetime)
    - [`relativetime`](#relativetime)
- [Twig Tags](#twig-tags)
  - [`frame`](#frame)
    - [Usage](#usage)
    - [Example](#example)
- [JavaScript Libraries](#javascript-libraries)
  - [Datepicker](#datepicker)
  - [Choices](#choices)

# Installation

```console
composer require t3g/symfony-template-bundle
```

Ensure that symfony default scripts are present in your `composer.json` file.

```json
{
    "scripts": {
        "auto-scripts": {
            "cache:clear": "symfony-cmd",
            "assets:install %PUBLIC_DIR%": "symfony-cmd"
        },
        "post-install-cmd": [
            "@auto-scripts"
        ],
        "post-update-cmd": [
            "@auto-scripts"
        ]
    }
}
```

# Configuration

The bundle comes with a sensible default configuration, which is listed below.
You can define these options if you need to change them:

```yaml
# config/packages/template.yaml
template:
    application:
        # Example: Intercept
        name: 'Template Bundle'
        # Example: intercept
        platformkey: ~
        copyright:
            author: TYPO3 GmbH
            url: https://typo3.com
        routes:
             # Example: app_index
            home: app_index
            privacy: https://typo3.com/privacy-policy
            legal: https://typo3.com/legal-notice
            feedback: https://jira.typo3.com/servicedesk/customer/portal/2
        menu:
            # Example: App\Menu\MenuBuilder
            class: T3G\Bundle\TemplateBundle\Menu\MenuBuilder
        assets:
            # Example: app
            encore_entrypoint: ~
        email:
            legal_footer: |
                TYPO3 GmbH, Emanuel-Leutze-Straße 11, DE-40547 Düsseldorf, Germany
                Phone: +49 (0)211 20 54 36 0, Web: www.typo3.com, Email: info@typo3.com

                Court of registration: Amtsgericht Düsseldorf HRB 77950
                CEO: Mathias Schreiber
                Supervisory Board: Olivier Dobberkau, Ric van Westhreenen, Stefan Busemann
        theme:
            # Example: md
            navbar_breakpoint: lg
            use_logo: false
            background: light
```

```console
bin/console config:dump-reference template
```

Configuration will be available within the templates and can be accessed through `template` variable.

Examples:

```twig
<title>{% block title %}{% endblock %} - {{ template.application.name }}</title>
```

```twig
<a class="navbar-brand" href="{{ path(template.application.routes.home) }}">
    <i class="fab fa-typo3 text-primary"></i>
    <strong>{{ template.application.name }}</strong>
</a>
```

## Encore

```console
composer require symfony/webpack-encore-bundle
```

To enable your encore entrypoint simply configure the key within the yaml configuration.

```yaml
# config/packages/template.yaml
template:
    application:
        assets:
            encore_entrypoint: app
```

## Extending Menus

```yaml
# config/packages/template.yml
template:
    application:
        menu:
            class: App\Menu\MenuBuilder
```

```php
<?php
namespace App\Menu;

use T3G\Bundle\TemplateBundle\Menu\MenuBuilder as TemplateMenuBuider;

class MenuBuilder extends TemplateMenuBuider
{
    public function mainDefault(array $options)
    {
        $menu = parent::mainDefault($options);
        $menu->addChild(
            'home',
            [
                'route' => 'app_index',
                'label' => 'Home',
                'extras' => [
                    'icon' => 'home',
                ],
            ]
        );
        return $menu;
    }
}
```

Available methods to override `mainDefault`, `mainProfile` and `mainFooter`.


### Dividing Menus

```php
$menu->addChild($this->getDivider());
```

# Page Template

Extend Default Layout

```twig
{% extends '@Template/layout.html.twig' %}
```

## Available Blocks

### `title`

```twig
{% block title %}Home{% endblock %}
```

```html
<title>Home - {{ template.application.name }}</title>
```

### `headline`

This block will **only** be rendered obove the body block if defined in the template.

```twig
{% block headline %}Super Headline{% endblock %}
```

```html
<div class="page-wrapper">
    <!-- HEADER -->
    <!-- FLASHMESSAGES -->
    <main class="page-main">
        <div class="content-section content-section-small bg-primary text-white">
            <div class="container">
                <h1 class="h2">Super Headline</h1>
            </div>
        </div>
        <!-- BODY BLOCK -->
    </main>
    <!-- FOOTER -->
</div>
```

### `body`

```twig
{% block body %}
    <div class="content-section">
        <div class="container">
            BODY CONTENT
        </div>
    </div>
{% endblock %}
```

```html
<div class="page-wrapper">
    <!-- HEADER -->
    <!-- FLASHMESSAGES -->
    <main class="page-main">
        <!-- HEADLINE -->
        <div class="content-section">
            <div class="container">
                BODY CONTENT
            </div>
        </div>
    </main>
    <!-- FOOTER -->
</div>
```

### `footer`


```twig
{% block footer %}
    <div class="content-section">
        <div class="container">
            FOOTER CONTENT
        </div>
    </div>
{% endblock %}
```

```html
<div class="page-wrapper">
    <!-- HEADER -->
    <!-- FLASHMESSAGES -->
    <!-- MAIN HEADLINE AND BODY -->
    <footer class="page-footer">
        <div class="content-section">
            <div class="container">
                FOOTER CONTENT
            </div>
        </div>
        <!-- COPYRIGHT AND FOOTER MENU -->
    </footer>
</div>
```

### `stylesheets`

Stylesheet block will be rendered after the `base` and `encore` css before the closing `</head>`.

### `javascripts`

JavaScript block will be rendered after `base` and `encore` javascript before the closing `</body>`.

# EMail Template

Extend Default Layout

```twig
{% extends '@Template/email.html.twig' %}
```

## Available Blocks

### `email_subject`

```twig
{% block email_subject %}Reset Your Password{% endblock %}
```

### `email_plaintext`

```twig
{% block email_plaintext %}
Forgot your password? Let's get you a new one.

We got a request to change the password for the account with the username {{ user.username }}.

You can reset your password by accessing {{ confirmationUrl }}

If you don't want to reset your password, you can ignore this email.
{% endblock %}
```

### `email_html_preview`

```twig
{% block email_html_preview %}
You requested a password reset for your account.
{% endblock %}
```

### `email_html_body`

```twig
{% block email_html_body %}
<h3>Forgot your password?<br>Let's get you a new one.</h3>
<p>We got a request to change the password for the account with the username <strong style="color: #222222;">{{ user.username }}</strong>.</p>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="buttonBlock" style="min-width:100%;">
    <tbody class="buttonBlockOuter">
        <tr>
            <td style="padding-top: 36px; padding-right:18px; padding-bottom:36px; padding-left:18px;" valign="top" align="center" class="buttonBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" class="buttonContentContainer" style="border-collapse: separate !important;border-radius: 3px;background-color: #ff8700;">
                    <tbody>
                        <tr>
                            <td align="center" valign="middle" class="buttonContent" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, Verdana, sans-serif; font-size: 16px; padding: 18px;">
                                <a class="button " title="Reset Your Password" href="{{ confirmationUrl }}" rel="noopener noreferrer" target="_blank" style="font-weight: bold;letter-spacing: -0.5px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Reset Your Password</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

<p style="font-size: 12px;">Or reset your password using this link: {{ confirmationUrl }}</p>
<p style="font-size: 12px;">If you don't want to reset your password, you can ignore this email.</p>
{% endblock %}
```

# Utilities

## AvatarUtility::getAvatar(string $email, int $size)

```php
<?php
use T3G\Bundle\TemplateBundle\Utility\AvatarUtility;
echo AvatarUtility::getAvatar('info@typo3.com', 32);
// <img src="https://...avatar.png" class="avatar" height="32" width="32">
```

## AvatarUtility::getAvatarUrl(string $email, int $size)

```php
<?php
use T3G\Bundle\TemplateBundle\Utility\AvatarUtility;
echo AvatarUtility::getAvatarUrl('info@typo3.com', 32);
// https://...avatar.png
```

# Twig Extensions

## AutolinkExtension

### `autolink`

Twig filter to automaticly convert urls, emails and phone numbers to links.

```twig
{{ value|autolink }}
```

or

```twig
{% apply autolink %}
    <p>
        Phone: +49 (0)211 205436-0<br>
        Web: www.typo3.com<br>
        Email: info@typo3.com
    </p>
{% endapply %}
```

```html
<p>
    Phone: <a href="tel:+492112054360">+49 (0)211 205436-0</a><br>
    Web: <a href="https://www.typo3.com" target="_blank" rel="noopener">www.typo3.com</a><br>
    Email: <a href="mailto:info@typo3.com">info@typo3.com</a>
</p>
```

## AvatarExtension

### `avatar`

Twig function to display avatars.

```twig
{{ avatar('info@typo3.com', 32) }}
```
```html
<img src="https://...avatar.png" class="avatar" height="32" width="32">
```

## IconExtension

### `icon`

Twig function to display typo3 icons.

```twig
{{ icon('actions-heart', 'auto') }}
```
```html
<span class="icon icon-size-auto icon-state-default">
    <span class="icon-markup">
        <svg role="img" class="icon-color"><use xlink:href="/bundles/template/icons/sprites/actions.svg#actions-heart"></use></svg>
    </span>
</span>
```

## MarkdownExtension

### `markdown`

Twig function to render markdown as HTML.

```twig
{{ value|markdown }}
```

## TemplateExtension

### `template_function_exist`

A function to check if a function is available within the current Twig Environment.

```twig
{% if template_function_exist('relativetime') %}
    The relativetime function is available.
{% endif %}
```

### `template_function_call`

Twig always checks for all functions with a template, also within a condition.
This function is a wrapper around the original function call that is only executed
if the function actually exists.

```twig
# Template will still work if `encore_entry_link_tags` is not defined, function just returns null.
{{ template_function_call('encore_entry_link_tags', template.application.assets.encore_entrypoint) }}

# Template will fail if `encore_entry_link_tags` is not registered.
{{ encore_entry_link_tags(template.application.assets.encore_entrypoint) }}
```

## DateTimeExtension

### `to_datetime`

Converts a unix timestamp to datetime object.

```twig
{{ to_datetime(timestamp) }}
```

### `localdate`

Returns a localized string representing this date.

```twig
{{ localdate(datetimeObject) }}
```


### `localdatetime`

Returns a localized string representing this datetime.

```twig
{{ localdatetime(datetimeObject) }}
```

### `relativetime`

Returns a string representation of a this time relative to now, such as "in two days". Rounds down by default.

```twig
{{ relativetime(datetimeObject) }}
```

# Twig Tags

## `frame`

| Option          | Type                                                            | Default |
| --------------- | --------------------------------------------------------------- | ------- |
| id              | string                                                          |         |
| size            | small/default                                                   | default |
| color           | default/primary/secondary/tertiary/quaternary/light/dark/white  | default |
| indent          | bool                                                            | false   |
| rulerBefore     | bool                                                            | false   |
| rulerAfter      | bool                                                            | false   |
| center          | bool                                                            | false   |
| backgroundImage | string                                                          |         |
| height          | auto/small/medium/max                                           | auto    |
| innerWidth      | small/medium/large/full/default                                 | default |

### Usage

```twig
{% frame with options %}Inner Content{% endframe %}
```

### Example

```twig
{% frame with { id: 'identifier', color: 'primary', center: true } %}
    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
{% endframe %}
```

```html
<div id="identifier" class="frame frame-size-default frame-background-primary frame-no-backgroundimage frame-space-before-none frame-space-after-none">
    <div class="frame-container">
        <div class="frame-inner text-center">
            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
    </div>
</div>
```

# JavaScript Libraries

## Datepicker

The library can be enabled and configured through the attribute `data-datepicker`, pass the configuration as json encoded string.

**Example HTML**

```html
<input
    type='text'
    name='date'
    placeholder='yyyy-mm-dd'
    data-datepicker='{"clearBtn":true}'
    class="form-control"
>
```

**Example FormBuilder**

```php
$builder->add('date', ChoiceType::class, [
    'widget' => 'single_text',
    'attr' => [
        'placeholder' => 'yyyy-mm-dd',
        'data-datepicker' => json_encode(
            [
                'clearBtn' => true,
            ],
            JSON_THROW_ON_ERROR
        ),
    ],
    'html5' => false
]);
```

Source: https://github.com/mymth/vanillajs-datepicker

## Choices

The library can be enabled and configured through the attribute `data-choicesjs`, pass the configuration as json encoded string.

**Example HTML**

```html
<select
    name='country'
    data-choicesjs='{"maxItemCount":1}'
>
    <option value="">Please select a country</option>
    ...
    <option value="DE" selected="selected">Germany</option>
    <option value="GH">Ghana</option><option value="GI">Gibraltar</option>
    <option value="GL">Greenland</option><option value="GD">Grenada</option>
    ...
</select>
```

**Example FormBuilder**

```php
$builder->add('country', ChoiceType::class, [
    'attr' => [
        'data-choicesjs' => json_encode(
            [
                'maxItemCount' => 1,
            ],
            JSON_THROW_ON_ERROR
        ),
    ],
    'choices' => $countryChoices,
    'empty_data' => null,
    'placeholder' => 'Please select a country',
]);
```

Source: https://github.com/jshjohnson/Choices
