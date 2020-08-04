@extends('layouts.galungtemplate')

@section('content')

<div class="kt-subheader subheader-custom kt-grid__item" id="kt_subheader">
  <div class="kt-container ">
    <div class="kt-subheader__main">
      <h3 class="kt-subheader__title">
        Penjualan </h3>
      <span class="kt-subheader__separator kt-hidden"></span>
      <div class="kt-subheader__breadcrumbs">
        <a href="" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="#" class="kt-subheader__breadcrumbs-link">
          Beras
        </a>
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="#" class="kt-subheader__breadcrumbs-link">
          Transaksi Beras
        </a>
      </div>
    </div>
    <div class="kt-subheader__toolbar">
      <div class="kt-subheader__wrapper">
        <a href="#" class="btn kt-subheader__btn-daterange" id="kt_dashboard_daterangepicker">
          <span class="kt-subheader__btn-daterange-title" id="kt_dashboard_daterangepicker_title">Today</span>&nbsp;
          <span class="kt-subheader__btn-daterange-date" id="kt_dashboard_daterangepicker_date">Aug
            16
          </span>
        </a>
      </div>
    </div>
  </div>
</div>

<div class="kt-container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      @if(session('success'))
      <div data-notify="container" class="alert alert-success m-alert animated bounce alert-win" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 10000; top: 100px; left: 0px; right: 0px; animation-iteration-count: 1;">
        <button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 100002;" data-notify="dismiss" data-dismiss="alert" aria-label="Close"></button>
        <span data-notify="message">{{session('success')}}!</span>
        <a href="#" target="_blank" data-notify="url"></a>
      </div>
      @elseif(session('error'))
      <div data-notify="container" class="alert alert-success m-alert animated bounce alert-error" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 10000; top: 100px; left: 0px; right: 0px; animation-iteration-count: 1;">
        <button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 100002;" data-notify="dismiss" data-dismiss="alert" aria-label="Close"></button>
        <span data-notify="message">{{session('error')}}!</span>
        <a href="#" target="_blank" data-notify="url"></a>
      </div>
      @endif
      @if ($errors->any())
      <div data-notify="container" class="alert alert-success m-alert animated bounce alert-error" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 10000; top: 100px; left: 0px; right: 0px; animation-iteration-count: 1;">
        <button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="position: absolute
        ; right: 10px; top: 5px; z-index: 100002;" data-notify="dismiss" data-dismiss="alert" aria-label="Close"></button>
        @foreach ($errors->all() as $error)
        <span data-notify="message">{{ $error }} !</span>
        @endforeach
        <a href="#" target="_blank" data-notify="url"></a>
      </div>
      @endif

      <div class="row">
        <div class="col-md-2">
          <div class="kt-portlet sticky" data-sticky="true" data-margin-top="100px" data-sticky-for="1023" data-sticky-class="kt-sticky">
            <div class="kt-portlet__body">
              <h5 style="color: #222;">
                Jumlah Data Transaksi Beras Yang Tersedia
              </h5>
              <h4 class="mt-3 kt-font-success" style="font-weight: 800;">
                {{$jml}} Data
              </h4>

            </div>
          </div>
        </div>

        <div class="col-md-10">
          <div class="kt-portlet admin-portlet">
            <div class="kt-portlet__head">
              <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                  <i class="flaticon-avatar"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                  Data Transaksi Beras
                </h3>
              </div>
            </div>
            <div class="kt-portlet__body">
              <div class="kt-section">
                <div class="kt-section__content">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nama Pembeli</th>
                          <th>Nama / Jenis Beras</th>
                          <th>Jumlah Beras</th>
                          <th>Harga</th>
                          <th>Jenis Pembayaran</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      @if ($jml == 0)
                      <tbody style="text-align: center;">
                        <td colspan="7">Belum ada data</td>
                      </tbody>
                      @else
                      <tbody>
                        @php $no = 1; @endphp
                        @foreach ($data as $transaksi)
                        <tr>
                          <th scope="row">{{$no++}}</th>
                          <td>{{$transaksi -> users -> name}}</td>
                          <td>{{$transaksi -> beras -> nama}}</td>
                          <td>{{$transaksi -> jumlah}}</td>
                          <td>{{$transaksi -> harga}}</td>
                          <td>
                            @if($transaksi->jenis_bayar == 'cod')
                            Cash On Delivery
                            @else
                            <button type="button" class="btn btn-bold btn-bukti btn-sm" data-toggle="modal" data-target="#buktipembayaran"> Lihat Bukti Pembayaran</button>
                            @endif
                          </td>
                          <td>
                            <div class="dropdown dropdown-inline">
                              <a href="#" class="btn btn-default btn-icon btn-icon-md btn-sm btn-more-custom" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="flaticon-more-1"></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right dropdown-table-custom fade" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-149px, 33px, 0px);">
                                <ul class="kt-nav">
                                  <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link detail-data" data-toggle="modal" data-target="#modal-detail-user">
                                      <i class="kt-nav__link-icon flaticon2-indent-dots"></i>
                                      <span class="kt-nav__link-text">Detail</span>
                                    </a>
                                  </li>
                                  <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link edit-data" data-toggle="modal" data-target="#modal-edit-data">
                                      <i class=" kt-nav__link-icon flaticon2-settings"></i>
                                      <span class="kt-nav__link-text">Edit Data</span>
                                    </a>
                                  </li>
                                  <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link hapus-data" data-toggle="modal" data-target="#modal-hapus">
                                      <i class="kt-nav__link-icon fa fa-trash-alt"></i>
                                      <span class="kt-nav__link-text">Hapus data</span>
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                      @endif
                    </table>
                    {{$data->links()}}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- modal buktipembayaran -->
      <div class="modal fade" id="buktipembayaran" tabindex="-1" role="dialog" aria-labelledby="modal-detail-user">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Bukti Transfer</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              </button>
            </div>
            <div class="modal-body detail-modal" style="padding-top: 10px;">
              <div class="kt-portlet kt-portlet--height-fluid kt-widget19">
                <div class="kt-portlet__body kt-portlet__body--fit kt-portlet__body--unfill">
                  <div class="kt-widget19__pic kt-portlet-fit--top kt-portlet-fit--sides">
                    <img src="{{ asset('img/test.JPG') }}" alt="" id="image">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- modal buktipembayaran-->

      <!-- modal edit data -->
      <!-- <div class="modal modal-edit fade" id="modal-edit-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <span class="modal-icon">
              <i class="fa fa-user-plus"></i>
            </span>
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Data Beras</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              </button>
            </div>
            <div class="modal-body">
              <form action="" method="POST" id="edit-beras" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="PUT" name="_method">

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label>Nama / Jenis Beras</label>
                      <input type="text" class="form-control" name="nama" id="namas" required>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group ">
                          <label>Harga</label>
                          <input type="text" class="form-control" name="harga" id="hargas" required>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group ">
                          <label>Stok</label>
                          <input type="text" class="form-control" name="stok" id="stoks" required>
                        </div>
                      </div>
                    </div>

                    <div class="form-group ">
                      <label>Minimal Pembelian</label>
                      <input type="text" class="form-control" name="min_beli" id="min_belis" required>
                    </div>

                    <div class="form-group">
                      <label for="exampleTextarea">Deskripsi</label>
                      <textarea class="form-control" id="deskripsis" rows="6" style="resize: none;" name="deskripsi" required></textarea>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Upload Gambar</label>
                      <div class="col-lg-9 col-xl-6">
                        <div class="kt-avatar kt-avatar--outline" id="kt_user_add_avatar">
                          <div class="kt-avatar__holder">
                            <span class="message-image"> Max ukuran gambar 3MB </span>
                            <img id="edit-preview" src="" alt="" width="400px">
                          </div>
                          <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Masukkan gambar">
                            <i class="fa fa-plus"></i>
                            <input type="file" name="gambar" onchange="tampilkanPreview(this,'edit-preview')" accept="image/*">
                          </label>
                          <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Cancel avatar">
                            <i class="fa fa-times"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row verif-form">
                  <div class="col-md-6">
                    <button type="button" class="btn close-modal" data-dismiss="modal" aria-label="Close">Cancel</button>
                  </div>

                  <div class="col-md-6">
                    <input type="submit" value="Simpan perubahan" class="btn btn-verif btn-flat">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div> -->
      <!-- end modal edit data -->

      <!-- modal hapus -->
      <!-- <div class="modal modal-hapus fade" id="modal-hapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <span class="modal-icon">
              <i class="fa fa-trash-alt"></i>
            </span>
            <div class="modal-body">
              <h3>Hapus Data?</h3>
              <p>Data yang telah di hapus tidak dapat</p>
              <p>dikembalikan lagi</p>

              <div class="row verif-form">
                <div class="col-md-6">
                  <button type="button" class="btn close-modal" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>

                <div class="col-md-6">
                  <form action="" method="POST" id="hapus-data">
                    @csrf
                    <input type="hidden" value="delete" name="_method">

                    <input type="submit" value="Hapus data" class="btn btn-verif btn-flat">

                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
      <!-- end modal hapus -->

    </div>
  </div>
