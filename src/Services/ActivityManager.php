<?php

namespace App\Services;

use App\Repository\ActivityRepository;

class ActivityManager
{
    private $activityRepository;

    public function __construct(ActivityRepository $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    public function activityExist($activity)
    {
        $useractivities = $this->activityRepository->findAll();

        foreach ($useractivities as $useractivity) {
            if ($useractivity->getUser() === $activity->getUser() &&
                $useractivity->getDomain() === $activity->getdomain() &&
                $useractivity->getskill() === $activity->getskill() &&
                $useractivity->getStyle() === $activity->getStyle()
            ) {
                return true;
            }
        }
        return false;
    }
}
