-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : usygecypatdb.mysql.db
-- Généré le : mer. 22 oct. 2025 à 01:28
-- Version du serveur : 8.0.43-34
-- Version de PHP : 8.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `usygecypatdb`
--

-- --------------------------------------------------------

--
-- Structure de la table `mc_actu`
--

CREATE TABLE `mc_actu` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `is_online` tinyint(1) NOT NULL,
  `slug` varchar(185) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mc_actu`
--

INSERT INTO `mc_actu` (`id`, `title`, `content`, `is_online`, `slug`) VALUES
(1, 'Un rendement en or !!!', '<div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente dolor nam nostrum? Sequi rem voluptatibus nemo soluta nulla adipisci. Libero dignissimos laborum culpa magnam commodi est molestiae praesentium eius sint eum inventore sit reprehenderit nam, voluptates quasi blanditiis illum aut earum tempore non fugit voluptas modi? Numquam enim odio repellat.</div>', 1, 'un-rendement-en-or');

-- --------------------------------------------------------

--
-- Structure de la table `mc_categorie`
--

CREATE TABLE `mc_categorie` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mc_categorie`
--

INSERT INTO `mc_categorie` (`id`, `name`) VALUES
(1, 'Rend.  thématique'),
(2, 'Rend. classique');

-- --------------------------------------------------------

--
-- Structure de la table `mc_performance`
--

