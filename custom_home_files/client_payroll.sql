-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 26, 2024 at 02:47 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `client-payroll`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(55) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `fullname`, `email`, `updationDate`) VALUES
(1, 'admin', 'd00f5d5217896fb7fd601412cb890830', 'Dogoy', 'admin@mail.com', '2023-10-24 09:29:07'),
(5, 'test', '827ccb0eea8a706c4c34a16891f84e7b', 'test', 'test@test.com', '2024-01-18 10:59:12');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `daysWorked` int(200) NOT NULL,
  `overTime` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `startDate` date NOT NULL,
  `endDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `daysWorked`, `overTime`, `created_at`, `updated_at`, `startDate`, `endDate`) VALUES
(3, 1, 20, '', '2023-10-31 16:22:33', '2024-01-24 13:48:50', '2023-09-30', '2023-10-31'),
(4, 15, 23, '', '2023-10-31 16:25:58', '2023-10-31 16:25:58', '2023-10-11', '2023-10-31'),
(5, 16, 22, '5', '2023-10-31 16:25:58', '2024-02-03 10:45:57', '2023-10-11', '2023-10-31'),
(10, 17, 12, '', '2023-11-01 09:08:02', '2023-11-01 09:08:02', '2023-10-11', '2023-11-01'),
(15, 2, 19, '', '2023-11-01 13:25:14', '2023-11-01 13:25:14', '2023-09-01', '2023-11-01'),
(27, 16, 20, '4', '2024-02-14 13:09:49', '2024-02-14 13:09:49', '2024-02-01', '2024-02-29');

-- --------------------------------------------------------

--
-- Table structure for table `comissionData`
--

CREATE TABLE `comissionData` (
  `id` int(11) NOT NULL,
  `payrollMonth` varchar(50) DEFAULT NULL,
  `totalDaysWorkedSkilled` varchar(200) DEFAULT NULL,
  `totalDaysWorkedUnskilled` varchar(200) DEFAULT NULL,
  `rateSkilled` varchar(200) DEFAULT NULL,
  `rateUnskilled` varchar(200) DEFAULT NULL,
  `totalAmountSkilled` varchar(200) DEFAULT NULL,
  `totalAmountUnskilled` varchar(200) DEFAULT NULL,
  `supplierPersonalAmountCredited` varchar(200) DEFAULT NULL,
  `supplierPersonalGroupCosting` varchar(200) DEFAULT NULL,
  `netAmount` varchar(200) DEFAULT NULL,
  `totalSkilledEmployees` varchar(200) DEFAULT NULL,
  `totalUnskilledEmployees` varchar(200) DEFAULT NULL,
  `supplierName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comissionData`
--

INSERT INTO `comissionData` (`id`, `payrollMonth`, `totalDaysWorkedSkilled`, `totalDaysWorkedUnskilled`, `rateSkilled`, `rateUnskilled`, `totalAmountSkilled`, `totalAmountUnskilled`, `supplierPersonalAmountCredited`, `supplierPersonalGroupCosting`, `netAmount`, `totalSkilledEmployees`, `totalUnskilledEmployees`, `supplierName`) VALUES
(1, 'February 2024', '59', '29', '10', '10', '590', '290', '2', '2', '876', NULL, NULL, NULL),
(2, 'February 2024', '59', '29', '1', '1', '59', '29', '1', '1', '86', NULL, NULL, NULL),
(3, 'January 2024', '24', '0', '10', '10', '240', '0', '20', '20', '200', '1', '0', NULL),
(4, 'February 2024', '59', '29', '100', '20', '5900', '580', '10', '100', '6370', '3', '1', ''),
(5, 'February 2024', '59', '29', '100', '20', '5900', '580', '10', '100', '6370', '3', '1', ''),
(6, 'February 2024', '59', '29', '22', '22', '1298', '638', '22', '22', '1892', '3', '1', ''),
(7, 'January 2024', '24', '0', '3', '2', '72', '0', '2', '2', '68', '1', '0', ''),
(8, 'February 2024', '59', '29', '2', '2', '118', '58', '2', '2', '172', '3', '1', ''),
(9, 'February 2024', '59', '29', '3', '3', '177', '87', '3', '3', '258', '3', '1', 'DILIP MAHTO'),
(10, 'February 2024', '59', '29', '2', '2', '118', '58', '2', '2', '172', '3', '1', 'DILIP MAHTO'),
(11, 'January 2024', '24', '0', '12', '1', '288', '0', '1', '1', '286', '1', '0', 'DILIP MAHTO'),
(12, 'March 2024', '24', '0', '20', '10', '480', '0', '10', '20', '450', '1', '0', 'CHANDAN GUPTA'),
(13, 'February 2024', '59', '29', '2', '2', '118', '58', '2', '2', '172', '3', '1', 'DILIP MAHTO'),
(14, 'February 2024', '59', '29', '1', '1', '59', '29', '1', '1', '86', '3', '1', 'DILIP MAHTO'),
(15, 'February 2024', '59', '29', '3', '3', '177', '87', '3', '3', '258', '3', '1', 'DILIP MAHTO'),
(16, 'February 2024', '59', '29', '5', '5', '295', '145', '5', '5', '430', '3', '1', 'DILIP MAHTO'),
(17, 'January 2024', '24', '0', '3', '2', '72', '0', '2', '2', '68', '1', '0', 'DILIP MAHTO'),
(18, 'December 2023', '0', '26', '5', '5', '0', '130', '5', '5', '120', '0', '1', 'DILIP MAHTO');

-- --------------------------------------------------------

--
-- Table structure for table `group_counter`
--

CREATE TABLE `group_counter` (
  `supplier_id` int(11) NOT NULL,
  `counter` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `group_counter`
--

INSERT INTO `group_counter` (`supplier_id`, `counter`) VALUES
(1, 3),
(2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`id`, `code`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 'PAYROLL_65425CC8', '2023-10-01', '2023-11-01', '2023-11-01 14:12:24', '2023-11-01 14:12:24'),
(2, 'PAYROLL_659FF64E', '2024-01-11', '2024-01-27', '2024-01-11 14:08:14', '2024-01-11 14:08:14'),
(3, 'PAYROLL_65CCB8FD', '2024-02-01', '2024-02-29', '2024-02-14 12:58:37', '2024-02-14 12:58:37'),
(4, 'PAYROLL_65D7339D', '2024-03-01', '2024-03-31', '2024-02-22 11:44:29', '2024-02-22 11:44:29'),
(5, 'PAYROLL_65D9BBC2', '2023-12-01', '2023-12-31', '2024-02-24 09:49:54', '2024-02-24 09:49:54');

-- --------------------------------------------------------

--
-- Table structure for table `payslip`
--

CREATE TABLE `payslip` (
  `id` int(11) NOT NULL,
  `siteSelect` varchar(255) DEFAULT NULL,
  `employeeSelect` varchar(255) DEFAULT NULL,
  `rateDisplay` varchar(200) DEFAULT NULL,
  `daysWorked` decimal(10,0) DEFAULT NULL,
  `overTime` varchar(200) DEFAULT NULL,
  `totalAmountDisplay` varchar(200) DEFAULT NULL,
  `advance_in_site` decimal(10,2) DEFAULT NULL,
  `advance_in_home` decimal(10,2) DEFAULT NULL,
  `mess` decimal(10,2) DEFAULT NULL,
  `sunday_expenditure` decimal(10,2) DEFAULT NULL,
  `penalty` varchar(200) DEFAULT NULL,
  `net_pay` varchar(200) NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `payrollID` int(11) DEFAULT NULL,
  `payrollMonth` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payslip`
