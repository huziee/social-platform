<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        if ($users->isEmpty()) {
            $users = collect([User::factory()->create()]);
        }

        $categories = [
            'Lifestyle',
            'Tech',
            'Travel',
            'Food',
            'Business',
            'Health',
        ];

        $locations = [
            'New York, NY',
            'Los Angeles, CA',
            'Chicago, IL',
            'Houston, TX',
            'Seattle, WA',
            null,
        ];

        $titles = [
            'How I Plan My Week for Deep Work',
            'Small Habits That Compounded Fast',
            'A Weekend Guide to Exploring Downtown',
            'What I Learned Building My First App',
            'The Minimalist Desk Setup That Works',
            'Notes from a Quiet Morning Walk',
            'Three Recipes That Never Fail',
            'Simple Ways to Improve Your Focus',
            'Why I Switched to a 4-Day Workweek',
            'Lessons from 30 Days of Journaling',
        ];

        foreach ($titles as $title) {
            $user = $users->random();
            $start = now()->subDays(rand(0, 60));
            $end = (rand(0, 1) === 1) ? $start->copy()->addDays(rand(0, 7)) : null;

            Blog::create([
                'user_id' => $user->id,
                'title' => $title,
                'category' => $categories[array_rand($categories)],
                'description' => Str::limit(
                    'A pleasure exertion if believed provided to. All led out world this music while asked. ' .
                    'Paid mind even sons does he door no. Attended overcame repeated it is perceived. ' .
                    'Servants moreover in sensible it ye possible. Satisfied conveying a dependent contented.',
                    600
                ),
                'location' => $locations[array_rand($locations)],
                'start_date' => $start->toDateString(),
                'end_date' => $end?->toDateString(),
                'image' => null,
            ]);
        }
    }
}
