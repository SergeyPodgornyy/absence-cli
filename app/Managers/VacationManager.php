<?php

namespace App\Managers;

use App\Entities\UserEntity;
use App\Entities\VacationEntity;
use Carbon\Carbon;

class VacationManager
{
    /** @var int */
    private $minVacationDays;

    public function __construct(int $minVacationDays)
    {
        $this->minVacationDays = $minVacationDays;
    }

    public function calculate(\SplFixedArray $users, int $year) : \SplFixedArray
    {
        $count = $users->count();
        $result = new \SplFixedArray($count);

        /** @var UserEntity $user */
        foreach ($users as $key => $user) {
            $vacation = new VacationEntity();
            $vacation->fullName = $user->fullName;
            $vacation->year = $year;
            $vacation->vacationDays = $this->count($user, $year);

            $result[$key] = $vacation;
        }

        return $result;
    }

    /**
     * Count vacation days for user for given year
     *
     * @param   UserEntity $user
     * @param   int        $year
     * @return  int
     */
    public function count(UserEntity $user, int $year) : int
    {
        $yearlyVacation = $this->countYearlyVacation($user, $year);

        $workingMonths = $this->countWorkingMonthsPerYear($user, $year);

        return $this->countVacationByMonths($yearlyVacation, $workingMonths);
    }

    /**
     * @param   UserEntity $user
     * @param   int        $year
     * @return  int
     */
    public function countYearlyVacation(UserEntity $user, int $year) : int
    {
        if (!$this->isUserEmployedAtYear($user, $year)) {
            return 0;
        } elseif ($this->hasUserSpecialCondition($user)) {
            return \max($this->minVacationDays, $user->vacationDays);
        } else {
            $age = (new Carbon($user->birthDate))->diffInYears();

            return $this->minVacationDays + $this->countVacationForAge($age);
        }
    }

    /**
     * @param   int $age
     * @return  int
     */
    public function countVacationForAge(int $age) : int
    {
        $days = 0;
        $age -= 25;

        while ($age >= 5) {
            $days++;
            $age -= 5;
        }

        return $days;
    }

    /**
     * @param   UserEntity $user
     * @param   int        $year
     * @return  int
     */
    public function countWorkingMonthsPerYear(UserEntity $user, int $year) : int
    {
        $startYear = $this->getStartYear($user);

        if ($startYear < $year) {
            return 12;
        } elseif ($startYear > $year) {
            return 0;
        } else {
            $startMonth = $this->getStartDate($user)->isSameDay($this->getStartDate($user)->startOfMonth())
                ? $this->getStartDate($user)->startOfMonth()
                : $this->getStartDate($user)->startOfMonth()->addMonth();
            $endMonth = $this->getStartDate($user)->endOfYear()->addMonth()->startOfMonth();

            return $startMonth->diffInMonths($endMonth);
        }
    }

    /**
     * @param   int $yearlyVacation
     * @param   int $workingMonths
     * @return  int
     */
    public function countVacationByMonths(int $yearlyVacation, int $workingMonths) : int
    {
        if ($workingMonths === 12) {
            return $yearlyVacation;
        } elseif ($workingMonths === 0) {
            return 0;
        } else {
            return \floor($yearlyVacation * $workingMonths / 12);
        }
    }

    /**
     * @param   UserEntity $user
     * @return  Carbon
     * @throws  \InvalidArgumentException
     */
    private function getStartDate(UserEntity $user) : Carbon
    {
        return Carbon::createFromFormat('d.m.Y', $user->startDate);
    }

    /**
     * @param   UserEntity $user
     * @return  int
     * @throws  \InvalidArgumentException
     */
    private function getStartYear(UserEntity $user) : int
    {
        return $this->getStartDate($user)->year;
    }

    /**
     * @param   UserEntity $user
     * @param   int        $year
     *
     * @return  bool
     * @throws  \InvalidArgumentException
     */
    private function isUserEmployedAtYear(UserEntity $user, int $year) : bool
    {
        return $this->getStartYear($user) <= $year;
    }

    /**
     * @param   UserEntity $user
     * @return  bool
     */
    private function hasUserSpecialCondition(UserEntity $user) : bool
    {
        return (bool) $user->vacationDays;
    }
}
