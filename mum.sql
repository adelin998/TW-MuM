-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2020 at 05:10 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mum`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `artist_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `date_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`artist_id`, `name`, `image`, `date_added`) VALUES
(1, 'Katy Perry', 'katyperry.jpg_large', '2020-06-07'),
(2, 'Demi Lovato', '', '2020-06-07'),
(3, 'Ali Gatie', '', '2020-06-07');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` varchar(100) NOT NULL,
  `title` text NOT NULL,
  `artist` text NOT NULL,
  `album` text NOT NULL,
  `data` text NOT NULL,
  `image` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `title`, `artist`, `album`, `data`, `image`) VALUES
('017PF4Q3l4DBUiWoXk4OWT', 'Break My Heart', 'Dua Lipa', 'Future Nostalgia', '2020-03-27', 'https://i.scdn.co/image/ab67616d0000b273c966c2f4e08aee0442b6b8d6'),
('06s3QtMJVXw1AJX3UfvZG1', 'Hasta Que Dios Diga', 'Anuel AA , Bad Bunny', 'Emmanuel', '2020-05-29', 'https://i.scdn.co/image/ab67616d0000b2733cb695bfc1246bdf66161fce'),
('0nbXyq5TXYPCO7pr3N8S4I', 'The Box', 'Roddy Ricch', 'Please Excuse Me For Being Antisocial', '2019-12-06', 'https://i.scdn.co/image/ab67616d0000b273600adbc750285ea1a8da249f'),
('0SqqAgdovOE24BzxIClpjw', 'Yo Perreo Sola', 'Bad Bunny', 'YHLQMDLG', '2020-02-28', 'https://i.scdn.co/image/ab67616d0000b273548f7ec52da7313de0c5e4a0'),
('0VjIjW4GlUZAMYd2vXMi3b', 'Blinding Lights', 'The Weeknd', 'After Hours', '2020-03-20', 'https://i.scdn.co/image/ab67616d0000b2738863bc11d2aa12b54f5aeb36'),
('1Cv1YLb4q0RzL6pybtaMLo', 'Sunday Best', 'Surfaces', 'Where the Light Is', '2019-01-06', 'https://i.scdn.co/image/ab67616d0000b2733667dc27da7b24360d6050d0'),
('1jaTQ3nqY3oAAYyCTbIvnM', 'WHATS POPPIN', 'Jack Harlow', 'Sweet Action', '2020-03-13', 'https://i.scdn.co/image/ab67616d0000b27305a448540b069450ccfba889'),
('1K5KBOgreBi5fkEHvg5ap3', 'Life Is Good (feat. Drake)', 'Future , Drake', 'High Off Life', '2020-05-15', 'https://i.scdn.co/image/ab67616d0000b273935d8d5369bc55e74a39303e'),
('1mohfLaTJtB2RplHLQVM70', 'La Jeepeta - Remix', 'Nio Garcia , Anuel AA , Myke Towers , Brray , Juanka', 'La Jeepeta (Remix)', '2020-04-24', 'https://i.scdn.co/image/ab67616d0000b2735a89169ff864c80931b2b073'),
('1rgnBhdG2JDFTbYkYRZAku', 'Dance Monkey', 'Tones And I', 'Dance Monkey', '2019-05-10', 'https://i.scdn.co/image/ab67616d0000b27338802659d156935ada63c9e3'),
('1sgDyuLooyvEML4oHspNza', 'Lose Somebody', 'Kygo , OneRepublic', 'Golden Hour', '2020-05-29', 'https://i.scdn.co/image/ab67616d0000b27380368f0aa8f90c51674f9dd2'),
('1xQ6trAsedVPCdbtDAmk0c', 'Savage Love (Laxed - Siren Beat)', 'Jawsh 685 , Jason Derulo', 'Savage Love (Laxed - Siren Beat)', '2020-06-11', 'https://i.scdn.co/image/ab67616d0000b273e3eb3b8feeafb746ecf659e7'),
('22LAwLoDA5b4AaGSkg6bKW', 'Blueberry Faygo', 'Lil Mosey', 'Certified Hitmaker', '2020-02-06', 'https://i.scdn.co/image/ab67616d0000b2730824105a6282782aaabb0584'),
('24IgCW19L8lXKyFZwzFtD3', 'MAMACITA', 'Black Eyed Peas , Ozuna , J. Rey Soul', 'Translation', '2020-06-18', 'https://i.scdn.co/image/ab67616d0000b273d459374a978da728adea3f38'),
('24Yi9hE78yPEbZ4kxyoXAI', 'Roses - Imanbek Remix', 'SAINt JHN , Imanbek', 'Roses (Imanbek Remix)', '2019-10-09', 'https://i.scdn.co/image/ab67616d0000b273b340b496cb7c38d727ff40be'),
('2b8fOow8UzyDFAE27YhOZM', 'Memories', 'Maroon 5', 'Memories', '2019-09-20', 'https://i.scdn.co/image/ab67616d0000b273b8c0135a218de2d10a8435f5'),
('2DEZmgHKAvm41k4J3R2E9Y', 'Safaera', 'Bad Bunny , Jowell & Randy , Nengo Flow', 'YHLQMDLG', '2020-02-28', 'https://i.scdn.co/image/ab67616d0000b273548f7ec52da7313de0c5e4a0'),
('2gMXnyrvIjhVBUZwvLZDMP', 'Before You Go', 'Lewis Capaldi', 'Divinely Uninspired To A Hellish Extent (Extended Edition)', '2019-11-22', 'https://i.scdn.co/image/ab67616d0000b2737b9639babbe96e25071ec1d4'),
('2rRJrJEo19S2J82BDsQ3F7', 'Falling', 'Trevor Daniel', 'Nicotine', '2020-03-26', 'https://i.scdn.co/image/ab67616d0000b273626fb1736f04466054ff7dd4'),
('39Yp9wwQiSRIDOvrVg7mbk', 'THE SCOTTS', 'THE SCOTTS , Travis Scott , Kid Cudi', 'THE SCOTTS', '2020-04-24', 'https://i.scdn.co/image/ab67616d0000b27311d6f8c713ef93a9bb64ddfe'),
('3Dv1eDb0MEgF93GpLXlucZ', 'Say So', 'Doja Cat', 'Hot Pink', '2019-11-07', 'https://i.scdn.co/image/ab67616d0000b27382b243023b937fd579a35533'),
('3dVvWnj4D8JGkKvo6Hucso', 'TROLLZ (with Nicki Minaj)', '6ix9ine , Nicki Minaj', 'TROLLZ (with Nicki Minaj)', '2020-06-12', 'https://i.scdn.co/image/ab67616d0000b273ee39017530114e6f8e5908cc'),
('3eekarcy7kvN4yt5ZFzltW', 'HIGHEST IN THE ROOM', 'Travis Scott', 'HIGHEST IN THE ROOM', '2019-10-04', 'https://i.scdn.co/image/ab67616d0000b273e42b5fea4ac4c3d6328b622b'),
('3H7ihDc1dqLriiWXwsc2po', 'Breaking Me', 'Topic , A7S', 'Breaking Me', '2019-12-19', 'https://i.scdn.co/image/ab67616d0000b273ca801dab96017456b9847ac2'),
('3jjujdWJ72nww5eGnfs2E7', 'Adore You', 'Harry Styles', 'Fine Line', '2019-12-13', 'https://i.scdn.co/image/ab67616d0000b27377fdcfda6535601aff081b6a'),
('3Z8FwOEN59mRMxDCtb8N0A', 'Be Kind (with Halsey)', 'Marshmello , Halsey', 'Be Kind (with Halsey)', '2020-05-01', 'https://i.scdn.co/image/ab67616d0000b273fdf2e993e10e67396b3bf759'),
('3ZG8N7aWw2meb6UrI5ZmnZ', 'Relación', 'Sech', '1 of 1', '2020-05-21', 'https://i.scdn.co/image/ab67616d0000b273a00b470b311631817cc9fe93'),
('466cKvZn1j45IpxDdYZqdA', 'Toosie Slide', 'Drake', 'Dark Lane Demo Tapes', '2020-05-01', 'https://i.scdn.co/image/ab67616d0000b273bba7cfaf7c59ff0898acba1f'),
('4DpNNXFMMxQEKl7r0ykkWA', 'Play Date', 'Melanie Martinez', 'Cry Baby (Deluxe Edition)', '2015-08-14', 'https://i.scdn.co/image/ab67616d0000b2733899712512f50a8d9e01e951'),
('4HBZA5flZLE435QTztThqH', 'Stuck with U (with Justin Bieber)', 'Ariana Grande , Justin Bieber', 'Stuck with U', '2020-05-08', 'https://i.scdn.co/image/ab67616d0000b2732babb9dbd8f5146112f1bf86'),
('4NhDYoQTYCdWHTvlbGVgwo', 'GOOBA', '6ix9ine', 'GOOBA', '2020-05-08', 'https://i.scdn.co/image/ab67616d0000b2733e68a2c61ab786e2526f7269'),
('4nK5YrxbMGZstTLbvj6Gxw', 'Supalonely', 'BENEE , Gus Dapperton', 'STELLA & STEVE', '2019-11-15', 'https://i.scdn.co/image/ab67616d0000b27382f4ec53c54bdd5be4eed4a0'),
('4umIPjkehX1r7uhmGvXiSV', 'Intentions (feat. Quavo)', 'Justin Bieber , Quavo', 'Changes', '2020-02-14', 'https://i.scdn.co/image/ab67616d0000b2737fe4a82a08c4f0decbeddbc6'),
('4w47S36wQGBhGg073q3nt7', 'TKN (feat. Travis Scott)', 'ROSALÍA , Travis Scott', 'TKN (feat. Travis Scott)', '2020-05-28', 'https://i.scdn.co/image/ab67616d0000b2732a3d01289b78099e4508ba0e'),
('5RqR4ZCCKJDcBLIn4sih9l', 'Party Girl', 'StaySolidRocky', 'Party Girl', '2020-04-21', 'https://i.scdn.co/image/ab67616d0000b273f3fb166b5515fb19b070773c'),
('5v4GgrXPMghOnBBLmveLac', 'Savage Remix (feat. Beyoncé)', 'Megan Thee Stallion , Beyoncé', 'Savage Remix (feat. Beyoncé)', '2020-04-29', 'https://i.scdn.co/image/ab67616d0000b2739e1cf949785e00f925be7713'),
('62aP9fBQKYKxi7PDXwcUAS', 'ily (i love you baby) (feat. Emilee)', 'Surf Mesa , Emilee', 'ily (i love you baby) (feat. Emilee)', '2019-11-26', 'https://i.scdn.co/image/ab67616d0000b273b3de5764cc02f94714487c86'),
('696DnlkuDOXcMAnKlTgXXK', 'ROXANNE', 'Arizona Zervas', 'ROXANNE', '2019-10-10', 'https://i.scdn.co/image/ab67616d0000b273069a93617a916760ab88ffea'),
('6gBFPUFcJLzWGx4lenP6h2', 'goosebumps', 'Travis Scott', 'Birds In The Trap Sing McKnight', '2016-09-16', 'https://i.scdn.co/image/ab67616d0000b273f54b99bf27cda88f4a7403ce'),
('6UelLqGlWMcVH1E5c4H7lY', 'Watermelon Sugar', 'Harry Styles', 'Fine Line', '2019-12-13', 'https://i.scdn.co/image/ab67616d0000b27377fdcfda6535601aff081b6a'),
('6v3KW9xbzN5yKLt9YKDYA2', 'Señorita', 'Shawn Mendes , Camila Cabello', 'Shawn Mendes (Deluxe)', '2019-06-19', 'https://i.scdn.co/image/ab67616d0000b273c820f033bd82bef4355d1563'),
('76nqCfJOcFFWBJN32PAksn', 'Kings & Queens', 'Ava Max', 'Kings & Queens', '2020-03-12', 'https://i.scdn.co/image/ab67616d0000b273455b66109a326b6ffb3f169b'),
('7eJMfftS33KTjuF7lTsMCx', 'death bed (coffee for your head) (feat. beabadoobee)', 'Powfu , beabadoobee', 'death bed (coffee for your head) (feat. beabadoobee)', '2020-02-08', 'https://i.scdn.co/image/ab67616d0000b273bf01fd0986a195d485922167'),
('7ju97lgwC2rKQ6wwsf9no9', 'Rain On Me (with Ariana Grande)', 'Lady Gaga , Ariana Grande', 'Chromatica', '2020-05-29', 'https://i.scdn.co/image/ab67616d0000b2736040effba89b9b00a6f6743a'),
('7k4t7uLgtOxPwTpFmtJNTY', 'Tusa', 'KAROL G , Nicki Minaj', 'Tusa', '2019-11-07', 'https://i.scdn.co/image/ab67616d0000b273ddd3154c58e15a8bdb63bbcc'),
('7qEHsqek33rTcFNT9PFqLf', 'Someone You Loved', 'Lewis Capaldi', 'Divinely Uninspired To A Hellish Extent', '2019-05-17', 'https://i.scdn.co/image/ab67616d0000b273fc2101e6889d6ce9025f85f2'),
('7szuecWAPwGoV1e5vGu8tl', 'In Your Eyes', 'The Weeknd', 'After Hours', '2020-03-20', 'https://i.scdn.co/image/ab67616d0000b2738863bc11d2aa12b54f5aeb36'),
('7ytR5pFWmSjzHJIeQkgog4', 'ROCKSTAR (feat. Roddy Ricch)', 'DaBaby , Roddy Ricch', 'BLAME IT ON BABY', '2020-04-17', 'https://i.scdn.co/image/ab67616d0000b27320e08c8cc23f404d723b5647');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `firstname`, `lastname`, `password`, `image`, `email`) VALUES
(1, 'mihai.popescu', 'Mihaii', 'Popescuu', '1a1dc91c907325c69271ddf0c944bc72', 'user1.png', 'mihai.popescu@gmail.com'),
(4, 'Eludium', 'Bucur', 'Teodor', '8287458823facb8ff918dbfabcd22ccb', 'user1.png', 'asteo98@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`artist_id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `artist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
