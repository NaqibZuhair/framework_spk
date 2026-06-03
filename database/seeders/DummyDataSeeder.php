<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('aras_results')->truncate();
        DB::table('scores')->truncate();
        DB::table('interviews')->truncate();
        DB::table('jury_criteria')->truncate();
        DB::table('criteria')->truncate();
        DB::table('candidates')->truncate();
        DB::table('election_periods')->truncate();

        DB::table('users')->whereIn('email', [
            'admin@duta.test',
            'juri1@duta.test',
            'juri2@duta.test',
            'juri3@duta.test',
        ])->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = now();

        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */

        $adminId = DB::table('users')->insertGetId([
            'name' => 'Admin Seleksi',
            'email' => 'admin@duta.test',
            'email_verified_at' => $now,
            'password' => Hash::make('password'),
            'phone' => '081111111111',
            'role' => 'admin',
            'is_active' => true,
            'remember_token' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $juri1Id = DB::table('users')->insertGetId([
            'name' => 'Juri Public Speaking',
            'email' => 'juri1@duta.test',
            'email_verified_at' => $now,
            'password' => Hash::make('password'),
            'phone' => '082111111111',
            'role' => 'juri',
            'is_active' => true,
            'remember_token' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $juri2Id = DB::table('users')->insertGetId([
            'name' => 'Juri Kepribadian',
            'email' => 'juri2@duta.test',
            'email_verified_at' => $now,
            'password' => Hash::make('password'),
            'phone' => '082222222222',
            'role' => 'juri',
            'is_active' => true,
            'remember_token' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $juri3Id = DB::table('users')->insertGetId([
            'name' => 'Juri Institusi',
            'email' => 'juri3@duta.test',
            'email_verified_at' => $now,
            'password' => Hash::make('password'),
            'phone' => '082333333333',
            'role' => 'juri',
            'is_active' => true,
            'remember_token' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Election Period
        |--------------------------------------------------------------------------
        */

        $periodId = DB::table('election_periods')->insertGetId([
            'election_year' => 2026,
            'registration_start' => $now->copy()->subDays(7),
            'registration_end' => $now->copy()->addDays(7),
            'interview_start' => $now->copy()->addDays(8),
            'interview_end' => $now->copy()->addDays(9),
            'status' => 'scoring',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Candidates
        |--------------------------------------------------------------------------
        */

        $candidate1Id = DB::table('candidates')->insertGetId([
            'period_id' => $periodId,
            'registration_number' => 'DPNJ-2026-001',
            'full_name' => 'Aditya Saputra',
            'student_number' => '2103421045',
            'email' => 'aditya@student.pnj.ac.id',
            'phone' => '083111111111',
            'faculty' => 'Teknik',
            'study_program' => 'Teknik Informatika',
            'semester' => 5,
            'vision' => 'Menjadi representasi mahasiswa PNJ yang aktif dan komunikatif.',
            'mission' => 'Membangun citra positif PNJ melalui kegiatan akademik dan nonakademik.',
            'photo_file' => null,
            'cv_file' => null,
            'status' => 'valid',
            'validated_by' => $adminId,
            'validated_at' => $now,
            'rejection_reason' => null,
            'created_at' => $now->copy()->subDays(5),
            'updated_at' => $now,
        ]);

        $candidate2Id = DB::table('candidates')->insertGetId([
            'period_id' => $periodId,
            'registration_number' => 'DPNJ-2026-002',
            'full_name' => 'Rina Mutia',
            'student_number' => '2107411012',
            'email' => 'rina@student.pnj.ac.id',
            'phone' => '083222222222',
            'faculty' => 'Akuntansi',
            'study_program' => 'Akuntansi Terapan',
            'semester' => 5,
            'vision' => 'Mewakili PNJ dengan sikap profesional dan percaya diri.',
            'mission' => 'Meningkatkan partisipasi mahasiswa dalam kegiatan kampus.',
            'photo_file' => null,
            'cv_file' => null,
            'status' => 'interview_scheduled',
            'validated_by' => $adminId,
            'validated_at' => $now,
            'rejection_reason' => null,
            'created_at' => $now->copy()->subDays(4),
            'updated_at' => $now,
        ]);

        $candidate3Id = DB::table('candidates')->insertGetId([
            'period_id' => $periodId,
            'registration_number' => 'DPNJ-2026-003',
            'full_name' => 'Bagus Kurniawan',
            'student_number' => '2204311088',
            'email' => 'bagus@student.pnj.ac.id',
            'phone' => '083333333333',
            'faculty' => 'Teknik Mesin',
            'study_program' => 'Teknik Mesin',
            'semester' => 3,
            'vision' => 'Menjadi duta yang inspiratif bagi mahasiswa.',
            'mission' => 'Mendukung kegiatan kampus secara aktif dan bertanggung jawab.',
            'photo_file' => null,
            'cv_file' => null,
            'status' => 'scored',
            'validated_by' => $adminId,
            'validated_at' => $now,
            'rejection_reason' => null,
            'created_at' => $now->copy()->subDays(3),
            'updated_at' => $now,
        ]);

        $candidate4Id = DB::table('candidates')->insertGetId([
            'period_id' => $periodId,
            'registration_number' => 'DPNJ-2026-004',
            'full_name' => 'Nadia Putri',
            'student_number' => '2205521099',
            'email' => 'nadia@student.pnj.ac.id',
            'phone' => '083444444444',
            'faculty' => 'Administrasi Niaga',
            'study_program' => 'Administrasi Bisnis',
            'semester' => 3,
            'vision' => 'Menjadi perwakilan mahasiswa yang berintegritas.',
            'mission' => 'Mengenalkan nilai positif PNJ kepada masyarakat.',
            'photo_file' => null,
            'cv_file' => null,
            'status' => 'pending',
            'validated_by' => null,
            'validated_at' => null,
            'rejection_reason' => null,
            'created_at' => $now->copy()->subDays(2),
            'updated_at' => $now,
        ]);

        $candidate5Id = DB::table('candidates')->insertGetId([
            'period_id' => $periodId,
            'registration_number' => 'DPNJ-2026-005',
            'full_name' => 'Fajar Ramadhan',
            'student_number' => '2306612033',
            'email' => 'fajar@student.pnj.ac.id',
            'phone' => '083555555555',
            'faculty' => 'Teknik Elektro',
            'study_program' => 'Teknik Elektro',
            'semester' => 2,
            'vision' => 'Menjadi mahasiswa yang aktif dalam pengembangan citra kampus.',
            'mission' => 'Mengikuti kegiatan seleksi dengan bertanggung jawab.',
            'photo_file' => null,
            'cv_file' => null,
            'status' => 'invalid',
            'validated_by' => $adminId,
            'validated_at' => $now,
            'rejection_reason' => 'Berkas pendaftaran belum lengkap.',
            'created_at' => $now->copy()->subDays(1),
            'updated_at' => $now,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Criteria
        |--------------------------------------------------------------------------
        */

        $criteria = [
            [
                'code' => 'C1',
                'name' => 'Ekspresi, Etika, Kepercayaan Diri',
                'weight' => 0.2500,
            ],
            [
                'code' => 'C2',
                'name' => 'Berpikir Kritis, Kreatif, Inisiatif',
                'weight' => 0.2000,
            ],
            [
                'code' => 'C3',
                'name' => 'Komitmen Terhadap Duta dan Institusi',
                'weight' => 0.3000,
            ],
            [
                'code' => 'C4',
                'name' => 'Kemampuan Komunikasi, Argumentasi',
                'weight' => 0.2500,
            ],
        ];

        $criterionIds = [];

        foreach ($criteria as $criterion) {
            $criterionIds[$criterion['code']] = DB::table('criteria')->insertGetId([
                'period_id' => $periodId,
                'code' => $criterion['code'],
                'name' => $criterion['name'],
                'weight' => $criterion['weight'],
                'type' => 'benefit',
                'min_score' => 0,
                'max_score' => 100,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Jury Criteria
        |--------------------------------------------------------------------------
        */

        $juryCriteria = [
            [$juri1Id, $criterionIds['C1']],
            [$juri1Id, $criterionIds['C4']],
            [$juri2Id, $criterionIds['C2']],
            [$juri3Id, $criterionIds['C3']],
        ];

        foreach ($juryCriteria as [$juryId, $criterionId]) {
            DB::table('jury_criteria')->insert([
                'period_id' => $periodId,
                'user_id' => $juryId,
                'criterion_id' => $criterionId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Interviews
        |--------------------------------------------------------------------------
        */

        DB::table('interviews')->insert([
            [
                'period_id' => $periodId,
                'candidate_id' => $candidate2Id,
                'scheduled_at' => $now->copy()->addDays(8)->setTime(9, 0),
                'location' => 'Ruang Wawancara 1',
                'status' => 'scheduled',
                'created_by' => $adminId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'period_id' => $periodId,
                'candidate_id' => $candidate3Id,
                'scheduled_at' => $now->copy()->addDays(8)->setTime(9, 15),
                'location' => 'Ruang Wawancara 1',
                'status' => 'completed',
                'created_by' => $adminId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Scores
        |--------------------------------------------------------------------------
        */

        $scores = [
            [$candidate3Id, $juri1Id, $criterionIds['C1'], 88],
            [$candidate3Id, $juri1Id, $criterionIds['C4'], 90],
            [$candidate3Id, $juri2Id, $criterionIds['C2'], 85],
            [$candidate3Id, $juri3Id, $criterionIds['C3'], 92],

            [$candidate2Id, $juri1Id, $criterionIds['C1'], 80],
            [$candidate2Id, $juri1Id, $criterionIds['C4'], 84],
            [$candidate2Id, $juri2Id, $criterionIds['C2'], 82],
            [$candidate2Id, $juri3Id, $criterionIds['C3'], 86],
        ];

        foreach ($scores as [$candidateId, $juryId, $criterionId, $score]) {
            DB::table('scores')->insert([
                'period_id' => $periodId,
                'candidate_id' => $candidateId,
                'user_id' => $juryId,
                'criterion_id' => $criterionId,
                'score' => $score,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ARAS Results
        |--------------------------------------------------------------------------
        */

        DB::table('aras_results')->insert([
            [
                'period_id' => $periodId,
                'candidate_id' => $candidate3Id,
                'total_score' => 0.912500,
                'utility_score' => 1.000000,
                'final_rank' => 1,
                'calculated_by' => $adminId,
                'calculated_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'period_id' => $periodId,
                'candidate_id' => $candidate2Id,
                'total_score' => 0.830000,
                'utility_score' => 0.909589,
                'final_rank' => 2,
                'calculated_by' => $adminId,
                'calculated_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}