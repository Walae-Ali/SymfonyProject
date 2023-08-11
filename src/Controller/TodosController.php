<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodosController extends AbstractController
{
    #[Route('/todos', name: 'app_todos')]
    public function index(Request $request): Response
    {
        $session=$request->getSession();
        if(!$session->has('todos')){
            $todos=[

                'achat'=>'acheter clé usb',
                'études'=>'symfony',
                'sport'=>'marche'
            ];
            $session->set('todos',$todos);
            $this->addFlash('info',"la liste des todos vient d'etre initialisée");
        }

        return $this->render('todos/index.html.twig');
    }
    #[Route('/todos/add/{name}/{content}',name:'todos.add')]
public function addTodos($name,$content,Request $request):RedirectResponse
    {
        //on récupère la session
$session=$request->getSession();
//si le tableau de todos n'est pas initialisé alors message d'erreur
if(!$session->has('todos')){
    $this->addFlash('error',"la liste des todos n'est pas encore initialisée");

}
else{
    //recupere le tableau de todos
    $todos=$session->get('todos');
    //verififer si on a deja un toddo avec le mame nom
    if(isset($todos[$name])){
        //afficher une erreur
        $this->addFlash('error',"ce todo existe deja dans la liste");
    }
    else{
       //ajouter le toddo dans la liste
        $todos[$name]=$content;
        //afficher un message de succes
        $this->addFlash('success',"le todo d'id $name a ete ajouté correctement");
        $session->set('todos',$todos);
    }

}

return $this->redirectToRoute('app_todos');
    }


#[Route('/todos/update/{name}/{content}',name:'todos.update')]
public function updateTodos($name,$content,Request $request):RedirectResponse
{
    //on récupère la session
    $session=$request->getSession();
//si le tableau de todos n'est pas initialisé alors message d'erreur
    if(!$session->has('todos')){
        $this->addFlash('error',"la liste des todos n'est pas encore initialisée");

    }
    else{
        //recupere le tableau de todos
        $todos=$session->get('todos');
        //si le toddo n'existe pas dans la liste
        if(!isset($todos[$name])){
            //afficher une erreur
            $this->addFlash('error',"le todo d'id $name  n'existe pas dans la liste");
        }
        else{
            //mise à jour
            $todos[$name]=$content;
            $session->set('todos',$todos);
            //afficher un message de succes
            $this->addFlash('success',"le todo d'id $name a ete mis a jour  correctement");

        }

    }

    return $this->redirectToRoute('app_todos');
}


    #[Route('/todos/delete/{name}',name:'todos.delete')]
    public function deleteTodos($name,Request $request):RedirectResponse
    {
        //on récupère la session
        $session=$request->getSession();
//si le tableau de todos n'est pas initialisé alors message d'erreur
        if(!$session->has('todos')){
            $this->addFlash('error',"la liste des todos n'est pas encore initialisée");

        }
        else{
            //recupere le tableau de todos
            $todos=$session->get('todos');
            //si le toddo n'existe pas dans la liste
            if(!isset($todos[$name])){
                //afficher une erreur
                $this->addFlash('error',"le todo d'id $name  n'existe pas dans la liste");
            }
            else{
                //suppression
               unset($todos[$name]);
                $session->set('todos',$todos);
                //afficher un message de succes
                $this->addFlash('success',"le todo d'id $name a ete supprimé  correctement");

            }

        }

        return $this->redirectToRoute('app_todos');
    }

    #[Route('/todos/reset',name:'todos.reset')]
    public function resetTodos(Request $request):RedirectResponse
    {
        $session=$request->getSession();
        $session->remove('todos');


        return $this->redirectToRoute('app_todos');
    }
}
