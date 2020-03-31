SELECT
(select count(no_polisi)from kendaraan_masuk where jenis_kendaraan='MOTOR')as motor,
(select count(no_polisi)from kendaraan_masuk where jenis_kendaraan='MOBIL')as mobil


 "

 SELECT
(select count(no_polisi)from kendaraan_masuk where waktu_masuk <'07:00:00' and tanggal ='2019-02-08')as '07:00:00',
(select count(no_polisi)from kendaraan_masuk where hour(waktu_masuk)>= '08:00:00' and hour(waktu_masuk)<='08:00:00' and tanggal ='2019-02-08')as '08:00:00',
(select count(no_polisi)from kendaraan_masuk where hour(waktu_masuk)>= '09:00:00' and hour(waktu_masuk)<='09:00:00' and tanggal ='2019-02-08')as '09:00:00',
(select count(no_polisi)from kendaraan_masuk where hour(waktu_masuk)>= '10:00:00' and hour(waktu_masuk)<='10:00:00' and tanggal ='2019-02-08')as '10:00:00',
(select count(no_polisi)from kendaraan_masuk where hour(waktu_masuk)>= '11:00:00' and hour(waktu_masuk)<='11:00:00' and tanggal ='2019-02-08')as '12:00:00',
(select count(no_polisi)from kendaraan_masuk where hour(waktu_masuk)>= '13:00:00' and hour(waktu_masuk)<='13:00:00' and tanggal ='2019-02-08')as '13:00:00',
(select count(no_polisi)from kendaraan_masuk where hour(waktu_masuk)>= '14:00:00' and hour(waktu_masuk)<='14:00:00' and tanggal ='2019-02-08')as '14:00:00',
(select count(no_polisi)from kendaraan_masuk where hour(waktu_masuk)>= '15:00:00' and hour(waktu_masuk)<='15:00:00' and tanggal ='2019-02-08')as '15:00:00',
(select count(no_polisi)from kendaraan_masuk where hour(waktu_masuk)>= '16:00:00' and hour(waktu_masuk)<='16:00:00' and tanggal ='2019-02-08')as '16:00:00',
(select count(no_polisi)from kendaraan_masuk where hour(waktu_masuk)>= '17:00:00' and hour(waktu_masuk)<='17:00:00' and tanggal ='2019-02-08')as '17:00:00',
(select count(no_polisi)from kendaraan_masuk where hour(waktu_masuk)>= '18:00:00' and hour(waktu_masuk)<='18:00:00' and tanggal ='2019-02-08')as '18:00:00',
(select count(no_polisi)from kendaraan_masuk where hour(waktu_masuk)>= '19:00:00' and hour(waktu_masuk)<='19:00:00' and tanggal ='2019-02-08')as '19:00:00',
(select count(no_polisi)from kendaraan_masuk where hour(waktu_masuk)>= '20:00:00' and hour(waktu_masuk)<='20:00:00' and tanggal ='2019-02-08')as '20:00:00',
(select count(no_polisi)from kendaraan_masuk where hour(waktu_masuk)>= '21:00:00' and hour(waktu_masuk)<='21:00:00' and tanggal ='2019-02-08')as '21:00:00',
(select count(no_polisi)from kendaraan_masuk where hour(waktu_masuk)>= '22:00:00' and hour(waktu_masuk)<='22:00:00' and tanggal ='2019-02-08')as '22:00:00',
(select count(no_polisi)from kendaraan_masuk where hour(waktu_masuk)>= '23:00:00' and hour(waktu_masuk)<='23:00:00' and tanggal ='2019-02-08')as '23:00:00',
(select count(no_polisi)from kendaraan_masuk where hour(waktu_masuk)>= '00:00:00' and hour(waktu_masuk)<='00:00:00' and tanggal ='2019-02-08')as '00:00:00'


 "



 SELECT tbl_jam.jam, COUNT(kendaraan_masuk.jam) as Count
FROM tbl_jam 
LEFT JOIN kendaraan_masuk ON tbl_jam.jam=kendaraan_masuk.jam
GROUP BY tbl_jam.jam


SELECT 
tbl_jam.jam as jam
,tbl_jam.user_name as user_name
,coalesce(tot_motor,0) as motor
FROM tbl_jam
left JOIN 
(SELECT tbl_jam.jam, count(kendaraan_masuk.jenis_kendaraan)as tot_motor
FROM 
tbl_jam, kendaraan_masuk WHERE tbl_jam.jam=kendaraan_masuk.jam and kendaraan_masuk.jenis_kendaraan='MOTOR'  
GROUP BY kendaraan_masuk.jam ASC ) as _motor_keluar ON tbl_jam.jam=_motor_keluar.jam


SELECT tbl_tanggal.left_date as jam ,coalesce(tot_motor,0) as motor FROM tbl_jam left JOIN (SELECT tbl_tanggal.left_date, count(kendaraan_masuk.jenis_kendaraan)as tot_kendaraan FROM tbl_jam, kendaraan_masuk WHERE tbl_tanggal.left_date=kendaraan_masuk.left_date and kendaraan_masuk.tanggal='2019-02-08' GROUP BY kendaraan_masuk.left_date ASC ) as _motor_keluar ON tbl_tanggal.left_date=_motor_keluar.jam




