<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $users = DB::table('users')->pluck('id_user')->toArray();
        $admins = DB::table('admins')->pluck('id_admin')->toArray();
        $assets = DB::table('assets')->pluck('id_asset')->toArray();

        $bookings = [];
        $bookingAssets = [];

        $startDate = Carbon::now()->subMonths(6)->startOfMonth();
        $idCounter = 1;

        // Loop 6 bulan terakhir
        for ($month = 0; $month < 6; $month++) {
            $monthStart = $startDate->copy()->addMonths($month)->startOfMonth();
            $monthEnd = $monthStart->copy()->endOfMonth();

            // Total booking dalam 1 bulan (3–20)
            $totalBookings = rand(10, 15);

            for ($i = 0; $i < $totalBookings; $i++) {
                $id_booking = 'PMT-' . str_pad($idCounter++, 6, '0', STR_PAD_LEFT);
                $id_user = $users[array_rand($users)];
                $id_admin = $admins[array_rand($admins)];

                // Tanggal booking acak di bulan itu
                $start_time = Carbon::parse($monthStart)->addDays(rand(1, 25));
                $end_time = (clone $start_time)->addDays(rand(1, 5));

                // Status random (Rejected / Completed)
                $status = rand(0, 1) ? 'Completed' : 'Rejected';

                // Jika completed, generate return_at dan late_return
                $return_at = $status === 'Completed'
                    ? (clone $end_time)->addHours(rand(0, 48))
                    : null;
                $late_return = $status === 'Completed'
                    ? max(0, rand(0, 5))
                    : null;

                $bookings[] = [
                    'id_booking' => $id_booking,
                    'id_user' => $id_user,
                    'id_admin' => $id_admin,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'return_at' => $return_at,
                    'late_return' => $late_return,
                    'attachment' => null,
                    'note' => $status === 'Rejected' ? 'Rejected by ADMIN.' : null,
                    'status' => $status,
                    'created_at' => $start_time,
                    'updated_at' => $end_time,
                ];

                // Ambil minimal 1 aset, maksimal 4 aset
                $totalAssets = rand(3, 10);
                $selectedAssets = collect($assets)->shuffle()->take($totalAssets)->toArray();

                // Pastikan minimal 1 asset selalu dipilih
                if (empty($selectedAssets)) {
                    $selectedAssets = [$assets[array_rand($assets)]];
                }

                foreach ($selectedAssets as $assetId) {
                    $bookingAssets[] = [
                        'id_booking' => $id_booking,
                        'id_asset' => $assetId,
                    ];
                }
            }
        }

        DB::table('bookings')->insert($bookings);
        DB::table('booking_assets')->insert($bookingAssets);
    }
}
