<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\APIFormatter;
use App\Models\Siswa;
use Exception;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Siswa::all();

        if ($data) {
            return APIFormatter::createAPI(200, 'Success', $data);
        } else {
            return APIFormatter::createAPI(400, 'Failed');
        }
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
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required',
                'kelas' => 'required',
                'jurusan' => 'required',
            ]);

            $siswa = Siswa::create([
                'nama' => $request->nama,
                'kelas' => $request->kelas,
                'jurusan' => $request->jurusan,
            ]);

            $data = Siswa::where('id', '=', $siswa->id)->get();

            if ($data) {
                return APIFormatter::createAPI(200, 'Success', $data);
            } else {
                return APIFormatter::createAPI(400, 'Failed');
            }
        } catch (Exception $error) {
            return APIFormatter::createAPI(400, 'Failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Siswa::where('id', '=', $id)->get();

        if ($data) {
            return APIFormatter::createAPI(200, 'Success', $data);
        } else {
            return APIFormatter::createAPI(400, 'Failed');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required',
                'kelas' => 'required',
                'jurusan' => 'required',
            ]);

            $siswa = Siswa::find($id);

            $siswa->update($request->all());
            Siswa::withTrashed()->find($id)->restore();

            $data = Siswa::where('id', '=', $siswa->id)->get();

            if ($data) {
                return APIFormatter::createAPI(200, 'Success', $data);
            } else {
                return APIFormatter::createAPI(400, 'Failed');
            }
        } catch (Exception $error) {
            echo $error;
            return APIFormatter::createAPI(400, 'Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $siswa = Siswa::findOrFail($id);
            $data = $siswa->delete();

            if ($data) {
                return APIFormatter::createAPI(200, 'Success');
            } else {
                return APIFormatter::createAPI(400, 'Failed');
            }
        } catch (Exception $error) {
            return APIFormatter::createAPI(400, 'Failed');
        }
    }
}
