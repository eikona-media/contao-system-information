<?php

/*
 * This file is part of System Information Bundle for Contao Open Source CMS.
 *
 * (c) eikona-media.de
 *
 * @license MIT
 */

namespace EikonaMedia\Contao\SystemInformation\EventListener;

use Contao\BackendUser;
use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class NavigationListener
 * @package EikonaMedia\Contao\SystemInformation\EventListener
 */
class NavigationListener
{
    protected $requestStack;
    protected $router;
    protected $translator;
    protected $framework;

    /**
     * NavigationListener constructor.
     *
     * @param RequestStack $requestStack
     * @param RouterInterface $router
     * @param TranslatorInterface $translator
     * @param ContaoFrameworkInterface $framework
     */
    public function __construct(
        RequestStack $requestStack,
        RouterInterface $router,
        TranslatorInterface $translator,
        ContaoFrameworkInterface $framework
    )
    {
        $this->requestStack = $requestStack;
        $this->router = $router;
        $this->translator = $translator;
        $this->framework = $framework;
    }

    /**
     * @param array $modules
     *
     * @return array
     */
    public function onGetUserNavigation(array $modules)
    {
        $request = $this->requestStack->getCurrentRequest();

        $this->framework->initialize();

        /** @var BackendUser $backendUser */
        $backendUser = $this->framework->getAdapter(BackendUser::class)->getInstance();

        if ($backendUser->hasAccess('system_information', 'modules')) {
            $modules['system']['modules']['system_information'] = [
                'label' => $this->translator->trans('eimed.system_info.title'),
                'class' => 'navigation system_information',
                'href' => $this->router->generate('contao_system_information'),
                'isActive' => 'contao_system_information' === $request->attributes->get('_route'),
            ];
        }

        return $modules;
    }
}
