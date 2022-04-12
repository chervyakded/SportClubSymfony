<?php

namespace EfTech\SportClub\Controller;

use EfTech\SportClub\Form\LoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Класс обработки авторизации
 */
class LoginController extends AbstractController
{
    /**
     * @param Request $serverRequest
     * @param AuthenticationUtils $utils
     * @return Response
     */
    public function __invoke(
        Request $serverRequest,
        AuthenticationUtils $utils
    ): Response
    {
        $errs = $utils->getLastAuthenticationError();
        $formLogin = $this->createForm(LoginForm::class);
        $formLogin->setData([
            'login' => $utils->getLastUsername()
        ]);
        $context = [
            'form_login' => $formLogin,
            'errs'       => $errs
        ];
        return $this->renderForm('login.twig', $context);
    }
}
