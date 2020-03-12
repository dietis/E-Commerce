<?php
// src/Controller/.php
namespace App\Controller;

use App\Form\Save_user;
use App\Form\LoginForm;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class User_gestion extends AbstractController
{
    public function list()
    {
        // ...
    }

    /**
    * @Route("/User/Profile", name="user_page")
    */
    public function user_home(Request $request)
    {
        return $this->render(
            'user.html.twig',
            array()
        );
    }

    /**
     * @Route("/User/profile/settings", name="user_settings_page")
     */
    public function settings(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $usermail = $user->getEmail();

        return $this->render(
            'user_setting.html.twig',
            array('user' => $user)
        );
    }
     /**
     * @Route("/User/profile/settings/save", name="user_settings_ajax")
     */
    public function settings_validate(Request $request) {
        if ($request->isXMLHttpRequest()) {         
            //$json = json_encode(array('data' => $_POST['data1']), JSON_UNESCAPED_UNICODE);
            $data = ['foo1' => 'bar1', 'foo2' => 'bar2'];
            $response = new JsonResponse(['data' => 123]);
            // if you don't know the data to send when creating the response
            $response = new JsonResponse();
            // ...
            $response->setData(['data' => 123]);
            // if the data to send is already encoded in JSON
            //$response = JsonResponse::fromJsonString('{ "data": 123 }');

            return $response;
        }
        return new Response('This is not ajax!', 400);
    }

    /**
    * @Route("/login", name="login")
    */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
    
        return $this->render('login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/User/register", name="user_register_page")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(Save_user::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('user_page');
        }
        return $this->render(
            'register.html.twig',
            array('form' => $form->createView())
        );
    }

    
    /**
     * @Route("/logout", name="logout_url")
     */
    public function logoutAction()
    {
        return $this->redirectToRoute('/');
    }
}
