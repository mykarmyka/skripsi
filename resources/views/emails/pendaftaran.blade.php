@component('mail::message')
# Halo {{ $pasien->nama }},

Pendaftaran layanan Anda **berhasil** 🎉

Berikut detail pendaftaran Anda:

- **Nomor Antrian:** {{ $noAntrian }}
- **Layanan:** {{ $namaLayanan }}
- **Estimasi Datang:** {{ $estimasiDatang }} WIB
- **Tanggal Pendaftaran:** {{ \Carbon\Carbon::parse($tglPendaftaran)->translatedFormat('d F Y') }}

Mohon hadir **tepat waktu** sesuai estimasi,  
agar pelayanan berjalan lancar 🙏  

Terima kasih,  
**Klinik Bidan X**
@endcomponent
