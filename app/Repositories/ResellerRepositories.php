<?php

namespace App\Repositories;

use App\Models\Reseller;
use App\Models\User;
use App\Utils\UploadFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class ResellerRepositories
{
    public function __construct(
        protected readonly User $user,
        protected readonly Reseller $reseller,
        protected readonly UploadFile $uploadFile,
    ) {}

    public function findAll()
    {
        return $this->reseller->with(['user'])->latest()->get();
    }

    public function findAllPaginate()
    {
        return $this->reseller->with(['user'])->latest()->paginate(10);
    }

    public function findById(int $reseller_id): reseller
    {
        return $this->reseller->with(['user'])->where('id', $reseller_id)->first();
    }

    public function findLastData()
    {
        return $this->user->latest()->first();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $filenameKTP = $this->uploadFile->uploadSingleFile($request['photo_ktp'], "assets/images/reseller");
            $filenameImage = $this->uploadFile->uploadSingleFile($request['image'], "assets/images/profile");
            $request['image'] = $filenameImage;
            $request['photo_ktp'] = $filenameKTP;
            $request['password'] = bcrypt($request['password']);
            $this->user->create(Arr::only($request, ['email', 'password', 'image', 'role', 'status']));
            $user = $this->user->latest()->first();
            $request['users_id'] = $user->id;
            DB::commit();
            return $this->reseller->create(Arr::only($request, ['users_id', 'name', 'number_phone', 'photo_ktp']));
        } catch (\Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $reseller)
    {
        DB::beginTransaction();
        try {
            if (isset($request["photo_ktp"])) {
                $this->uploadFile->deleteExistFile("assets/images/reseller/" . $reseller->photo_ktp);
                $filename = $this->uploadFile->uploadSingleFile($request['photo_ktp'], 'assets/images/reseller');
                $request['photo_ktp'] = $filename;
            } else {
                $request['photo_ktp'] = $reseller->photo_ktp;
            }
            if (isset($request["image"])) {
                $this->uploadFile->deleteExistFile("assets/images/profile/" . $reseller->user->image);
                $filename = $this->uploadFile->uploadSingleFile($request['image'], 'assets/images/profile');
                $request['image'] = $filename;
            } else {
                $request['image'] = $reseller->user->image;
            }
            $reseller->user->update(Arr::only($request, ['email', 'image']));
            DB::commit();
            return $reseller->update(Arr::only($request, ['name', 'number_phone', 'photo_ktp']));
        } catch (\Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($reseller): bool
    {
        $this->uploadFile->deleteExistFile("assets/images/reseller/" . $reseller->photo_ktp);
        $this->uploadFile->deleteExistFile("assets/images/profile/" . $reseller->user->image);
        return $reseller->delete();
    }
}
