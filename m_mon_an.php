<?php
require_once("database.php");
class M_mon_an extends database
{
	public function lay_mon_an_cho_gio_hang($chuoi)
        {
            $query="Select * from mon_an where ma_mon in($chuoi)";
			$this->setQuery($query);
			return $this->loadAllRows();
        }
	
	public function Tim_mon_an($gtTim)
	{
		$sql="SELECT * FROM mon_an WHERE ten_mon like '%$gtTim%'";
		$this->setQuery($sql);
		return $this->loadAllRows();	
	}
	
	
	public function Doc_mon_an($vt=-1,$limit=-1)
	{
		$sql="select * from mon_an";
		if($vt>=0 && $limit>0)
		{
			$sql.=" limit $vt,$limit";	
		}
		$this->setQuery($sql);
		return $this->loadAllRows();	
	}
	public function Doc_mon_an_theo_ma_mon($ma_mon)
	{
		$sql="select * from mon_an where ma_mon=?";
		$this->setQuery($sql);
		return $this->loadRow(array($ma_mon));
	}
	
	public function Doc_mon_an_trong_ngay($vt=-1,$limit=-1)
	{
		$sql="select * from mon_an where trong_ngay=1";
		if($vt>=0 && $limit>0)
		{
			$sql.=" limit $vt,$limit";	
		}
		$this->setQuery($sql);
		return $this->loadAllRows();	
	}
	
	
	public function Doc_mon_an_cung_loai($ma_loai,$ma_mon,$vt=-1,$limit=-1)
	{
		$sql="select * from mon_an where ma_loai=? and ma_mon!=?";
		if($vt>=0 && $limit>0)
		{
			$sql.=" limit $vt,$limit";	
		}
		$this->setQuery($sql);
		return $this->loadAllRows(array($ma_loai,$ma_mon));	
	}
	
	
	
}
?>