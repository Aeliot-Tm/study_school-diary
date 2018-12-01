<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 18.11.2018
 * Time: 4:48
 */

namespace Controller;

use Core\DB\Exception\ExecutionException;
use Core\DB\Exception\NotUniqueException;
use Core\Form\FormFactory;
use Core\HTTP\Request\Request;
use Core\HTTP\Response\RedirectResponse;
use Core\HTTP\Response\Response;
use Form\LoginType;
use Service\SecurityService;
use Template\Menu;
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
     * @var Menu
     */
    private $menu;

    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @param SecurityService $securityService
     * @param FormFactory $formFactory
     * @param Menu $menu
     * @param Renderer $renderer
     */
    public function __construct(
        SecurityService $securityService,
        FormFactory $formFactory,
        Menu $menu,
        Renderer $renderer
    ) {
        $this->renderer = $renderer;
        $this->securityService = $securityService;
        $this->menu = $menu;
        $this->formFactory = $formFactory;
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws ExecutionException
     * @throws NotUniqueException
     * @throws \Exception
     */
    public function login(Request $request)
    {
        $form = $this->formFactory->build(LoginType::class);
        if ($request->getMethod() === Request::METHOD_POST) {
            $form->parseRequest($request);
            if ($form->isValid()) {
                if ($this->securityService->authorize($form->getData())) {
                    $this->menu->invalidate();

                    return new RedirectResponse('/');
                }
                //TODO add message on fail
            }
        }

        return new Response($this->renderer->render('Security/login.php', ['form' => $form]));
    }

    /**
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        $this->securityService->logout();
        $this->menu->invalidate();

        return new RedirectResponse('/', Response::REDIRECT_FOUND);
    }
}