SELECT
tbl_jenis_kendaraan.jenis_kendaraan as jenis_kendaraan
,COALESCE(jm_enam,0) as '06:00:00'

FROM tbl_jenis_kendaraan 

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_enam
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='06:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as enam ON tbl_jenis_kendaraan.jenis_kendaraan=enam.jenis_kendaraan 

<!-- rekap jam query -->

SELECT
tbl_jenis_kendaraan.jenis_kendaraan as jenis_kendaraan
,COALESCE(jm_enam,0) as '06:00:00'
,COALESCE(jm_tujuh,0) as '07:00:00'
,COALESCE(jm_delapan,0) as '08:00:00'
,COALESCE(jm_sembilan,0) as '09:00:00'
,COALESCE(jm_sepuluh,0) as '10:00:00'
,COALESCE(jm_sebelas,0) as '11:00:00'
,COALESCE(jm_duabelas,0) as '12:00:00'
,COALESCE(jm_tigabelas,0) as '13:00:00'
,COALESCE(jm_empatbelas,0) as '14:00:00'
,COALESCE(jm_limabelas,0) as '15:00:00'
,COALESCE(jm_enambelas,0) as '16:00:00'
,COALESCE(jm_tujuhbelas,0) as '17:00:00'
,COALESCE(jm_delapanbelas,0) as '18:00:00'
,COALESCE(jm_sembilanbelas,0) as '19:00:00'
,COALESCE(jm_duapuluh,0) as '20:00:00'
,COALESCE(jm_duasatu,0) as '21:00:00'
,COALESCE(jm_duadua,0) as '22:00:00'
,COALESCE(jm_duatiga,0) as '23:00:00'
,COALESCE(jm_nolnol,0) as '00:00:00'

FROM tbl_jenis_kendaraan 

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_enam
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='06:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as enam ON tbl_jenis_kendaraan.jenis_kendaraan=enam.jenis_kendaraan 

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_tujuh
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='07:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as tujuh ON tbl_jenis_kendaraan.jenis_kendaraan=tujuh.jenis_kendaraan

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_delapan
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='08:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as delapan ON tbl_jenis_kendaraan.jenis_kendaraan=delapan.jenis_kendaraan  

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_sembilan
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='09:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as sembilan ON tbl_jenis_kendaraan.jenis_kendaraan=sembilan.jenis_kendaraan  

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_sepuluh
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='10:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as sepuluh ON tbl_jenis_kendaraan.jenis_kendaraan=sepuluh.jenis_kendaraan  

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_sebelas
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='11:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as sebelas ON tbl_jenis_kendaraan.jenis_kendaraan=sebelas.jenis_kendaraan  

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_duabelas
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='12:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as duabelas ON tbl_jenis_kendaraan.jenis_kendaraan=duabelas.jenis_kendaraan  

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_tigabelas
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='13:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as tigabelas ON tbl_jenis_kendaraan.jenis_kendaraan=tigabelas.jenis_kendaraan 

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_empatbelas
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='14:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as empatbelas ON tbl_jenis_kendaraan.jenis_kendaraan=empatbelas.jenis_kendaraan   

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_limabelas
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='15:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as limabelas ON tbl_jenis_kendaraan.jenis_kendaraan=limabelas.jenis_kendaraan 

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_enambelas
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='16:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as enambelas ON tbl_jenis_kendaraan.jenis_kendaraan=enambelas.jenis_kendaraan 

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_tujuhbelas
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='17:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as tujuhbelas ON tbl_jenis_kendaraan.jenis_kendaraan=tujuhbelas.jenis_kendaraan 

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_delapanbelas
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='18:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as delapanbelas ON tbl_jenis_kendaraan.jenis_kendaraan=delapanbelas.jenis_kendaraan

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_sembilanbelas
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='19:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as sembilanbelas ON tbl_jenis_kendaraan.jenis_kendaraan=sembilanbelas.jenis_kendaraan

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_duapuluh
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='20:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as duapuluh ON tbl_jenis_kendaraan.jenis_kendaraan=duapuluh.jenis_kendaraan

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_duasatu
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='21:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as duasatu ON tbl_jenis_kendaraan.jenis_kendaraan=duasatu.jenis_kendaraan

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_duadua
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='22:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as duadua ON tbl_jenis_kendaraan.jenis_kendaraan=duadua.jenis_kendaraan

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_duatiga
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='23:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as duatiga ON tbl_jenis_kendaraan.jenis_kendaraan=duatiga.jenis_kendaraan

left JOIN 
(SELECT tbl_jenis_kendaraan.jenis_kendaraan, count(COALESCE(kendaraan_masuk.no_polisi,0))AS jm_nolnol
FROM 
tbl_jenis_kendaraan, kendaraan_masuk WHERE tbl_jenis_kendaraan.jenis_kendaraan=kendaraan_masuk.jenis_kendaraan and kendaraan_masuk.tanggal='2019-02-10' and jam='00:00:00'
GROUP BY kendaraan_masuk.jenis_kendaraan ASC ) as nolnol ON tbl_jenis_kendaraan.jenis_kendaraan=nolnol.jenis_kendaraan

