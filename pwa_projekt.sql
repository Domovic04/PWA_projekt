-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jun 24, 2025 at 09:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pwa_projekt`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `ID` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_mysql561_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`ID`, `username`, `password`) VALUES
(10, 'mamut', '$2y$10$aN/ERwuXxqBwFnnAknosIugbxQu6luKpes3BI0saOL5ArlUFDC8BW'),
(11, 'admin', '$2y$10$TEGbWMzWtA5YSApBGy9C8.IDnKhJ8YgyQpU7sOakw7ejwzzSRfEVy');

-- --------------------------------------------------------

--
-- Table structure for table `vijesti`
--

CREATE TABLE `vijesti` (
  `id` int(11) NOT NULL,
  `naslov` varchar(255) NOT NULL,
  `podnaslov` varchar(255) NOT NULL,
  `slika` varchar(255) DEFAULT NULL,
  `sadrzaj` text NOT NULL,
  `kategorija` enum('Vozač','Formula') NOT NULL,
  `prikaz` tinyint(1) DEFAULT 0,
  `datum` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_mysql561_ci;

--
-- Dumping data for table `vijesti`
--

INSERT INTO `vijesti` (`id`, `naslov`, `podnaslov`, `slika`, `sadrzaj`, `kategorija`, `prikaz`, `datum`) VALUES
(1, 'Lewis Hamilton', 'GOAT', 'hamilton.jpeg', 'Lewis Hamilton je poznat po svom agresivnom i zanimljivom načinu vožnje. Također je poznat po svom oštrom ulasku u zavoj.Povjerenje u kontrolu automobila Hamiltonu omogućuje izvrsnu vožnju u kišnim uvjetima što je bio dokaz na Velikoj nagradi Velike Britanije 2008. godine. Samouvjerenost je pokazao i tijekom pretjecanja, što je odrazilo 32 pretjecanja u četiri utrke tijekom sezone 2010.Njegov agresivni način vožnje ponekad privlači pozornost kritičara. U sezoni 2010. tijekom Velike nagrade Malezije 2010. kritičari su tvrdili da je obrambena vožnja Hamiltona bila namjera slomiti ravnotežu Renaultu za čijim je upravljačem bio Vitalij Petrov. Hamilton se ubrzo obranio od tih optužbi, ali je voditelj utrka Charlie Whiting proglasio da će se ubuduće kažnjavati takva vožnja. Lewis Hamilton je na Velike nagrade Malezije 2011. godine bio kažnjen zbog istog prekomjernog krivudanja stazom zajedno s bivšim timskim kolegom Fernandom Alonsom. Na Velikoj nagradi Monaka 2011. godine ponovno je kažnjen zbog namjernog sudara s Pastorom Maldonadom, vozačem Williamsa.', 'Vozač', 1, '2025-06-14 20:37:45'),
(2, 'Max Verstappen', 'Mad Max', 'max-verstappen-red-bull-racing-helmet-ieas0xpn0ab388xw.jpg', 'Max Emilian Verstappen (Hasselt, Belgija, 30. rujna 1997.) je nizozemski vozač Formule 1 za momčad Red Bulla, aktualni svjetski prvak u Formuli 1 te sin bivšeg vozača Formule 1 Josa Verstappena. U kartingu je osvojio preko dvadeset naslova prvaka u raznim kategorijama, a 2014. osvojio je treće mjesto u Europskoj Formuli 3 za momčad Van Amersfoort Racing. U Formuli 1 se natječe od 2015.', 'Vozač', 1, '2025-06-14 20:38:02'),
(3, 'Fernando Alonso', 'Rookie of the year', 'F99jKEdW8AAqeMq.jpg', '\r\nFernando Alonso Díaz (Oviedo, Asturija, 29. srpnja 1981.) španjolski je vozač automobilističkih utrka. Dvostruki je svjetski prvak Formule 1, prvak FIA Svjetskog prvenstva u utrkama izdržljivosti (WEC) te jedini vozač u povijesti koji je dva puta uvršten u FIA-inu Kuću slavnih. Dvostruki je pobjednik utrke 24 sata Le Mansa te pobjednik utrke 24 sata Daytone. Često ga se smatra jednim od najboljih i najkompletnijih vozača u Formuli 1.', 'Vozač', 1, '2025-06-14 20:50:34'),
(4, 'Charles Leclerc', 'Monaco prince', 'Charles-Leclerc-scaled-1.jpeg', 'Puno mu je ime Charles Marc Hervé Perceval Leclerc. Otac mu je bio Hervé Leclerc, a majka mu je Pascale. Charles Leclerc ima starijeg brata, Lorenza te mlađeg, Arthura. Djed mu je bio Charles Manni - osnivač tvrtke Mecaplast (koja je kasnije preimenovana u Novares Group), a koju trenutno vodi Leclercov ujak, Thierry Manni. Leclercov otac, Hervé, u 80-ima i 90-im godinama 20. stoljeća natjecao se u Formuli 3. Osim francuskog jezika, Leclerc govori i talijanski i engleski jezik. U vezi je s Alexandrom Saint-Mleux.', 'Vozač', 1, '2025-06-14 20:51:06'),
(5, 'AMR25', 'Bolid Aston Martin', 'AMR25_Hero_Desktop.webp', 'The Aston Martin Formula 1 team will compete with the AMR25 in the 2025 season. The car is designed to be more driveable and stable, with a focus on airflow management and performance improvements, especially in the transient phases of cornering. It will be driven by Fernando Alonso and Lance Stroll.', 'Formula', 1, '2025-06-14 20:54:38'),
(6, 'RedBull RB21', 'Bolid RedBull', '2025-red-bull-racing-rb21-f1-race-car_100956874.jpg', 'The Red Bull RB21 is Red Bull Racing\'s Formula One car for the 2025 season, featuring Max Verstappen and Liam Lawson as drivers. The car is an evolution of the previous RB20 and is powered by the Honda RBPTH003 power unit. Red Bull aims to reclaim the Teams\' championship with the RB21 after finishing third in 2024.', 'Formula', 1, '2025-06-14 20:55:37'),
(7, 'FW47', 'Bolid Williams Racing tima', '2025-Formula1-Williams-FW47-001-1080.jpg', 'The Williams FW47 is a Formula One racing car designed and constructed by Williams competing in the 2025 Formula One World Championship. The car is being driven by Alexander Albon and Carlos Sainz Jr.The car was launched on 14 February 2025 at Silverstone Circuit in a one-off camo livery; it was driven by Sainz.', 'Formula', 1, '2025-06-14 20:56:40'),
(8, 'F1-75', 'Bolid Ferrari Scuderia ', '2022-Formula1-Ferrari-F1-75-011-1080.jpg', 'The Ferrari F1-75 (also known by its internal name, Project 674 is a Formula One racing car designed and constructed by Scuderia Ferrari which competed in the 2022 Formula One World Championship.', 'Formula', 1, '2025-06-14 20:57:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `un_username` (`username`);

--
-- Indexes for table `vijesti`
--
ALTER TABLE `vijesti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vijesti`
--
ALTER TABLE `vijesti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
