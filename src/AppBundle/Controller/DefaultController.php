<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Fortune;
use AppBundle\Form\FortuneType;
use Pagerfanta\Pagerfanta;



class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $fortunes = $this->getDoctrine()->getRepository('AppBundle:Fortune')->findLast();
        $newFortunes = new Pagerfanta($fortunes);
        $newFortunes->setMaxPerPage(10);
        return $this->render('default/index.html.twig', [
          'fortunes' => $newFortunes
        ]);
    }

    /**
     * @Route("/vote_up/{id}", name="vote_up")
     */
     public function voteUpAction($id)
     {
       $fortune = $this->getDoctrine()->getRepository("AppBundle:Fortune")->find($id);
       $fortune->voteUp();
       $this->getDoctrine()->getManager()->flush();
       return $this->redirectToRoute("homepage");
     }

     /**
      * @Route("/vote_down/{id}", name="vote_down")
      */
      public function voteDownAction($id)
      {
        $fortune = $this->getDoctrine()->getRepository("AppBundle:Fortune")->find($id);
        $fortune->voteDown();
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute("homepage");
      }

      /**
      *@Route("/best_rated", name="best_rated")
      */
      public function showBestRatedAction(Request $request)
        {
          return $this->render('default/showBestRated.html.twig', [
              'bestQuotes' => $this->getDoctrine()->getRepository("AppBundle:Fortune")->bestRated(),
          ]);
        }

        /**
        *@Route("/worst_rated", name="worst_rated")
        */
        public function showWorstRatedAction(Request $request)
          {
            return $this->render('default/showWorstRated.html.twig', [
                'worstQuotes' => $this->getDoctrine()->getRepository("AppBundle:Fortune")->worstRated(),
            ]);
          }

      /**
      *@Route("/by_author/{author}", name="by_author")
      */
      public function showByAuthorAction($author)
      {
        return $this->render('default/showByAuthor.html.twig', [
          'findAuthor' => $this->getDoctrine()->getRepository("AppBundle:Fortune")->findByAuthor($author),
        ]);
      }


      /**
      *@Route("/story/{id}", name="story")
      */
      public function showOneStoryAction($id)
   {
      return $this->render('default/showByStory.html.twig', [
           'fortune'=>$this->getDoctrine()->getRepository("AppBundle:Fortune")->find($id)
           ]);
   }

      /**
      *@Route("/new", name="new")
      */
      public function createAction(Request $request)
      {
        $form = $this->createForm(new FortuneType, new Fortune);

        $form->handleRequest($request);
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($form->getData());
          $em->flush();
          return $this->redirectToRoute('homepage');
        }

        return $this->render('default/create.html.twig', [
          'form' => $form->createView(),
        ]);
      }

  /**
  * @Route("/story/{id}/edit", name="edit")
  */
  public function editAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $fortune = $em->getRepository("AppBundle:Fortune")->find($id);
    $form = $this->createForm(new FortuneType, $fortune);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $fortune = $form->getData();

      $em->flush();

      return $this->redirectToRoute("story", ["id" => $id]);
    }

    return $this->render('default/edit.html.twig', [
      'form' => $form->createView(),
      'fortune' => $fortune
    ]);
  }

  /**
  * @Route("/moderate/{id}", name="validateQuote")
  */
  public function validateQuoteAction(Request $request, $id)
      {
        $quote = $this->getDoctrine()->getRepository("AppBundle:Fortune")->find($id);

        $quote->setValidate();
        $this->getDoctrine()->getManager()->Flush();
        return $this->redirect($this->getRequest()->headers->get('referer'));
      }
}
