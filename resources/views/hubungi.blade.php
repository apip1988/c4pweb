@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-envelope mr-2"></i> Hubungi Urusetia</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('hubungi.hantar') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nama Penuh</label>
                            <input type="text" name="nama" class="form-control" value="{{ Auth::check() ? Auth::user()->name : '' }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>No. Kad Pengenalan</label>
                                <input type="text" name="ic" class="form-control" value="{{ Auth::check() ? Auth::user()->ic_number : '' }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>No. Telefon</label>
                                <input type="text" name="telefon" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>PTJ / Jabatan</label>
                            <input type="text" name="ptj" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Perkara</label>
                            <select name="perkara" class="form-control">
                                <option value="Pertanyaan">Pertanyaan Umum</option>
                                <option value="Masalah Teknikal">Masalah Teknikal Portal</option>
                                <option value="Aduan">Aduan Penempatan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mesej / Apa yang ingin dihantar</label>
                            <textarea name="mesej" class="form-control" rows="4" placeholder="Tuliskan butiran lanjut di sini..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block shadow-sm">
                            <i class="fas fa-paper-plane mr-2"></i> Hantar Maklumat
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow border-0 mb-4" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-map-marker-alt mr-2"></i> Lokasi Kami</h5>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.582862410885!2d101.68478471475678!3d2.922119997871638!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cdb66974000001%3A0xc6ed7e834ebc1b48!2sKementerian%20Kesihatan%20Malaysia!5e0!3m2!1sms!2smy!4v1647670000000!5m2!1sms!2smy" 
                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>

            <div class="card shadow border-0" style="border-radius: 15px;">
    <div class="card-body text-center">
        <h6 class="font-weight-bold mb-4 text-secondary text-uppercase" style="letter-spacing: 1px;">Ikuti Kami Di Media Sosial</h6>
        
        <div class="d-flex justify-content-around align-items-center mb-4">
            <a href="https://facebook.com/medicalassistantboard" target="_blank" class="text-primary" title="Facebook">
                <i class="fab fa-facebook fa-3x mb-2"></i>
                <p class="small font-weight-bold mb-0 text-dark">Facebook</p>
            </a>

            <a href="https://t.me/cawanganperkhidmatanppp" target="_blank" class="text-info" title="Telegram">
                <i class="fab fa-telegram fa-3x mb-2"></i>
                <p class="small font-weight-bold mb-0 text-dark">Telegram</p>
            </a>

            <a href="https://www.tiktok.com/@kkmputrajaya" target="_blank" class="text-dark" title="TikTok">
                <i class="fab fa-tiktok fa-3x mb-2"></i>
                <p class="small font-weight-bold mb-0 text-dark">TikTok</p>
            </a>

            <a href="tel:0388831408" class="text-success" title="Hubungi Kami">
                <i class="fas fa-phone-square fa-3x mb-2"></i>
                <p class="small font-weight-bold mb-0 text-dark">03-8883 1408</p>
            </a>
        </div>

        <hr>
        <div class="alert alert-light border-0 small text-muted mb-0" style="border-radius: 10px;">
            <i class="fas fa-info-circle mr-1"></i> Waktu Operasi: Isnin - Jumaat (8:00 AM - 5:00 PM)
        </div>
    </div>
</div>
        </div>
    </div>
</div>
@endsection