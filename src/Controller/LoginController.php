<?php

namespace EfTech\SportClub\Controller;

use EfTech\SportClub\Exception\RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Класс обработки авторизации
 */
final class LoginController extends AbstractController
{
    /**
     * @param Request $serverRequest
     * @return Response
     */
    public function __invoke(Request $serverRequest): Response
    {
        try {
            $response = $this->doLogin($serverRequest);
        } catch (Throwable $e) {
            $response = $this->buildErrorResponse($e);
        }
        return $response;
    }

    /**
     * @param  Throwable $e
     * @return Response
     */
    private function buildErrorResponse(Throwable $e): Response
    {
        $httpCode = 500;
        $template = 'errors.twig';
        $context  = [
            'errors' => [$e->getMessage()],
        ];
        $response = $this->render($template, $context);
        $response->setStatusCode($httpCode);
        return $response;
    }

    /**
     * Реализация процесса аутентификации
     *
     * @param  Request $serverRequest
     * @return Response
     */
    private function doLogin(Request $serverRequest): Response
    {
        $response = null;
        $context  = [];
        if ('POST' === $serverRequest->getMethod()) {
            $authData = $serverRequest->request->all();
//            $this->validateAuthData($authData);
            if ($this->isAuth($authData['login'], $authData['password'])) {
                $response = $serverRequest->query->has('redirect')
                    ? $this->redirect($serverRequest->query->get('redirect'))
                    : $this->redirect('/');
            } else {
                $context['errMsg'] = 'Логин и пароль не подходят';
            }
        }
        if (null === $response) {
            $response = $this->render('login.twig', $context);
        }
        return $response;
    }

//    private function validateAuthData(array $authData): void
//    {
//        if (false === array_key_exists('login', $authData)) {
//            throw new RuntimeException('Отсутствует логин');
//        }
//
//        if (false === is_string($authData['login'])) {
//            throw new RuntimeException('Логин имеет неверный формат');
//        }
//
//        if (false === array_key_exists('password', $authData)) {
//            throw new RuntimeException('Отсутствует пароль');
//        }
//
//        if (false === is_string($authData['password'])) {
//            throw new RuntimeException('Пароль имеет неверный формат');
//        }
//    }

    /**
     * Проводит аутентификацию пользователя
     *
     * @param  string $login    - логин пользователя
     * @param  string $password - пароль пользователя
     * @return boolean
     */
    private function isAuth(string $login, string $password): bool
    {
//        return $this->httpAuthProvider->auth($login, $password);
        return true;
    }
}
