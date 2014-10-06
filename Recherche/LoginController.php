<?php

namespace Ibisc\ReservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Ibisc\ReservationBundle\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Session\Session;


class LoginController extends Controller
{
    public function loginAction(Request $request)
    {
        if($request->getMethod() == 'POST'){
            
            $usermail=$request->get('mail');
            $password=$request->get('mdp');
            
            $error = 0;
            $em = $this->getDoctrine()->getEntityManager();
            $repository = $em->getRepository('IbiscReservationBundle:Utilisateur');

            $user = $repository->findOneBy(array('mail'=>$usermail, 'mdp'=>$password));
        
            if($user){
                
                $session = new Session();
                $session->start();
                $session->set('user_id', $user->getId());
                $session->set('user_nom', $user->getNom());
                $session->set('user_prenom', $user->getPrenom());
                $session->set('admin', $user->getEstAdmin());
                $session->set('listeReservations', $user->getReservations());
                var_dump($user->getReservations());
                return $this->render('IbiscReservationBundle:Default:accueil.html.twig', array('prenom' => $user->getPrenom(), 'nom' => $user->getNom(), 'admin' => $user->getEstAdmin(), 'listeReservations' => $user->getReservations()));
            } 
            
            else{
        
                 $error = 1;
                 return $this->render('IbiscReservationBundle:Default:login.html.twig', array('alert' => 'Mail ou mot de passe incorrect', 'error' => $error));
            }
            
            
            
        
        }
        
        return $this->render('IbiscReservationBundle:Default:login.html.twig');
        
        
    }
    
    public function logoutAction()
    {
        $session = new Session();
        
        $_SESSION = array();
        
        if (ini_get("session.use_cookies")) {
    
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
            $session->invalidate();
    
        }
        
        return $this->render('IbiscReservationBundle:Default:login.html.twig', array('alert' => 0));
    }
    
}
