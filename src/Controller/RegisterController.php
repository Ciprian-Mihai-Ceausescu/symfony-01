<?php

namespace App\Controller;

use App\Entity\User;
use App\Event\UserRegisterEvent;
use App\Form\UserType;
use App\Security\TokenGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     */
    public function register(
        //Pt a encoda parola
        UserPasswordEncoderInterface $passwordEncoder,
        Request $request
    ) {
        //Obiect utilizator
        $user = new User();
        //Cream form-ul
        $form = $this->createForm(
            UserType::class,
            $user
        );
        //Validam form-ul
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword(
                $user,
                $user->getPlainPassword()
            );
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()
                ->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('micro_post_index');
        }

        return $this->render(
            'register/register.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}