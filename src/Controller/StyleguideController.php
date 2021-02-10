<?php declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use T3G\Bundle\TemplateBundle\ThemeConstants;

class StyleguideController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('@Template/styleguide/index.html.twig');
    }

    /**
     * @return Response
     */
    public function componentAccordion(): Response
    {
        $data = [
            [
                'title' => 'Accordion Item',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sem dui, molestie a est sed, mattis faucibus sem. Curabitur id tristique dolor. Cras non orci sed lectus mollis ultrices. Sed sit amet sem tincidunt, ultrices tellus quis, tempor risus. Morbi hendrerit a enim non vestibulum. Phasellus pellentesque lorem lorem, sit amet faucibus dui venenatis id. Duis dignissim libero non nisl molestie pulvinar. Sed hendrerit magna quis diam placerat posuere. Nam imperdiet ex non auctor tempus. Suspendisse aliquet nulla et magna tempus porttitor. Duis nec maximus enim, sed auctor risus. Integer augue mi, pellentesque in felis ut, tempor placerat lorem. Mauris porttitor urna vitae nisi sollicitudin sodales. Mauris eu sem nulla.'
            ],
            [
                'title' => 'Accordion Item',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sem dui, molestie a est sed, mattis faucibus sem. Curabitur id tristique dolor. Cras non orci sed lectus mollis ultrices. Sed sit amet sem tincidunt, ultrices tellus quis, tempor risus. Morbi hendrerit a enim non vestibulum. Phasellus pellentesque lorem lorem, sit amet faucibus dui venenatis id. Duis dignissim libero non nisl molestie pulvinar. Sed hendrerit magna quis diam placerat posuere. Nam imperdiet ex non auctor tempus. Suspendisse aliquet nulla et magna tempus porttitor. Duis nec maximus enim, sed auctor risus. Integer augue mi, pellentesque in felis ut, tempor placerat lorem. Mauris porttitor urna vitae nisi sollicitudin sodales. Mauris eu sem nulla.'
            ],
            [
                'title' => 'Accordion Item',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sem dui, molestie a est sed, mattis faucibus sem. Curabitur id tristique dolor. Cras non orci sed lectus mollis ultrices. Sed sit amet sem tincidunt, ultrices tellus quis, tempor risus. Morbi hendrerit a enim non vestibulum. Phasellus pellentesque lorem lorem, sit amet faucibus dui venenatis id. Duis dignissim libero non nisl molestie pulvinar. Sed hendrerit magna quis diam placerat posuere. Nam imperdiet ex non auctor tempus. Suspendisse aliquet nulla et magna tempus porttitor. Duis nec maximus enim, sed auctor risus. Integer augue mi, pellentesque in felis ut, tempor placerat lorem. Mauris porttitor urna vitae nisi sollicitudin sodales. Mauris eu sem nulla.'
            ],
            [
                'title' => 'Accordion Item',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sem dui, molestie a est sed, mattis faucibus sem. Curabitur id tristique dolor. Cras non orci sed lectus mollis ultrices. Sed sit amet sem tincidunt, ultrices tellus quis, tempor risus. Morbi hendrerit a enim non vestibulum. Phasellus pellentesque lorem lorem, sit amet faucibus dui venenatis id. Duis dignissim libero non nisl molestie pulvinar. Sed hendrerit magna quis diam placerat posuere. Nam imperdiet ex non auctor tempus. Suspendisse aliquet nulla et magna tempus porttitor. Duis nec maximus enim, sed auctor risus. Integer augue mi, pellentesque in felis ut, tempor placerat lorem. Mauris porttitor urna vitae nisi sollicitudin sodales. Mauris eu sem nulla.'
            ]
        ];

        return $this->render('@Template/styleguide/component/accordion.html.twig', [
            'data' => $data,
        ]);
    }

    /**
     * @return Response
     */
    public function componentAggregation(): Response
    {
        return $this->render('@Template/styleguide/component/aggregation.html.twig', [
            'colors' => ThemeConstants::getThemeColors()
        ]);
    }

    /**
     * @return Response
     */
    public function componentAlert(): Response
    {
        return $this->render('@Template/styleguide/component/alert.html.twig', [
            'colors' => ThemeConstants::getThemeColors()
        ]);
    }

    /**
     * @return Response
     */
    public function componentBadge(): Response
    {
        return $this->render('@Template/styleguide/component/badge.html.twig', [
            'colors' => ThemeConstants::getThemeColors()
        ]);
    }

    /**
     * @return Response
     */
    public function componentButton(): Response
    {
        return $this->render('@Template/styleguide/component/button.html.twig', [
            'colors' => ThemeConstants::getThemeColors()
        ]);
    }

    /**
     * @return Response
     */
    public function componentCard(): Response
    {
        return $this->render('@Template/styleguide/component/card.html.twig', [
            'colors' => ThemeConstants::getThemeColors()
        ]);
    }

    /**
     * @return Response
     */
    public function componentDashboard(): Response
    {
        return $this->render('@Template/styleguide/component/dashboard.html.twig');
    }

    /**
     * @return Response
     */
    public function componentForm(): Response
    {
        return $this->render('@Template/styleguide/component/form.html.twig');
    }

    /**
     * @return Response
     */
    public function componentFrame(): Response
    {
        return $this->render('@Template/styleguide/component/frame.html.twig', [
            'colors' => ThemeConstants::getFrameColors()
        ]);
    }

    /**
     * @return Response
     */
    public function componentReview(): Response
    {
        return $this->render('@Template/styleguide/component/review.html.twig', [
            'colors' => ThemeConstants::getReviewColors()
        ]);
    }

    /**
     * @return Response
     */
    public function componentIssue(): Response
    {
        return $this->render('@Template/styleguide/component/issue.html.twig', [
            'colors' => ThemeConstants::getIssueColors()
        ]);
    }

    /**
     * @return Response
     */
    public function componentStatus(): Response
    {
        return $this->render('@Template/styleguide/component/status.html.twig', [
            'colors' => ThemeConstants::getStatusColors()
        ]);
    }

    /**
     * @return Response
     */
    public function componentOptionswitch(): Response
    {
        return $this->render('@Template/styleguide/component/optionswitch.html.twig');
    }

    /**
     * @return Response
     */
    public function componentPricing(): Response
    {
        return $this->render('@Template/styleguide/component/pricing.html.twig');
    }

    /**
     * @return Response
     */
    public function componentProgress(): Response
    {
        return $this->render('@Template/styleguide/component/progress.html.twig', [
            'colors' => ThemeConstants::getProgressColors()
        ]);
    }

    /**
     * @return Response
     */
    public function componentDataTable(): Response
    {
        return $this->render('@Template/styleguide/component/datatable.html.twig', [
            'colors' => ThemeConstants::getThemeColors()
        ]);
    }

    /**
     * @return Response
     */
    public function componentGuide(): Response
    {
        return $this->render('@Template/styleguide/component/guide.html.twig');
    }

    /**
     * @return Response
     */
    public function componentText(): Response
    {
        return $this->render('@Template/styleguide/component/text.html.twig');
    }
}