CREATE TABLE `mc_performance` (
  `id` int NOT NULL,
  `year` int NOT NULL,
  `rate` double NOT NULL,
  `product_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mc_performance`
--

INSERT INTO `mc_performance` (`id`, `year`, `rate`, `product_id`) VALUES
(1, 2017, 5.05, 3),
(2, 2018, 5.05, 3),
(3, 2019, 5.05, 3),
(4, 2020, 4.95, 3),
(5, 2017, 4.89, 1),
(6, 2018, 4.5, 1),
(7, 2019, 4.51, 1),
(8, 2020, 4.5, 1),
(9, 2017, 5.96, 2),
(10, 2018, 6.03, 2),
(11, 2019, 6.1, 2),
(12, 2020, 6.02, 2);

-- --------------------------------------------------------

--
-- Structure de la table `mc_produit`
--

CREATE TABLE `mc_produit` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `soc_gest` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capital` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thematique` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capitalisation` double NOT NULL,
  `nb_assoc` int NOT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_promo` tinyint(1) DEFAULT NULL,
  `share_price` double NOT NULL,
  `share_nbr` int NOT NULL,
  `share_sub_min` int NOT NULL,
  `fruition_delay` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `withdrawal_value` double NOT NULL,
  `immvable_nbr` int NOT NULL,
  `surface` int NOT NULL,
  `tenant_nbr` int NOT NULL,
  `top` int NOT NULL,
  `tof` int NOT NULL,
  `life_insurance_avaible` tinyint(1) NOT NULL,
  `reserve_ran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `works_advance` int NOT NULL,
  `invest_strat` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `info_trim` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `life_asset_trim` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `subscription_com` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `manage_com` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `arb_mov_com` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `pilot_works_com` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `wit_cession_com` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `share_muta_com` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `categorie_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mc_produit`
--

INSERT INTO `mc_produit` (`id`, `name`, `soc_gest`, `capital`, `thematique`, `capitalisation`, `nb_assoc`, `image_name`, `slug`, `is_promo`, `share_price`, `share_nbr`, `share_sub_min`, `fruition_delay`, `withdrawal_value`, `immvable_nbr`, `surface`, `tenant_nbr`, `top`, `tof`, `life_insurance_avaible`, `reserve_ran`, `works_advance`, `invest_strat`, `info_trim`, `life_asset_trim`, `subscription_com`, `manage_com`, `arb_mov_com`, `pilot_works_com`, `wit_cession_com`, `share_muta_com`, `created_at`, `updated_at`, `categorie_id`) VALUES
(1, 'SCPI PRIMOVIE', 'Primonial', 'Variable', 'Santé / Education', 3.4, 30915, '16b6a4638281136aa8da3400e0d5a50e43a8070a.png', 'scpi-primovie', 0, 20300, 16731157, 10, '1er jour du 6ème mois', 18473, 215, 1025849, 412, 97, 93, 1, '2436016 €', 43099900, '<p>Cr&eacute;&eacute;e en 2012, la SCPI Primovie investit principalement dans des actifs immobiliers li&eacute;s aux secteurs de la sant&eacute; et de l&rsquo;&eacute;ducation. Primovie privil&eacute;gie les actifs dont les locataires exercent, au moment de l&rsquo;acquisition, une activit&eacute; en relation avec les secteurs :</p>\r\n\r\n<ul>\r\n	<li>de la petite enfance, de l&rsquo;&eacute;ducation ou de la location &agrave; destination des &eacute;tudiants : cr&egrave;ches priv&eacute;es, &eacute;coles et centres de formation priv&eacute;s, r&eacute;sidences &eacute;tudiantes ;</li>\r\n	<li>de la sant&eacute; : notamment cliniques et centres de sant&eacute; ;</li>\r\n	<li>des s&eacute;niors et de la d&eacute;pendance : maisons de retraite et r&eacute;sidences seniors.</li>\r\n</ul>\r\n\r\n<p>D&eacute;veloppement en Europe en cours.</p>', '<p>Le pilotage de la performance des fonds au jour le jour par les g&eacute;rants ainsi que le travail effectu&eacute; par les &eacute;quipes d&rsquo;asset management pour recouvrer les loyers ont fortement contribu&eacute; &agrave; l&rsquo;atteinte des objectifs de performance annuelle fix&eacute;s pour la SCPI Primovie. Au 31 d&eacute;cembre 2020, la SCPI avait encaiss&eacute; pr&egrave;s de 99% des quittancements de l&rsquo;ann&eacute;e.</p>\r\n\r\n<p>La SCPI Primovie s&rsquo;inscrit pleinement dans la d&eacute;marche de responsabilit&eacute; de Primonial REIM. Investie d&egrave;s l&rsquo;origine dans l&rsquo;immobilier de la sant&eacute; et de l&rsquo;&eacute;ducation, des secteurs socialement utiles, la SCPI Primovie est devenue en 2020, un fonds de soutien et de m&eacute;c&eacute;nat au profit de l&rsquo;h&ocirc;pital Necker-Enfants malades. Chaque souscription de nouvelles parts de Primovie permet ainsi &agrave; la Soci&eacute;t&eacute; de Gestion de faire un don &agrave; l&rsquo;h&ocirc;pital. Primonial REIM fait &eacute;galement de l&rsquo;am&eacute;lioration des performances environnementales du parc immobilier une priorit&eacute; et met en &oelig;uvre les meilleures pratiques ESG*** (Environnement Social Gouvernance) pour valoriser la qualit&eacute; des actifs dans le temps.</p>\r\n\r\n<p>Au 4e trimestre 2020, la SCPI Primovie a collect&eacute; plus de 164 millions d&rsquo;euros, portant sa capitalisation &agrave; pr&egrave;s de 3,4 milliards d&rsquo;euros au 31 d&eacute;cembre 2020.</p>\r\n\r\n<p>La vacance financi&egrave;re de la SCPI Primovie est principalement li&eacute;e aux lib&eacute;rations et relocations intervenues sur le patrimoine de bureaux.&nbsp;</p>\r\n\r\n<p>La distribution au titre du 4e trimestre 2020 s&rsquo;&eacute;l&egrave;ve &agrave; 2,45 &euro; par part dont 0,40 &euro; par part de distribution de plus-value.</p>', '<p>La soci&eacute;t&eacute; de gestion a proc&eacute;d&eacute; pour le compte de la SCPI Primovie &agrave; 57,19 millions d&rsquo;euros d&rsquo;acquisitions sur le trimestre, au nombre desquelles figurent la signature d&rsquo;un nouvel actif au sein du portefeuille Futura situ&eacute; &agrave; Eisenach en Allemagne, l&rsquo;acquisition d&rsquo;un portefeuille de trois r&eacute;sidences services seniors en VEFA &agrave; Montargis, Saint-Alban et l&rsquo;acquisition d&rsquo;une r&eacute;sidence services seniors &agrave; Angers.</p>\r\n\r\n<p>La SCPI a c&eacute;d&eacute; 2 actifs de bureaux situ&eacute;s &agrave; Lyon et Paris au cours de ce trimestre pour un montant de plus de 31 millions d&rsquo;euros.&nbsp;</p>\r\n\r\n<p>Au 31 d&eacute;cembre 2020, le patrimoine immobilier de Primovie compte 215 actifs (directs et indirects), localis&eacute;s en zone euro (hors France) &agrave; hauteur de 30,4%. Le taux d&rsquo;occupation financier de Primovie s&rsquo;&eacute;l&egrave;ve &agrave; 93,2%.&nbsp;</p>', '<p>9,00 % HT &agrave; majorer de la TVA au taux en vigueur soit 9,15 % TTC maximum du prix de souscription prime d&rsquo;&eacute;mission incluse (pour un taux de TVA de 20,00 %)</p>', '<p>La commission de gestion de la SCPI est fix&eacute;e comme suit :</p>\r\n\r\n<ul>\r\n	<li>10 % HT maximum (&agrave; majorer de la TVA au taux en vigueur) des produits locatifs HT encaiss&eacute;s par la SCPI et par les soci&eacute;t&eacute;s que la SCPI contr&ocirc;le au sens du Code mon&eacute;taire et financier (limit&eacute; &agrave; la quote-part de d&eacute;tention de la SCPI), pour l&rsquo;administration et la gestion du patrimoine de la SCPI ;</li>\r\n	<li>5 % HT maximum (&agrave; majorer de la TVA au taux en vigueur) des produits financiers nets encaiss&eacute;s par la SCPI et par les soci&eacute;t&eacute;s que la SCPI contr&ocirc;le au sens du Code mon&eacute;taire et financier (limit&eacute; &agrave; la quote-part de d&eacute;tention de la SCPI), les produits de participation pay&eacute;s &agrave; la SCPI par les participations contr&ocirc;l&eacute;es sont exclus de la base de calcul ;</li>\r\n	<li>de laquelle sont d&eacute;duites les commissions de gestion d&eacute;j&agrave; pay&eacute;es par les participations&nbsp;</li>\r\n</ul>\r\n\r\n<p>contr&ocirc;l&eacute;es, &agrave; proportion de la d&eacute;tention du capital par la SCPI dans ces soci&eacute;t&eacute;s&nbsp;contr&ocirc;l&eacute;es.</p>', '<p>Une commission de 1,25 % HT (&agrave; majorer de la TVA au taux en vigueur) du prix de cession net vendeur &nbsp;:</p>\r\n\r\n<p style=\"margin-left:40px\">&nbsp;==&gt; Des actifs immobiliers d&eacute;tenus en direct par la SCPI, ou des actifs immobiliers d&eacute;tenus par les soci&eacute;t&eacute;s dans lesquelles la SCPI d&eacute;tient une participation contr&ocirc;l&eacute;e au sens du Code mon&eacute;taire et financier (limit&eacute; &agrave; la quote-part de d&eacute;tention de la SCPI) (dans le cas de la cession directe ou indirecte d&rsquo;actifs et de droits immobiliers),</p>\r\n\r\n<p>ou&nbsp;</p>\r\n\r\n<p style=\"margin-left:40px\">==&gt;De la valeur conventionnelle des actifs et droits immobiliers ayant servi &agrave; la d&eacute;termination de la valeur des titres (dans le cas de la cession d&rsquo;une participation) ;&nbsp;</p>\r\n\r\n<p>Une commission de 1,25 % HT (&agrave; majorer de la TVA au taux en vigueur) du prix d&rsquo;acquisition des actifs et droits immobiliers, ou des titres de participations contr&ocirc;l&eacute;es ou non contr&ocirc;l&eacute;es, pour la quote-part de ce prix pay&eacute;e gr&acirc;ce au r&eacute;investissement des produits de cession d&rsquo;autres actifs ou titres des soci&eacute;t&eacute;s d&eacute;tenus par la SCPI, y compris en cas de financement compl&eacute;mentaire par emprunt ;&nbsp;</p>\r\n\r\n<p>&nbsp;Desquelles sont d&eacute;duites les commissions d&rsquo;acquisition et de cession d&eacute;j&agrave; pay&eacute;es par les soci&eacute;t&eacute;s que la SCPI contr&ocirc;le, &agrave; proportion de la d&eacute;tention du capital par la SCPI dans ces soci&eacute;t&eacute;s contr&ocirc;l&eacute;es.&nbsp;</p>', '<p>Il est d&ucirc; &agrave; la Soci&eacute;t&eacute; de Gestion &agrave; titre de r&eacute;mun&eacute;ration de sa mission de suivi et de pilotage des travaux, une commission de suivi et de pilotage de la r&eacute;alisation des travaux sur le patrimoine immobilier &eacute;gale &agrave; 3 % hors taxes maximum du montant toutes taxes comprises des travaux effectivement r&eacute;alis&eacute;s.&nbsp;</p>', '<p>En cas de cession r&eacute;alis&eacute;e par confrontation des ordres d&rsquo;achat et de vente en application de l&rsquo;article L.214-93 du Code mon&eacute;taire et financier, une commission de cession, assise sur le montant de la transaction, et dont le taux est fix&eacute; par l&rsquo;Assembl&eacute;e G&eacute;n&eacute;rale</p>', '<p>En cas de cession de parts r&eacute;alis&eacute;e directement entre vendeur et acheteur, des frais de transfert d&rsquo;un montant de 75 euros HT (90 euros TTC pour un taux de TVA de 20 %) par dossier. Les frais sont dus par le cessionnaire, sauf convention contraire entre les parties ;&nbsp;</p>\r\n\r\n<p>En cas de mutation de parts, des frais de transfert d&rsquo;un montant de 200 euros HT (soit 240 euros TTC pour un taux de TVA de 20%) par h&eacute;ritier, ne pouvant d&eacute;passer 10% de la valorisation des parts au jour du d&eacute;c&egrave;s, et de 75 euros HT (soit 90 euros TTC pour un taux de TVA de 20%) par dossier pour les autres cas de mutation &agrave; titre gratuit (donation notamment).&nbsp;</p>', '2012-07-19 00:00:00', '2023-04-11 18:54:49', 1),
(2, 'SCPI VENDOME REGIONS', 'NORMA CAPITAL', 'Variable', 'Diversifiée', 0.214, 4283, '4b517faa8468e52f87b3cf699ea2c4886f30c8af.png', 'scpi-vendome-regions', 0, 65500, 327269, 5, '1er jour du 6ème mois', 5895000, 67, 124685, 129, 97, 97, 0, 'Réserves : 144 000 € RAN : 510 595 €', 40408300, '<p>Priorit&eacute; est donn&eacute;e aux investissements en biens immobiliers privil&eacute;giant les revenus locatifs imm&eacute;diats, avec des actifs &nbsp;situ&eacute;s dans les grandes agglom&eacute;rations r&eacute;gionales<br />\r\nLa strat&eacute;gie s&rsquo;articule autour de trois axes :</p>\r\n\r\n<ul>\r\n	<li>Une choix d&rsquo;actifs disposant d&rsquo;un potentiel de cr&eacute;ation de&nbsp;valeur,</li>\r\n	<li>Une politique de revalorisation du patrimoine en maximisant&nbsp;le niveau des loyers,</li>\r\n	<li>Une s&eacute;lection d&rsquo;actifs diff&eacute;rents quant &agrave; leur typologie La composition des actifs immobiliers de petite et de moyenne valeur est uniquement orient&eacute;e dans les activit&eacute;s tertiaires :&nbsp;immeubles de bureaux, commerces et locaux d&rsquo;activit&eacute;s.</li>\r\n</ul>', '<p>La SCPI Vend&ocirc;me R&eacute;gions s&rsquo;est d&eacute;montr&eacute;e r&eacute;siliente face &agrave; la crise sanitaire. D&egrave;s l&rsquo;annonce du premier confinement, Norma Capital a engag&eacute; une relation de proximit&eacute; avec ses locataires, ses associ&eacute;s, les associations professionnelles et l&rsquo;Autorit&eacute; des March&eacute;s Financiers afin de suivre la situation au plus pr&egrave;s et agir le plus rapidement et concr&egrave;tement possible. Les taux de recouvrement se sont impos&eacute;s dans les bulletins trimestriels d&egrave;s le 1er trimestre 2020. Le taux de recouvrement de l&rsquo;ann&eacute;e de Vend&ocirc;me R&eacute;gions est de 98,70 %.</p>', '<p>La SCPI Vend&ocirc;me R&eacute;gions s&rsquo;est d&eacute;montr&eacute;e r&eacute;siliente face &agrave; la crise&nbsp;sanitaire.<br />\r\nD&egrave;s l&rsquo;annonce du premier confinement, Norma Capital a engag&eacute; une relation de proximit&eacute; avec ses locataires, ses associ&eacute;s, les associations professionnelles et l&rsquo;Autorit&eacute; des March&eacute;s Financiers afin de suivre la situation au plus pr&egrave;s et agir le plus rapidement et concr&egrave;tement possible.</p>\r\n\r\n<p>Les taux de recouvrement se sont impos&eacute;s dans les bulletins trimestriels d&egrave;s le 1er trimestre 2020. Le taux de recouvrement de l&rsquo;ann&eacute;e de Vend&ocirc;me R&eacute;gions est de 98,70 %.</p>', '<p>10 % HT du prix de souscription (soit 12 % TTC au taux de TVA actuel)</p>', '<p>10 % HT du prix de souscription (soit 12 % TTC au taux de TVA actuel) pr&eacute;lev&eacute;s sur les produits locatifs HT encaiss&eacute;s et les produits financiers nets</p>', '<p>La commission sera alors &eacute;gale &agrave; :</p>\r\n\r\n<ul>\r\n	<li>2 % du prix de vente net vendeur si celui-ci est inf&eacute;rieur &agrave; 5 000 000 &euro; ;</li>\r\n	<li>1,5 % du prix de vente net vendeur si celui-ci est sup&eacute;rieur ou &eacute;gal &agrave; 5 000 000 &euro;.</li>\r\n</ul>', '<p>Une commission de suivi et de pilotage de la r&eacute;alisation des travaux sur le patrimoine immobilier de 1 % HT maximum sur les gros travaux sup&eacute;rieurs &agrave; 100 000 &euro; HT suivis directement par la soci&eacute;t&eacute; de gestion.</p>', '<p>75 &euro; HT (soit 90 &euro; TTC au taux de TVA actuel) de frais de dossier</p>', '<p>75 &euro; HT (soit 90 &euro; TTC au taux de TVA actuel) de frais de dossier</p>', '2015-05-22 00:00:00', '2022-05-29 12:34:12', 2),
(3, 'PIERVAL SANTE', 'LA FRANCAISE', 'Variable', 'Santé', 1.39, 27132, 'b8c72ae7d79399295306042766a234a761ce8831.png', 'pierval-sante', 1, 20000, 6932625, 5, '1er jour du 5ème mois', 1789800, 128, 498993, 687, 0, 99, 0, 'RAN par part : 0,44 €', 2147483647, '<p>Cr&eacute;&eacute;e en 2013, &nbsp;Pierval Sant&eacute; est une SCPI &nbsp;d&rsquo;entreprise th&eacute;matique &nbsp;&agrave; capital variable, d&eacute;di&eacute;e aux actifs immobiliers de sant&eacute;.<br />\r\nPS propose une solution d&#39;&eacute;pargne innovante dans le paysage des SCPI d&#39;entreprises classiques.</p>', '<p>Au cours de l&rsquo;ann&eacute;e 2020, la SCPI a b&eacute;n&eacute;fici&eacute; d&rsquo;un int&eacute;r&ecirc;t croissant de la part des souscripteurs de SCPI qui s&rsquo;explique en grande partie par la r&eacute;silience de son patrimoine immobilier face &agrave; la crise sanitaire sans pr&eacute;c&eacute;dent que nous traversons.</p>\r\n\r\n<p>La collecte a fortement progress&eacute; jusqu&rsquo;&agrave; 505 millions d&rsquo;euros (+36% par rapport &agrave; 2019 dans un march&eacute; estim&eacute; &agrave; -20%).</p>\r\n\r\n<p>En cons&eacute;quence, les performances se sont maintenues (TDVM retrait&eacute; de fiscalit&eacute; &eacute;trang&egrave;re de 5,38 % contre 5,34 % en 2019) &agrave; un niveau sup&eacute;rieur au march&eacute;&nbsp;des SCPI (TDVM non retrait&eacute; de 4,95 % contre environ 4,12 % estim&eacute; pour le march&eacute;). En effet, le TDVM retrait&eacute; de fiscalit&eacute; &eacute;trang&egrave;re permet une meilleure comparaison des performances d&rsquo;une SCPI internationale par rapport &agrave; une SCPI peu ou pas expos&eacute;e &agrave; l&rsquo;&eacute;tranger, car il pr&eacute;sente le rendement de la SCPI comme si tous ses revenus &eacute;taient de source fran&ccedil;aise.</p>', '<p>Le volume des investissements s&rsquo;est parfaitement adapt&eacute; avec pr&egrave;s de 411 millions d&rsquo;euros d&rsquo;investissements r&eacute;alis&eacute;s et 118 millions d&rsquo;euros engag&eacute;s (promesses de ventes sign&eacute;es notamment dans des projets de construction d&rsquo;&eacute;tablissements de sant&eacute;).</p>', '<p>&#39;La commission de souscription vers&eacute;e par la SCPI &agrave; la Soci&eacute;t&eacute; de gestion de 10,09 % HT soit 10,51 % TTC maximum du prix de souscription, prime d&rsquo;&eacute;mission incluse soit 100,90 &euro; HT et 105,10 &euro; TTC (au taux de TVA actuellement en vigueur).</p>', '<p>7,00% HT (&agrave; majorer de la TVA au taux en vigueur soit 8,40 % TTC pour un taux de TVA de 20 %) du montant hors taxes des produits locatifs encaiss&eacute;s par la soci&eacute;t&eacute; pour son administration et la gestion de son patrimoine</p>', '<p>La commission de mouvement sur les actifs immobiliers vers&eacute;e par la SCPI est fix&eacute;e &agrave; un montant maximum de 3,00 % HT de la valeur des acquisitions, soit 3,60 % TTC pour un taux de TVA de 20 %.</p>', '<p>X</p>', '<p>Pour la r&eacute;alisation d&#39;un transfert de parts avec intervention de la Soci&eacute;t&eacute; de Gestion et si une contrepartie est trouv&eacute;e, une commission d&rsquo;intervention pour le remboursement forfaitaire des frais de constitution de dossier &eacute;gale &agrave; 5 % HT de la somme revenant au c&eacute;dant (soit 6 % TTC au taux de TVA de 20 % actuellement en vigueur). Cette commission est &agrave; la charge de l&rsquo;acqu&eacute;reur.</p>', '<p>en cas de cession de parts r&eacute;alis&eacute;e directement entre vendeur et acheteur, des frais de transfert d&rsquo;un montant de 50 euros HT (60 euros TTC pour un taux de TVA de 20 %) par dossier. Les frais sont dus par le cessionnaire, sauf convention contraire entre les parties ; en cas de mutation de parts (succession, donation&hellip;), des frais de transfert d&rsquo;un montant de 200 euros HT (soit 240 euros TTC pour un taux de TVA de 20 %) par dossier. Ce montant est index&eacute; le 1er janvier de chaque ann&eacute;e, en fonction de la variation de l&#39;indice g&eacute;n&eacute;ral INSEE du co&ucirc;t des services au cours de l&#39;ann&eacute;e &eacute;coul&eacute;e, la nouvelle somme ainsi obtenue &eacute;tant arrondie &agrave; l&rsquo;euro inf&eacute;rieur.</p>', '2013-11-25 00:00:00', '2023-04-11 18:54:50', 1),
(5, 'Perial asset managment', 'PERIAL Asset Management', 'Variable', 'BioTech', 4.6, 4500, '981ef10e48ed11cb432c8346ed4c59c6ed923e45.jpg', 'perial-asset-managment', 0, 65500, 16731157, 100, '1er jour du 5ème mois', 18473, 328, 124685, 328, 83, 87, 1, 'RAN par part : 0,34 €', 2147483647, '<p>Facilis laborum doloremque consectetur, qui eligendi dignissimos fuga minus, aperiam impedit labore possimus quisquam iste iusto vitae saepe consequuntur natus expedita asperiores ducimus, neque vero quibusdam beatae! Odit cum molestiae laboriosam veritatis blanditiis sapiente corporis! Ab accusamus animi, deserunt, assumenda reprehenderit eos adipisci dignissimos iure, ipsa ducimus doloremque culpa rerum nobis ut amet. Provident dicta cum nam similique architecto alias odit, inventore facilis ea accusamus quidem aliquid ex assumenda expedita voluptates eveniet excepturi nesciunt magni sequi quasi aliquam pariatur nostrum et impedit. Quaerat dolore nostrum deleniti quia ipsam perspiciatis error quibusdam qui ipsa facere esse in explicabo obcaecati, necessitatibus earum ipsum repudiandae saepe exercitationem voluptatem velit mollitia omnis quisquam.</p>', '<p>Facilis laborum doloremque consectetur, qui eligendi dignissimos fuga minus, aperiam impedit labore possimus quisquam iste iusto vitae saepe consequuntur natus expedita asperiores ducimus, neque vero quibusdam beatae! Odit cum molestiae laboriosam veritatis blanditiis sapiente corporis! Ab accusamus animi, deserunt, assumenda reprehenderit eos adipisci dignissimos iure, ipsa ducimus doloremque culpa rerum nobis ut amet. Provident dicta cum nam similique architecto alias odit, inventore facilis ea accusamus quidem aliquid ex assumenda expedita voluptates eveniet excepturi nesciunt magni sequi quasi aliquam pariatur nostrum et impedit. Quaerat dolore nostrum deleniti quia ipsam perspiciatis error quibusdam qui ipsa facere esse in explicabo obcaecati, necessitatibus earum ipsum repudiandae saepe exercitationem voluptatem velit mollitia omnis quisquam.</p>', '<p>Facilis laborum doloremque consectetur, qui eligendi dignissimos fuga minus, aperiam impedit labore possimus quisquam iste iusto vitae saepe consequuntur natus expedita asperiores ducimus, neque vero quibusdam beatae! Odit cum molestiae laboriosam veritatis blanditiis sapiente corporis! Ab accusamus animi, deserunt, assumenda reprehenderit eos adipisci dignissimos iure, ipsa ducimus doloremque culpa rerum nobis ut amet. Provident dicta cum nam similique architecto alias odit, inventore facilis ea accusamus quidem aliquid ex assumenda expedita voluptates eveniet excepturi nesciunt magni sequi quasi aliquam pariatur nostrum et impedit. Quaerat dolore nostrum deleniti quia ipsam perspiciatis error quibusdam qui ipsa facere esse in explicabo obcaecati, necessitatibus earum ipsum repudiandae saepe exercitationem voluptatem velit mollitia omnis quisquam.</p>', '<p>Facilis laborum doloremque consectetur, qui eligendi dignissimos fuga minus, aperiam impedit labore possimus quisquam iste iusto vitae saepe consequuntur natus expedita asperiores ducimus, neque vero quibusdam beatae! Odit cum molestiae laboriosam veritatis blanditiis sapiente corporis! Ab accusamus animi, deserunt, assumenda reprehenderit eos adipisci dignissimos iure, ipsa ducimus doloremque culpa rerum nobis ut amet. Provident dicta cum nam similique architecto alias odit, inventore facilis ea accusamus quidem aliquid ex assumenda expedita voluptates eveniet excepturi nesciunt magni sequi quasi aliquam pariatur nostrum et impedit. Quaerat dolore nostrum deleniti quia ipsam perspiciatis error quibusdam qui ipsa facere esse in explicabo obcaecati, necessitatibus earum ipsum repudiandae saepe exercitationem voluptatem velit mollitia omnis quisquam.</p>', '<p>Facilis laborum doloremque consectetur, qui eligendi dignissimos fuga minus, aperiam impedit labore possimus quisquam iste iusto vitae saepe consequuntur natus expedita asperiores ducimus, neque vero quibusdam beatae! Odit cum molestiae laboriosam veritatis blanditiis sapiente corporis! Ab accusamus animi, deserunt, assumenda reprehenderit eos adipisci dignissimos iure, ipsa ducimus doloremque culpa rerum nobis ut amet. Provident dicta cum nam similique architecto alias odit, inventore facilis ea accusamus quidem aliquid ex assumenda expedita voluptates eveniet excepturi nesciunt magni sequi quasi aliquam pariatur nostrum et impedit. Quaerat dolore nostrum deleniti quia ipsam perspiciatis error quibusdam qui ipsa facere esse in explicabo obcaecati, necessitatibus earum ipsum repudiandae saepe exercitationem voluptatem velit mollitia omnis quisquam.</p>', '<p>Facilis laborum doloremque consectetur, qui eligendi dignissimos fuga minus, aperiam impedit labore possimus quisquam iste iusto vitae saepe consequuntur natus expedita asperiores ducimus, neque vero quibusdam beatae! Odit cum molestiae laboriosam veritatis blanditiis sapiente corporis! Ab accusamus animi, deserunt, assumenda reprehenderit eos adipisci dignissimos iure, ipsa ducimus doloremque culpa rerum nobis ut amet. Provident dicta cum nam similique architecto alias odit, inventore facilis ea accusamus quidem aliquid ex assumenda expedita voluptates eveniet excepturi nesciunt magni sequi quasi aliquam pariatur nostrum et impedit. Quaerat dolore nostrum deleniti quia ipsam perspiciatis error quibusdam qui ipsa facere esse in explicabo obcaecati, necessitatibus earum ipsum repudiandae saepe exercitationem voluptatem velit mollitia omnis quisquam.</p>', '<p>Facilis laborum doloremque consectetur, qui eligendi dignissimos fuga minus, aperiam impedit labore possimus quisquam iste iusto vitae saepe consequuntur natus expedita asperiores ducimus, neque vero quibusdam beatae! Odit cum molestiae laboriosam veritatis blanditiis sapiente corporis! Ab accusamus animi, deserunt, assumenda reprehenderit eos adipisci dignissimos iure, ipsa ducimus doloremque culpa rerum nobis ut amet. Provident dicta cum nam similique architecto alias odit, inventore facilis ea accusamus quidem aliquid ex assumenda expedita voluptates eveniet excepturi nesciunt magni sequi quasi aliquam pariatur nostrum et impedit. Quaerat dolore nostrum deleniti quia ipsam perspiciatis error quibusdam qui ipsa facere esse in explicabo obcaecati, necessitatibus earum ipsum repudiandae saepe exercitationem voluptatem velit mollitia omnis quisquam.</p>', '<p>Facilis laborum doloremque consectetur, qui eligendi dignissimos fuga minus, aperiam impedit labore possimus quisquam iste iusto vitae saepe consequuntur natus expedita asperiores ducimus, neque vero quibusdam beatae! Odit cum molestiae laboriosam veritatis blanditiis sapiente corporis! Ab accusamus animi, deserunt, assumenda reprehenderit eos adipisci dignissimos iure, ipsa ducimus doloremque culpa rerum nobis ut amet. Provident dicta cum nam similique architecto alias odit, inventore facilis ea accusamus quidem aliquid ex assumenda expedita voluptates eveniet excepturi nesciunt magni sequi quasi aliquam pariatur nostrum et impedit. Quaerat dolore nostrum deleniti quia ipsam perspiciatis error quibusdam qui ipsa facere esse in explicabo obcaecati, necessitatibus earum ipsum repudiandae saepe exercitationem voluptatem velit mollitia omnis quisquam.</p>', '<p>Facilis laborum doloremque consectetur, qui eligendi dignissimos fuga minus, aperiam impedit labore possimus quisquam iste iusto vitae saepe consequuntur natus expedita asperiores ducimus, neque vero quibusdam beatae! Odit cum molestiae laboriosam veritatis blanditiis sapiente corporis! Ab accusamus animi, deserunt, assumenda reprehenderit eos adipisci dignissimos iure, ipsa ducimus doloremque culpa rerum nobis ut amet. Provident dicta cum nam similique architecto alias odit, inventore facilis ea accusamus quidem aliquid ex assumenda expedita voluptates eveniet excepturi nesciunt magni sequi quasi aliquam pariatur nostrum et impedit. Quaerat dolore nostrum deleniti quia ipsam perspiciatis error quibusdam qui ipsa facere esse in explicabo obcaecati, necessitatibus earum ipsum repudiandae saepe exercitationem voluptatem velit mollitia omnis quisquam.</p>', '2022-12-08 00:00:00', '2023-03-16 22:05:45', 1);

-- --------------------------------------------------------

--
-- Structure de la table `mc_repart_geo`
--

CREATE TABLE `mc_repart_geo` (
  `id` int NOT NULL,
  `geo_name` varchar(185) COLLATE utf8mb4_unicode_ci NOT NULL,
  `geo_value` double NOT NULL,
  `produit_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mc_repart_geo`
--

INSERT INTO `mc_repart_geo` (`id`, `geo_name`, `geo_value`, `produit_id`) VALUES
(1, 'France', 37.4, 3),
(2, 'Allemagne', 28.5, 3),
(3, 'Irlande', 20.2, 3),
(4, 'Pays-Bas', 7.5, 3),
(5, 'Royaume-Uni', 3.5, 3),
(6, 'Portugal', 2.6, 3),
(7, 'Espagne', 0.4, 3),
(8, 'Betagne', 3, 2),
(9, 'Pays de la Loire', 15, 2),
(10, 'Haut de France', 13, 2),
(11, 'Île de France', 12, 2),
(12, 'Grand Est', 6, 2),
(13, 'Centre - Val de Loire - Bourgogne - Franche Comté', 4, 2),
(14, 'Nouvelle Aquitaine', 12, 2),
(15, 'PACA - Auvergne - Rhône Alpes', 5, 2),
(16, 'Occitanie', 28, 2),
(17, 'La Réunion', 2, 2),
(18, 'Région Parisienne', 41.4, 1),
(19, 'Régions', 21, 1),
(20, 'Allemagne', 19.7, 1),
(21, 'Paris', 8.2, 1),
(22, 'Italie', 7.6, 1),
(23, 'Espagne', 2.1, 1),
(24, 'Paca', 33, 5),
(25, 'Rhône Alpes', 33, 5),
(26, 'Région Parisienne', 20, 5),
(27, 'Afrique', 16, 5);

-- --------------------------------------------------------

--
-- Structure de la table `mc_repart_sector`
--

CREATE TABLE `mc_repart_sector` (
  `id` int NOT NULL,
  `sector_name` varchar(185) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sector_value` double NOT NULL,
  `produit_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mc_repart_sector`
--

INSERT INTO `mc_repart_sector` (`id`, `sector_name`, `sector_value`, `produit_id`) VALUES
(1, 'Sanitaire et soins de ville', 30.9, 3),
(2, 'Autres secteurs de santé', 8.7, 3),
(3, 'Médico-Social', 60.4, 3),
(4, 'Bureaux', 67, 2),
(5, 'Commerces', 19, 2),
(6, 'Activitès', 14, 2),
(7, 'Sante/Senior', 67.5, 1),
(8, 'Bureaux/Autres', 25.8, 1),
(9, 'Education', 6.7, 1),
(12, 'SecteurA', 25, 5),
(13, 'SecteurB', 55, 5),
(14, 'SecteurC', 20, 5);

-- --------------------------------------------------------

--
-- Structure de la table `mc_user`
--

CREATE TABLE `mc_user` (
  `id` int NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mc_user`
--

INSERT INTO `mc_user` (`id`, `email`, `roles`, `password`, `first_name`, `last_name`) VALUES
(1, 'gerin.patrice@usygec.fr', '[]', '6109vf42', 'Patrice', 'GERIN');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `mc_actu`
--
ALTER TABLE `mc_actu`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mc_categorie`
--
ALTER TABLE `mc_categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mc_performance`
--
ALTER TABLE `mc_performance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FE1AD2354584665A` (`product_id`);

--
-- Index pour la table `mc_produit`
--
ALTER TABLE `mc_produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9AB288E4BCF5E72D` (`categorie_id`);

--
-- Index pour la table `mc_repart_geo`
--
ALTER TABLE `mc_repart_geo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C631E788F347EFB` (`produit_id`);

--
-- Index pour la table `mc_repart_sector`
--
ALTER TABLE `mc_repart_sector`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8D81AE3CF347EFB` (`produit_id`);

--
-- Index pour la table `mc_user`
--
ALTER TABLE `mc_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_EFF9DEE0E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `mc_actu`
--
ALTER TABLE `mc_actu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `mc_categorie`
--
ALTER TABLE `mc_categorie`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `mc_performance`
--
ALTER TABLE `mc_performance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `mc_produit`
--
ALTER TABLE `mc_produit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `mc_repart_geo`
--
ALTER TABLE `mc_repart_geo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `mc_repart_sector`
--
ALTER TABLE `mc_repart_sector`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `mc_user`
--
ALTER TABLE `mc_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `mc_performance`
--
ALTER TABLE `mc_performance`
  ADD CONSTRAINT `FK_FE1AD2354584665A` FOREIGN KEY (`product_id`) REFERENCES `mc_produit` (`id`);

--
-- Contraintes pour la table `mc_produit`
--
ALTER TABLE `mc_produit`
  ADD CONSTRAINT `FK_9AB288E4BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `mc_categorie` (`id`);

--
-- Contraintes pour la table `mc_repart_geo`
--
ALTER TABLE `mc_repart_geo`
  ADD CONSTRAINT `FK_C631E788F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `mc_produit` (`id`);

--
-- Contraintes pour la table `mc_repart_sector`
--
ALTER TABLE `mc_repart_sector`
  ADD CONSTRAINT `FK_8D81AE3CF347EFB` FOREIGN KEY (`produit_id`) REFERENCES `mc_produit` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
