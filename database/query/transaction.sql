CREATE ROW TABLE ERESERVE.RESV_H (
	"DocEntry" BIGINT not null,
	"DocNum" INTEGER null,
	"DocDate" DATE null,
	"RequiredDate" DATE null,
	"RequestType" DATE null,
	"Requester" INTEGER null,
	"Division" INTEGER null,
	"Department" INTEGER null,
	"Company" INTEGER null,
	"Memo" NVARCHAR (5000) null,
	"Canceled" VARCHAR (20) null,
	"DocStatus" VARCHAR (20) null,
	"ApprovalStatus" VARCHAR (20) null,
	"ApprovalKey" INTEGER null,
	"isConfirmed" VARCHAR (20) null,
	"ConfirmDate" DATE null,
	"ConfirmBy" INTEGER null,
	"SAP_GIRNo" INTEGER null,
	"SAP_TrfNo" INTEGER null,
	"SAP_PRNo" INTEGER null,
	"CreateDate" DATE null,
	"CreateTime" TIME null,
	"CreatedBy" INTEGER null,
	"UpdateDate" DATE null,
	"UpdateTime" TIME null,
	"UpdatedBy" INTEGER null,
	PRIMARY KEY ("DocEntry")
);

CREATE ROW TABLE ERESERVE.RESV_D (
	"DocEntry" BIGINT null,
	"LineNum" INTEGER null,
	"ItemCode" VARCHAR (20) null,
	"ItemName" NVARCHAR (5000) null,
	"ItemCategory" INTEGER null,
	"WhsCode" VARCHAR (20) null,
	"UoMCode" VARCHAR (20) null,
	"UoMName" VARCHAR (20) null,
	"ReqQty" FLOAT (52) null,
	"ReqDate" DATE null,
	"ReqNotes" NVARCHAR (5000) null,
	"OtherResvNo" VARCHAR (100) null,
	"RequestType" VARCHAR (20) null,
	"QtyReadyIssue" FLOAT (52) null,
	"LineStatus" VARCHAR (20) null,
	"SAP_GIRNo" INTEGER null,
	"SAP_TrfNo" INTEGER null,
	"SAP_PRNo" INTEGER null
);

/****** Object: TABLE [sessions] - Script Date: 11/11/2020 2:20:29 PM ******/
CREATE ROW TABLE "sessions" (
	"id" VARCHAR (200) null,
	"user_id" BIGINT null,
	"ip_address" VARCHAR (50) null,
	"user_agent" NVARCHAR (5000) null,
	"payload" NVARCHAR (5000) null,
	"last_activity" INTEGER null
);


select a.nip, a.nama, d.status, a.jumlah_anak, b.nama_jabatan, a.golongan, b.gaji_pokok, b.tunj_jabatan,
c.tunj_suami_istri, c.tunj_anak, c.tunj_makan, c.tunj_lembur,
(
select sum(x.jumlah) as jumlah
from detail_potongan as x
left join potongan as y on x.kode_potongan = y.kode_potongan
where MONTH(x.tgl_potongan) = '11' and YEAR(x.tgl_potongan)= '2020' and x.nip = a.nip
group by  x.tgl_potongan
) as jumlah_potongan,
(b.gaji_pokok + b.tunj_jabatan) as tunjangan_tetap,
ROUND(((b.gaji_pokok + b.tunj_jabatan)/173), 2) as upah_per_jam,
(
select jumlah_lembur from data_lembur
where MONTH(bulan_lembur) = '11' and YEAR(bulan_lembur)= '2020' and nip = a.nip
) as jumlah_lembur,
(
select ROUND(((b.gaji_pokok + b.tunj_jabatan)/173 * jumlah_lembur), 2) from data_lembur
where MONTH(bulan_lembur) = '11' and YEAR(bulan_lembur)= '2020' and nip = a.nip
) as total_upah_lembur,
((
select ROUND(((b.gaji_pokok + b.tunj_jabatan)/173 * jumlah_lembur), 2) from data_lembur
where MONTH(bulan_lembur) = '11' and YEAR(bulan_lembur)= '2020' and nip = a.nip
) + (b.gaji_pokok + b.tunj_jabatan) -
(
select sum(x.jumlah) as jumlah
from detail_potongan as x
left join potongan as y on x.kode_potongan = y.kode_potongan
where MONTH(x.tgl_potongan) = '11' and YEAR(x.tgl_potongan)= '2020' and x.nip = a.nip
group by  x.tgl_potongan
)

)  as gaji_bersih
from pegawai as a
inner join jabatan as b on a.jabatan = b.kode_jabatan
inner join golongan as c on a.golongan = c.kode_golongan
inner join status_pernikahan as d on a.status = d.id
left join data_lembur as e on e.nip = a.nip