--

INSERT INTO `payslip` (`id`, `siteSelect`, `employeeSelect`, `rateDisplay`, `daysWorked`, `overTime`, `totalAmountDisplay`, `advance_in_site`, `advance_in_home`, `mess`, `sunday_expenditure`, `penalty`, `net_pay`, `CreationDate`, `payrollID`, `payrollMonth`) VALUES
(49, '9', '17', '123', '26', '1', '1120653', '100.00', '311.00', '231.00', '200.00', '0', '1119821.25', '2024-02-20 16:38:18', 3, 'February 2024'),
(52, '1', '1', '100', '29', '1', '2400', '0.00', '0.00', '0.00', '0.00', '0', '2408.3333333333335', '2024-02-20 17:15:30', 3, 'February 2024'),
(53, '1', '15', '12121', '8', '7', '96968', '0.00', '0.00', '0.00', '0.00', '0', '104038.58333333333', '2024-02-20 17:18:26', 3, 'February 2024'),
(54, '9', '17', '123', '24', '6', '2952', '0.00', '0.00', '0.00', '0.00', '0', '3013.5', '2024-02-21 15:58:26', 2, 'January 2024'),
(56, '1', '2', '2000', '24', '1', '48000', '0.00', '0.00', '0.00', '0.00', '0', '48166.666666666664', '2024-02-22 11:48:57', 4, 'March 2024'),
(57, '1', '18', '1000', '25', '6', '25000', '0.00', '0.00', '0.00', '0.00', '0', '25500', '2024-02-24 09:41:26', 3, 'February 2024'),
(58, '1', '1', '100', '26', '1', '2600', '0.00', '0.00', '0.00', '0.00', '0', '2608.3333333333335', '2024-02-24 09:50:27', 5, 'December 2023');

