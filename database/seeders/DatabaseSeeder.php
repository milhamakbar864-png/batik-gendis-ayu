<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\InventoryMovement;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\BankAccount;
use App\Models\StoreSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Users
        $admin = User::create([
            'name' => 'Administrator Batik Gendis Ayu',
            'email' => 'admin@batikgendisayu.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jl. Malioboro No. 45, Gedongtengen',
            'city' => 'Yogyakarta',
            'postal_code' => '55271',
        ]);

        $customer1 = User::create([
            'name' => 'Rina Kusumawardhani',
            'email' => 'rina.kusuma@gmail.com',
            'password' => Hash::make('customer123'),
            'role' => 'customer',
            'phone' => '082198765432',
            'address' => 'Jl. Kaliurang KM 5.5 No. 12',
            'city' => 'Sleman, D.I. Yogyakarta',
            'postal_code' => '55281',
        ]);

        $customer2 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@yahoo.com',
            'password' => Hash::make('customer123'),
            'role' => 'customer',
            'phone' => '085712344321',
            'address' => 'Jl. Diponegoro No. 88, Menteng',
            'city' => 'Jakarta Pusat',
            'postal_code' => '10310',
        ]);

        // 2. Seed Store Settings
        $settings = [
            'store_name' => 'Batik Gendis Ayu',
            'tagline' => 'Pesona Keanggunan Batik Nusantara Berkelas & Bernilai Budaya Tinggi',
            'description' => 'Batik Gendis Ayu menghadirkan koleksi batik tulis, cap, dan kombinasi premium dari para maestro pembatik nusantara. Menjaga warisan luhur tradisi dengan sentuhan estetika modern.',
            'phone' => '0812-3456-7890',
            'whatsapp' => '6281234567890',
            'email' => 'info@batikgendisayu.com',
            'address' => 'Jl. Malioboro No. 45, Sosromenduran, Gedongtengen, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55271',
            'instagram' => '@batikgendisayu',
        ];
        foreach ($settings as $k => $v) {
            StoreSetting::set($k, $v);
        }

        // 3. Seed Bank Accounts
        BankAccount::create([
            'bank_name' => 'Bank Central Asia (BCA)',
            'account_number' => '8420-998-123',
            'account_holder' => 'Batik Gendis Ayu Official',
            'is_active' => true,
        ]);
        BankAccount::create([
            'bank_name' => 'Bank Mandiri',
            'account_number' => '137-00-1928374-1',
            'account_holder' => 'Batik Gendis Ayu',
            'is_active' => true,
        ]);
        BankAccount::create([
            'bank_name' => 'Bank Rakyat Indonesia (BRI)',
            'account_number' => '0029-01-082736-50-8',
            'account_holder' => 'Batik Gendis Ayu',
            'is_active' => true,
        ]);

        // 4. Seed Categories
        $categoriesData = [
            [
                'name' => 'Kemeja Batik Pria',
                'slug' => 'kemeja-batik-pria',
                'description' => 'Koleksi kemeja lengan panjang dan pendek untuk pria berwibawa, cocok untuk formal maupun kasual santai.',
                'image' => 'https://images.unsplash.com/photo-1607345366928-199ea26cfe3e?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Blouse & Tunik Wanita',
                'slug' => 'blouse-tunik-wanita',
                'description' => 'Busana atasan batik modern elegan untuk wanita anggun, memadukan siluet masa kini dengan motif klasik.',
                'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Batik Tulis Sutra Eksklusif',
                'slug' => 'batik-tulis-sutra-eksklusif',
                'description' => 'Mahakarya batik tulis canting tangan di atas kain sutra ATBM berkualitas tinggi karya maestro pengrajin.',
                'image' => 'https://images.unsplash.com/photo-1590736969955-71cc94801759?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Kain Panjang & Jarik',
                'slug' => 'kain-panjang-jarik',
                'description' => 'Kain lembaran batik adiluhung untuk upacara adat, wisuda, pernikahan, maupun bahan busana tailor custom.',
                'image' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'name' => 'Sarimbit / Couple Series',
                'slug' => 'sarimbit-couple-series',
                'description' => 'Set busana serasi berpasangan untuk resepsi, pesta keluarga, dan hari raya yang harmonis.',
                'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=800&auto=format&fit=crop',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $categories[$c['slug']] = Category::create($c);
        }

        // 5. Seed Products & Variants
        $productsData = [
            [
                'category_slug' => 'kemeja-batik-pria',
                'sku' => 'BGA-KMJ-001',
                'name' => 'Kemeja Batik Pria Parang Kusumo Katun Primisima',
                'motif' => 'Parang Kusumo',
                'material' => 'Katun Primisima Sanforized',
                'technique' => 'Batik Cap Kombinasi Tulis',
                'buy_price' => 195000,
                'price' => 345000,
                'weight' => 380,
                'description' => 'Kemeja pria motif Parang Kusumo melambangkan keteguhan jiwa dan budi pekerti luhur. Dilapisi furing trikot halus kelas premium yang sejuk, menyerap keringat dan tidak menerawang. Jahitan tailor rapi dengan potongan reguler fit yang nyaman dipakai seharian di kantor maupun resepsi.',
                'image' => 'https://images.unsplash.com/photo-1607345366928-199ea26cfe3e?q=80&w=800&auto=format&fit=crop',
                'min_stock' => 6,
                'is_featured' => true,
                'variants' => [
                    ['size' => 'M', 'stock' => 12],
                    ['size' => 'L', 'stock' => 18],
                    ['size' => 'XL', 'stock' => 8],
                    ['size' => 'XXL', 'stock' => 4],
                ],
            ],
            [
                'category_slug' => 'kemeja-batik-pria',
                'sku' => 'BGA-KMJ-002',
                'name' => 'Kemeja Slimfit Motif Sekar Jagad Indigofera',
                'motif' => 'Sekar Jagad',
                'material' => 'Katun Mercerized Halus',
                'technique' => 'Batik Cap Pewarnaan Alami Indigofera',
                'buy_price' => 220000,
                'price' => 395000,
                'weight' => 350,
                'description' => 'Motif Sekar Jagad menggambarkan keanekaragaman dan keindahan dunia dalam satu harmoni. Kemeja berpotongan slimfit modern dengan kerah kaku formal dan kancing tersembunyi (hidden button) untuk tampilan eksekutif muda yang percaya diri.',
                'image' => 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?q=80&w=800&auto=format&fit=crop',
                'min_stock' => 5,
                'is_featured' => true,
                'variants' => [
                    ['size' => 'S', 'stock' => 7],
                    ['size' => 'M', 'stock' => 14],
                    ['size' => 'L', 'stock' => 10],
                    ['size' => 'XL', 'stock' => 3], // stok kritis
                ],
            ],
            [
                'category_slug' => 'blouse-tunik-wanita',
                'sku' => 'BGA-BLS-001',
                'name' => 'Blouse Batik Wanita Anggun Motif Kawung Cokelat Sogani',
                'motif' => 'Kawung Picis',
                'material' => 'Katun Primisima Halus',
                'technique' => 'Batik Cap Tradisional Sogan Solo',
                'buy_price' => 160000,
                'price' => 285000,
                'weight' => 300,
                'description' => 'Blouse wanita elegan berhiaskan motif Kawung berfilosofi kesucian hati dan pengendalian diri. Model lengan terompet manis dengan aksen lipit depan dan kancing mutiara, sangat fleksibel dipadukan dengan rok lilit maupun celana kulot bahan.',
                'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?q=80&w=800&auto=format&fit=crop',
                'min_stock' => 5,
                'is_featured' => true,
                'variants' => [
                    ['size' => 'All Size fit to L', 'stock' => 20],
                    ['size' => 'XL - Jumbo', 'stock' => 9],
                ],
            ],
            [
                'category_slug' => 'blouse-tunik-wanita',
                'sku' => 'BGA-TNK-002',
                'name' => 'Tunik Batik Panjang Asimetris Mega Mendung Emerald',
                'motif' => 'Mega Mendung',
                'material' => 'Rayon Viscose Premium (Jatuh & Dingin)',
                'technique' => 'Batik Kombinasi Modern Handprint',
                'buy_price' => 175000,
                'price' => 310000,
                'weight' => 320,
                'description' => 'Tunik muslimah ramah wudhu dan busui dengan resleting depan tersembunyi. Potongan bawah asimetris anggun yang menyamarkan lekuk tubuh, memberikan kesan jenjang dan berwibawa.',
                'image' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?q=80&w=800&auto=format&fit=crop',
                'min_stock' => 4,
                'is_featured' => false,
                'variants' => [
                    ['size' => 'M', 'stock' => 15],
                    ['size' => 'L', 'stock' => 12],
                    ['size' => 'XL', 'stock' => 8],
                ],
            ],
            [
                'category_slug' => 'batik-tulis-sutra-eksklusif',
                'sku' => 'BGA-STR-001',
                'name' => 'Kain Sutra ATBM Tulis Halus Motif Truntum Babon Angrem',
                'motif' => 'Truntum Babon Angrem',
                'material' => 'Sutra Alam ATBM (Alat Tenun Bukan Mesin)',
                'technique' => 'Batik Tulis Canting Tembok Halus 100%',
                'buy_price' => 1250000,
                'price' => 2450000,
                'weight' => 450,
                'description' => 'Mahakarya adibusana warisan leluhur. Motif Truntum melambangkan cinta kasih yang tulus bersemi kembali, dipadukan Babon Angrem pembawa berkah kedamaian keluarga. Memerlukan waktu pengerjaan canting tangan selama 3-4 bulan oleh perajin senior di Imogiri. Sangat istimewa untuk kolektor dan acara sakral.',
                'image' => 'https://images.unsplash.com/photo-1590736969955-71cc94801759?q=80&w=800&auto=format&fit=crop',
                'min_stock' => 2,
                'is_featured' => true,
                'variants' => [
                    ['size' => 'Panjang 2.60m x Lebar 1.15m', 'stock' => 3],
                ],
            ],
            [
                'category_slug' => 'kain-panjang-jarik',
                'sku' => 'BGA-JRK-001',
                'name' => 'Kain Jarik Tradisional Sido Asih Gendhis Klasik',
                'motif' => 'Sido Asih',
                'material' => 'Katun Mori Seno Super',
                'technique' => 'Batik Cap Tulis Tradisional Sogan Lawasan',
                'buy_price' => 135000,
                'price' => 240000,
                'weight' => 360,
                'description' => 'Kain jarik panjang serbaguna motif Sido Asih berfilosofi harapan agar hidup penuh kasih sayang timbal balik. Tekstur kain padat namun lemas dan nyaman dililit untuk busana kebaya pesta atau siraman pernikahan.',
                'image' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=800&auto=format&fit=crop',
                'min_stock' => 5,
                'is_featured' => false,
                'variants' => [
                    ['size' => '2.20m x 1.10m', 'stock' => 25],
                ],
            ],
            [
                'category_slug' => 'sarimbit-couple-series',
                'sku' => 'BGA-SRM-001',
                'name' => 'Sarimbit Pasangan Kemeja & Dress Gamis Motif Wahyu Tumurun',
                'motif' => 'Wahyu Tumurun',
                'material' => 'Katun Primisima Halus kombinasi Ceruti Babydoll',
                'technique' => 'Batik Cap Halus',
                'buy_price' => 380000,
                'price' => 675000,
                'weight' => 750,
                'description' => 'Sepasang busana harmonis untuk suami & istri. Kemeja pria lapis furing sejuk dipadukan dengan gamis wanita berlayer ceruti anggun bertabur payet kristal sintetis. Memberikan aura serasi memukau di setiap pesta pernikahan.',
                'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=800&auto=format&fit=crop',
                'min_stock' => 3,
                'is_featured' => true,
                'variants' => [
                    ['size' => 'Pria M - Wanita M', 'stock' => 6],
                    ['size' => 'Pria L - Wanita L', 'stock' => 8],
                    ['size' => 'Pria XL - Wanita XL', 'stock' => 2], // stok menipis
                ],
            ],
        ];

        foreach ($productsData as $pData) {
            $cat = $categories[$pData['category_slug']];
            $product = Product::create([
                'category_id' => $cat->id,
                'sku' => $pData['sku'],
                'name' => $pData['name'],
                'slug' => Str::slug($pData['name']),
                'motif' => $pData['motif'],
                'material' => $pData['material'],
                'technique' => $pData['technique'],
                'buy_price' => $pData['buy_price'],
                'price' => $pData['price'],
                'weight' => $pData['weight'],
                'description' => $pData['description'],
                'image' => $pData['image'],
                'min_stock' => $pData['min_stock'],
                'is_active' => true,
                'is_featured' => $pData['is_featured'],
            ]);

            foreach ($pData['variants'] as $v) {
                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'size' => $v['size'],
                    'sku_variant' => $product->sku . '-' . Str::slug($v['size']),
                    'stock' => $v['stock'],
                ]);

                // Record initial inventory movement (Restock / Stok Awal Masuk)
                InventoryMovement::create([
                    'product_id' => $product->id,
                    'variant_id' => $variant->id,
                    'type' => 'in',
                    'reference_type' => 'supplier_purchase',
                    'reference_number' => 'PO-INIT-' . date('Ym') . '-' . str_pad($variant->id, 3, '0', STR_PAD_LEFT),
                    'quantity' => $v['stock'],
                    'stock_before' => 0,
                    'stock_after' => $v['stock'],
                    'unit_cost' => $product->buy_price,
                    'notes' => 'Penerimaan stok awal dari Pengrajin Batik Rekanan Batik Gendis Ayu.',
                    'created_by' => $admin->id,
                ]);
            }
        }

        // 6. Seed Sample Orders with Items and Inventory Adjustments
        $p1 = Product::where('sku', 'BGA-KMJ-001')->with('variants')->first();
        $v1 = $p1->variants->first();

        $p2 = Product::where('sku', 'BGA-BLS-001')->with('variants')->first();
        $v2 = $p2->variants->first();

        // Order 1: Completed
        $order1 = Order::create([
            'order_number' => 'ORD-BGA-202611-0001',
            'user_id' => $customer1->id,
            'customer_name' => $customer1->name,
            'customer_email' => $customer1->email,
            'customer_phone' => $customer1->phone,
            'shipping_address' => $customer1->address,
            'city' => $customer1->city,
            'province' => 'D.I. Yogyakarta',
            'postal_code' => $customer1->postal_code,
            'courier' => 'J&T Express EZ',
            'tracking_number' => 'JT882910482901',
            'subtotal' => 630000,
            'shipping_cost' => 15000,
            'total_amount' => 645000,
            'payment_method' => 'Bank Transfer BCA',
            'payment_status' => 'paid',
            'payment_date' => now()->subDays(2),
            'order_status' => 'completed',
            'customer_notes' => 'Mohon dikemas rapi dengan kotak batik, untuk kado ulang tahun ayah.',
            'admin_notes' => 'Pesanan telah diterima pembeli dengan baik.',
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $p1->id,
            'variant_id' => $v1->id,
            'product_name' => $p1->name,
            'variant_size' => $v1->size,
            'price' => $p1->price,
            'buy_price' => $p1->buy_price,
            'quantity' => 1,
            'subtotal' => $p1->price,
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $p2->id,
            'variant_id' => $v2->id,
            'product_name' => $p2->name,
            'variant_size' => $v2->size,
            'price' => $p2->price,
            'buy_price' => $p2->buy_price,
            'quantity' => 1,
            'subtotal' => $p2->price,
        ]);

        // Inventory movement for Order 1
        InventoryMovement::create([
            'product_id' => $p1->id,
            'variant_id' => $v1->id,
            'type' => 'sale',
            'reference_type' => 'order',
            'reference_number' => $order1->order_number,
            'quantity' => -1,
            'stock_before' => $v1->stock + 1,
            'stock_after' => $v1->stock,
            'unit_cost' => $p1->buy_price,
            'notes' => 'Pengurangan persediaan otomatis dari pesanan online ' . $order1->order_number,
            'created_by' => $admin->id,
        ]);

        // Order 2: Processing (Paid, waiting shipment)
        $order2 = Order::create([
            'order_number' => 'ORD-BGA-202611-0002',
            'user_id' => $customer2->id,
            'customer_name' => $customer2->name,
            'customer_email' => $customer2->email,
            'customer_phone' => $customer2->phone,
            'shipping_address' => $customer2->address,
            'city' => $customer2->city,
            'province' => 'DKI Jakarta',
            'postal_code' => $customer2->postal_code,
            'courier' => 'JNE REG',
            'tracking_number' => null,
            'subtotal' => 675000,
            'shipping_cost' => 24000,
            'total_amount' => 699000,
            'payment_method' => 'Bank Mandiri',
            'payment_status' => 'paid',
            'payment_date' => now()->subHours(5),
            'order_status' => 'processing',
            'customer_notes' => 'Kirim saat jam kerja kantor ya min.',
            'admin_notes' => 'Pembayaran terverifikasi via Mandiri. Sedang proses quality check & packing.',
        ]);

        $pSarimbit = Product::where('sku', 'BGA-SRM-001')->with('variants')->first();
        $vSarimbit = $pSarimbit->variants->first();

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $pSarimbit->id,
            'variant_id' => $vSarimbit->id,
            'product_name' => $pSarimbit->name,
            'variant_size' => $vSarimbit->size,
            'price' => $pSarimbit->price,
            'buy_price' => $pSarimbit->buy_price,
            'quantity' => 1,
            'subtotal' => $pSarimbit->price,
        ]);

        InventoryMovement::create([
            'product_id' => $pSarimbit->id,
            'variant_id' => $vSarimbit->id,
            'type' => 'sale',
            'reference_type' => 'order',
            'reference_number' => $order2->order_number,
            'quantity' => -1,
            'stock_before' => $vSarimbit->stock + 1,
            'stock_after' => $vSarimbit->stock,
            'unit_cost' => $pSarimbit->buy_price,
            'notes' => 'Pengurangan persediaan otomatis dari pesanan online ' . $order2->order_number,
            'created_by' => $admin->id,
        ]);
    }
}
