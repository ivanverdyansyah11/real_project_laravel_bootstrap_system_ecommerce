<?php

namespace App\Repositories;

use App\Models\Reseller;
use App\Models\User;
use App\Utils\UploadFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AuthRepository
{
    public function __construct(
        protected readonly User $user,
        protected readonly Reseller $reseller,
        protected readonly UploadFile $uploadFile,
    ) {}

    public function createUser($request) : User
    {
        DB::beginTransaction();
        try {
            $filenameKTP = $this->uploadFile->uploadSingleFile($request['photo_ktp'], "assets/images/reseller");
            $request['photo_ktp'] = $filenameKTP;
            $request['password'] = bcrypt($request['password']);
            $userValidation = $this->user->create(Arr::only($request, ['email', 'password', 'role']));
            $userLastId = $this->user->latest()->first();
            $request['users_id'] = $userLastId->id;
            $this->reseller->create(Arr::only($request, ['users_id', 'name', 'number_phone', 'photo_ktp']));
            DB::commit();
            return $userValidation;
        } catch (\Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }

    public function logout($request): bool
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return true;
    }
}
