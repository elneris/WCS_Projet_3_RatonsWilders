<?php

namespace App\Services;

use App\Entity\Activity;
use App\Entity\User;
use App\Repository\ActivityRepository;

class ActivityManager
{
    private $activityRepository;

    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    public function activityExists(Activity $activity, User $user)
    {
        $userActivity = $this->activityRepository->findOneBy([
            'user' => $user,
            'domain' => $activity->getDomain(),
            'style' => $activity->getStyle(),
            'skill' => $activity->getSkill(),
        ]);

        return !empty($userActivity);
    }
}
