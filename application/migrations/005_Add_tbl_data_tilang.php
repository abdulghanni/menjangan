<?php 

defined("BASEPATH") OR exit("No direct script access allowed");

class Migration_Add_tbl_data_tilang extends CI_Migration 
{

    public function __construct()
    {
        $this->load->dbforge();
        $this->load->database();
    }

    public function up() 
    {
        $fields["tilangid"]["type"] = "int";
        $fields["tilangid"]["constraint"] = "11";
        $fields["tilangid"]["default"] = "";
        $this->dbforge->add_key("tilangid");
        $fields["kec_id"]["type"] = "int";
        $fields["kec_id"]["constraint"] = "11";
        $fields["kec_id"]["default"] = "";
        $fields["nomor_tilang"]["type"] = "varchar";
        $fields["nomor_tilang"]["constraint"] = "255";
        $fields["nomor_tilang"]["default"] = "";
        $fields["tanggal_sidang"]["type"] = "timestamp";
        $fields["tanggal_sidang"]["constraint"] = "";
        $fields["tanggal_sidang"]["default"] = "CURRENT_TIMESTAMP";
        $fields["nama_lengkap"]["type"] = "text";
        $fields["nama_lengkap"]["constraint"] = "";
        $fields["nama_lengkap"]["default"] = "";
        $fields["foto"]["type"] = "varchar";
        $fields["foto"]["constraint"] = "255";
        $fields["foto"]["default"] = "";
        $fields["kecamatan"]["type"] = "varchar";
        $fields["kecamatan"]["constraint"] = "500";
        $fields["kecamatan"]["default"] = "";
        $fields["tanggal_pengambilan"]["type"] = "varchar";
        $fields["tanggal_pengambilan"]["constraint"] = "255";
        $fields["tanggal_pengambilan"]["default"] = "";
        $fields["nomor_hp"]["type"] = "varchar";
        $fields["nomor_hp"]["constraint"] = "45";
        $fields["nomor_hp"]["default"] = "";
        $fields["alamat"]["type"] = "varchar";
        $fields["alamat"]["constraint"] = "255";
        $fields["alamat"]["default"] = "";
        $fields["bb_id"]["type"] = "int";
        $fields["bb_id"]["constraint"] = "255";
        $fields["bb_id"]["default"] = "";
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('tbl_data_tilang',true);
    }

    public function down() {
        $this->dbforge->drop_table('tbl_data_tilang',true);
    }

}

/* Location: application/migrations/005_Add_tbl_data_tilang.php */