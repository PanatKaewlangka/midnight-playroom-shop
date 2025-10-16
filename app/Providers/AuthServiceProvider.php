<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // --- นี่คือส่วนที่สำคัญที่สุด ---
        // เป็นการนิยาม 'Gate' หรือ 'กฎ' ที่ชื่อว่า is_admin
        // เพื่อใช้ตรวจสอบสิทธิ์การเข้าถึงของแอดมิน
        Gate::define('is_admin', function (User $user) {
            // เรียกใช้เมธอด isAdmin() ที่เราสร้างไว้ใน User Model
            return $user->isAdmin();
        });
    }
}

