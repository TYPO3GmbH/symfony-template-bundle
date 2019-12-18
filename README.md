# symfony-template-bundle

This package is used across various TYPO3 Symfony Applications to ensure a streamlined visual experience and reduced maintenance.

## Installation

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

## Configuration

The bundle comes with a sensible default configuration, which is listed below.
You can define these options if you need to change them:

```yaml
# config/packages/template.yaml
template:
    application:
        # Example: Intercept
        name: 'Template Bundle'
        routes:
             # Example: app_index
            home: app_index
        menu:
            # Example: App\Menu\MenuBuilder
            class: T3G\Bundle\TemplateBundle\Menu\MenuBuilder
        assets:
            # Example: app
            encore_entrypoint: ~
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


## Page Template

Extend Default Layout

```twig
{% extends '@Template/layout.html.twig' %}
```

### Available Blocks

#### `title`

```twig
{% block title %}Home{% endblock %}
```

```html
<title>Home - {{ template.application.name }}</title>
```

#### `headline`

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

#### `body`

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

#### `footer`


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

#### `stylesheets`

Stylesheet block will be rendered after the `base` and `encore` css before the closing `</head>`.

#### `javascripts`

JavaScript block will be rendered after `base` and `encore` javascript before the closing `</body>`.

## EMail Template

Extend Default Layout

```twig
{% extends '@Template/email.html.twig' %}
```

### Available Blocks

#### `email_subject`

```twig
{% block email_subject %}Reset Your Password{% endblock %}
```

#### `email_plaintext`

```twig
{% block email_plaintext %}
Forgot your password? Let's get you a new one.

We got a request to change the password for the account with the username {{ user.username }}.

You can reset your password by accessing {{ confirmationUrl }}

If you don't want to reset your password, you can ignore this email.
{% endblock %}
```

#### `email_html_preview`

```twig
{% block email_html_preview %}
You requested a password reset for your account.
{% endblock %}
```

#### `email_html_body`

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
