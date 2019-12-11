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
        $menu = $this->factory->createItem('root');
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


## Templates

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
