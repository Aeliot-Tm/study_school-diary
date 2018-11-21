<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 18.11.2018
 * Time: 4:48
 */

namespace Controller;

use Core\HTTP\Request\Request;
use Core\HTTP\Response\RedirectResponse;
use Core\HTTP\Response\Response;
use Form\LoginForm;
use Service\SecurityService;
use Template\Renderer;

class SecurityController
{
    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * @var SecurityService
     */
    private $securityService;

    /**
     * @param SecurityService $securityService
     * @param Renderer $renderer
     */
    public function __construct(SecurityService $securityService, Renderer $renderer)
    {
        $this->renderer = $renderer;
        $this->securityService = $securityService;
    }

    public function login(Request $request)
    {
        $form = new LoginForm();
        if ($request->getMethod() === Request::METHOD_POST) {
            $form->parseRequest($request);
            if ($form->isValid()) {
                $this->securityService->authorize($form->getData());

                return new RedirectResponse('/');
            }
        }

        return new Response($this->renderer->render('Security/login.php', ['form' => $form]));
    }
}