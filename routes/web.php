<?php

use App\Http\Controllers\AuthController;
use App\Http\Livewire\CrudGenerator;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\DataKaryawanController;
use App\Http\Livewire\Master\AttributeController;
use App\Http\Livewire\Master\AttributeNilaiController;
use App\Http\Livewire\Master\DataJabatanController;
use App\Http\Livewire\Mining\DataLatihController;
use App\Http\Livewire\Mining\DataSetController;
use App\Http\Livewire\Mining\HasilPerhitunganDataSet;
use App\Http\Livewire\Mining\KlasifikasiDataSet;
use App\Http\Livewire\Mining\PengujianDataSet;
use App\Http\Livewire\Nasabah\DataNasabahController;
use App\Http\Livewire\Settings\Menu;
use App\Http\Livewire\UserManagement\Permission;
use App\Http\Livewire\UserManagement\PermissionRole;
use App\Http\Livewire\UserManagement\Role;
use App\Http\Livewire\UserManagement\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});


Route::post('login', [AuthController::class, 'login'])->name('admin.login');
Route::group(['middleware' => ['auth:sanctum', 'verified', 'user.authorization']], function () {
    // Crud Generator Route
    Route::get('/crud-generator', CrudGenerator::class)->name('crud.generator');

    // user management
    Route::get('/permission', Permission::class)->name('permission');
    Route::get('/permission-role/{role_id}', PermissionRole::class)->name('permission.role');
    Route::get('/role', Role::class)->name('role');
    Route::get('/user', User::class)->name('user');
    Route::get('/menu', Menu::class)->name('menu');

    // App Route
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Master data
    Route::get('/data-jabatan', DataJabatanController::class)->name('data-jabatan');
    Route::get('/data-attribute', AttributeController::class)->name('data-attribute');
    Route::get('/nilai-attribute', AttributeNilaiController::class)->name('nilai-attribute');

    // transaction
    Route::get('/data-nasabah', DataNasabahController::class)->name('data-nasabah');

    // mining
    Route::get('/data-latih', DataLatihController::class)->name('data-latih');
    Route::get('/data-set', DataSetController::class)->name('data-set');
    Route::get('/klasifikasi-data', KlasifikasiDataSet::class)->name('klasifikasi-data');
    Route::get('/perhitungan-data', HasilPerhitunganDataSet::class)->name('perhitungan-data');
    Route::get('/pengujian-data', PengujianDataSet::class)->name('pengujian-data');
});
