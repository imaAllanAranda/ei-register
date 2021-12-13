<?php

namespace Database\Seeders;

use App\Models\Adviser;
use App\Models\Claim;
use App\Models\ClaimNote;
use App\Models\Complaint;
use App\Models\ComplaintNote;
use App\Models\User;
use App\Models\VulnerableClient;
use App\Models\VulnerableClientNote;
use App\Traits\Validators\AdviserRequirementValidator;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    use AdviserRequirementValidator;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $this->call([RoleSeeder::class, UserSeeder::class, PermissionSeeder::class]);

        $user = User::factory()->create();

        $user->assignRole('admin');

        $complainants = [];

        Adviser::factory(10)->create([
            'status' => 'Active',
        ]);

        $staffNames = [];

        foreach (range(1, 10) as $item) {
            array_push($complainants, $faker->name());
        }

        foreach (range(1, 100) as $item) {
            $complaint = Complaint::factory()->create();

            ComplaintNote::factory()->create([
                'complaint_id' => $complaint->id,
            ]);

            $claim = Claim::factory()->create([
                'adviser_id' => Adviser::where('type', 'Adviser')->inRandomOrder()->first()->id,
            ]);

            ClaimNote::factory()->create([
                'claim_id' => $claim->id,
            ]);

            $vulnerableClient = VulnerableClient::factory()->create();

            VulnerableClientNote::factory()->create([
                'vulnerable_client_id' => $vulnerableClient->id,
            ]);
        }

        $adviser = Adviser::oldest('name')->first();

        $requirements = $adviser->requirements;

        $requirements['adviser_requirements']['fspr'] = '2021-08-31';

        $adviser->update([
            'requirements' => $requirements,
        ]);
    }
}
