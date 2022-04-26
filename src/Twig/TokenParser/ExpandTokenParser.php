<?php
declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Twig\TokenParser;

use T3G\Bundle\TemplateBundle\Twig\Node\ExpandNode;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

final class ExpandTokenParser extends AbstractTokenParser
{
    public function parse(Token $token)
    {
        $stream = $this->parser->getStream();

        $attributes = null;
        if ($stream->nextIf(Token::NAME_TYPE, 'with')) {
            $attributes = $this->parser->getExpressionParser()->parseExpression();
        }

        $stream->expect(Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse([$this, 'decideTagEnd'], true);
        $stream->expect(Token::BLOCK_END_TYPE);

        return new ExpandNode($body, $attributes, $token->getLine(), $this->getTag());
    }

    public function decideTagEnd(Token $token)
    {
        return $token->test('endexpand');
    }

    public function getTag()
    {
        return 'expand';
    }
}
