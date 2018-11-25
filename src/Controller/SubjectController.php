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
use Core\HTTP\Exception\NotFoundException;
use Core\HTTP\Request\Request;
use Core\HTTP\Response\RedirectResponse;
use Core\HTTP\Response\Response;
use Form\SubjectForm;
use Model\SubjectModel;
use Template\Renderer;

class SubjectController
{
    /**
     * @var SubjectModel
     */
    private $model;

    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * @param SubjectModel $model
     * @param Renderer $renderer
     */
    public function __construct(SubjectModel $model, Renderer $renderer)
    {
        $this->model = $model;
        $this->renderer = $renderer;
    }

    /**
     * @param Request $request
     * @return Response|RedirectResponse
     * @throws ExecutionException
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $form = new SubjectForm();
        if ($request->getMethod() === Request::METHOD_POST) {
            $form->parseRequest($request);
            if ($form->isValid()) {
                $this->model->create($form->getData());

                return new RedirectResponse('/subjects');
            }
        }

        return new Response($this->renderer->render('Subject/create.php', ['form' => $form]));
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

        return new RedirectResponse('/subjects');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     * @throws ExecutionException
     * @throws NotFoundException
     * @throws NotUniqueException
     * @throws \Exception
     */
    public function edit(Request $request, int $id)
    {
        $subject = $this->model->getOne($id);
        if (!$subject) {
            throw new NotFoundException();
        }
        $form = new SubjectForm($subject);
        if ($request->getMethod() === Request::METHOD_POST) {
            $form->parseRequest($request);
            if ($form->isValid()) {
                $this->model->update($form->getData());

                return new RedirectResponse('/subjects');
            }
        }

        return new Response($this->renderer->render('Subject/edit.php', ['subject' => $subject, 'form' => $form]));
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
        $subjects = $this->model->getList($limit, $offset, $filter);

        return new Response($this->renderer->render('Subject/list.php', ['subjects' => $subjects]));
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
        $subject = $this->model->getOne($id);

        return new Response($this->renderer->render('Subject/view.php', ['subject' => $subject]));
    }
}