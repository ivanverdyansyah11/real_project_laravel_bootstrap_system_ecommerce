<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\Reseller;
use App\Models\User;
use App\Utils\UploadFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class CustomerRepositories
{
    public function __construct(
        protected readonly User $user,
        protected readonly Customer $customer,
        protected readonly UploadFile $uploadFile,
    ) {}

    public function findAll()
    {
        return $this->customer->with(['user'])->latest()->get();
    }

    public function findAllPaginate()
    {
        return $this->customer->with(['user'])->latest()->get();
    }

    public function findById(int $customer_id): customer
    {
        return $this->customer->with(['user'])->where('id', $customer_id)->first();
    }

    public function findByUserId(int $customer_id)
    {
        return $this->customer->with(['user'])->where('users_id', $customer_id)->first();
    }

    public function findLastData()
    {
        return $this->user->latest()->first();
    }

    public function approved(int $id)
    {
        $customer = $this->findByUserId($id);
        $request['status'] = 1;
        return $customer->user->update($request);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $filenameKTP = $this->uploadFile->uploadSingleFile($request['photo_ktp'], "assets/images/customer");
            $filenameImage = $this->uploadFile->uploadSingleFile($request['image'], "assets/images/profile");
            $request['image'] = $filenameImage;
            $request['photo_ktp'] = $filenameKTP;
            $request['password'] = bcrypt($request['password']);
            $this->user->create(Arr::only($request, ['email', 'password', 'image', 'role', 'status']));
            $user = $this->user->latest()->first();
            $request['users_id'] = $user->id;
            DB::commit();
            return $this->customer->create(Arr::only($request, ['users_id', 'name', 'number_phone', 'photo_ktp']));
        } catch (\Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $customer)
    {
        DB::beginTransaction();
        try {
            if (isset($request["photo_ktp"])) {
                $this->uploadFile->deleteExistFile("assets/images/customer/" . $customer->photo_ktp);
                $filename = $this->uploadFile->uploadSingleFile($request['photo_ktp'], 'assets/images/customer');
                $request['photo_ktp'] = $filename;
            } else {
                $request['photo_ktp'] = $customer->photo_ktp;
            }
            if (isset($request["image"])) {
                $this->uploadFile->deleteExistFile("assets/images/profile/" . $customer->user->image);
                $filename = $this->uploadFile->uploadSingleFile($request['image'], 'assets/images/profile');
                $request['image'] = $filename;
            } else {
                $request['image'] = $customer->user->image;
            }
            $customer->user->update(Arr::only($request, ['email', 'image']));
            DB::commit();
            return $customer->update(Arr::only($request, ['name', 'number_phone', 'photo_ktp']));
        } catch (\Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($customer)
    {
        $this->uploadFile->deleteExistFile("assets/images/customer/" . $customer->photo_ktp);
        $this->uploadFile->deleteExistFile("assets/images/profile/" . $customer->user->image);
        return $customer->delete();
    }
}
