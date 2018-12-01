<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 03.11.2018
 * Time: 16:24
 */

namespace Controller;

use Core\DB\Exception\ExecutionException;
use Core\DB\Exception\NotUniqueException;
use Core\Form\FormFactory;
use Core\HTTP\Exception\NotFoundException;
use Core\HTTP\Request\Request;
use Core\HTTP\Response\RedirectResponse;
use Core\HTTP\Response\Response;
use Form\UserType;
use Model\UserModel;
use Template\Renderer;

class UserController
{
    /**
     * @var UserModel
     */
    private $model;

    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @param UserModel $model
     * @param FormFactory $formFactory
     * @param Renderer $renderer
     */
    public function __construct(UserModel $model, FormFactory $formFactory, Renderer $renderer)
    {
        $this->model = $model;
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
    }

    /**
     * @param Request $request
     * @return Response|RedirectResponse
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $form = $this->formFactory->build(UserType::class);
        if ($request->getMethod() === Request::METHOD_POST) {
            $form->parseRequest($request);
            if ($form->isValid()) {
                $this->model->create($form->getData());

                return new RedirectResponse('/users');
            }
        }

        return new Response($this->renderer->render('User/create.php', ['form' => $form]));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ExecutionException
     */
    public function delete(Request $request, int $id)
    {
        $this->model->delete($id);

        return new RedirectResponse('/users');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     * @throws NotFoundException
     * @throws ExecutionException
     * @throws NotUniqueException
     * @throws \Exception
     */
    public function edit(Request $request, int $id)
    {
        $user = $this->model->getOne($id);
        if (!$user) {
            throw new NotFoundException();
        }
        $form = $this->formFactory->build(UserType::class, $user);
        if ($request->getMethod() === Request::METHOD_POST) {
            $form->parseRequest($request);
            if ($form->isValid()) {
                $this->model->update($form->getData());

                return new RedirectResponse('/users');
            }
        }

        return new Response($this->renderer->render('User/edit.php', ['user' => $user, 'form' => $form]));
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ExecutionException
     * @throws \Exception
     */
    public function list(Request $request)
    {
        $limit = (int)$request->get('limit', 16);
        $offset = (int)$request->get('offset', 0);
        $filter = (array)$request->get('filter', []);
        $users = $this->model->getList($limit, $offset, $filter);

        return new Response($this->renderer->render('User/list.php', ['users' => $users]));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws ExecutionException
     * @throws NotUniqueException
     * @throws \Exception
     */
    public function view(Request $request, int $id)
    {
        $user = $this->model->getOne($id);

        return new Response($this->renderer->render('User/view.php', ['user' => $user]));
    }
}