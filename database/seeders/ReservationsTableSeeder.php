<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reservation;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Reservation::create(['reservation_datetime' => '2025-03-04 18:25:00', 'customer_id' => '3', 'stylist_id' => '2' ]);
        Reservation::create(['reservation_datetime' => '2025-03-04 20:22:00', 'customer_id' => '4', 'stylist_id' => '3' ]);
        Reservation::create(['reservation_datetime' => '2025-03-05 09:25:00', 'customer_id' => '1', 'stylist_id' => '1' ]);
        Reservation::create(['reservation_datetime' => '2025-03-05 11:35:00', 'customer_id' => '1', 'stylist_id' => '2' ]);
        Reservation::create(['reservation_datetime' => '2025-03-05 19:25:00', 'customer_id' => '2', 'stylist_id' => '1' ]);
        Reservation::create(['reservation_datetime' => '2025-03-06 10:40:00', 'customer_id' => '5', 'stylist_id' => '2' ]);
        Reservation::create(['reservation_datetime' => '2025-03-06 13:00:00', 'customer_id' => '4', 'stylist_id' => '3' ]);
        Reservation::create(['reservation_datetime' => '2025-03-06 20:05:00', 'customer_id' => '3', 'stylist_id' => '3' ]);
        Reservation::create(['reservation_datetime' => '2025-03-07 12:15:00', 'customer_id' => '1', 'stylist_id' => '1' ]);
        Reservation::create(['reservation_datetime' => '2025-03-07 15:05:00', 'customer_id' => '3', 'stylist_id' => '3' ]);
        Reservation::create(['reservation_datetime' => '2025-03-07 19:35:00', 'customer_id' => '3', 'stylist_id' => '1' ]);
    }
}