-- --------------------------------------------------------

--
-- Table structure for table `tbldesignation`
--

CREATE TABLE `tbldesignation` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbldesignation`
--

INSERT INTO `tbldesignation` (`id`, `name`, `status`, `CreationDate`) VALUES
(1, 'MASON', 'skilled', '2024-02-22 16:30:19'),
(3, 'FITTER', 'skilled', '2024-02-22 16:30:25'),
(4, 'FITTER HELPER', 'unskilled', '2024-02-22 16:31:27'),
(5, 'CARPENTER', 'skilled', '2024-02-22 16:30:32'),
(6, 'CARPENTER HELPER', 'unskilled', '2024-02-22 16:31:37'),
(7, 'COOK HELPER', 'unskilled', '2024-02-22 16:31:40'),
(8, 'SENIOR SUPERVISOR', 'skilled', '2024-02-22 16:30:50'),
(9, 'JUNIOR SUPERVISOR', 'unskilled', '2024-02-22 16:31:43'),
(10, 'MANAGER', 'unskilled', '2024-02-22 16:31:45'),
(11, 'CHIPPER', 'skilled', '2024-02-22 16:31:04'),
(12, 'WELDER', 'skilled', '2024-02-22 16:31:06'),
(13, 'POWER TOOL OPERATOR', 'skilled', '2024-02-22 16:31:13'),
(15, 'COOK', 'skilled', '2024-02-22 16:30:44');

-- --------------------------------------------------------

--
-- Table structure for table `tblemployees`
--

CREATE TABLE `tblemployees` (
  `id` int(11) NOT NULL,
  `EmpId` varchar(100) NOT NULL,
  `FirstName` varchar(150) NOT NULL,
  `LastName` varchar(150) NOT NULL,
  `Gender` varchar(100) NOT NULL,
  `Dob` varchar(100) NOT NULL,
  `doj` varchar(200) NOT NULL,
  `govID` varchar(200) NOT NULL,
  `rate` varchar(200) NOT NULL,
  `Status` int(1) NOT NULL,
  `Site` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `designation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblemployees`
--

INSERT INTO `tblemployees` (`id`, `EmpId`, `FirstName`, `LastName`, `Gender`, `Dob`, `doj`, `govID`, `rate`, `Status`, `Site`, `supplier_id`, `group_id`, `CreationDate`, `designation`) VALUES
(1, '202310004', 'wari', 'beira', 'Male', '2023-10-03', '2023-10-21', '909090', '100', 0, 1, 2, NULL, '2024-02-22 16:34:39', 4),
(2, '202310005', 'issa', 'moussa', 'Male', '2023-10-06', '2023-10-21', '988888', '2000', 1, 1, 1, NULL, '2024-02-22 16:03:47', 1),
(15, '202310001', 'ali', 'tahir', 'Male', '2023-10-03', '2023-10-19', 'fdfdf', '12121', 1, 1, 2, NULL, '2024-02-22 16:03:51', 15),
(16, '202310002', 'saleh', 'hamit', 'Female', '2023-10-12', '2023-10-11', 'jhjhjhj', '888', 1, 2, NULL, NULL, '2024-02-22 16:03:55', 8),
(17, '202310003', 'mahamat', 'herry', 'Male', '2023-09-14', '2023-10-24', 'gfgfgf', '123', 1, 9, 2, 6, '2024-02-22 16:03:58', 3),
(18, '202311001', 'oumar', 'mahamat', 'Male', '2023-11-23', '2023-10-17', '123456', '1000', 1, 1, 2, 6, '2024-02-22 16:04:03', 13);

-- --------------------------------------------------------

--
-- Table structure for table `tblgroup`
--

CREATE TABLE `tblgroup` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `totalHomeAdvance` decimal(10,2) DEFAULT NULL,
  `trainAllowance` decimal(10,2) DEFAULT NULL,
  `travelCost` decimal(10,2) DEFAULT NULL,
  `fooding` decimal(10,2) DEFAULT NULL,
  `trainTicketCost` decimal(10,2) DEFAULT NULL,
  `personalCosting` decimal(10,2) DEFAULT NULL,
  `others` decimal(10,2) DEFAULT NULL,
  `totalCreditedAmount` varchar(200) DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblgroup`
