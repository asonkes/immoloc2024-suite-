<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\TooManyLoginAttemptsAuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * Permet à l'utilisateur de se connecter
     *
     * @param AuthenticationUtils $utils
     * @return Response
     */
    #[Route('/login', name: 'account_login')]
    public function index(AuthenticationUtils $utils): Response
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        $loginError = null;
        // dump($error);
        // $error, c'est toutes les erreurs, badCredential = mauvais mot de passe etc, et si trop d'ssais raté... On a tooMany...(trop de tentatives)

        if ($error instanceof TooManyLoginAttemptsAuthenticationException) {
            // L'erreur est due à la limitation de tentative de connexion
            $loginError = "Trop de tentatives de connexion. réessayer plus tard";
        }


        return $this->render('account/index.html.twig', [
            'hasError' => $error !== null,
            'username' => $username,
            // Lien avec le "if" d'en haut... 
            'loginError' => $loginError
        ]);
    }

    /**
     * Permet de se déconnecter
     *
     * @return void
     */
    #[Route("/logout", name: "account_logout")]
    public function logout(): void
    {
    }
}
