<?php

namespace App\Security;

use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{


    private $usersRepository;
    private $router;
    private $csrfTokenManager;
    private $userPasswordEncoder;

    public function __construct(UsersRepository $usersRepository, RouterInterface $router, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->usersRepository = $usersRepository;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }


    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'login'
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'username' => $request->request->get('username'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['username']
        );
        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        return $this->usersRepository->findOneBy(['username' => $credentials['username']]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if (empty($credentials['password'])) {
            throw new CustomUserMessageAuthenticationException('Hasło nie może być puste.');
        }
        return  $this->userPasswordEncoder->isPasswordValid($user, $credentials['password']);
    }


    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->router->generate('homepage'));
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('login');
    }


}