--

INSERT INTO `tblgroup` (`id`, `name`, `supplier_id`, `totalHomeAdvance`, `trainAllowance`, `travelCost`, `fooding`, `trainTicketCost`, `personalCosting`, `others`, `totalCreditedAmount`, `creation_date`) VALUES
(4, 'CHANDAN_GUPTA_Group_0001', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2023-11-20 13:17:50'),
(5, 'CHANDAN_GUPTA_Group_0002', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2023-11-20 13:18:49'),
(6, 'DILIP_MAHTO_Group_0001', 2, '6000.00', '40.00', '40.00', '40.00', '40.00', '40.00', '10.00', '7000.00', '2023-11-20 13:19:07'),
(7, 'CHANDAN_GUPTA_Group_0003', 1, NULL, '10.00', '10.00', '10.00', '10.00', '10.00', '0.00', '0', '2023-11-27 14:27:58'),
(8, 'DILIP_MAHTO_Group_0006', 2, '10.00', '20.00', '20.00', '20.00', '20.00', '20.00', '0.00', '4000', '2023-11-27 14:58:32'),
(9, 'DILIP_MAHTO_Group_0007', 2, '3000.00', '30.00', '30.00', '30.00', '30.00', '100.00', '10.00', '5000', '2023-11-28 09:58:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblleaves`
--

CREATE TABLE `tblleaves` (
  `id` int(11) NOT NULL,
  `LeaveType` varchar(110) NOT NULL,
  `ToDate` varchar(120) NOT NULL,
  `FromDate` varchar(120) NOT NULL,
  `Description` mediumtext NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `AdminRemark` mediumtext DEFAULT NULL,
  `AdminRemarkDate` varchar(120) DEFAULT NULL,
  `Status` int(1) NOT NULL,
  `IsRead` int(1) NOT NULL,
  `empid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblleavetype`
--

CREATE TABLE `tblleavetype` (
  `id` int(11) NOT NULL,
  `LeaveType` varchar(200) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblleavetype`
--

INSERT INTO `tblleavetype` (`id`, `LeaveType`, `Description`, `CreationDate`) VALUES
(1, 'Casual Leave', 'Provided for urgent or unforeseen matters to the employees.', '2020-11-01 12:07:56'),
(2, 'Medical Leave', 'Related to Health Problems of Employee', '2020-11-06 13:16:09'),
(3, 'Restricted Holiday', 'Holiday that is optional', '2020-11-06 13:16:38'),
(5, 'Paternity Leave', 'To take care of newborns', '2021-03-03 10:46:31'),
(6, 'Bereavement Leave', 'Grieve their loss of losing loved ones', '2021-03-03 10:47:48'),
(7, 'Compensatory Leave', 'For Overtime workers', '2021-03-03 10:48:37'),
(8, 'Maternity Leave', 'Taking care of newborn ,recoveries', '2021-03-03 10:50:17'),
(9, 'Religious Holidays', 'Based on employee\'s followed religion', '2021-03-03 10:51:26'),
(10, 'Adverse Weather Leave', 'In terms of extreme weather conditions', '2021-03-03 13:18:26'),
(11, 'Voting Leave', 'For official election day', '2021-03-03 13:19:06'),
(12, 'Self-Quarantine Leave', 'Related to COVID-19 issues', '2021-03-03 13:19:48'),
(13, 'Personal Time Off', 'To manage some private matters', '2021-03-03 13:21:10');

-- --------------------------------------------------------

--
-- Table structure for table `tblsite`
--

CREATE TABLE `tblsite` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblsite`
--

INSERT INTO `tblsite` (`id`, `name`, `city`, `CreationDate`) VALUES
(1, 'HTS', 'Kanyakumari', '2024-01-17 09:13:50'),
(2, 'CMRL-02', 'Chennai', '2023-10-21 09:15:37'),
(9, 'MAIN PLANT', 'Kanyakumari', '2023-10-21 09:16:17');

-- --------------------------------------------------------

--
-- Table structure for table `tblsupplier`
--

CREATE TABLE `tblsupplier` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblsupplier`
--

INSERT INTO `tblsupplier` (`id`, `name`, `creation_date`) VALUES
(1, 'CHANDAN GUPTA', '2023-11-20 10:28:25'),
(2, 'DILIP MAHTO', '2023-11-20 13:18:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `comissionData`
--
ALTER TABLE `comissionData`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_counter`
--
ALTER TABLE `group_counter`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payslip`
--
ALTER TABLE `payslip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payroll` (`payrollID`);

--
-- Indexes for table `tbldesignation`
--
ALTER TABLE `tbldesignation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblemployees`
--
ALTER TABLE `tblemployees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Site` (`Site`),
  ADD KEY `fk_supplier` (`supplier_id`),
  ADD KEY `fk_group` (`group_id`),
  ADD KEY `fk_designation` (`designation`);

--
-- Indexes for table `tblgroup`
--
ALTER TABLE `tblgroup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `tblleaves`
--
ALTER TABLE `tblleaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UserEmail` (`empid`);

--
-- Indexes for table `tblleavetype`
--
ALTER TABLE `tblleavetype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblsite`
--
ALTER TABLE `tblsite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblsupplier`
--
ALTER TABLE `tblsupplier`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `comissionData`
--
ALTER TABLE `comissionData`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payslip`
--
ALTER TABLE `payslip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `tbldesignation`
--
ALTER TABLE `tbldesignation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tblemployees`
--
ALTER TABLE `tblemployees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tblgroup`
--
ALTER TABLE `tblgroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblleaves`
--
ALTER TABLE `tblleaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblleavetype`
--
ALTER TABLE `tblleavetype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tblsite`
--
ALTER TABLE `tblsite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblsupplier`
--
ALTER TABLE `tblsupplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `tblemployees` (`id`);

--
-- Constraints for table `payslip`
--
ALTER TABLE `payslip`
  ADD CONSTRAINT `fk_payroll` FOREIGN KEY (`payrollID`) REFERENCES `payroll` (`id`);

--
-- Constraints for table `tblemployees`
--
ALTER TABLE `tblemployees`
  ADD CONSTRAINT `FK_Site` FOREIGN KEY (`Site`) REFERENCES `tblsite` (`id`),
  ADD CONSTRAINT `fk_designation` FOREIGN KEY (`designation`) REFERENCES `tbldesignation` (`id`),
  ADD CONSTRAINT `fk_group` FOREIGN KEY (`group_id`) REFERENCES `tblgroup` (`id`),
  ADD CONSTRAINT `fk_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `tblsupplier` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
