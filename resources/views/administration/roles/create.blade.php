@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen overflow-hidden flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div class="max-h-screen overflow-hidden" :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-20 px-8 max-h-screen hide-scrollbar overflow-y-auto">
            <div class="flex items-end justify-between mb-2">
                <div>
                    <div class="text-[#135F9C] text-[40px] font-bold">
                        Tambah Role
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('administration.roles.index') }}" class="cursor-pointer">Roles</a> / <span class="text-[#2E46BA] cursor-pointer">Create</span>
                    </div>
                </div>
            </div>
            <div class="w-full bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Tambahkan Role?')" action="{{ route('administration.roles.store') }}" method="POST">
                    @csrf
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="name" class="font-bold text-[#232D42] text-[16px]">Nama</label>
                                <div class="relative">
                                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('name')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="lg:flex ps-5">
                            <div class="left-role">
                                <div class="lg:flex items-center justify-between">
                                    <div class="administration-role pb-10">
                                        <h6 class="font-bold text-[#232D42] text-[16px]">Administration</h6>
                                        <div class="container">
                                            <div class="row row-cols-12 pt-3 ps-3 ">
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="administrationuser" name="administration[]" value="administration-user">
                                                    <label class="form-check-label" for="administrationuser">
                                                    User
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="administrationapproval" name="administration[]" value="administration-approval">
                                                    <label class="form-check-label" for="administrationapproval">
                                                    Approval Data
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="administrationlog" name="administration[]" value="administration-log">
                                                    <label class="form-check-label" for="administrationlog">
                                                    Log Aktifitas User
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="administrationrole" name="administration[]" value="administration-role">
                                                    <label class="form-check-label" for="administrationrole">
                                                    Role
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex items-center justify-between">
                                    <div class="inisiasi-role pb-10">
                                        <h6 class="font-bold text-[#232D42] text-[16px]">Inisiasi Data</h6>
                                        <div class="container">
                                            <div class="row row-cols-12 pt-3 ps-3 ">
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="inisiasisetting-pbb" name="inisiasi[]" value="inisiasi-setting-pbb">
                                                    <label class="form-check-label" for="inisiasisetting-pbb">
                                                    Setting No PBB
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="inisiasiproduksi-listrik" name="inisiasi[]" value="inisiasi-produksi-listrik">
                                                    <label class="form-check-label" for="inisiasiproduksi-listrik">
                                                    Produksi Listrik
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="inisiasidata-awal-tahun" name="inisiasi[]" value="inisiasi-data-awal-tahun">
                                                    <label class="form-check-label" for="inisiasidata-awal-tahun">
                                                    Data Awal Tahun
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="inisiasipenerimaan-batu-bara" name="inisiasi[]" value="inisiasi-penerimaan-batu-bara">
                                                    <label class="form-check-label" for="inisiasipenerimaan-batu-bara">
                                                    Rec. Penerimaan Batu Bara
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="inisiasipemakaian" name="inisiasi[]" value="inisiasi-pemakaian">
                                                    <label class="form-check-label" for="inisiasipemakaian">
                                                    Rec. Pemakaian
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="inisiasipemakaian-bbm" name="inisiasi[]" value="inisiasi-pemakaian-bbm">
                                                    <label class="form-check-label" for="inisiasipemakaian-bbm">
                                                    Rec. Pemakaian BBM
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex items-center justify-between">
                                    <div class="kontrak-role pb-10">
                                        <h6 class="font-bold text-[#232D42] text-[16px]">Kontrak</h6>
                                        <div class="container">
                                            <div class="row row-cols-12 pt-3 ps-3 ">
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="kontrakbatu-bara" name="kontrak[]" value="kontrak-batu-bara">
                                                    <label class="form-check-label" for="kontrakbatu-bara">
                                                    Batu Bara
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="kontrakpemesanan-bbm" name="kontrak[]" value="kontrak-pemesanan-bbm">
                                                    <label class="form-check-label" for="kontrakpemesanan-bbm">
                                                    Pemesanan BBM
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="kontraktransfer-bbm" name="kontrak[]" value="kontrak-transfer-bbm">
                                                    <label class="form-check-label" for="kontraktransfer-bbm">
                                                    Transfer BBM
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mid-role px-20">
                                <div class="lg:flex items-center justify-between">
                                    <div class="data-role pb-10">
                                        <h6 class="font-bold text-[#232D42] text-[16px]">Data Master</h6>
                                        <div class="container">
                                            <div class="row row-cols-12 pt-3 ps-3 ">
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="datakapal" name="data[]" value="data-kapal">
                                                    <label class="form-check-label" for="datakapal">
                                                    Kapal
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="datapemasok" name="data[]" value="data-pemasok">
                                                    <label class="form-check-label" for="datapemasok">
                                                    Pemasok
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="dataagen-kapal" name="data[]" value="data-agen-kapal">
                                                    <label class="form-check-label" for="dataagen-kapal">
                                                    Agen Kapal
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="databongkar-muat" name="data[]" value="data-bongkar-muat">
                                                    <label class="form-check-label" for="databongkar-muat">
                                                    Perusahaan Bongkar Muat
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="datatransportir" name="data[]" value="data-transportir">
                                                    <label class="form-check-label" for="datatransportir">
                                                    Transportir
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="datapelabuhan-muat" name="data[]" value="data-pelabuhan-muat">
                                                    <label class="form-check-label" for="datapelabuhan-muat">
                                                    Pelabuhan Muat
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="datasurveyor" name="data[]" value="data-surveyor">
                                                    <label class="form-check-label" for="datasurveyor">
                                                    Surveyor
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="datapic" name="data[]" value="data-pic">
                                                    <label class="form-check-label" for="datapic">
                                                    Person in Charge
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="datadermaga" name="data[]" value="data-dermaga">
                                                    <label class="form-check-label" for="datadermaga">
                                                    Dermaga Suralaya
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="dataalat" name="data[]" value="data-alat">
                                                    <label class="form-check-label" for="dataalat">
                                                    Alat Besar
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="databunker-bbm" name="data[]" value="data-bunker-bbm">
                                                    <label class="form-check-label" for="databunker-bbm">
                                                    Bunker BBM
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="dataunit" name="data[]" value="data-unit">
                                                    <label class="form-check-label" for="dataunit">
                                                    Unit
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="datamuatan" name="data[]" value="data-muatan">
                                                    <label class="form-check-label" for="datamuatan">
                                                    Jenis Muatan
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex items-center justify-between">
                                    <div class="inputan-role pb-10">
                                        <h6 class="font-bold text-[#232D42] text-[16px]">Inputan</h6>
                                        <div class="container">
                                            <div class="row row-cols-12 pt-3 ps-3 ">
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="inputananalisa" name="inputan[]" value="inputan-analisa">
                                                    <label class="form-check-label" for="inputananalisa">
                                                    Analisa
                                                    </label>
                                                </div>
                                                {{-- <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="inputanpembongkaran-batu-bara" name="inputan[]" value="inputan-pembongkaran-batu-bara">
                                                    <label class="form-check-label" for="inputanpembongkaran-batu-bara">
                                                    Pembongkaran Batu Bara
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="inputanpenerimaan-batu-bara" name="inputan[]" value="inputan-penerimaan-batu-bara">
                                                    <label class="form-check-label" for="inputanpenerimaan-batu-bara">
                                                    Penerimaan Batu Bara
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="inputanpemakaian-batu-bara" name="inputan[]" value="inputan-pemakaian-batu-bara">
                                                    <label class="form-check-label" for="inputanpemakaian-batu-bara">
                                                    Pemakaian Batu Bara
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="inputanpenerimaan-bbm" name="inputan[]" value="inputan-penerimaan-bbm">
                                                    <label class="form-check-label" for="inputanpenerimaan-bbm">
                                                    Penerimaan BBM
                                                    </label>
                                                </div> --}}
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="inputanstock-opname" name="inputan[]" value="inputan-stock-opname">
                                                    <label class="form-check-label" for="inputanstock-opname">
                                                    Stock Opname
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="inputantug" name="inputan[]" value="inputan-tug">
                                                    <label class="form-check-label" for="inputantug">
                                                    TUG
                                                    </label>
                                                </div>
                                                {{-- <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="inputanjadwal-kapal" name="inputan[]" value="inputan-jadwal-kapal">
                                                    <label class="form-check-label" for="inputanjadwal-kapal">
                                                Jadwal Kapal
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="inputanpencatatan-counter" name="inputan[]" value="inputan-pencatatan-counter">
                                                    <label class="form-check-label" for="inputanpencatatan-counter">
                                                Pencatatan Counter
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="inputanpemantauan-kapal" name="inputan[]" value="inputan-pemantauan-kapal">
                                                    <label class="form-check-label" for="inputanpemantauan-kapal">
                                                Pemantauan Kapal
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="inputandata-bongkar" name="inputan[]" value="inputan-data-bongkar">
                                                    <label class="form-check-label" for="inputandata-bongkar">
                                                Perbaiki Data Bongkar
                                                    </label>
                                                </div>
                                             --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mid-2-role ps-20">
                                <div class="lg:flex items-center justify-between">
                                    <div class="laporan-role pb-10">
                                        <h6 class="font-bold text-[#232D42] text-[16px]">Laporan</h6>
                                        <div class="container">
                                            <div class="row row-cols-12 pt-3 ps-3 ">
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="laporanexecutive-summary" name="laporan[]" value="laporan-executive-summary">
                                                    <label class="form-check-label" for="laporanexecutive-summary">
                                                    Laporan Executive Summary
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="laporankontrak" name="laporan[]" value="laporan-kontrak">
                                                    <label class="form-check-label" for="laporankontrak">
                                                    Kontrak
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="laporanpersediaan" name="laporan[]" value="laporan-persediaan">
                                                    <label class="form-check-label" for="laporanpersediaan">
                                                    Persediaan
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="laporanpenerimaan" name="laporan[]" value="laporan-penerimaan">
                                                    <label class="form-check-label" for="laporanpenerimaan">
                                                    Penerimaan
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="laporankualitas-batu-bara" name="laporan[]" value="laporan-kualitas-batu-bara">
                                                    <label class="form-check-label" for="laporankualitas-batu-bara">
                                                    Kualitas Batu Bara
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="laporanpembongkaran" name="laporan[]" value="laporan-pembongkaran">
                                                    <label class="form-check-label" for="laporanpembongkaran">
                                                    Pembongkaran
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="laporanalat-besar" name="laporan[]" value="laporan-alat-besar">
                                                    <label class="form-check-label" for="laporanalat-besar">
                                                    Alat Besar
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="laporandenda" name="laporan[]" value="laporan-denda">
                                                    <label class="form-check-label" for="laporandenda">
                                                    Denda
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="laporanberita-acara" name="laporan[]" value="laporan-berita-acara">
                                                    <label class="form-check-label" for="laporanberita-acara">
                                                    Berita Acara
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="laporanperformance" name="laporan[]" value="laporan-performance">
                                                    <label class="form-check-label" for="laporanperformance">
                                                    Perfomance
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="laporanbw" name="laporan[]" value="laporan-bw">
                                                    <label class="form-check-label" for="laporanbw">
                                                    BW
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="laporanpemantauan-kapal" name="laporan[]" value="laporan-pemantauan-kapal">
                                                    <label class="form-check-label" for="laporanpemantauan-kapal">
                                                    Pemantauan Kapal
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex items-center justify-between">
                                    <div class="batu-bara-role pb-10">
                                        <h6 class="font-bold text-[#232D42] text-[16px]">Batu Bara</h6>
                                        <div class="container">
                                            <div class="row row-cols-12 pt-3 ps-3 ">
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="batu-barapembongkaran" name="batu_bara[]" value="batu-bara-pembongkaran">
                                                    <label class="form-check-label" for="batu-barapembongkaran">
                                                    Pembongkaran
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="batu-barapenerimaan" name="batu_bara[]" value="batu-bara-penerimaan">
                                                    <label class="form-check-label" for="batu-barapenerimaan">
                                                    Penerimaan
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="batu-barapemakaian" name="batu_bara[]" value="batu-bara-pemakaian">
                                                    <label class="form-check-label" for="batu-barapemakaian">
                                                    Pemakaian
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex items-center justify-between">
                                    <div class="bbm-role pb-10">
                                        <h6 class="font-bold text-[#232D42] text-[16px]">BBM</h6>
                                        <div class="container">
                                            <div class="row row-cols-12 pt-3 ps-3 ">
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="bbmpenerimaan" name="bbm[]" value="bbm-penerimaan">
                                                    <label class="form-check-label" for="bbmpenerimaan">
                                                    Penerimaan
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="bbmpemakaian" name="bbm[]" value="bbm-pemakaian">
                                                    <label class="form-check-label" for="bbmpemakaian">
                                                    Pemakaian
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex items-center justify-between">
                                    <div class="biomassa-role pb-10">
                                        <h6 class="font-bold text-[#232D42] text-[16px]">Biomassa</h6>
                                        <div class="container">
                                            <div class="row row-cols-12 pt-3 ps-3 ">
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="biomassapenerimaan" name="biomassa[]" value="biomassa-penerimaan">
                                                    <label class="form-check-label" for="biomassapenerimaan">
                                                    Penerimaan
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="right-role ps-20">
                                <div class="lg:flex items-center justify-between">
                                    <div class="pengaturan-role pb-10">
                                        <h6 class="font-bold text-[#232D42] text-[16px]">Pengaturan</h6>
                                        <div class="container">
                                            <div class="row row-cols-12 pt-3 ps-3 ">
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="pengaturanubah-password" name="pengaturan[]" value="pengaturan-ubah-password">
                                                    <label class="form-check-label" for="pengaturanubah-password">
                                                    Ubah Password
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex items-center justify-between">
                                    <div class="variabel-role pb-10">
                                        <h6 class="font-bold text-[#232D42] text-[16px]">Variabel</h6>
                                        <div class="container">
                                            <div class="row row-cols-12 pt-3 ps-3 ">
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="variabelharga-bbm" name="variabel[]" value="variabel-harga-bbm">
                                                    <label class="form-check-label" for="variabelharga-bbm">
                                                    Harga BBM
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="variabeljasa-dermaga" name="variabel[]" value="variabel-jasa-dermaga">
                                                    <label class="form-check-label" for="variabeljasa-dermaga">
                                                    Harga Jasa Dermaga
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="variabelangkut-bbm" name="variabel[]" value="variabel-angkut-bbm">
                                                    <label class="form-check-label" for="variabelangkut-bbm">
                                                    Harga Angkut BBM
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="variabelpajak-daerah" name="variabel[]" value="variabel-pajak-daerah">
                                                    <label class="form-check-label" for="variabelpajak-daerah">
                                                    Besar Pajak Daerah
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="variabelpajak-kso" name="variabel[]" value="variabel-pajak-kso">
                                                    <label class="form-check-label" for="variabelpajak-kso">
                                                    Besar Pajak KSO
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="variabeltarif-listrik" name="variabel[]" value="variabel-tarif-listrik">
                                                    <label class="form-check-label" for="variabeltarif-listrik">
                                                    Tarif Listrik
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="variabeltarif-kwh" name="variabel[]" value="variabel-tarif-kwh">
                                                    <label class="form-check-label" for="variabeltarif-kwh">
                                                    Tarif KWH Meter
                                                    </label>
                                                </div>
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="variabeltarif-ship" name="variabel[]" value="variabel-tarif-ship">
                                                    <label class="form-check-label" for="variabeltarif-ship">
                                                    Tarif Ship Unloader
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{route('administration.roles.index')}}" class="bg-[#C03221] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Tambah Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
