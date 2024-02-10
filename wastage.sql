get free serial no for Pending Configuration 

SELECT a.serial_no FROM `inventory` a left join ipconfuration b on a.serial_no = b.serial_no where b.status<>1;
