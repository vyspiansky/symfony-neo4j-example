<?php

namespace Mentatik\UserBundle\Controller;


use GraphAware\Neo4j\OGM\EntityManager;
use GraphAware\Neo4j\OGM\Tests\Integration\Model\Repository;
use Mentatik\UserBundle\Form\UserType;
use Mentatik\UserBundle\Model\User;
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
        return $this->templating->renderResponse('MentatikUserBundle:Admin:index.html.twig',
            array('user_list'=> $user_list));
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
        $form = $this->createUserForm($user, 'Create');

        if ($request->getMethod() == 'POST') {
            return $this->save_user_from_form($request, $form);
        }

        return $this->templating->renderResponse('MentatikUserBundle:Admin:form.html.twig',
            array('form'=> $form->createView()));
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
        $form = $this->createUserForm($user, 'Update');

        if ($request->getMethod() == 'POST') {
            return $this->save_user_from_form($request, $form);
        }

        return $this->templating->renderResponse('MentatikUserBundle:Admin:form.html.twig',
            array('form'=> $form->createView()));
    }

    /**
     * @Route("/user/{id}/delete", name="mentatik_user_admin_delete" )
     * @param integer $id
     * @Method({"DELETE"})
     * @return Response
     */
    public function deleteAction($id)
    {
        $user = $this->userRepository->findOneById((int)$id);
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

    private function save_user_from_form(Request $request,Form $form)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $this->em->persist($user);
            $this->em->flush();
        }
        return new RedirectResponse($this->router->generate('mentatik_user_admin_list'));
    }
}
