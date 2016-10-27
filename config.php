<?php
//error_reporting(0);
date_default_timezone_set("Asia/Kolkata");
/* -----Database values----- */
define('DB_HOST', 'localhost');
define('DB_USER', 'cosytree_rs');
//define('DB_USER', 'root');
define('DB_DATABASE', 'cosytree_rs');
//define('DB_PASS', '');
define('DB_PASS', 'iZXbVFs6=5{B');
/* -----/Database values----- */

/* -----Tables------ */
define('USERS', 'rs_user_master');
define('ROLES', 'rs_role_master');
define('STATE', 'rs_state_master');
define('CITY', 'rs_city_master');
define('COUNTRY', 'rs_country_master');
define('CPROFILE', 'rs_company_profile_master');
define('BGROUP', 'rs_blood_group_master');
define('EBASIC', 'rs_employee_basic_master');
// Added By Raviraj Start
define('MBANKMASTER', 'rs_bank_master');

//Employee Management Section
define('MEMPLOYEEEDU', 'rs_employee_education_master');
define('MEMPLOYEEEXP', 'rs_employee_experience_master');
define('MEMPLOYEESAL', 'rs_employee_salary_master');
define('MDEPARTMENTMASTER', 'rs_department_master');
define('MSUBDEPARTMENTMASTER', 'rs_sub_department');
define('MREPORTINGMANGER', 'rs_reporting_managers');
define('MDESIGNATION', 'rs_designation_master');
define('MHOLIDAY', 'rs_holiday_master');
define('MSALARY', 'rs_salary_master');
define('MATTENDENCE', 'rs_attendance_master');
define('MLEAVECATEGORY', 'rs_leave_category_master');

//Unit Section
define('MUNITTYPES', 'rs_unit_type');
define('MUNITMANAGEMENT', 'rs_unit_management');
define('MFLOORMANAGEMENT', 'rs_floor_management');
define('MUNITRENTPAYMENT', 'rs_unit_rent_payment');
define('MUNITOWNER', 'rs_unit_owner');
define('MUNITROOMMGMT', 'rs_unit_room_management_master');
define('MUNITROOM', 'rs_unit_room_master');
define('MUNITBED', 'rs_unit_bed_master');

//Venodor section 
define('MVENDORMASTERS', 'rs_vendor_master');
define('MVENDORBILLS', 'rs_vendor_bills_master');
define('MVENDORBILLDETAILS', 'rs_vendor_bill_details_master');
define('MSUPPLIERCATEGORY', 'rs_supplier_category_master');
define('MQUANTITYMEASUREMENTS', 'rs_quantity_measurement_master');
define('MPRODUCTITEM', 'rs_product_item_master');
define('MINVENTORY', 'rs_inventory_master');
define('MINVENTORYDETAILS', 'rs_inventory_details_master');

/* -----/Tables------ */

/* -----Server paths----- */
define('ROOT', $_SERVER['DOCUMENT_ROOT']) . '/rs';
define('WEBSITE', 'http://' . $_SERVER['SERVER_NAME']) . '/rs';
define('PRODUCT_TEMP_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '/rs/admin');
define('Gallery', $_SERVER['DOCUMENT_ROOT'] . '/rs/admin/gallery');
define('UPLOAD', $_SERVER['DOCUMENT_ROOT'] . '/rs/uploads');
define('SYM', '/');
define('CLOGO', 'logo/');
define('HOME','?url=dashboard&sessionid=' . $_SESSION['sessionid'] . '');
/* -----/Server paths----- */

/* ---------Social URL------- */
define('FACEBOOK', 'https://www.facebook.com/');
define('LINKEDIN', 'https://www.linkedin.com/');
/* ---------Social URL------- */


define('PROJECT','ROOMSOOM');
?>