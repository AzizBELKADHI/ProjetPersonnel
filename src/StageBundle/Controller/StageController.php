<?php

namespace StageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\Traineeship;
use UserBundle\Entity\User;


class StageController extends Controller
{
    public function backAction()
    {
        return $this->render('@Stage/Traineeship/back.html.twig');
    }

    public function showAllInternshipsAction(Request $request) {
        $stage=$this->getDoctrine()->getRepository(Traineeship::class)->findAll();
        return $this->render('@Stage/Traineeship/allInternshipsBack.html.twig', array( 'stages'=>$stage ));
    }

    public function showInternshipsAction($id) {
        $stage=$this->getDoctrine()->getRepository(Traineeship::class)->find($id);
        return $this->render('@Stage/Traineeship/showDetailsInternship.html.twig', ['stages'=>$stage]);
    }

    public function editInternshipAction(Request $request,$id)
    {
        $stage= $this->getDoctrine()->getRepository(Traineeship::class)->find($id);
        $stage->setStatus($stage->getStatus());

        $form= $this->createFormBuilder($stage)
            ->add('status', ChoiceType::class,  array('choices' => ['Change status' => ['Validate' => 'Validate', 'Invalidate' => 'Invalidate','In_Progress' => 'In_Progress', ], ],'attr' => array('class' => 'form-control'),'label' => "Validation of the internship" ))
            ->add('Submit', SubmitType::class, array('label' => 'Submit', 'attr' => array('class' => 'btn btn-success btn-sm','style'=>'margin-top:10px' )))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $status= $form['status']->getData();
            $em= $this->getDoctrine()->getManager();
            $stage->setStatus($status);
            $em->flush();

            return $this->redirectToRoute("stage_back");
        }
        return $this->render("@Stage/Traineeship/editInternshipBack.html.twig",
            array("form"=>$form->createView()));
    }


    //Front

    public function serviceAction()
    {
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $services = $this->getDoctrine()->getRepository(Traineeship::class)->findBy(array('userUser' => $user));

            return $this->render("@Stage/Traineeship/allInternshipsFront.html.twig", array( 'stages'=>$services));
        } //else
            //return $this->render("@fidelite/front/404.html.twig");
    }


    public function addInternshipAction(Request $request)
    {

        $logged = $this->container->get('security.token_storage')->getToken()->getUser();
        $user = $this->getDoctrine()->getRepository(User::class)->find($logged);

        $stage= new Traineeship();

        $form= $this->createFormBuilder($stage)
            ->add('company',TextType::class, array('attr' => array('class' => 'form-control','required' => true),'label' => "Company"))
            ->add('startDate',DateType::class, array('attr' => array('class' => 'form-control','required' => true),'widget' => 'single_text','label' => "Start date of internship"))
            ->add('duration',TextType::class, array('attr' => array('class' => 'form-control','required' => true),'label' => "Duration of the internship"))
            ->add('tuteur', TextType::class, array('attr' => array('class' => 'form-control','required' => true),'label' => "School tutor"))
            ->add('missions', TextareaType::class, array('attr' => array('class' => 'form-control','required' => true),'label' => "Missions proposed by the company"))

            ->add('Submit', SubmitType::class, array('label' => 'Submit', 'attr' => array('class' => 'btn btn-success btn-sm','style'=>'margin-top:10px' )))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $company= $form['company']->getData();
            $startDate= $form['startDate']->getData();
            $duration= $form['duration']->getData();
            $tuteur= $form['tuteur']->getData();
            $missions= $form['missions']->getData();
            $stage->setCompany($company);
            $stage->setDuration($duration);
            $stage->setStartDate($startDate);
            $stage->setMissions($missions);
            $stage->setTuteur($tuteur);
            $stage->setStatus('In_Progress');
            $stage->setUserUser($user);
            $em= $this->getDoctrine()->getManager();
            $em->persist($stage);
            $em->flush();
            $this->addFlash('message','Internship successfully added');
            return $this->redirectToRoute("front_home");
        }
        return $this->render("@Stage/Traineeship/addInternshipsFront.html.twig",
            array("form"=>$form->createView()));
    }






}