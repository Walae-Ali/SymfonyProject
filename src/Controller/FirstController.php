<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[route ('/greet/{name}/{surname}',name: 'greetings')]
    public function greetings($name,$surname):Response{
       return $this->render('first/sayHello.html.twig',
           ['name'=>$name,'surname'=>$surname]);
}

    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
      return $this->render('first/index.html.twig',[
          'name'=>'Ali',
          'firstname'=>'wala'
      ]);}
        #[Route('/sayHello', name: 'say.hello')]
    public function sayHello(): Response
    {
        $rand=rand(0,10);
        echo $rand;
        if($rand%2==0){
            return $this->redirectToRoute('app_first');
        }

      /**  return $this->render('first/sayHello.html.twig',[
            'name'=>'Ali',
            'firstname'=>'wala'
        ]);
**/
return $this->forward('App\Controller\FirstController::index');
}}
