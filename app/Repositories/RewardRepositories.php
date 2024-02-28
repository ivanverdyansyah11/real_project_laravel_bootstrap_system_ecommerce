<?php

namespace App\Repositories;

use App\Models\Reward;
use App\Utils\UploadFile;

class RewardRepositories
{
    public function __construct(
        protected readonly Reward $reward,
        protected readonly UploadFile $uploadFile,
    ) {}

    public function findAll()
    {
        return $this->reward->latest()->get();
    }

    public function findAllPaginate()
    {
        return $this->reward->latest()->get();
    }

    public function findById(int $reward_id): reward
    {
        return $this->reward->where('id', $reward_id)->first();
    }

    public function store($request): reward
    {
        $request['image'] = $this->uploadFile->uploadSingleFile($request['image'], "assets/images/reward");
        return $this->reward->create($request);
    }

    public function update($request, $reward): bool
    {
        if (isset($request["image"])) {
            $this->uploadFile->deleteExistFile("assets/images/reward/" . $reward->image);
            $filename = $this->uploadFile->uploadSingleFile($request['image'], 'assets/images/reward');
            $request['image'] = $filename;
        } else {
            $request['image'] = $reward->image;
        }
        return $reward->update($request);
    }

    public function delete($reward): bool
    {
        $this->uploadFile->deleteExistFile("assets/images/reward/" . $reward->image);
        return $reward->delete();
    }
}
