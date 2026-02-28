<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penugasan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
            color: #666;
        }

        .info {
            margin-bottom: 20px;
        }

        .info table {
            width: 100%;
        }

        .info td {
            padding: 3px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
        }

        td {
            font-size: 10px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
        }

        .signature {
            margin-top: 50px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN PENUGASAN PEGAWAI</h1>
        <p>Sistem Informasi Penjadwalan Pegawai</p>
        <p>Periode: <?php echo e(DateTime::createFromFormat('!m', $bulan)->format('F')); ?> <?php echo e($tahun); ?></p>
    </div>

    <div class="info">
        <table style="border: none;">
            <tr style="border: none;">
                <td style="border: none; width: 150px;">Tanggal Cetak</td>
                <td style="border: none;">: <?php echo e(now()->format('d F Y H:i:s')); ?></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;">Total Pegawai</td>
                <td style="border: none;">: <?php echo e($pegawai->count()); ?> orang</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;">Total Tugas</td>
                <td style="border: none;">: <?php echo e($pegawai->sum('total_tugas')); ?> tugas</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 30px;">No</th>
                <th>NIP</th>
                <th>Nama Pegawai</th>
                <th>Jabatan</th>
                <th>Seksi</th>
                <th class="text-center">Total Tugas</th>
                <th class="text-center">Total Jam</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $pegawai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-center"><?php echo e($index + 1); ?></td>
                    <td><?php echo e($p->nip); ?></td>
                    <td><?php echo e($p->name); ?></td>
                    <td><?php echo e($p->jabatan); ?></td>
                    <td><?php echo e($p->seksi); ?></td>
                    <td class="text-center"><?php echo e($p->total_tugas); ?></td>
                    <td class="text-center"><?php echo e($p->total_jam); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">TOTAL</th>
                <th class="text-center"><?php echo e($pegawai->sum('total_tugas')); ?></th>
                <th class="text-center"><?php echo e($pegawai->sum('total_jam')); ?></th>
            </tr>
            <tr>
                <th colspan="5" class="text-right">RATA-RATA</th>
                <th class="text-center">
                    <?php echo e($pegawai->count() > 0 ? round($pegawai->sum('total_tugas') / $pegawai->count(), 2) : 0); ?></th>
                <th class="text-center">
                    <?php echo e($pegawai->count() > 0 ? round($pegawai->sum('total_jam') / $pegawai->count(), 2) : 0); ?></th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <div class="signature">
            <p><?php echo e(now()->locale('id')->translatedFormat('l, d F Y')); ?></p>
            <p style="margin-top: 60px;">
                <strong>Admin Sistem</strong><br>
                _____________________
            </p>
        </div>
    </div>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\penugasan-pegawai\resources\views/admin/laporan/pdf.blade.php ENDPATH**/ ?>