<?php

/*
 * This file is part of System Information Bundle for Contao Open Source CMS.
 *
 * (c) eikona-media.de
 *
 * @license MIT
 */

namespace EikonaMedia\Contao\SystemInformation\Controller;

use Contao\BackendUser;
use Contao\CoreBundle\Exception\AccessDeniedException;
use Contao\CoreBundle\Exception\InternalServerErrorException;
use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\Message;
use Contao\System;
use EikonaMedia\Contao\SystemInformation\Service\SystemInformationService;
use Linfo\Linfo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Twig_Environment;
use Twig_Extensions_Extension_Intl;

/**
 * Class BackendController
 * @package EikonaMedia\Contao\SystemInformation\Controller
 */
class BackendController extends Controller
{
    private $systemInformationService;
    private $requestStack;
    private $request;
    private $router;
    private $translator;
    private $framework;
    private $twig;

    /**
     * BackendController constructor.
     *
     * @param SystemInformationService $systemInformationService
     * @param RequestStack $requestStack
     * @param RouterInterface $router
     * @param TranslatorInterface $translator
     * @param ContaoFrameworkInterface $framework
     * @param Twig_Environment $twig
     */
    public function __construct(
        SystemInformationService $systemInformationService,
        RequestStack $requestStack,
        RouterInterface $router,
        TranslatorInterface $translator,
        ContaoFrameworkInterface $framework,
        Twig_Environment $twig
    )
    {
        $this->systemInformationService = $systemInformationService;
        $this->requestStack = $requestStack;
        $this->router = $router;
        $this->translator = $translator;
        $this->framework = $framework;
        $this->twig = $twig;
    }

    /**
     * @return BinaryFileResponse|RedirectResponse|Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function indexAction()
    {
        $this->request = $this->requestStack->getCurrentRequest();
        if (null === $this->request) {
            throw new InternalServerErrorException('No request object given.');
        }

        $this->framework->initialize();

        /** @var BackendUser $backendUser */
        $backendUser = $this->framework->getAdapter(BackendUser::class)->getInstance();
        if (!$backendUser->hasAccess('system_information', 'modules')) {
            throw new AccessDeniedException('Not enough permissions to access system information.');
        }

        return $this->infoAction();
    }

    /**
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    private function infoAction(): Response
    {
        $this->twig->addExtension(new Twig_Extensions_Extension_Intl());
        $parameters = [
            'backUrl' => System::getReferer(),
            'messages' => Message::generate(),
            'systemLoadInfo' => $this->systemInformationService::getSystemLoadInfo(),
            'phpInfo' => $this->systemInformationService::getPHPInfo(),
            'osInfo' => $this->systemInformationService::getOSInfo(),
            'hostInfo' => $this->systemInformationService::getHostInfo(),
            'hardwareInfo' => $this->systemInformationService::getHardwareInfo(),
            'databaseInfo' => $this->systemInformationService::getDatabaseInfo(),
            'virtualizationInfo' => $this->systemInformationService::getVirtualizationInfo(),
        ];

        return new Response($this->twig->render(
            '@EikonaMediaContaoSystemInformation/index.html.twig',
            $parameters
        ));
    }

    /**
     * @return Response
     */
    public function getSystemLoadAction(): Response
    {
        $systemLoadInfo = $this->systemInformationService::getSystemLoadInfo();

        return new JsonResponse([
            'now' => $systemLoadInfo->getLast1Minute(),
            '5min' => $systemLoadInfo->getLast5Minutes(),
            '15min' => $systemLoadInfo->getLast15Minutes(),
            'factor' => $systemLoadInfo->getFactor(),
        ]);
    }
}
