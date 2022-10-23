SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `bt` (
  `id` varchar(100) NOT NULL,
  `tieu_de` varchar(100) NOT NULL,
  `id_gv` varchar(100) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `updateon` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `game` (
  `id` varchar(100) NOT NULL,
  `tieu_de` varchar(100) NOT NULL,
  `id_gv` varchar(100) NOT NULL,
  `goi_y` varchar(10000) NOT NULL,
  `updateon` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `nop_bt` (
  `id` varchar(100) NOT NULL,
  `id_bt` varchar(100) NOT NULL,
  `id_sv` varchar(100) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `updateon` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `nt` (
  `id` varchar(100) NOT NULL,
  `id_gui` varchar(100) NOT NULL,
  `id_nhan` varchar(100) NOT NULL,
  `nd` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `sv` (
  `id` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `code` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `SDT` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `avatar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `sv` (`id`, `username`, `pass`, `code`, `name`, `SDT`, `email`, `avatar`) VALUES
('1', 'teacher1', 'f83e69e4170a786e44e3d32a2479cce9', 1, 'Nguyễn Xuân Hoàng', '0987532623', 'gv_hoangnx@gmail.com', ''),
('2', 'teacher2', 'f83e69e4170a786e44e3d32a2479cce9', 1, 'Phạm Văn Khánh', '0954343245', 'gv_khanhpv@gmail.com', ''),
('3', 'student1', 'f83e69e4170a786e44e3d32a2479cce9', 2, 'Phạm Tiến Dũng', '0917832723', 'sv_dungpt@gmai.com', 'hinh-nen-4k-laptop-va-pc.jpg'),
('4', 'student2', 'f83e69e4170a786e44e3d32a2479cce9', 2, 'Hà Nam Anh', '0765432456', 'sv_namhn@gmail.com', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
