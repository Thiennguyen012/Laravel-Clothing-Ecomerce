<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\Interfaces\IUserRepository;

class UserRepository extends BaseRepository implements IUserRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
    public function newUser(array $data = [])
    {
        return $this->model->create($data);
    }
    public function userFilter($name = null, $email = null, $role = null, $sort = null, $direction = null)
    {
        $query = $this->model->where('role', $role);
        if ($name) {
            $query = $query->where('name', 'like', "%$name%");
        }
        if ($email) {
            $query = $query->where('email', 'like', "%$email%");
        }
        if ($sort) {
            $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';
        }
        switch ($sort) {
            case 'id':
            case 'name':
            case 'email':
            case 'updated_at':
                $query = $query->orderBy($sort, $direction);
                break;
            case 'role':
            default:
                $query = $query->orderBy('id', 'desc');
        }
        return $query->paginate(12);
    }
    public function changeRole($user_id, $role)
    {
        $user = $this->model->where('id', $user_id)->first();
        $user->update([
            'role' => $role
        ]);
    }
}
