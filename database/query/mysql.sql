select a.nip,
       a.nama,
       d.status,
       a.jumlah_anak,
       b.nama_jabatan,
       a.golongan,
       b.gaji_pokok,
       b.tunj_jabatan,
       c.tunj_suami_istri,
       c.tunj_anak,
       c.tunj_makan,
       c.tunj_lembur,
       (
           select sum(x.jumlah) as jumlah
           from detail_potongan as x
                    left join potongan as y on x.kode_potongan = y.kode_potongan
           where MONTH(x.tgl_potongan) = '11'
             and YEAR(x.tgl_potongan) = '2020'
             and x.nip = a.nip
           group by x.tgl_potongan
       )                                                 as jumlah_potongan,
       (b.gaji_pokok + b.tunj_jabatan)                   as tunjangan_tetap,
       ROUND(((b.gaji_pokok + b.tunj_jabatan) / 173), 2) as upah_per_jam,
       (
           select jumlah_lembur
           from data_lembur
           where MONTH(bulan_lembur) = '11'
             and YEAR(bulan_lembur) = '2020'
             and nip = a.nip
       )                                                 as jumlah_jam_lembur,
       (
           select ROUND(((b.gaji_pokok + b.tunj_jabatan) / 173 * jumlah_lembur), 2)
           from data_lembur
           where MONTH(bulan_lembur) = '11'
             and YEAR(bulan_lembur) = '2020'
             and nip = a.nip
       )                                                 as total_upah_lembur,
       (
                       IFNULL((
                                  select ROUND(((b.gaji_pokok + b.tunj_jabatan) / 173 * jumlah_lembur), 2)
                                  from data_lembur
                                  where MONTH(bulan_lembur) = '11'
                                    and YEAR(bulan_lembur) = '2020'
                                    and nip = a.nip
                              ), 0) + (b.gaji_pokok + b.tunj_jabatan) -
                       IFNULL((
                                  select sum(x.jumlah) as jumlah
                                  from detail_potongan as x
                                           left join potongan as y on x.kode_potongan = y.kode_potongan
                                  where MONTH(x.tgl_potongan) = '11'
                                    and YEAR(x.tgl_potongan) = '2020'
                                    and x.nip = a.nip
                                  group by x.tgl_potongan
                              ), 0) +
                       CASE
                           WHEN d.status = 'Menikah' AND a.jumlah_anak > 0
                               THEN (c.tunj_suami_istri + (c.tunj_anak * a.jumlah_anak))
                           WHEN d.status = 'Menikah' AND a.jumlah_anak = 0 THEN (c.tunj_suami_istri)
                           WHEN d.status = 'Cerai' AND a.jumlah_anak > 0 THEN (c.tunj_anak * a.jumlah_anak)
                           ELSE 0
                           END

           )                                             as gaji_bersih
from pegawai as a
         inner join jabatan as b on a.jabatan = b.kode_jabatan
         inner join golongan as c on a.golongan = c.kode_golongan
         inner join status_pernikahan as d on a.status = d.id
         left join data_lembur as e on e.nip = a.nip
