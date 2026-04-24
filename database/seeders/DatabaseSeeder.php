<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@pcstore.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Customer user
        User::create([
            'name'     => 'John Doe',
            'email'    => 'john@example.com',
            'password' => Hash::make('password'),
            'role'     => 'customer',
        ]);

        User::firstOrCreate(
    ['email' => 'admin@pcstore.com'],
    [
        'name' => 'Admin User',
        'password' => bcrypt('your-password'),
        'role' => 'admin',
    ]
);

        // Categories
        $categories = [
            ['name' => 'CPUs & Processors',    'slug' => 'cpus-processors',    'description' => 'Desktop and server processors from AMD and Intel.'],
            ['name' => 'Motherboards',          'slug' => 'motherboards',       'description' => 'ATX, mATX, and ITX motherboards for every build.'],
            ['name' => 'Memory (RAM)',           'slug' => 'memory-ram',         'description' => 'DDR4 and DDR5 memory kits for gaming and workstations.'],
            ['name' => 'Storage',               'slug' => 'storage',            'description' => 'SSDs, HDDs, and NVMe drives.'],
            ['name' => 'Graphics Cards (GPUs)', 'slug' => 'graphics-cards',     'description' => 'NVIDIA and AMD GPUs for gaming and creative work.'],
            ['name' => 'Power Supplies',        'slug' => 'power-supplies',     'description' => 'Modular and semi-modular PSUs from 450W to 1600W.'],
            ['name' => 'PC Cases',              'slug' => 'pc-cases',           'description' => 'Full tower, mid tower, and mini-ITX cases.'],
            ['name' => 'Cooling',               'slug' => 'cooling',            'description' => 'Air coolers, AIO liquid coolers, and case fans.'],
        ];

        foreach ($categories as $cat) {
            Category::create(array_merge($cat, ['is_active' => true]));
        }

        // Products
        $products = [
            // CPUs
            [
                'category_id' => 1, 'name' => 'AMD Ryzen 9 7950X', 'brand' => 'AMD',
                'price' => 699.99, 'sale_price' => 649.99, 'stock' => 15, 'sku' => 'AMD-R9-7950X',
                'short_description' => '16-core, 32-thread desktop processor.',
                'description' => 'The AMD Ryzen 9 7950X is a flagship desktop processor featuring 16 cores and 32 threads. Built on the Zen 4 architecture with 5nm process node, it delivers exceptional performance for gaming, content creation, and professional workloads.',
                'specs' => ['Cores' => '16', 'Threads' => '32', 'Base Clock' => '4.5 GHz', 'Boost Clock' => '5.7 GHz', 'TDP' => '170W', 'Socket' => 'AM5'],
                'is_featured' => true,
            ],
            [
                'category_id' => 1, 'name' => 'Intel Core i9-13900K', 'brand' => 'Intel',
                'price' => 589.99, 'sale_price' => null, 'stock' => 12, 'sku' => 'INT-I9-13900K',
                'short_description' => '24-core hybrid architecture processor.',
                'description' => 'The Intel Core i9-13900K features Intel\'s hybrid architecture with 8 P-cores and 16 E-cores for a total of 24 cores and 32 threads. Ideal for gaming and multitasking.',
                'specs' => ['P-Cores' => '8', 'E-Cores' => '16', 'Threads' => '32', 'Boost Clock' => '5.8 GHz', 'TDP' => '125W', 'Socket' => 'LGA1700'],
                'is_featured' => true,
            ],
            [
                'category_id' => 1, 'name' => 'AMD Ryzen 5 7600X', 'brand' => 'AMD',
                'price' => 249.99, 'sale_price' => 219.99, 'stock' => 30, 'sku' => 'AMD-R5-7600X',
                'short_description' => 'Best mid-range gaming CPU.',
                'description' => 'The Ryzen 5 7600X offers outstanding gaming performance at a competitive price point. 6 cores, 12 threads on AM5 platform.',
                'specs' => ['Cores' => '6', 'Threads' => '12', 'Base Clock' => '4.7 GHz', 'Boost Clock' => '5.3 GHz', 'TDP' => '105W', 'Socket' => 'AM5'],
                'is_featured' => false,
            ],
            // Motherboards
            [
                'category_id' => 2, 'name' => 'ASUS ROG Crosshair X670E Hero', 'brand' => 'ASUS',
                'price' => 629.99, 'sale_price' => null, 'stock' => 8, 'sku' => 'ASUS-X670E-HERO',
                'short_description' => 'Premium AM5 motherboard for enthusiasts.',
                'description' => 'The ROG Crosshair X670E Hero is ASUS\'s flagship AM5 motherboard with PCIe 5.0 support, 18+2 power stages, and extensive connectivity.',
                'specs' => ['Socket' => 'AM5', 'Form Factor' => 'ATX', 'Chipset' => 'X670E', 'Memory Slots' => '4', 'Max Memory' => '128GB DDR5'],
                'is_featured' => true,
            ],
            [
                'category_id' => 2, 'name' => 'MSI MAG B650 TOMAHAWK WIFI', 'brand' => 'MSI',
                'price' => 229.99, 'sale_price' => 199.99, 'stock' => 20, 'sku' => 'MSI-B650-TOMAHAWK',
                'short_description' => 'Great value AM5 motherboard with WiFi 6E.',
                'description' => 'The MSI MAG B650 TOMAHAWK WIFI delivers solid AM5 performance for mid-range builds. Includes WiFi 6E, 2.5G LAN, and robust power delivery.',
                'specs' => ['Socket' => 'AM5', 'Form Factor' => 'ATX', 'Chipset' => 'B650', 'Memory Slots' => '4', 'Max Memory' => '128GB DDR5'],
                'is_featured' => false,
            ],
            // RAM
            [
                'category_id' => 3, 'name' => 'G.Skill Trident Z5 RGB 32GB DDR5-6000', 'brand' => 'G.Skill',
                'price' => 149.99, 'sale_price' => 129.99, 'stock' => 25, 'sku' => 'GSKILL-TZ5-32GB-6000',
                'short_description' => '2x16GB DDR5-6000 with RGB lighting.',
                'description' => 'G.Skill Trident Z5 RGB DDR5-6000 32GB kit offers blazing-fast speeds for AM5 and Intel 12th/13th gen platforms with stunning RGB aesthetics.',
                'specs' => ['Capacity' => '32GB (2x16GB)', 'Speed' => 'DDR5-6000', 'CAS Latency' => 'CL36', 'Voltage' => '1.35V'],
                'is_featured' => true,
            ],
            [
                'category_id' => 3, 'name' => 'Corsair Vengeance 32GB DDR5-5600', 'brand' => 'Corsair',
                'price' => 119.99, 'sale_price' => null, 'stock' => 40, 'sku' => 'COR-VEN-32GB-5600',
                'short_description' => 'Reliable DDR5 kit for everyday builds.',
                'description' => 'The Corsair Vengeance DDR5-5600 32GB kit is an excellent choice for gaming builds on AM5 and Intel platforms. Features Intel XMP 3.0 and AMD EXPO support.',
                'specs' => ['Capacity' => '32GB (2x16GB)', 'Speed' => 'DDR5-5600', 'CAS Latency' => 'CL36', 'Voltage' => '1.25V'],
                'is_featured' => false,
            ],
            // Storage
            [
                'category_id' => 4, 'name' => 'Samsung 990 Pro 2TB NVMe SSD', 'brand' => 'Samsung',
                'price' => 189.99, 'sale_price' => 169.99, 'stock' => 35, 'sku' => 'SAM-990PRO-2TB',
                'short_description' => 'Top-tier PCIe 4.0 NVMe SSD.',
                'description' => 'The Samsung 990 Pro delivers exceptional sequential read/write speeds up to 7,450/6,900 MB/s. Perfect for gaming, content creation, and professional workloads.',
                'specs' => ['Capacity' => '2TB', 'Interface' => 'PCIe 4.0 x4 NVMe', 'Read Speed' => '7,450 MB/s', 'Write Speed' => '6,900 MB/s', 'Form Factor' => 'M.2 2280'],
                'is_featured' => true,
            ],
            [
                'category_id' => 4, 'name' => 'WD Black SN850X 1TB NVMe SSD', 'brand' => 'Western Digital',
                'price' => 109.99, 'sale_price' => null, 'stock' => 28, 'sku' => 'WD-SN850X-1TB',
                'short_description' => 'Gaming-optimized PCIe 4.0 NVMe SSD.',
                'description' => 'The WD Black SN850X is engineered for gaming with speeds up to 7,300 MB/s read. Game Mode 2.0 technology intelligently optimizes for game loading.',
                'specs' => ['Capacity' => '1TB', 'Interface' => 'PCIe 4.0 x4 NVMe', 'Read Speed' => '7,300 MB/s', 'Write Speed' => '6,600 MB/s', 'Form Factor' => 'M.2 2280'],
                'is_featured' => false,
            ],
            // GPUs
            [
                'category_id' => 5, 'name' => 'NVIDIA GeForce RTX 4090 24GB', 'brand' => 'NVIDIA',
                'price' => 1599.99, 'sale_price' => null, 'stock' => 5, 'sku' => 'NV-RTX4090-24G',
                'short_description' => 'The fastest consumer GPU ever made.',
                'description' => 'The NVIDIA GeForce RTX 4090 is the ultimate graphics card for gamers and creators. With 16,384 CUDA cores and 24GB GDDR6X, it dominates 4K gaming and AI workloads.',
                'specs' => ['VRAM' => '24GB GDDR6X', 'CUDA Cores' => '16,384', 'Boost Clock' => '2520 MHz', 'TDP' => '450W', 'Outputs' => '3x DP 1.4a, 1x HDMI 2.1'],
                'is_featured' => true,
            ],
            [
                'category_id' => 5, 'name' => 'AMD Radeon RX 7900 XTX 24GB', 'brand' => 'AMD',
                'price' => 999.99, 'sale_price' => 899.99, 'stock' => 9, 'sku' => 'AMD-RX7900XTX-24G',
                'short_description' => 'AMD\'s flagship RDNA 3 graphics card.',
                'description' => 'The Radeon RX 7900 XTX is AMD\'s most powerful consumer GPU with 24GB GDDR6 memory and DisplayPort 2.1 support for 8K gaming.',
                'specs' => ['VRAM' => '24GB GDDR6', 'Compute Units' => '96', 'Boost Clock' => '2500 MHz', 'TDP' => '355W', 'Outputs' => '2x DP 2.1, 1x HDMI 2.1, 1x USB-C'],
                'is_featured' => true,
            ],
            [
                'category_id' => 5, 'name' => 'NVIDIA GeForce RTX 4070 Ti 12GB', 'brand' => 'NVIDIA',
                'price' => 799.99, 'sale_price' => 749.99, 'stock' => 14, 'sku' => 'NV-RTX4070TI-12G',
                'short_description' => 'Excellent 4K gaming at a lower price.',
                'description' => 'The RTX 4070 Ti offers great 4K performance with DLSS 3 Frame Generation and full ray tracing support. A strong choice for high-refresh-rate 1440p and 4K gaming.',
                'specs' => ['VRAM' => '12GB GDDR6X', 'CUDA Cores' => '7,680', 'Boost Clock' => '2610 MHz', 'TDP' => '285W'],
                'is_featured' => false,
            ],
            // PSUs
            [
                'category_id' => 6, 'name' => 'Corsair RM1000x 1000W 80+ Gold', 'brand' => 'Corsair',
                'price' => 189.99, 'sale_price' => 159.99, 'stock' => 18, 'sku' => 'COR-RM1000X',
                'short_description' => 'Fully modular 1000W Gold-rated PSU.',
                'description' => 'The Corsair RM1000x offers 80 PLUS Gold efficiency, fully modular cables, and near-silent operation. Ideal for high-end gaming systems.',
                'specs' => ['Wattage' => '1000W', 'Efficiency' => '80+ Gold', 'Modular' => 'Fully Modular', 'Fan Size' => '135mm'],
                'is_featured' => false,
            ],
            // Cases
            [
                'category_id' => 7, 'name' => 'Lian Li PC-O11 Dynamic EVO', 'brand' => 'Lian Li',
                'price' => 169.99, 'sale_price' => null, 'stock' => 22, 'sku' => 'LL-O11D-EVO',
                'short_description' => 'Premium dual-chamber mid-tower case.',
                'description' => 'The Lian Li O11 Dynamic EVO is an evolution of the iconic O11 Dynamic with improved radiator support and enhanced airflow. Perfect for custom water-cooling loops.',
                'specs' => ['Form Factor' => 'Mid Tower', 'Motherboard Support' => 'E-ATX, ATX, mATX', 'Drive Bays' => '4x 2.5", 2x 3.5"', 'Max GPU Length' => '420mm'],
                'is_featured' => true,
            ],
            // Cooling
            [
                'category_id' => 8, 'name' => 'Noctua NH-D15 CPU Air Cooler', 'brand' => 'Noctua',
                'price' => 99.99, 'sale_price' => null, 'stock' => 17, 'sku' => 'NOC-NHD15',
                'short_description' => 'Best-in-class dual-tower air cooler.',
                'description' => 'The Noctua NH-D15 is the gold standard of CPU air cooling with dual NF-A15 PWM fans and six heatpipes. Handles TDPs up to 250W with ease.',
                'specs' => ['Type' => 'Air Cooler', 'Fans' => '2x 140mm NF-A15', 'Max TDP' => '250W', 'Height' => '165mm'],
                'is_featured' => false,
            ],
            [
                'category_id' => 8, 'name' => 'ARCTIC Liquid Freezer II 360 AIO', 'brand' => 'ARCTIC',
                'price' => 129.99, 'sale_price' => 109.99, 'stock' => 11, 'sku' => 'ARC-LF2-360',
                'short_description' => '360mm all-in-one liquid CPU cooler.',
                'description' => 'The ARCTIC Liquid Freezer II 360 delivers outstanding thermal performance with a 360mm radiator and three 120mm fans. Includes VRM fan for additional cooling.',
                'specs' => ['Type' => 'AIO Liquid', 'Radiator' => '360mm', 'Fans' => '3x 120mm P12 PWM', 'Pump Speed' => '800-2000 RPM'],
                'is_featured' => true,
            ],
        ];

        foreach ($products as $p) {
            Product::create(array_merge($p, [
                'slug'      => Str::slug($p['name']) . '-' . Str::random(4),
                'is_active' => true,
                'specs'     => $p['specs'],
            ]));
        }
    }
}
