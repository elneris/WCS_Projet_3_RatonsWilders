<?php

namespace App\Services;

use App\Entity\Activity;
use App\Entity\Domain;
use App\Entity\Skill;
use App\Entity\Style;
use App\Entity\User;
use App\Repository\ActivityRepository;
use App\Repository\DomainRepository;
use App\Repository\SkillRepository;
use App\Repository\StyleRepository;

class ActivityManager
{
    private $activityRepository;
    private $domainRepository;
    private $skillRepository;
    private $styleRepository;

    public function __construct(ActivityRepository $activityRepository, DomainRepository $domainRepository,
                                SkillRepository $skillRepository, StyleRepository $styleRepository)
    {
        $this->activityRepository = $activityRepository;
        $this->domainRepository = $domainRepository;
        $this->skillRepository = $skillRepository;
        $this->styleRepository = $styleRepository;
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

    public function domainExist(Domain $domain)
    {
        $domainName = $this->domainRepository->findOneBy([
            'name' => $domain->getName()
        ]);

        return !empty($domainName);
    }

    public function skillExist(Skill $skill)
    {
        $skillName = $this->skillRepository->findOneBy([
            'name' => $skill->getName()
        ]);

        return !empty($skillName);
    }

    public function styleExist(Style $style)
    {
        $styleName = $this->styleRepository->findOneBy([
            'type' => $style->getType()
        ]);

        return !empty($styleName);
    }
}