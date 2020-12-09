@extends('layouts.admin')
@section('title')
   Category
@endsection

@section('content')
    <!-- Page Content -->
    <div
            class="section-content section-dashboard-home"
            data-aos="fade-up"
          >
            <div class="container-fluid">
              <div class="dashboard-heading">
                <h2 class="dashboard-title">Category</h2>
                <p class="dashboard-subtitle">Create new Category</p>
              </div>
              <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                    {{-- memunculkan pesan error dari dokumentasi laravel --}}
                        @if($errors->any())
                            <div class="alert alert-danger">
                              <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                              </ul>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-body">
                              <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf {{-- csrf agar form kita bisa dipakai --}}
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>Nama Kategori</label>
                                      <input type="text" name="name" class="form-control" required>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>Foto</label>
                                      <input type="file" name="photo" class="form-control"   >
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col text-right">
                                    <button type="submit" class="btn btn-success px-5">
                                      Save Now
                                    </button>
                                  </div>
                                </div>
                              </form>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
@endsection