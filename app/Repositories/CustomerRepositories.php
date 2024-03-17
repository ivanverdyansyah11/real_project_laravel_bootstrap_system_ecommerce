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
        return $this->customer->latest()->get();
    }

    public function findAllPaginate()
    {
        return $this->customer->latest()->get();
    }

    public function findById(int $customer_id): customer
    {
        return $this->customer->where('id', $customer_id)->first();
    }

    public function findByUserId(int $customer_id)
    {
        return $this->customer->where('users_id', $customer_id)->first();
    }

    public function findLastData()
    {
        return $this->user->latest()->first();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $filenameKTP = $this->uploadFile->uploadSingleFile($request['photo_ktp'], "assets/images/customer");
            $filenameImage = $this->uploadFile->uploadSingleFile($request['image'], "assets/images/profile");
            $request['image'] = $filenameImage;
            $request['photo_ktp'] = $filenameKTP;
            DB::commit();
            return $this->customer->create($request);
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
                $this->uploadFile->deleteExistFile("assets/images/profile/" . $customer->image);
                $filename = $this->uploadFile->uploadSingleFile($request['image'], 'assets/images/profile');
                $request['image'] = $filename;
            } else {
                $request['image'] = $customer->image;
            }
            DB::commit();
            return $customer->update($request);
        } catch (\Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($customer)
    {
        $this->uploadFile->deleteExistFile("assets/images/customer/" . $customer->photo_ktp);
        $this->uploadFile->deleteExistFile("assets/images/profile/" . $customer->image);
        return $customer->delete();
    }
}
