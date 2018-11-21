<?php
/**
 * Created by PhpStorm.
 * Enrollment: Aeliot
 * Date: 03.11.2018
 * Time: 16:24
 */

namespace Controller;

use Core\HTTP\Exception\NotFoundException;
use Core\HTTP\Request\Request;
use Core\HTTP\Response\RedirectResponse;
use Core\HTTP\Response\Response;
use Enum\Role;
use Form\AdminEnrollmentForm;
use Model\EnrollmentModel;
use Model\SubjectModel;
use Model\UserModel;
use Template\Renderer;

class EnrollmentController
{
    /**
     * @var EnrollmentModel
     */
    private $model;

    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * @var UserModel
     */
    private $userModel;

    /**
     * @var SubjectModel
     */
    private $subjectModel;

    /**
     * @param EnrollmentModel $model
     * @param UserModel $userModel
     * @param SubjectModel $subjectModel
     * @param Renderer $renderer
     */
    public function __construct(
        EnrollmentModel $model,
        UserModel $userModel,
        SubjectModel $subjectModel,
        Renderer $renderer
    ) {
        $this->model = $model;
        $this->renderer = $renderer;
        $this->userModel = $userModel;
        $this->subjectModel = $subjectModel;
    }

    /**
     * @param Request $request
     * @return Response|RedirectResponse
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $users = $this->getUsers();
        $subjects = $this->getSubjects();
        $form = new AdminEnrollmentForm(null, $users, $subjects);
        if ($request->getMethod() === Request::METHOD_POST) {
            $form->parseRequest($request);
            if ($form->isValid()) {
                $this->model->create($form->getData());

                return new RedirectResponse('/enrollments');
            }
        }

        return new Response(
            $this->renderer->render(
                'Enrollment/create.php',
                ['form' => $form, 'users' => $users, 'subjects' => $subjects]
            )
        );
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws \Core\DB\Exception\ExecutionException
     */
    public function delete(Request $request, int $id)
    {
        $this->model->delete($id);

        return new RedirectResponse('/enrollments');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     * @throws NotFoundException
     * @throws \Core\DB\Exception\ExecutionException
     * @throws \Core\DB\Exception\NotUniqueException
     */
    public function edit(Request $request, int $id)
    {
        $enrollment = $this->model->getOne($id);
        if (!$enrollment) {
            throw new NotFoundException();
        }
        $users = $this->getUsers();
        $subjects = $this->getSubjects();
        $form = new AdminEnrollmentForm($enrollment, $users, $subjects);
        if ($request->getMethod() === Request::METHOD_POST) {
            $form->parseRequest($request);
            if ($form->isValid()) {
                $this->model->update($form->getData());

                return new RedirectResponse('/enrollments');
            }
        }

        return new Response(
            $this->renderer->render(
                'Enrollment/edit.php',
                ['enrollment' => $enrollment, 'form' => $form, 'users' => $users, 'subjects' => $subjects]
            )
        );
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Core\DB\Exception\ExecutionException
     */
    public function list(Request $request)
    {
        $limit = (int)$request->get('limit', 16);
        $offset = (int)$request->get('offset', 0);
        $filter = (array)$request->get('filter', []);
        $enrollments = $this->model->getList($limit, $offset, $filter);

        return new Response($this->renderer->render('Enrollment/list.php', ['enrollments' => $enrollments]));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws \Core\DB\Exception\ExecutionException
     * @throws \Core\DB\Exception\NotUniqueException
     */
    public function view(Request $request, int $id)
    {
        $enrollment = $this->model->getOne($id);

        return new Response($this->renderer->render('Enrollment/view.php', ['enrollment' => $enrollment]));
    }

    /**
     * @return array
     * @throws \Core\DB\Exception\ExecutionException
     */
    private function getSubjects(): array
    {
        return $this->subjectModel->getNames();
    }

    /**
     * @return array
     */
    private function getUsers(): array
    {
        return $this->userModel->getNames(Role::getForEnrollment());
    }
}