<?php

namespace Tests\Feature;

use App\Entities\UserEntity;
use App\Entities\VacationEntity;
use App\Managers\VacationManager;
use Carbon\Carbon;
use Tests\TestCase;

class VacationManagerTest extends TestCase
{
    /** @var VacationManager */
    protected $vacationManager;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->vacationManager = $this->app->make(VacationManager::class);
    }

    /**
     * Count how many days employee has by working months
     */
    public function testVacationsPerMonth() : void
    {
        $this->assertSame(36, $this->vacationManager->countVacationByMonths(36, 12));
        $this->assertSame(0, $this->vacationManager->countVacationByMonths(36, 0));
        $this->assertSame(12, $this->vacationManager->countVacationByMonths(36, 4));
    }

    /**
     * Test how many working months employee has for a given year
     */
    public function testWorkingMonthsPerYear() : void
    {
        $year = 2017;

        // Year before
        $user = new UserEntity();
        $user->startDate = '01.06.2016';
        $this->assertSame(12, $this->vacationManager->countWorkingMonthsPerYear($user, $year));

        // Year after
        $user->startDate = '01.06.2018';
        $this->assertSame(0, $this->vacationManager->countWorkingMonthsPerYear($user, $year));

        // Test full month
        $user->startDate = '01.06.2017';
        $this->assertSame(7, $this->vacationManager->countWorkingMonthsPerYear($user, $year));

        // Test half month
        $user->startDate = '15.06.2017';
        $this->assertSame(6, $this->vacationManager->countWorkingMonthsPerYear($user, $year));
    }

    /**
     * Test how many extra vacation days employee could have regarding his/her age
     */
    public function testExtraVacationPerAge() : void
    {
        // age less than 30
        $this->assertSame(0, $this->vacationManager->countVacationForAge(29));

        // age equals 30
        $this->assertSame(1, $this->vacationManager->countVacationForAge(30));

        // age more than 30
        $this->assertSame(1, $this->vacationManager->countVacationForAge(31));
        $this->assertSame(1, $this->vacationManager->countVacationForAge(34));
        $this->assertSame(2, $this->vacationManager->countVacationForAge(35));
    }

    /**
     * Test how many vacation employee could have per year
     */
    public function testYearlyVacation() : void
    {
        $year = 2017;
        $user = new UserEntity();

        // not employed yet
        $user->startDate = '01.06.2018';
        $this->assertSame(0, $this->vacationManager->countYearlyVacation($user, $year));

        // has special condition
        $minVacationDays = (int) env('MIN_VACATION_DAYS', 26);
        $user->startDate = '01.06.2017';
        $user->vacationDays = $minVacationDays + 1;
        $this->assertSame($user->vacationDays, $this->vacationManager->countYearlyVacation($user, $year));

        // has special condition
        $user->vacationDays = $minVacationDays - 1;
        $this->assertSame($minVacationDays, $this->vacationManager->countYearlyVacation($user, $year));

        // normal vacation
        $user->vacationDays = null;
        $user->birthDate = Carbon::now()->subYears(25)->format('d.m.Y');
        $this->assertSame($minVacationDays, $this->vacationManager->countYearlyVacation($user, $year));

        // normal vacation with age
        $user->birthDate = Carbon::now()->subYears(33)->format('d.m.Y');
        $this->assertSame($minVacationDays + 1, $this->vacationManager->countYearlyVacation($user, $year));
    }

    /**
     * Test how many vacation employee could have per year
     */
    public function testVacationPerUser() : void
    {
        $year = 2017;
        $user = new UserEntity();
        $user->startDate = '15.06.2017';
        $user->birthDate = Carbon::now()->subYears(33)->format('d.m.Y');
        $user->vacationDays = (int) env('MIN_VACATION_DAYS', 26) + 1;

        $this->assertSame(
            $this->vacationManager->countVacationByMonths(
                $this->vacationManager->countYearlyVacation($user, $year),
                $this->vacationManager->countWorkingMonthsPerYear($user, $year)
            ),
            $this->vacationManager->count($user, $year)
        );
    }

    /**
     * Test vacation days count for users
     */
    public function testVacationForUsers() : void
    {
        $year = 2017;
        $user = new UserEntity();
        $user->fullName = 'Test';
        $user->startDate = '15.06.2017';
        $user->birthDate = Carbon::now()->subYears(33)->format('d.m.Y');
        $user->vacationDays = (int) env('MIN_VACATION_DAYS', 26) + 1;

        $users = new \SplFixedArray(1);
        $users[0] = $user;

        $result = $this->vacationManager->calculate($users, $year);
        /** @var VacationEntity $vacation */
        $vacation = $result[0];

        $this->assertInstanceOf(\SplFixedArray::class, $result);
        $this->assertInstanceOf(VacationEntity::class, $vacation);
        $this->assertSame($users->count(), $result->count());

        $this->assertSame($vacation->fullName, $user->fullName);
        $this->assertSame($vacation->year, $year);
        $this->assertSame($vacation->vacationDays, $this->vacationManager->count($user, $year));
    }
}
