<?php

namespace App\Listeners;

use App\Events\UserSaved;
use App\Services\UserServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveUserBackgroundInformation
{
    protected UserServiceInterface $userService;

    private static array $detailKeys = [
        'Full name',
        'Middle Initial',
        'Avatar',
        'Gender',
    ];

    /**
     * Create the event listener.
     *
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    private static function generateUserDetailsArray($userId, array $values): array
    {
        return \array_map(function ($key, $value, $type = 'bio') use ($userId) {
            return \compact('key', 'value', 'type') + ['user_id' => $userId];
        }, self::$detailKeys, $values);
    }

    /**
     * Handle the event.
     *
     * @param UserSaved $event
     * @return void
     */
    public function handle(UserSaved $event)
    {
        $values = [
            $event->user->fullname,
            $event->user->middleinitial,
            asset($event->user->photo),
            $event->user->gender
        ];

        $this->userService->saveDetails($event->user, self::generateUserDetailsArray($event->user->id, $values));
    }
}
