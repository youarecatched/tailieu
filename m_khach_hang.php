<?php
    require_once('database.php');
    class M_khach_hang extends database {
        function khach_hang_hoa_don() {
            $query = 'SELECT hd.ma_hoa_don, ngay_dat, kh.ma_khach_hang, ten_khach_hang, dia_chi, dien_thoai,email, tong_tien, mon_an.ma_mon, ten_mon, so_luong, mon_an.don_gia, mon_an.don_gia*so_luong as thanh_tien, hinh FROM hoa_don hd, khach_hang kh, mon_an, chi_tiet_hoa_don ct WHERE hd.ma_hoa_don = ct.ma_hoa_don AND hd.ma_khach_hang = kh.ma_khach_hang AND ct.ma_mon = mon_an.ma_mon Order by  kh.ma_khach_hang';
            $this->setQuery($query);
			$khachhangs=$this->loadAllRows();
			$mang=array();
			foreach($khachhangs as $row)
			{
				$mang[]=$row;
			}
            return $mang;
        }
        function themKhachHang($ten_khach_hang, $email, $dia_chi, $dien_thoai, $ghi_chu) {
            $query = "INSERT INTO khach_hang(ten_khach_hang, email, dia_chi, dien_thoai, ghi_chu) ";
            $query.= "VALUES(?,?,?,?,?)";
            $this->setQuery($query);
            $result = $this->execute(array($ten_khach_hang, $email, $dia_chi, $dien_thoai, $ghi_chu));
            if($result)
                return $this->getLastId();  //If query execute successful, the system will return lastID in table khach_hang
            else
            
                return false;
        }
        
        function themHoaDon($ma_khach_hang, $ngay_dat, $tong_tien,$tien_dat_coc,$con_lai,$hinh_thuc_thanh_toan) {
            $query = "INSERT INTO hoa_don(ma_khach_hang, ngay_dat, tong_tien,tien_dat_coc,con_lai,hinh_thuc_thanh_toan) VALUES(?,?,?,?,?,?)";
            $this->setQuery($query);
            $result = $this->execute(array($ma_khach_hang, $ngay_dat, $tong_tien,$tien_dat_coc,$con_lai,$hinh_thuc_thanh_toan));
            if($result) 
                return $this->getLastId();
            else
                return false;
        }
        
        function themChiTietHoaDon($ma_hoa_don, $ma_mon, $so_luong, $don_gia, $mon_thuc_don) {
            $query = "INSERT INTO chi_tiet_hoa_don(ma_hoa_don, ma_mon, so_luong, don_gia, mon_thuc_don) VALUES(?,?,?,?,?)";
            $this->setQuery($query);
            $this->execute(array($ma_hoa_don, $ma_mon, $so_luong, $don_gia, $mon_thuc_don));
        }
        
        function capNhatDonGia_mon($ma_hoa_don) {
            $query = "UPDATE chi_tiet_hoa_don ";
            $query.= "SET don_gia = (SELECT don_gia FROM mon_an WHERE chi_tiet_hoa_don.ma_mon = mon_an.ma_mon) ";
            $query.= "WHERE mon_thuc_don=1 and ma_hoa_don = ?";
            $this->setQuery($query);
            $this->execute(array($ma_hoa_don));
        }
        
        function capNhatDonGia_thuc_don($ma_hoa_don) {
            $query = "UPDATE chi_tiet_hoa_don ";
            $query.= "SET don_gia = (SELECT don_gia FROM thuc_don WHERE chi_tiet_hoa_don.ma_mon = thuc_don.ma_thuc_don) ";
            $query.= "WHERE mon_thuc_don=0 and ma_hoa_don = ?";
            $this->setQuery($query);
            $this->execute(array($ma_hoa_don));
        }
        
        function capNhatTongTien($ma_hoa_don)
        {
            $query = "UPDATE hoa_don ";
            $query.= "SET tong_tien = (SELECT SUM( so_luong * don_gia ) AS tt FROM chi_tiet_hoa_don WHERE chi_tiet_hoa_don.ma_hoa_don = hoa_don.ma_hoa_don) ";
            $query.= "WHERE ma_hoa_don = ?";
            $this->setQuery($query);
            $this->execute(array($ma_hoa_don));
        }
        function capNhatTienConLai($ma_hoa_don)
        {
            $query = "UPDATE hoa_don ";
            $query.= "SET con_lai = tong_tien-tien_dat_coc ";
            $query.= "WHERE ma_hoa_don = ?";
            $this->setQuery($query);
            $this->execute(array($ma_hoa_don));
        }
        function getChiTietHoaDon($ma_hoa_don) {
            $query = "SELECT hd.so_hoa_don, ngay_hd, kh.ma_khach_hang, ten_khach_hang, phai, ngay_sinh, dia_chi, dien_thoai, ";
            $query.= "email, tri_gia, sp.ma_san_pham, ten_san_pham, so_luong, sp.don_gia, sp.don_gia*so_luong as thanh_tien, hinh ";
            $query.= "FROM hoa_don hd, khach_hang kh, san_pham sp, ct_hoa_don ct ";
            $query.= "WHERE hd.so_hoa_don = ct.so_hoa_don AND hd.ma_khach_hang = kh.ma_khach_hang AND ct.ma_san_pham = sp.ma_san_pham ";
            $query.= "AND hd.so_hoa_don = ?";
            $this->setQuery($query);
            return $this->loadAllRows(array($ma_hoa_don));
        }
        public function lay_hoa_don($key)
        {
            $query = "SELECT khach_hang.ma_khach_hang,ten_khach_hang, email, dia_chi, dien_thoai,
                    hoa_don.ma_hoa_don,ngay_dat,tong_tien,tien_dat_coc,con_lai,hinh_thuc_thanh_toan,chi_tiet_hoa_don.ma_mon,
                    so_luong,chi_tiet_hoa_don.don_gia,mon_thuc_don FROM khach_hang,hoa_don,chi_tiet_hoa_don 
                    WHERE hoa_don.ma_khach_hang=khach_hang.ma_khach_hang and hoa_don.ma_hoa_don=chi_tiet_hoa_don.ma_hoa_don and khach_hang.ma_khach_hang=?";
            $this->setQuery($query);
            return $this->loadAllRows(array($key));
        }
    } 
?>