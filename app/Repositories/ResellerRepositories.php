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

  public function store($request): reseller
  {
    DB::beginTransaction();     
    try {
      if ($request["image"]) {
        $filenameImage = $this->uploadFile->uploadSingleFile($request['image'], "profile");
        $request['image'] = $filenameImage;
      }

      if ($request["photo_ktp"]) {
        $filenameKTP = $this->uploadFile->uploadSingleFile($request['photo_ktp'], "reseller");
        $request['photo_ktp'] = $filenameKTP;
      }

      dd($request);

      $reseller = $this->reseller->create(Arr::except($request, "images"));

      DB::commit();
      return $reseller;
    } catch (\Exception $e) {
      logger($e->getMessage());
      DB::rollBack();
      throw $e;
    }
  }

  public function update($request, $reseller): bool
  {
    return $reseller->update($request);
  }

  public function delete($reseller): bool
  {
    return $reseller->delete();
  }
}