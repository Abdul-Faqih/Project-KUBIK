<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetMasterSeeder extends Seeder
{
    public function run(): void
    {
        $assetMasters = [
            // ---------- Rooms ----------
            ['name' => 'AG01', 'category' => 'CAT-000001', 'type' => 'TYP-000001'],
            ['name' => 'AG02', 'category' => 'CAT-000001', 'type' => 'TYP-000001'],
            ['name' => 'AG03', 'category' => 'CAT-000001', 'type' => 'TYP-000001'],
            ['name' => 'AG04', 'category' => 'CAT-000001', 'type' => 'TYP-000001'],
            ['name' => 'AG05', 'category' => 'CAT-000001', 'type' => 'TYP-000001'],
            ['name' => 'AG06', 'category' => 'CAT-000001', 'type' => 'TYP-000001'],
            ['name' => 'AG07', 'category' => 'CAT-000001', 'type' => 'TYP-000001'],
            ['name' => 'AG08', 'category' => 'CAT-000001', 'type' => 'TYP-000001'],

            // ---------- Auditorium ----------
            ['name' => 'AUDI 1', 'category' => 'CAT-000002', 'type' => 'TYP-000001'],
            ['name' => 'AUDI 2', 'category' => 'CAT-000002', 'type' => 'TYP-000001'],
            ['name' => 'AUDI 3', 'category' => 'CAT-000002', 'type' => 'TYP-000001'],

            // ---------- Meeting Room ----------
            ['name' => 'AG09', 'category' => 'CAT-000003', 'type' => 'TYP-000001'],
            ['name' => 'AG10', 'category' => 'CAT-000003', 'type' => 'TYP-000001'],
            ['name' => 'AG11', 'category' => 'CAT-000003', 'type' => 'TYP-000001'],
            ['name' => 'AG12', 'category' => 'CAT-000003', 'type' => 'TYP-000001'],
            ['name' => 'AG13', 'category' => 'CAT-000003', 'type' => 'TYP-000001'],

            // ---------- Electrical ----------
            ['name' => 'Panasonic Cable Roll 10m', 'category' => 'CAT-000004', 'type' => 'TYP-000002'],
            ['name' => 'Power Strip 4 Slots', 'category' => 'CAT-000004', 'type' => 'TYP-000002'],
            ['name' => 'HDMI Cable 10m', 'category' => 'CAT-000004', 'type' => 'TYP-000002'],
            ['name' => 'Universal Laptop Adapter', 'category' => 'CAT-000004', 'type' => 'TYP-000002'],
            ['name' => 'Philips Projector Lamp', 'category' => 'CAT-000004', 'type' => 'TYP-000002'],
            ['name' => 'Extension Cord 5m', 'category' => 'CAT-000004', 'type' => 'TYP-000002'],
            ['name' => 'DC Power Supply 12V', 'category' => 'CAT-000004', 'type' => 'TYP-000002'],
            ['name' => 'Large Electrical Terminal', 'category' => 'CAT-000004', 'type' => 'TYP-000002'],
            ['name' => 'Sanwa Digital Multimeter', 'category' => 'CAT-000004', 'type' => 'TYP-000002'],
            ['name' => 'VGA Cable 15 Pin', 'category' => 'CAT-000004', 'type' => 'TYP-000002'],

            // ---------- Sound System ----------
            ['name' => 'Polytron Active Speaker', 'category' => 'CAT-000005', 'type' => 'TYP-000002'],
            ['name' => 'Yamaha MG10 Sound Mixer', 'category' => 'CAT-000005', 'type' => 'TYP-000002'],
            ['name' => 'Shure Wireless Microphone', 'category' => 'CAT-000005', 'type' => 'TYP-000002'],
            ['name' => 'Tripod Mic Stand', 'category' => 'CAT-000005', 'type' => 'TYP-000002'],
            ['name' => 'XLR Cable 10m', 'category' => 'CAT-000005', 'type' => 'TYP-000002'],
            ['name' => 'Behringer FBQ3102 Equalizer', 'category' => 'CAT-000005', 'type' => 'TYP-000002'],
            ['name' => '1000W Power Amplifier', 'category' => 'CAT-000005', 'type' => 'TYP-000002'],
            ['name' => 'Mic Clip Holder', 'category' => 'CAT-000005', 'type' => 'TYP-000002'],
            ['name' => 'Wireless Receiver', 'category' => 'CAT-000005', 'type' => 'TYP-000002'],
            ['name' => 'Scarlett 2i2 Audio Interface', 'category' => 'CAT-000005', 'type' => 'TYP-000002'],

            // ---------- Projector ----------
            ['name' => 'Epson X500 Projector', 'category' => 'CAT-000006', 'type' => 'TYP-000002'],
            ['name' => 'BenQ MX550 Projector', 'category' => 'CAT-000006', 'type' => 'TYP-000002'],
            ['name' => 'Infocus IN114 Projector', 'category' => 'CAT-000006', 'type' => 'TYP-000002'],
            ['name' => 'Sony VPL-EX430 Projector', 'category' => 'CAT-000006', 'type' => 'TYP-000002'],
            ['name' => 'Panasonic PT-VX42 Projector', 'category' => 'CAT-000006', 'type' => 'TYP-000002'],
            ['name' => '100 Inch Projector Screen', 'category' => 'CAT-000006', 'type' => 'TYP-000002'],
            ['name' => '70 Inch Projector Screen', 'category' => 'CAT-000006', 'type' => 'TYP-000002'],
            ['name' => 'Ceiling Projector Bracket', 'category' => 'CAT-000006', 'type' => 'TYP-000002'],
            ['name' => 'Universal Projector Remote', 'category' => 'CAT-000006', 'type' => 'TYP-000002'],
            ['name' => 'HDMI Splitter USB', 'category' => 'CAT-000006', 'type' => 'TYP-000002'],

            // ---------- Table ----------
            ['name' => 'Metal Computer Desk', 'category' => 'CAT-000007', 'type' => 'TYP-000002'],
            ['name' => 'Oval Meeting Table', 'category' => 'CAT-000007', 'type' => 'TYP-000002'],

            // ---------- Chair ----------
            ['name' => 'Black Office Chair', 'category' => 'CAT-000008', 'type' => 'TYP-000002'],
            ['name' => 'Foldable Chair', 'category' => 'CAT-000008', 'type' => 'TYP-000002'],
            ['name' => 'Rotating Meeting Chair', 'category' => 'CAT-000008', 'type' => 'TYP-000002'],
            ['name' => 'Plastic Chair', 'category' => 'CAT-000008', 'type' => 'TYP-000002'],

            // ---------- Stationery ----------
            ['name' => 'Snowman Marker Black', 'category' => 'CAT-000009', 'type' => 'TYP-000002'],
            ['name' => 'Snowman Marker Green', 'category' => 'CAT-000009', 'type' => 'TYP-000002'],
            ['name' => 'Snowman Marker Red', 'category' => 'CAT-000009', 'type' => 'TYP-000002'],
            ['name' => 'Snowman Board Eraser', 'category' => 'CAT-000009', 'type' => 'TYP-000002'],
        ];

        foreach ($assetMasters as $i => $am) {
            // Room categories (1–3) have only 1 stock
            $isRoom = in_array($am['category'], ['CAT-000001', 'CAT-000002', 'CAT-000003']);
            $stock = $isRoom ? 1 : rand(2, 10);

            DB::table('asset_masters')->insert([
                'name' => $am['name'],
                'id_category' => $am['category'],
                'id_type' => $am['type'],
                'stock_total' => $stock,
                'stock_available' => $stock,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