</div>

<script type="text/javascript">
  function tampilkanPreview(gambar, idpreview) {
    //membuat objek gambar
    var gb = gambar.files;
    //loop untuk merender gambar
    for (var i = 0; i < gb.length; i++) {
      //bikin variabel
      var gbPreview = gb[i];
      var imageType = /image.*/;
      var preview = document.getElementById(idpreview);
      var reader = new FileReader();
      if (gbPreview.type.match(imageType)) {
        //jika tipe data sesuai
        preview.file = gbPreview;
        reader.onload = (function(element) {
          return function(e) {
            element.src = e.target.result;
          };
        })(preview);
        //membaca data URL gambar
        reader.readAsDataURL(gbPreview);
      } else {
        //jika tipe data tidak sesuai
        alert("Type file tidak sesuai. Khusus image.");
      }
    }
  }

  // modal detail
  // $('#modal-detail-user').on('show.bs.modal', function(event) {
  //     var a = $(event.relatedTarget)
  //     var nama = a.data('nama')
  //     var harga = a.data('harga')
  //     var min_beli = a.data('min_beli')
  //     var stok = a.data('stok')
  //     var deskripsi = a.data('deskripsi')
  //     var image = a.data('image')
  //     var admin_name = a.data('admin_name')

  //     var modal = $(this)
  //     modal.find('.modal-title').text('Detail Beras ' + nama)
  //     modal.find('.modal-body #nama').text('Beras ' + nama)
  //     modal.find('.modal-body #harga').text('Harga Rp. ' + harga)
  //     modal.find('.modal-body #min_beli').text('Minimal Pembelian ' + min_beli)
  //     modal.find('.modal-body #stok').text(stok)
  //     modal.find('.modal-body #deskripsi').text(deskripsi)
  //     modal.find('.modal-body #admin_name').text('Admin yang menangani : ' + admin_name)
  //     modal.find('.modal-body #image').attr('src', image)

  // })
  // modal detail

  // modal edit
  // $('#modal-edit-data').on('show.bs.modal', function(event) {
  //     var a = $(event.relatedTarget)
  //     var nama = a.data('nama')
  //     var harga = a.data('harga')
  //     var min_beli = a.data('min_beli')
  //     var stok = a.data('stok')
  //     var deskripsi = a.data('deskripsi')
  //     var image = a.data('image')
  //     var admin_name = a.data('admin_name')
  //     var href = a.data('href')

  //     var modal = $(this)
  //     modal.find('.modal-title').text('Detail Beras ' + nama)
  //     modal.find('.modal-body #namas').val(nama)
  //     modal.find('.modal-body #hargas').val(harga)
  //     modal.find('.modal-body #min_belis').val(min_beli)
  //     modal.find('.modal-body #stoks').val(stok)
  //     modal.find('.modal-body #deskripsis').val(deskripsi)
  //     modal.find('.modal-body #admin_names').val(admin_name)
  //     modal.find('.modal-body #edit-preview').attr('src', image)
  //     modal.find('.modal-body #edit-beras').attr('action', href)
  // })
  // modal edit

  //Modal hapus
  // $('#modal-hapus').on('show.bs.modal', function(event) {
  //     var a = $(event.relatedTarget)
  //     var href = a.data('href')

  //     var modal = $(this)
  //     modal.find('.modal-body #hapus-data').attr('action', href)
  // })
  //End Modal hapus
</script>

@endsection