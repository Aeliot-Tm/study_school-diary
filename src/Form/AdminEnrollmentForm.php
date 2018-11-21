<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 07.11.2018
 * Time: 23:36
 */

namespace Form;

use Core\HTTP\Request\Request;
use Enum\Role;

class AdminEnrollmentForm
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $violations = [];

    /**
     * @var array
     */
    private $users;

    /**
     * @var array
     */
    private $subjects;

    /**
     * @param array $data
     * @param array $users
     * @param array $subjects
     */
    public function __construct(array $data = null, array $users = [], array $subjects = [])
    {
        $this->data = $data ?: [];
        $this->users = $users;
        $this->subjects = $subjects;
    }

    /**
     * @return array|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getViolations(): array
    {
        return $this->violations;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return !$this->violations;
    }

    /**
     * @param Request $request
     */
    public function parseRequest(Request $request)
    {
        $userId = $request->get('user_id');
        $this->data['user_id'] = $userId ? (int)$userId : null;
        $subjectId = $request->get('subject_id');
        $this->data['subject_id'] = $subjectId ? (int)$subjectId : null;
        $this->data['role'] = $role = $request->get('role');

        if (!array_key_exists($userId, $this->users)) {
            $this->violations['user_id'] = 'Invalid user';
        }
        if (!array_key_exists($subjectId, $this->subjects)) {
            $this->violations['subject_id'] = 'Invalid subject';
        }
        if (!in_array($role, Role::getForEnrollment())) {
            $this->violations['role'] = 'Invalid role';
        }
    }
}
