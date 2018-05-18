<?php
include_once("database.php");
class M_thuc_don extends database
{
	public function lay_thuc_don_cho_gio_hang($chuoi)
        {
            $query="Select * from thuc_don where ma_thuc_don in($chuoi)";
			$this->setQuery($query);
			return $this->loadAllRows();
        }
	public function Doc_thuc_don()
	{
		$sql="select * from thuc_don";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function Doc_thuc_don_theo_ma_thuc_don($ma_thuc_don)
	{
		$sql="select * from thuc_don where ma_thuc_don=?";
		$this->setQuery($sql);
		$param=array($ma_thuc_don);
		return $this->loadRow($param);
	}
	
	public function Doc_chi_tiet_thuc_don($ma_thuc_don)
	{
		$sql="SELECT m.* FROM thuc_don_mon_an td INNER JOIN mon_an m ON td.ma_mon=m.ma_mon where ma_thuc_don=?";
		$this->setQuery($sql);
		$param=array($ma_thuc_don);
		return $this->loadAllRows($param);
	}
}
?>