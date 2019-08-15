<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/profile", name="app_profile")
     */
    public function profile(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('profile/profile.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, LoginFormAuthenticator $authenticator, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $authenticatorHandler): Response
    {
        if ($request->isMethod('POST')) {
            $user = new User();
            $user->setNom($request->request->get('nom'));
            $user->setPrenom($request->request->get('prenom'));
            $user->setSexe($request->request->get('sexe'));
//            $user->setDateNaissance($dateTime->diff($dateTime));
            $user->setEmail($request->request->get('email'));
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
//            $user->setDateInscription($request->request->get('date_inscription'));
//            $user->setDateNaissance(\DateTime::createFromFormat('Y-m-d', "2018-09-09"));
            $user->setAdresse($request->request->get('adresse'));
//            dd($user);
            $user->setTelephone($request->request->get('telephone'));
            $user->setRoles(['ROLE_ALLOWED_TO_SWITCH']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            //return $this->redirectToRoute('home');
            return $authenticatorHandler
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $authenticator,
                    'main'
                );
        }
        return $this->render('security/register.html.twig');
    }

    /**
     * @Route("/forgotten_password", name="app_forgotten_password")
     */
    public function forgottenPassword(Request $request, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneByEmail($email);

            /* @var $user User */
            if ($user === null) {
                $this->addFlash('danger', 'Email Inconnu');
                return $this->redirectToRoute('home');
            }
            $token = $tokenGenerator->generateToken();
            try{
                $user->setResetToken($token);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('home');
            }
            $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
            $message = (new \Swift_Message('Forgot Password'))
                ->setFrom('arbadimpoyi@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    "blablabla voici le token pour reseter votre mot de passe : " . $url,
                    'text/html'
                );
            $mailer->send($message);
            $this->addFlash('notice', 'Mail envoyé');
            return $this->redirectToRoute('home');
        }
        return $this->render('security/forgotten_password.html.twig');
    }

    /**
     * @Route("/reset_password/{token}", name="app_reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneByResetToken($token);

            /* @var $user User */
            if ($user === null) {
                $this->addFlash('danger', 'Token Inconnu');
                return $this->redirectToRoute('home');
            }
            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $entityManager->flush();
            $this->addFlash('notice', 'Mot de passe mis à jour');
            return $this->redirectToRoute('home');
        }else {
            return $this->render('security/reset_password.html.twig', ['token' => $token]);
        }
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('home');
    }
}