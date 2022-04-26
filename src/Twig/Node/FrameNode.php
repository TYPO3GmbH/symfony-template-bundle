<?php
declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Twig\Node;

use Twig\Compiler;
use Twig\Node\Node;
use Twig\Node\NodeOutputInterface;

class FrameNode extends Node implements NodeOutputInterface
{
    protected $tagName = 'frame';

    public function __construct(Node $body = null, Node $attributes = null, int $lineno, string $tag = null)
    {
        $nodes = ['body' => $body];
        if ($attributes !== null) {
            $nodes['attributes'] = $attributes;
        }

        parent::__construct($nodes, [], $lineno, $tag);
    }

    public function compile(Compiler $compiler)
    {
        $attributeStorageName = uniqid($this->tagName);
        $compiler->addDebugInfo($this);

        if ($this->hasNode('attributes')) {
            $compiler
                ->write('$' . $attributeStorageName . ' = ')
                ->subcompile($this->getNode('attributes'))
                ->raw(';' . PHP_EOL)
                ->write('if (!is_array($' . $attributeStorageName . ')) {' . PHP_EOL)
                ->indent()
                ->write("throw new UnexpectedValueException('{% {$this->tagName} with x %}: x is not an array');" . PHP_EOL)
                ->outdent()
                ->write('}' . PHP_EOL);
        } else {
            $compiler->write('$' . $attributeStorageName . ' = [];' . PHP_EOL);
        }

        $compiler
            ->write('ob_start();' . PHP_EOL)
            ->subcompile($this->getNode('body'))
            ->write('$content = ob_get_clean();' . PHP_EOL)
            ->write('echo $this->env->getExtension(\'T3G\Bundle\TemplateBundle\Twig\Extension\BlockExtension\')->frameFunction($this->env, $content, $' . $attributeStorageName . ');' . PHP_EOL)
        ;
    }
}
