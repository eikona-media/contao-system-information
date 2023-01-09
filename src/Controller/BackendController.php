<?php

declare(strict_types=1);

/*
 * This file is part of System Information Bundle for Contao Open Source CMS.
 *
 * (c) eikona-media.de
 *
 * @license MIT
 */

namespace EikonaMedia\Contao\SystemInformation\Controller;

use Contao\BackendUser;
use Contao\CoreBundle\Controller\AbstractBackendController;
use Contao\CoreBundle\Exception\AccessDeniedException;
use Contao\Message;
use Contao\System;
use EikonaMedia\Contao\SystemInformation\Service\SystemInformationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Terminal42\ServiceAnnotationBundle\Annotation\ServiceTag;
use Twig\Environment;

/**
 * @ServiceTag("controller.service_arguments")
 */
class BackendController extends AbstractBackendController
{
    private SystemInformationService $systemInformationService;
    private TokenStorageInterface $tokenStorage;
    private Environment $twig;
    private TranslatorInterface $translator;

    public function __construct(SystemInformationService $systemInformationService, TokenStorageInterface $tokenStorage, Environment $twig, TranslatorInterface $translator)
    {
        $this->systemInformationService = $systemInformationService;
        $this->tokenStorage = $tokenStorage;
        $this->twig = $twig;
        $this->translator = $translator;
    }

    /**
     * @Route("/%contao.backend.route_prefix%/system_information", name="contao_system_information", defaults={"_scope": "backend"})
     */
    public function indexAction(): Response
    {
        $this->checkPermissions();
        $parameters = [
            'title' => $this->translator->trans('eimed.system_info.title'),
            'headline' => $this->translator->trans('eimed.system_info.title'),
            'backUrl' => System::getReferer(),
            'messages' => Message::generate(),
            'systemLoadInfo' => $this->systemInformationService->getSystemLoadInfo(),
            'phpInfo' => $this->systemInformationService->getPHPInfo(),
            'osInfo' => $this->systemInformationService->getOSInfo(),
            'hostInfo' => $this->systemInformationService->getHostInfo(),
            'hardwareInfo' => $this->systemInformationService->getHardwareInfo(),
            'databaseInfo' => $this->systemInformationService->getDatabaseInfo(),
            'virtualizationInfo' => $this->systemInformationService->getVirtualizationInfo(),
        ];

        return $this->render('@EikonaMediaContaoSystemInformation/index.html.twig', $parameters);
    }

    /**
     * @Route("/contao/system_information/system_load", name="contao_system_information.system_load", defaults={"_scope": "backend"})
     */
    public function getSystemLoadAction(): Response
    {
        $this->checkPermissions();
        $systemLoadInfo = $this->systemInformationService->getSystemLoadInfo();

        return new JsonResponse([
            'now' => $systemLoadInfo->getLast1Minute(),
            '5min' => $systemLoadInfo->getLast5Minutes(),
            '15min' => $systemLoadInfo->getLast15Minutes(),
            'factor' => $systemLoadInfo->getFactor(),
        ]);
    }

    private function checkPermissions(): void
    {
        $token = $this->tokenStorage->getToken();

        if (null === $token) {
            throw new \RuntimeException('No token provided');
        }

        $user = $token->getUser();

        if (!$user instanceof BackendUser || !$user->hasAccess('system_information', 'modules')) {
            throw new AccessDeniedException('Not enough permissions to access system information.');
        }
    }
}
