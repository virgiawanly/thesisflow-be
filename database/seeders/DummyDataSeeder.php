<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\Faculty;
use App\Models\Lecturer;
use App\Models\ProgramStudy;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'System Admin',
            'type' => UserType::SYSTEM_ADMIN,
            'username' => 'system_admin',
            'password' => bcrypt('P@ssword123'),
        ]);

        $faculty = Faculty::create([
            'nama' => 'Fakultas Teknik',
        ]);

        $programStudy = ProgramStudy::create([
            'nama' => 'Sistem Informasi',
            'fakultas_id' => $faculty->id,
        ]);

        User::create([
            'nama' => 'Program Study Admin',
            'type' => UserType::PROGRAM_STUDY_ADMIN,
            'username' => 'program_study_admin',
            'password' => bcrypt('P@ssword123'),
            'prodi_id' => $programStudy->id,
            'fakultas_id' => $faculty->id,
        ]);

        $lecturer = Lecturer::create([
            'nidn' => '1010101010',
            'nama' => 'Lecturer 1',
            'prodi_id' => $programStudy->id,
            'fakultas_id' => $faculty->id,
            'email' => 'lecturer1@example.ac.id',
            'aktif' => true,
        ]);

        User::create([
            'nama' => $lecturer->nama,
            'type' => UserType::LECTURER,
            'username' => $lecturer->nidn,
            'lecturer_id' => $lecturer->id,
            'password' => bcrypt('P@ssword123'),
            'prodi_id' => $programStudy->id,
            'fakultas_id' => $faculty->id,
        ]);

        $students = [
            [
                'nrp' => '250000001',
                'nama' => 'Student 1',
                'prodi_id' => $programStudy->id,
                'fakultas_id' => $faculty->id,
                'status_akademik' => 'aktif',
                'status_keuangan' => 'lunas',
                'total_sks' => 110,
                'ipk' => 3.5,
                'angkatan' => 2025,
            ],
            [
                'nrp' => '250000002',
                'nama' => 'Student 2',
                'prodi_id' => $programStudy->id,
                'fakultas_id' => $faculty->id,
                'status_akademik' => 'aktif',
                'status_keuangan' => 'lunas',
                'total_sks' => 115,
                'ipk' => 3.5,
                'angkatan' => 2025,
            ]
        ];

        foreach ($students as $student) {
            $student = Student::create($student);

            User::create([
                'nama' => $student->nama,
                'type' => UserType::STUDENT,
                'username' => $student->nrp,
                'student_id' => $student->id,
                'password' => bcrypt('P@ssword123'),
                'prodi_id' => $programStudy->id,
                'fakultas_id' => $faculty->id,
            ]);
        }
    }
}
