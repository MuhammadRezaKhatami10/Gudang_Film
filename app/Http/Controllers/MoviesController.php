<?php

namespace App\Http\Controllers;

use App\Http\Resources\MoviesCollection;
use Inertia\Inertia;
use App\Models\movies;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //objek, konstraktor, kelas, mengurutkan dari id secara menurun, pagineten untuk membagi halaman setiap halama 8 elemen
        $movies = new MoviesCollection(Movies::OrderByDesc('id')->paginate(8));
        //merender tampilan homepage dengan inertia. render untuk meghasilkan respon tampilan dari data yang dikirim 
        return Inertia::render('Homepage', [
            //elemen array yang menyimpan judul halaman dengan nilai "Gudang Film". Data ini akan tersedia di tampilan "Homepage"
            'title' => "Gudang Film",
            //elemen array yang menyimpan deskripsi halaman dengan nilai "Selamat Datang Di Gudang Film". akan tersedia di tampilan "Homepage"
            'description' => "Selamat Datang Di Gudang Film",
            //elemen array yang menyimpan objek $movies. Objek ini berisi koleksi film yang diurutkan dan dipaginasi.
            'movies' => $movies,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //digunakan untuk menambahkan film 
     //deklarasi metode store() yang menerima parameter $request
     public function store(Request $request)
    {
       //membuat instance baru dari model Movies. Model ini merepresentasikan tabel atau entitas "Movies" dalam database.
        $movies = new Movies();
        //mengisi atribut title pada objek $movies dengan nilai yang diterima dari permintaan HTTP ($request).
        $movies->title = $request->title;
        //mengisi atribut description pada objek $movies dengan nilai yang diterima dari $request
        $movies->description = $request->description;
        //mengisi atribut category pada objek $movies dengan nilai yang diterima dari $request.
        $movies->category = $request->category;
        //mengisi atribut production pada objek $movies dengan alamat email pengguna yang saat ini sedang terautentikasi. 
        //Fungsi auth()->user() digunakan untuk mendapatkan objek pengguna yang terautentikasi, dan kemudian mengakses 
        //atribut email dari objek tersebut.
        $movies->production = auth()->user()->email;
        //menyimpan data film yang telah diatur pada objek $movies ke dalam database. 
        $movies->save();
        //mengarahkan pengguna kembali ke halaman sebelumnya setelah menyimpan data film.
        return redirect()->back()->with('message', 'Film berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\movies  $movies
     * @return \Illuminate\Http\Response
     */
    //digunakan untuk menampilakan film atau data yang ada pada database
     //deklarasi metode show() yang menerima parameter $movies. Parameter ini merupakan 
    //instance dari model Movies yang digunakan untuk mengakses data film dalam database.
     public function show(movies $movies)
    {
        // menginisialisasi variabel $myMovies. menggunakan model Movies, melakukan query ke database untuk 
        // mengambil data film yang diproduksi oleh pengguna yang saat ini terautentikasi. Fungsi where() digunakan untuk menambahkan 
        //kondisi pada query, di mana kolom 'production' harus sama dengan alamat email pengguna yang saat ini terautentikasi (auth()->user()->email). Fungsi get() digunakan untuk menjalankan query dan mengambil semua hasilnya.
        $myMovies = $movies::where('production', auth()->user()->email)->get();
        //menggunakan Inertia.js untuk merender tampilan 'Dashboard'. Fungsi render() dari kelas Inertia digunakan untuk menghasilkan
        //respons yang berisi tampilan dengan data yang dikirimkan ke tampilan
        return Inertia::render('Dashboard', [
            // elemen array yang menyimpan data film yang telah diambil dari database. 
            'myMovies' => $myMovies,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\movies  $movies
     * @return \Illuminate\Http\Response
     */
    //digunakan untuk melakukan fungsi edit
     //deklarasi metode edit() yang menerima dua parameter, yaitu $movies dan $request. 
     public function edit(movies $movies, Request $request)
    {
        //menggunakan Inertia.js untuk merender tampilan 'EditMovies'. Fungsi render() dari kelas Inertia digunakan untuk menghasilkan respons yang berisi tampilan
        return Inertia::render('EditMovies', [
            //elemen array yang menyimpan data film yang akan diedit.menggunakan instance $movies,
            //melakukan query ke database untuk mencari data film berdasarkan $request->id, 
            //yang merupakan ID film yang dikirim melalui permintaan HTTP. Fungsi find() digunakan untuk mencari data film berdasarkan ID tersebut.
            'myMovies' => $movies->find($request->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\movies  $movies
     * @return \Illuminate\Http\Response
     */
    //digunakan untuk menampilkan hasil dari fungsi edit 
     //deklarasi metode update() yang menerima parameter $request
     public function update(Request $request)
    {
        //melakukan operasi pembaruan pada tabel 'movies' dalam database
        Movies::where('id', $request->id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
        ]);
        //mengarahkan pengguna kembali ke rute dengan nama 'dashboard' setelah berhasil melakukan pembaruan data film.
        //to_route() adalah helper function yang digunakan untuk menghasilkan URL rute berdasarkan nama rute yang diberikan.
        return to_route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\movies  $movies
     * @return \Illuminate\Http\Response
     */
    //digunakan untuk menghapus data
     //deklarasi metode destroy() yang menerima parameter $request
     public function destroy(Request $request)
    {
        //menggunakan model movies untuk mencari data film berdasarkan ID yang diterima dari permintaan HTTP ($request->id).
        $movies = Movies::find($request->id);
        // menghapus data film yang ditemukan pada langkah sebelumnya dengan memanggil metode delete(). Metode ini digunakan untuk menghapus entitas film dari database.
        $movies->delete();
        //mengarahkan pengguna kembali ke halaman sebelumnya setelah berhasil menghapus data film
        return redirect()->back()->with('message', 'Film berhasil dihapus');
    }
}
