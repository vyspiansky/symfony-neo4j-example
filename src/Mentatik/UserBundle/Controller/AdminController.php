<?php

namespace Mentatik\UserBundle\Controller;


use GraphAware\Neo4j\OGM\EntityManager;
use GraphAware\Neo4j\OGM\Tests\Integration\Model\Repository;
use Mentatik\UserBundle\Form\UserType;
use Mentatik\UserBundle\Model\User;
use Mentatik\UserBundle\Model\Ship;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface as Templating;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

use GraphAware\Neo4j\OGM\Common\Collection;


/**
 * @Route("/admin", service="mentatik_user.admin_controller" )
 */
class AdminController
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Repository
     */
    private $userRepository;

    /**
     * @var Repository
     */
    private $shipRepository;

    /**
     * @var Templating
     */
    private $templating;

    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @var Router
     */
    private $router;


    public function __construct(
        Templating $templating,
        EntityManager $graphEntityManager,
        FormFactory $formFactory,
        Router $router
    ) {
        $this->templating = $templating;
        $this->em = $graphEntityManager;
        $this->userRepository = $this->em->getRepository(User::class);
        $this->shipRepository = $this->em->getRepository(Ship::class);
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    /**
     * @Route("/user", name="mentatik_user_admin_list" )
     * @Method({"GET"})
     */
    public function indexAction()
    {
        $user_list = $this->userRepository->findAll();

        /*
        foreach ($person->getMovies() as $movie) {
            echo sprintf("    -- %s\n", $movie->getTitle());
        }
        */

        return $this->templating->renderResponse('MentatikUserBundle:Admin:index.html.twig',
            array('user_list' => $user_list)
        );
    }

    /**
     * @Route("/user/insert", name="mentatik_user_admin_insert" )
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function insertAction(Request $request)
    {
        $user = new User();


        // dummy code - this is here just so that the User has some ships
        // otherwise, this isn't an interesting example
//        $ship1 = new Ship();
//        $ship1->setTitle('Ship #01');
//        $user->getShips()->add($ship1);
//
//        $ship2 = new Ship();
//        $ship2->setTitle('Ship #02');
//        $user->getShips()->add($ship2);
        // end dummy code


        $form = $this->createUserForm($user, 'Create');

        if ($request->getMethod() == 'POST') {
            //return $this->save_user_from_form($request, $form, new Collection());

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $user = $form->getData();

//                foreach ($user->getShips() as $ship) {
//                    echo $ship->getTitle() . '<br>';
//
//                    /** @var Ship $ship */
//                    $ship = $this->shipRepository->findOneBy(['title' => $ship->getTitle()]);
//
//
//                    $user->getShips()->add($ship);
//                    $ship->getUsers()->add($user);
//                }

                $this->em->persist($user);
                $this->em->flush();
            }
            return new RedirectResponse($this->router->generate('mentatik_user_admin_list'));
        }

        return $this->templating->renderResponse('MentatikUserBundle:Admin:form.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * @Route("/user/{id}/update", name="mentatik_user_admin_update" )
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updateAction(Request $request, $id)
    {
        $user = $this->userRepository->findOneById((int)$id);

        if (!$user) {
            throw $this->createNotFoundException('No user found for id ' . $id);
        }

        // $originalShips = new ArrayCollection();
        $originalShips = new Collection();

        foreach ($user->getShips() as $ship) {
            $originalShips->add($ship);
        }

        $form = $this->createUserForm($user, 'Update');


//        $editForm = $this->createForm(TaskType::class, $task);
//        $editForm->handleRequest($request);


        if ($request->getMethod() == 'POST') {
            // return $this->save_user_from_form($request, $form, $originalShips);


            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

//                foreach ($user->getShips() as $ship) {
//                    $ship->getUsers()->removeElement($user);
//                }
//                $user->getShips()->clear();
                //$this->em->remove($user);


                //$user = $this->userRepository->findOneById((int)$id);


                // remove the relationship between the Ship and the User
                foreach ($originalShips as $ship) {

                    if (false === $user->getShips()->contains($ship)) {

                        $user->getShips()->removeElement($ship);

                        //var_dump($user->getShips());

                        // remove the User from the Ship
                        $ship->getUsers()->removeElement($user);

                        //$actor->getMovies()->removeElement($movie);
                        //$movie->getActors()->removeElement($actor);
                        //$entityManager->flush();

                        // if it was a many-to-one relationship, remove the relationship like this
                        // $ship->setUser(null);

                        $this->em->persist($ship);
                        //$this->em->flush();

                        // if you wanted to delete the Ship entirely, you can also do that
                        // $em->remove($ship);
                    }
                }

                // $user = $form->getData();
                $this->em->persist($user);
                $this->em->flush();


                //$this->em->remove($user);
                //$this->em->flush();
            }

//            die();

            return new RedirectResponse($this->router->generate('mentatik_user_admin_list'));


        }

        return $this->templating->renderResponse(
            'MentatikUserBundle:Admin:form.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * @Route("/user/{id}/delete", name="mentatik_user_admin_delete" )
     * @param integer $id
     * @Method({"GET"})
     * @return Response
     */
    public function deleteAction($id)
    {
        // TODO: DELETE Method must be instead of GET
        $user = $this->userRepository->findOneById((int)$id);


        foreach ($user->getShips() as $ship) {
            $ship->getUsers()->removeElement($user);
        }
        $user->getShips()->clear();
        //$this->em->remove($user);

        $this->em->remove($user);
        $this->em->flush();
        return new RedirectResponse($this->router->generate('mentatik_user_admin_list'));
    }

    private function createUserForm(User $user, $buttonAction)
    {
        $form = $this->formFactory->create(UserType::class, $user);
        $form->add('submit', SubmitType::class, array(
            'label' => $buttonAction
        ));
        return $form;
    }

//    private function save_user_from_form(Request $request, Form $form, $originalShips)
//    {
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $user = $form->getData();
//            $this->em->persist($user);
//            $this->em->flush();
//        }
//        return new RedirectResponse($this->router->generate('mentatik_user_admin_list'));
//    }
}
