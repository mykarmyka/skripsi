<?php $__env->startComponent('mail::message'); ?>
# Halo <?php echo new \Illuminate\Support\EncodedHtmlString($pasien->nama); ?>,

Pendaftaran layanan Anda **berhasil** 🎉

Berikut detail pendaftaran Anda:

- **Nomor Antrian:** <?php echo new \Illuminate\Support\EncodedHtmlString($noAntrian); ?>

- **Layanan:** <?php echo new \Illuminate\Support\EncodedHtmlString($namaLayanan); ?>

- **Estimasi Datang:** <?php echo new \Illuminate\Support\EncodedHtmlString($estimasiDatang); ?> WIB
- **Tanggal Pendaftaran:** <?php echo new \Illuminate\Support\EncodedHtmlString(\Carbon\Carbon::parse($tglPendaftaran)->translatedFormat('d F Y')); ?>


Mohon hadir **tepat waktu** sesuai estimasi,  
agar pelayanan berjalan lancar 🙏  

Terima kasih,  
**Klinik Bidan X**
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\xampp\htdocs\skripsi\resources\views/emails/pendaftaran.blade.php ENDPATH**/ ?>