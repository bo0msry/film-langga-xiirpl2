<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman login utama
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Menampilkan halaman registrasi akun baru
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Fungsi untuk memproses Login
    public function login(Request $request)
    {
        // Validasi input dari form
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek login ke database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $redirect = $request->input('redirect');

            // Kembali ke halaman asal hanya jika URL masih mengarah ke host yang sama.
            if (is_string($redirect) && $redirect !== '') {
                $redirectHost = parse_url($redirect, PHP_URL_HOST);
                $redirectScheme = parse_url($redirect, PHP_URL_SCHEME);

                if ($redirectHost === $request->getHost() && in_array($redirectScheme, ['http', 'https'], true)) {
                    return redirect()->to($redirect)->with('success', 'Berhasil login!');
                }
            }

            // Langsung redirect ke dashboard admin atau halaman yang dituju
            return redirect()->intended(route('admin.films.index'))->with('success', 'Berhasil login!');
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Fungsi untuk memproses Register (Pendaftaran Akun Baru)
    public function register(Request $request)
    {
        // Validasi input register
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        // Buat akun beserta profil dan role default dalam satu transaksi.
        $user = DB::transaction(function () use ($validated) {
            $role = Role::firstOrCreate(['name' => 'user']);

            $profile = Profile::forceCreate([
                'alamat' => '',
                'umur' => 0,
                'bio' => '',
            ]);

            return User::forceCreate([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'email_verified_at' => now(),
                'role_id' => $role->id,
                'profile_id' => $profile->id,
            ]);
        });

        // Otomatis login setelah berhasil terdaftar
        Auth::login($user);
        $request->session()->regenerate();

        $redirect = $request->input('redirect');

        // Kembali ke halaman asal hanya jika URL masih mengarah ke host yang sama.
        if (is_string($redirect) && $redirect !== '') {
            $redirectHost = parse_url($redirect, PHP_URL_HOST);
            $redirectScheme = parse_url($redirect, PHP_URL_SCHEME);

            if ($redirectHost === $request->getHost() && in_array($redirectScheme, ['http', 'https'], true)) {
                return redirect()->to($redirect)->with('success', 'Akun berhasil dibuat!');
            }
        }

        return redirect()->route('home')->with('success', 'Akun berhasil dibuat!');
    }

    // Fungsi untuk Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil logout!');
    }
}
