<?php
include_once("database.php");
class M_lien_he extends database
{
	// ma_lien_he, ho_ten, email, noi_dung, ngay_gui, trang_thai
	public function Them_lien_he($ho_ten, $email,$noi_dung)
	{
		$sql="INSERT INTO lien_he VALUES(?,?,?,?,?,?)";
		$this->setQuery($sql);
		$param=array(NULL,$ho_ten, $email,$noi_dung,date("Y-m-d"),0);
		return $this->execute($param);	
	}
	
}
?>