<?php

namespace StageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use StageBundle\Entity\Traineeship;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

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

    public function deleteInternshipAction($id){
        $em= $this->getDoctrine()->getManager();
        $stage= $this->getDoctrine()->getRepository(Traineeship::class)->find($id);
        $em->remove($stage);
        $em->flush();
        return $this->redirectToRoute("stage_back");
    }


    public function editInternshipAction(Request $request,$id)
    {
        $stage= $this->getDoctrine()->getRepository(Traineeship::class)->find($id);

        $stage->setCompany($stage->getCompany());
        $stage->setStartDate($stage->getStartDate());
        $stage->setDuration($stage->getDuration());
        $stage->setStatus($stage->getStatus());
        $form= $this->createFormBuilder($stage)
            ->add('company',TextType::class, array('attr' => array('class' => 'form-control','disabled' => true),'label' => "The company"))
            ->add('startDate',DateType::class, array('attr' => array('class' => 'form-control','disabled' => true),'widget' => 'single_text','label' => "Start date of the internship"))
            ->add('duration', TextType::class, array('attr' => array('class' => 'form-control','disabled' => true),'label' => "The duration of the internship"))
            ->add('status', ChoiceType::class,  array('choices' => ['Change status' => ['Valider' => 'Valider', 'Invalider' => 'Invalider','En_cours' => 'En_cours', ], ],'attr' => array('class' => 'form-control'),'label' => "Validation of the internship" ))
            ->add('Submit', SubmitType::class, array('label' => 'Submit', 'attr' => array('class' => 'btn btn-success btn-sm','style'=>'margin-top:10px' )))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $status= $form['status']->getData();
            $company= $form['company']->getData();
            $startDate= $form['startDate']->getData();
            $duration= $form['duration']->getData();
            $em= $this->getDoctrine()->getManager();
           // $stage= $em->getRepository(Traineeship::class)->find($id);
            $stage->setCompany($company);
            $stage->setStartDate($startDate);
            $stage->setDuration($duration);
            $stage->setStatus($status);
            $em->flush();

            return $this->redirectToRoute("stage_back");
        }
        return $this->render("@Stage/Traineeship/editInternshipBack.html.twig",
            array("form"=>$form->createView()));
    }




}