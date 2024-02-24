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
  
  public function createUser($request) : Reseller
  {
    DB::beginTransaction();
    try {
      $filename = $this->uploadFile->uploadSingleFile($request['photo_ktp'], "assets/images/reseller");
      $request['password'] = bcrypt($request->password);
      $this->user->create($request->only('email','password','role'));
      $user = $this->user->latest()->first();
      $request['users_id'] = $user->id;
      $reseller = $this->reseller->create([
        'users_id' => $request['users_id'],
        'name' => $request['name'],
        'number_phone' => $request['number_phone'],
        'photo_ktp' => $filename,
      ]);

      DB::commit();
      return $reseller;
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