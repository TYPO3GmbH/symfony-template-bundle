<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class SecurityHeadersResponseSubscriber implements EventSubscriberInterface
{
    /**
     * @var array{headers: array<string, string>, content_security_policy: array{report_only: bool, rules: array<string, string>}} $configuration
     */
    private array $configuration;

    /**
     * @param array{headers: array<string, string>, content_security_policy: array{report_only: bool, rules: array<string, string>}} $configuration
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return array<string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'onResponse',
        ];
    }

    public function onResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();

        $this->applyHeaders($response);
        $this->applyContentSecurityPolicyRules($response);
    }

    private function applyHeaders(Response $response): void
    {
        $headers = array_change_key_case($this->configuration['headers'], CASE_LOWER);
        if (!isset($headers['x-frame-options'])) {
            // Symfony DI configuration doesn't allow to pre-define a scalar within prototypes *and* have that always
            // available, thus we're adding it here.
            $headers['x-frame-options'] = 'sameorigin';
        }

        $response->headers->add($headers);
    }

    private function applyContentSecurityPolicyRules(Response $response): void
    {
        $contentSecurityPolicy = $this->configuration['content_security_policy'];
        if ([] === $contentSecurityPolicy['rules']) {
            return;
        }

        $ruleSet = [];
        foreach ($contentSecurityPolicy['rules'] as $ruleKey => $ruleValue) {
            $ruleSet[] = sprintf('%s %s', $ruleKey, $ruleValue);
        }
        $policy = implode('; ', $ruleSet);

        $headerName = $contentSecurityPolicy['report_only']
            ? 'Content-Security-Policy-Report-Only'
            : 'Content-Security-Policy';
        $response->headers->set($headerName, $policy);
        $response->headers->set(sprintf('X-%s', $headerName), $policy);
    }
}
