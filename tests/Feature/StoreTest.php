<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    // 1. Auth: Guest tidak dapat membuka dashboard
    public function test_guest_cannot_access_dashboard()
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(302); // Memastikan diredirect (biasanya ke halaman login)
    }

    // 2. Product: Validasi harga negatif
    public function test_product_price_validation()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::create(['name' => 'Tas Dior']);

        $response = $this->actingAs($admin)->post('/products', [
            'name' => 'Dior Test',
            'sku' => 'DIOR-999',
            'price' => -5000,
            'category_id' => $category->id,
            'stock' => 10
        ]);
        
        $response->assertSessionHasErrors(['price']);
    }

    // 3. Authorization: Staff dibatasi dari halaman tertentu
    public function test_staff_access_restriction()
    {
        $staff = User::factory()->create(['role' => 'staff']);

        $response = $this->actingAs($staff)->get('/products/create');
        
        // Memastikan akses ditolak (Forbidden 403 atau Redirect 302)
        $this->assertTrue(in_array($response->status(), [403, 302, 401]));
    }
}