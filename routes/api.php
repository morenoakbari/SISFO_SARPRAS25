    <?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Hash;
    use App\Models\User;
    use App\Http\Controllers\Api\UserApiController;
    use App\Http\Controllers\Api\BarangApiController;
    use App\Http\Controllers\Api\PeminjamanApiController;
    use App\Http\Controllers\Api\KategoriApiController;
    use App\Http\Controllers\Api\PengembalianApiController;


    /*
    |--------------------------------------------------------------------------|
    | API Routes               `                                                 |
    |--------------------------------------------------------------------------|
    | Semua route ini otomatis pakai prefix `/api`                              |
    | Contoh akses: http://localhost:8000/api/users                             |
    |--------------------------------------------------------------------------|
    */

    // Route default bawaan Laravel
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    // List semua user (contoh)
    Route::get('/users', [UserApiController::class, 'index']);

    // ==========================
    // AUTH API Routes
    // ==========================

    // LOGIN
    Route::post('/login', function (Request $request) {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah!'
            ], 401);
        }

        $token = $user->createToken('token-user')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token' => $token,
            'user'  => $user,
        ]);
    });

    // LOGOUT
    Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    });

    // PROFILE (contoh protected route)
    Route::middleware('auth:sanctum')->get('/profile', function (Request $request) {
        return response()->json($request->user());
    });

    // ==========================
    // Barang API Routes
    // ==========================
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/barangs', [BarangApiController::class, 'store']);
        Route::get('/barangs', [BarangApiController::class, 'index']); 
        Route::put('/barangs/{barang}', [BarangApiController::class, 'update']);
        Route::delete('/barangs/{barang}', [BarangApiController::class, 'destroy']);
    });

    // ==========================
    // Kategori API Routes
    // ==========================
    Route::post('/kategoris', [KategoriApiController::class, 'store']);
    Route::put('/kategoris/{kategori}', [KategoriApiController::class, 'update']);



    // ==========================
    // Peminjaman API Routes
    // ==========================
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/peminjaman', [PeminjamanApiController::class, 'index']);
        Route::post('/peminjaman', [PeminjamanApiController::class, 'store']);
        Route::post('/peminjaman/{id}/kembalikan', [PeminjamanApiController::class, 'kembalikan']);
    });


    // ==========================
    // Pengembalian API Routes
    // ==========================
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/peminjaman/{id}/kembalikan', [PeminjamanApiController::class, 'kembalikan']); // untuk pengembalian di controller PeminjamanApiController
        Route::put('/pengembalian/{id}', [PengembalianApiController::class, 'kembalikan']); // untuk pengembalian di controller PengembalianApiController
    });
