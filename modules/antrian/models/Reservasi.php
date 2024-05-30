<?php

namespace app\modules\antrian\models;

use Yii;

/**
 * This is the model class for table "reservasi".
 *
 * @property string $ID
 * @property string|null $TANGGALKUNJUNGAN field -> tanggalperiksa BPJS
 * @property string|null $TANGGAL_REF
 * @property int|null $NORM field -> nomorrm BPJS
 * @property string|null $NIK field -> nik BPJS
 * @property string|null $NAMA
 * @property string|null $TEMPAT_LAHIR
 * @property string|null $TANGGAL_LAHIR
 * @property string|null $ALAMAT
 * @property int|null $PEKERJAAN
 * @property string|null $INSTANSI_ASAL
 * @property string|null $JK
 * @property string|null $WILAYAH
 * @property int|null $PROFESI
 * @property int|null $POLI
 * @property string|null $POLI_BPJS
 * @property string|null $REF_POLI_RUJUKAN
 * @property string|null $DOKTER
 * @property string|null $CARABAYAR
 * @property int|null $JENIS_KUNJUNGAN 1 (Rujukan FKTP), 2 (Rujukan Internal), 3 (Kontrol), 4 (Rujukan Antar RS)
 * @property string|null $NO_KARTU_BPJS fiel -> nomorkartu BPJS
 * @property string|null $CONTACT field -> notelp BPJS
 * @property string|null $TGL_DAFTAR
 * @property int|null $NO
 * @property int|null $ANTRIAN_POLI
 * @property int|null $NOMOR_ANTRIAN Perhitungan Dari Jadwal HFIS
 * @property string|null $JAM
 * @property string|null $JAM_PELAYANAN
 * @property string|null $ESTIMASI_PELAYANAN Perhitungan Dari Jadwal HFIS
 * @property string|null $POS_ANTRIAN
 * @property int|null $JENIS 1 : PasienLama 2: PasienBaru
 * @property int $JADWAL_DOKTER TABLE->JADWAL_DOKTER FIELD->ID
 * @property string|null $NO_REF_BPJS field -> nomorreferensi BPJS
 * @property int|null $JENIS_REF_BPJS field -> jenisreferensi BPJS
 * @property int|null $JENIS_REQUEST_BPJS field -> jenisrequest BPJS
 * @property int|null $POLI_EKSEKUTIF_BPJS field -> polieksekutif BPJS
 * @property string|null $REF
 * @property string|null $SEP
 * @property int|null $RAWAT_INAP
 * @property int|null $JENIS_APLIKASI 0=Web, 1=MobileApp, 2=Mobile JKN,5=Onsite
 * @property int|null $STATUS
 * @property int|null $REF_JADWAL Ref ID Jadwal_dokter_hfis
 * @property string $JAM_PRAKTEK Jam Rencana Kunjungan Berdasarkan Jadwal Dokter HFIS
 * @property string|null $WAKTU_CHECK_IN
 * @property int|null $LOKET_RESPON
 * @property string|null $UPDATE_TIME
 * @property int|null $VAKSIN_KE
 */
class Reservasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservasi';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_regonline');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID'], 'required'],
            [['TANGGALKUNJUNGAN', 'TANGGAL_REF', 'TANGGAL_LAHIR', 'TGL_DAFTAR', 'WAKTU_CHECK_IN', 'UPDATE_TIME'], 'safe'],
            [['NORM', 'PEKERJAAN', 'PROFESI', 'POLI', 'JENIS_KUNJUNGAN', 'NO', 'ANTRIAN_POLI', 'NOMOR_ANTRIAN', 'JENIS', 'JADWAL_DOKTER', 'JENIS_REF_BPJS', 'JENIS_REQUEST_BPJS', 'POLI_EKSEKUTIF_BPJS', 'RAWAT_INAP', 'JENIS_APLIKASI', 'STATUS', 'REF_JADWAL', 'LOKET_RESPON', 'VAKSIN_KE'], 'integer'],
            [['ALAMAT', 'JK'], 'string'],
            [['ID', 'WILAYAH', 'POLI_BPJS', 'REF_POLI_RUJUKAN', 'POS_ANTRIAN'], 'string', 'max' => 10],
            [['NIK'], 'string', 'max' => 16],
            [['NAMA', 'DOKTER', 'CARABAYAR', 'CONTACT', 'JAM', 'JAM_PELAYANAN', 'ESTIMASI_PELAYANAN', 'JAM_PRAKTEK'], 'string', 'max' => 50],
            [['TEMPAT_LAHIR', 'REF'], 'string', 'max' => 100],
            [['INSTANSI_ASAL'], 'string', 'max' => 150],
            [['NO_KARTU_BPJS'], 'string', 'max' => 15],
            [['NO_REF_BPJS'], 'string', 'max' => 75],
            [['SEP'], 'string', 'max' => 20],
            [['ID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TANGGALKUNJUNGAN' => 'Tanggalkunjungan',
            'TANGGAL_REF' => 'Tanggal Ref',
            'NORM' => 'Norm',
            'NIK' => 'Nik',
            'NAMA' => 'Nama',
            'TEMPAT_LAHIR' => 'Tempat Lahir',
            'TANGGAL_LAHIR' => 'Tanggal Lahir',
            'ALAMAT' => 'Alamat',
            'PEKERJAAN' => 'Pekerjaan',
            'INSTANSI_ASAL' => 'Instansi Asal',
            'JK' => 'Jk',
            'WILAYAH' => 'Wilayah',
            'PROFESI' => 'Profesi',
            'POLI' => 'Poli',
            'POLI_BPJS' => 'Poli Bpjs',
            'REF_POLI_RUJUKAN' => 'Ref Poli Rujukan',
            'DOKTER' => 'Dokter',
            'CARABAYAR' => 'Carabayar',
            'JENIS_KUNJUNGAN' => 'Jenis Kunjungan',
            'NO_KARTU_BPJS' => 'No Kartu Bpjs',
            'CONTACT' => 'Contact',
            'TGL_DAFTAR' => 'Tgl Daftar',
            'NO' => 'No',
            'ANTRIAN_POLI' => 'Antrian Poli',
            'NOMOR_ANTRIAN' => 'Nomor Antrian',
            'JAM' => 'Jam',
            'JAM_PELAYANAN' => 'Jam Pelayanan',
            'ESTIMASI_PELAYANAN' => 'Estimasi Pelayanan',
            'POS_ANTRIAN' => 'Pos Antrian',
            'JENIS' => 'Jenis',
            'JADWAL_DOKTER' => 'Jadwal Dokter',
            'NO_REF_BPJS' => 'No Ref Bpjs',
            'JENIS_REF_BPJS' => 'Jenis Ref Bpjs',
            'JENIS_REQUEST_BPJS' => 'Jenis Request Bpjs',
            'POLI_EKSEKUTIF_BPJS' => 'Poli Eksekutif Bpjs',
            'REF' => 'Ref',
            'SEP' => 'Sep',
            'RAWAT_INAP' => 'Rawat Inap',
            'JENIS_APLIKASI' => 'Jenis Aplikasi',
            'STATUS' => 'Status',
            'REF_JADWAL' => 'Ref Jadwal',
            'JAM_PRAKTEK' => 'Jam Praktek',
            'WAKTU_CHECK_IN' => 'Waktu Check In',
            'LOKET_RESPON' => 'Loket Respon',
            'UPDATE_TIME' => 'Update Time',
            'VAKSIN_KE' => 'Vaksin Ke',
        ];
    }
}
