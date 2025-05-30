<?php

namespace App\Services;

use App\Models\Habit;
use App\Models\User;
use DateTime;

class HabitService
{
    public static function encodeDays(array $days): int
    {
        $map = [
            'Sunday' => 1 << 0, // 1
            'Monday' => 1 << 1, // 2
            'Tuesday' => 1 << 2, // 4
            'Wednesday' => 1 << 3,  // 8
            'Thursday' => 1 << 4, // ...
            'Friday' => 1 << 5,
            'Saturday' => 1 << 6,
        ];
        $mask = 0;
        foreach ($days as $day) {
            $mask |= $map[$day] ?? 0;
        }

        return $mask;
    }

    public static function store(User $user, array $data): Habit
    {
        if (isset($data['reminder_time']) && $data['reminder_time'] != null) {
            $time = DateTime::createFromFormat('h:i A', $data['reminder_time']);
            $data['reminder_time'] = $time->format('H:i');
        }

        return Habit::create([
            'user_id' => $user->id,
            'name' => $data['name'],
            'days' => self::encodeDays($data['days']),
            'reminder_time' => (! empty($data['reminder_time'])) ? $data['reminder_time'] : null,
        ]);

    }

    public function CanCreateHabit($user, $name): array
    {
        if ($user->habits()->count() >= config('app.data.max_habits')) {
            return [
                'status' => false,
                'message' => 'Sorry, you can’t add more than '.config('app.data.max_habits').' habits.',
            ];
        }

        if ($user->habits()->where('name', $name)->exists()) {
            return [
                'status' => false,
                'message' => 'Habit already exists!',
            ];
        }

        return [
            'status' => true,
        ];

    }

    public static function update(Habit $habit, array $data): Habit
    {
        $habit->update([
            'name' => $data['name'],
            'days' => self::encodeDays($data['days']),
            'reminder_time' => $data['reminder_time'],
        ]);

        return $habit;
    }

    public function CanUpdateHabit($user, $habit, $name): array
    {

        if ($user->habits()->where('id', '!=', $habit->id)->where('name', $name)->exists()) {
            return [
                'status' => false,
                'message' => 'There is another habit with that name',
            ];
        }

        return [
            'status' => true,
        ];

    }
}
