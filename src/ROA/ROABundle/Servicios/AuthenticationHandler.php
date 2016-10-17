<?php

    namespace ROA\ROABundle\Servicios;

    use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
    use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
    use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
    use Symfony\Component\Security\Core\Exception\AuthenticationException;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\RedirectResponse;
    use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

    //use Symfony\Bundle\FrameworkBundle\Routing\Router;
    //use Symfony\Component\Routing\RouterInterface;



    class AuthenticationHandler implements AuthenticationFailureHandlerInterface, LogoutSuccessHandlerInterface, AuthenticationSuccessHandlerInterface
    {
        
        public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
        {       
            $referer = $request->headers->get('referer');       
            //$request->getSession()->setFlash('error', $exception->getMessage());
            $request->getSession()->setFlash('error', 'Usuario o Contraseña incorrecta');

            return new RedirectResponse($referer);
        }

        public function onLogoutSuccess(Request $request) 
        {
            //$referer = $request->headers->get('referer');
            //return new RedirectResponse($referer);
        }
        public function onAuthenticationSuccess(Request $request, TokenInterface $token)
        {
            
            //echo $request->getSession()->count();
            $usuario = $token->getUser();
            if ($usuario->getActivacion() != null){
              throw new AuthenticationException('ERROR');  
            }

            //$url = $this->router->generate('_inicio');
            

           // echo $request->getSession()->get('security.secured_area.target_path'); exit();
            //echo __DIR__; exit();

            //return new RedirectResponse($url);

            //return new RedirectResponse($request->getSession()->get('_security._target_path'));

            //return $this->httpUtils->createRedirectResponse($request, $this->determineTargetUrl($request));
            //return new RedirectResponse($this->determineTargetUrl($request));
            return new RedirectResponse('/roa/web/app.php/index');
        }
    }
?>