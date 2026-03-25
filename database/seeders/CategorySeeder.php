<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Óculos',
                'slug' => 'oculos',
                'description' => 'Óculos de sol premium - Oakley e similares',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Tênis',
                'slug' => 'tenis',
                'description' => 'Tênis urbanos - New Balance, Nike e mais',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Streetwear',
                'slug' => 'streetwear',
                'description' => 'Roupas urbanas e acessórios',
                'is_active' => true,
                'order' => 3,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Criar alguns produtos de exemplo
        $oculos = Category::where('slug', 'oculos')->first();
        $tenis = Category::where('slug', 'tenis')->first();
        $streetwear = Category::where('slug', 'streetwear')->first();

        $products = [
            [
                'category_id' => $oculos->id,
                'name' => 'Oakley Frogskins',
                'slug' => 'oakley-frogskins',
                'description' => 'Óculos de sol clássico com lentes de qualidade premium',
                'price' => 599.00,
                'compare_price' => 799.00,
                'stock' => 15,
                'sku' => 'OAK-FROG-001',
                'is_active' => true,
                'is_featured' => true,
                'images' => ['https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=800&q=80'],
            ],
            [
                'category_id' => $oculos->id,
                'name' => 'Ray-Ban Aviator',
                'slug' => 'ray-ban-aviator',
                'description' => 'Clássico aviador com armação dourada',
                'price' => 449.00,
                'compare_price' => 599.00,
                'stock' => 12,
                'sku' => 'RB-AVIAT-001',
                'is_active' => true,
                'is_featured' => true,
                'images' => ['https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=800&q=80'],
            ],
            [
                'category_id' => $oculos->id,
                'name' => 'Oakley Holbrook',
                'slug' => 'oakley-holbrook',
                'description' => 'Design moderno com proteção UV400',
                'price' => 649.00,
                'compare_price' => 849.00,
                'stock' => 18,
                'sku' => 'OAK-HOL-001',
                'is_active' => true,
                'is_featured' => false,
                'images' => ['https://images.unsplash.com/photo-1473496169904-658ba7c44d8a?w=800&q=80'],
            ],
            [
                'category_id' => $tenis->id,
                'name' => 'New Balance 574',
                'slug' => 'new-balance-574',
                'description' => 'Tênis confortável e estiloso para o dia a dia',
                'price' => 799.00,
                'compare_price' => 999.00,
                'stock' => 20,
                'sku' => 'NB-574-001',
                'is_active' => true,
                'is_featured' => true,
                'images' => ['https://images.unsplash.com/photo-1539185441755-769473a23570?w=800&q=80'],
            ],
            [
                'category_id' => $tenis->id,
                'name' => 'Nike Air Force 1',
                'slug' => 'nike-air-force-1',
                'description' => 'O clássico do streetwear',
                'price' => 699.00,
                'compare_price' => 899.00,
                'stock' => 25,
                'sku' => 'NK-AF1-001',
                'is_active' => true,
                'is_featured' => true,
                'images' => ['https://images.unsplash.com/photo-1549298916-b41d501d3772?w=800&q=80'],
            ],
            [
                'category_id' => $tenis->id,
                'name' => 'Adidas Ultraboost',
                'slug' => 'adidas-ultraboost',
                'description' => 'Máximo conforto e tecnologia',
                'price' => 899.00,
                'compare_price' => 1099.00,
                'stock' => 15,
                'sku' => 'AD-UB-001',
                'is_active' => true,
                'is_featured' => false,
                'images' => ['https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&q=80'],
            ],
            [
                'category_id' => $tenis->id,
                'name' => 'Vans Old Skool',
                'slug' => 'vans-old-skool',
                'description' => 'Clássico skate atemporal',
                'price' => 399.00,
                'compare_price' => 499.00,
                'stock' => 30,
                'sku' => 'VN-OS-001',
                'is_active' => true,
                'is_featured' => false,
                'images' => ['https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=800&q=80'],
            ],
            [
                'category_id' => $streetwear->id,
                'name' => 'Camiseta Premium Black',
                'slug' => 'camiseta-premium-black',
                'description' => 'Camiseta 100% algodão com design exclusivo',
                'price' => 199.00,
                'compare_price' => 249.00,
                'stock' => 30,
                'sku' => 'TEE-PREM-001',
                'is_active' => true,
                'is_featured' => false,
                'images' => ['https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&q=80'],
            ],
            [
                'category_id' => $streetwear->id,
                'name' => 'Jaqueta Bomber',
                'slug' => 'jaqueta-bomber',
                'description' => 'Jaqueta bomber minimalista preta',
                'price' => 899.00,
                'compare_price' => 1199.00,
                'stock' => 10,
                'sku' => 'JAC-BOMB-001',
                'is_active' => true,
                'is_featured' => false,
                'images' => ['https://images.unsplash.com/photo-1551028719-00167b16eac5?w=800&q=80'],
            ],
            [
                'category_id' => $streetwear->id,
                'name' => 'Moletom Premium',
                'slug' => 'moletom-premium',
                'description' => 'Moletom oversized com capuz',
                'price' => 349.00,
                'compare_price' => 449.00,
                'stock' => 25,
                'sku' => 'HOO-PREM-001',
                'is_active' => true,
                'is_featured' => true,
                'images' => ['https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=800&q=80'],
            ],
            [
                'category_id' => $streetwear->id,
                'name' => 'Boné Snapback',
                'slug' => 'bone-snapback',
                'description' => 'Boné ajustável minimalista',
                'price' => 149.00,
                'compare_price' => null,
                'stock' => 40,
                'sku' => 'CAP-SNAP-001',
                'is_active' => true,
                'is_featured' => false,
                'images' => ['https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=800&q=80'],
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
