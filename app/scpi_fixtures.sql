-- Fixtures SCPI pour base de démonstration
-- 7 produits SCPI avec leurs catégories, performances, répartitions géographiques et sectorielles

-- Nettoyage des données existantes (optionnel - décommenter si besoin)
-- TRUNCATE TABLE `mc_repart_sector`;
-- TRUNCATE TABLE `mc_repart_geo`;
-- TRUNCATE TABLE `mc_performance`;
-- TRUNCATE TABLE `mc_produit`;
-- TRUNCATE TABLE `mc_categorie`;

-- ========================================
-- INSERTION DES CATÉGORIES (si elles n'existent pas)
-- ========================================

INSERT IGNORE INTO `mc_categorie` (`id`, `name`) VALUES
(1, 'Rend. thématique'),
(2, 'Rend. classique');

-- ========================================
-- INSERTION DES 7 PRODUITS SCPI
-- ========================================

-- Produit 1: SCPI CORUM ORIGIN
INSERT INTO `mc_produit` (`id`, `name`, `soc_gest`, `capital`, `thematique`, `capitalisation`, `nb_assoc`, `image_name`, `slug`, `is_promo`, `share_price`, `share_nbr`, `share_sub_min`, `fruition_delay`, `withdrawal_value`, `immvable_nbr`, `surface`, `tenant_nbr`, `top`, `tof`, `life_insurance_avaible`, `reserve_ran`, `works_advance`, `invest_strat`, `info_trim`, `life_asset_trim`, `subscription_com`, `manage_com`, `arb_mov_com`, `pilot_works_com`, `wit_cession_com`, `share_muta_com`, `created_at`, `updated_at`, `categorie_id`) VALUES
(10, 'SCPI CORUM ORIGIN', 'CORUM Asset Management', 'Variable', 'Diversifiée Europe', 5.2, 45000, NULL, 'scpi-corum-origin', 1, 1000, 5200000, 1, '1er jour du 3ème mois', 950, 185, 425000, 320, 98, 96, 1, 'RAN par part : 12,45 €', 15500000,
'<p>Créée en 2012, CORUM Origin est une SCPI diversifiée investissant dans l\'immobilier tertiaire européen. La stratégie d\'investissement privilégie les actifs de bureaux, commerces et logistique dans les grandes métropoles européennes. CORUM Origin se distingue par une politique d\'acquisition dynamique et une gestion active du patrimoine pour maximiser les rendements tout en maîtrisant les risques.</p>',
'<p>Au cours du dernier trimestre, CORUM Origin a maintenu une performance solide avec un taux de distribution attractif. La collecte s\'est élevée à 125 millions d\'euros, portant la capitalisation à 5,2 milliards d\'euros. Le taux d\'occupation financier reste excellent à 96%, témoignant de la qualité du patrimoine et de la gestion locative.</p>',
'<p>CORUM Origin a réalisé 8 acquisitions au cours du trimestre pour un montant total de 98 millions d\'euros, incluant un immeuble de bureaux premium à Francfort, un parc commercial en Espagne et plusieurs actifs logistiques en France. Une cession stratégique d\'un actif mature à Paris a permis de cristalliser une plus-value significative.</p>',
'<p>9,50 % TTC maximum du prix de souscription, prime d\'émission incluse</p>',
'<p>10 % HT des produits locatifs encaissés et 5 % HT des produits financiers nets</p>',
'<p>1,25 % HT du prix de cession ou d\'acquisition des actifs</p>',
'<p>3 % HT du montant TTC des travaux effectivement réalisés</p>',
'<p>75 € HT par dossier, à la charge du cessionnaire</p>',
'<p>75 € HT par dossier pour les cessions directes, 200 € HT par héritier pour les successions</p>',
NOW(), NOW(), 1);

-- Produit 2: SCPI EPARGNE PIERRE
INSERT INTO `mc_produit` (`id`, `name`, `soc_gest`, `capital`, `thematique`, `capitalisation`, `nb_assoc`, `image_name`, `slug`, `is_promo`, `share_price`, `share_nbr`, `share_sub_min`, `fruition_delay`, `withdrawal_value`, `immvable_nbr`, `surface`, `tenant_nbr`, `top`, `tof`, `life_insurance_avaible`, `reserve_ran`, `works_advance`, `invest_strat`, `info_trim`, `life_asset_trim`, `subscription_com`, `manage_com`, `arb_mov_com`, `pilot_works_com`, `wit_cession_com`, `share_muta_com`, `created_at`, `updated_at`, `categorie_id`) VALUES
(11, 'SCPI EPARGNE PIERRE', 'Atland Voisin', 'Variable', 'Commerces et Bureaux', 2.8, 22500, NULL, 'scpi-epargne-pierre', 0, 22500, 124444, 5, '1er jour du 6ème mois', 21800, 95, 185000, 178, 94, 92, 1, 'Réserves : 2 450 000 €', 8500000,
'<p>Epargne Pierre, créée en 1999, est l\'une des SCPI historiques du marché français. Elle investit principalement dans des bureaux et commerces situés en Île-de-France et dans les principales métropoles régionales. La stratégie privilégie les actifs de qualité à fort potentiel locatif, avec une gestion patrimoniale rigoureuse visant la pérennité des revenus.</p>',
'<p>La SCPI Epargne Pierre continue de démontrer sa résilience avec un rendement stable et un patrimoine diversifié. Le taux de recouvrement des loyers s\'établit à 98,5%, confirmant la qualité des locataires et la pertinence des emplacements. La collecte nette du trimestre s\'élève à 18 millions d\'euros.</p>',
'<p>Epargne Pierre a acquis un immeuble de bureaux moderne à Lyon pour 15 millions d\'euros, entièrement loué à un locataire de premier rang. Un important programme de rénovation énergétique a été lancé sur plusieurs actifs parisiens pour améliorer leur performance environnementale et leur attractivité.</p>',
'<p>12 % TTC du prix de souscription</p>',
'<p>10 % HT des produits locatifs encaissés et des produits financiers nets</p>',
'<p>2 % HT du prix de vente net vendeur si inférieur à 5 M€, 1,5 % HT si supérieur</p>',
'<p>1 % HT sur les travaux supérieurs à 100 000 € HT</p>',
'<p>75 € HT de frais de dossier</p>',
'<p>75 € HT de frais de dossier</p>',
NOW(), NOW(), 2);

-- Produit 3: SCPI PATRIMOINE ET COMMERCE
INSERT INTO `mc_produit` (`id`, `name`, `soc_gest`, `capital`, `thematique`, `capitalisation`, `nb_assoc`, `image_name`, `slug`, `is_promo`, `share_price`, `share_nbr`, `share_sub_min`, `fruition_delay`, `withdrawal_value`, `immvable_nbr`, `surface`, `tenant_nbr`, `top`, `tof`, `life_insurance_avaible`, `reserve_ran`, `works_advance`, `invest_strat`, `info_trim`, `life_asset_trim`, `subscription_com`, `manage_com`, `arb_mov_com`, `pilot_works_com`, `wit_cession_com`, `share_muta_com`, `created_at`, `updated_at`, `categorie_id`) VALUES
(12, 'SCPI PATRIMOINE ET COMMERCE', 'Paref Gestion', 'Variable', 'Commerces de proximité', 1.6, 18200, NULL, 'scpi-patrimoine-et-commerce', 1, 1050, 1523809, 10, '1er jour du 4ème mois', 1025, 142, 98500, 285, 96, 95, 1, 'RAN : 1 250 000 €', 5200000,
'<p>Patrimoine et Commerce se spécialise dans l\'acquisition de commerces de proximité en pied d\'immeuble, principalement dans les centres-villes et quartiers dynamiques. Cette stratégie permet de bénéficier de loyers réguliers issus de commerces alimentaires, pharmacies, banques et enseignes nationales reconnues, offrant une grande résilience économique.</p>',
'<p>La SCPI maintient un excellent taux d\'occupation à 95% grâce à la qualité de ses emplacements commerciaux. Le dernier trimestre a été marqué par une collecte dynamique de 12 millions d\'euros et par le renouvellement de plusieurs baux avec revalorisation des loyers. Les commerces de proximité continuent de démontrer leur résilience.</p>',
'<p>Patrimoine et Commerce a investi dans 5 nouveaux actifs commerciaux situés à Lyon, Bordeaux et Toulouse, pour un montant total de 8,5 millions d\'euros. Ces acquisitions incluent des pharmacies, une boulangerie-pâtisserie et deux locaux de restauration rapide, tous loués à des enseignes reconnues.</p>',
'<p>10 % TTC du prix de souscription</p>',
'<p>8 % HT des loyers encaissés</p>',
'<p>1,5 % HT du montant de la transaction</p>',
'<p>2 % HT des travaux</p>',
'<p>90 € TTC par dossier</p>',
'<p>90 € TTC pour les cessions, 150 € TTC pour les mutations</p>',
NOW(), NOW(), 1);

-- Produit 4: SCPI IMMORENTE
INSERT INTO `mc_produit` (`id`, `name`, `soc_gest`, `capital`, `thematique`, `capitalisation`, `nb_assoc`, `image_name`, `slug`, `is_promo`, `share_price`, `share_nbr`, `share_sub_min`, `fruition_delay`, `withdrawal_value`, `immvable_nbr`, `surface`, `tenant_nbr`, `top`, `tof`, `life_insurance_avaible`, `reserve_ran`, `works_advance`, `invest_strat`, `info_trim`, `life_asset_trim`, `subscription_com`, `manage_com`, `arb_mov_com`, `pilot_works_com`, `wit_cession_com`, `share_muta_com`, `created_at`, `updated_at`, `categorie_id`) VALUES
(13, 'SCPI IMMORENTE', 'Sofidy', 'Variable', 'Diversifiée', 3.5, 28900, NULL, 'scpi-immorente', 0, 27500, 127272, 3, '1er jour du 5ème mois', 26800, 168, 325000, 245, 95, 93, 0, 'Réserves : 3 850 000 €', 11200000,
'<p>Immorente est une SCPI diversifiée créée en 1986, l\'une des plus anciennes du marché. Elle investit dans des bureaux, commerces, hôtels et locaux d\'activité, principalement en France. Son patrimoine mature et diversifié offre une grande stabilité de revenus. La stratégie privilégie les actifs bien situés avec des baux longs et des locataires de qualité.</p>',
'<p>Immorente poursuit sa stratégie de diversification avec un patrimoine équilibré entre différents secteurs d\'activité. Le taux d\'occupation reste satisfaisant à 93%. La SCPI a distribué ce trimestre un dividende stable, confirmant la régularité de ses performances. La maturité du patrimoine permet une gestion optimisée des cash-flows.</p>',
'<p>La SCPI a procédé à l\'acquisition d\'un hôtel 4 étoiles à Strasbourg pour 12 millions d\'euros, loué à un exploitant reconnu sous bail ferme de 12 ans. Un actif de bureaux vieillissant en première couronne parisienne a été cédé pour 8 millions d\'euros, permettant un arbitrage patrimonial favorable.</p>',
'<p>11 % TTC du prix de souscription</p>',
'<p>10 % HT des produits locatifs et financiers</p>',
'<p>2 % HT du montant de la transaction</p>',
'<p>1,5 % HT des travaux</p>',
'<p>80 € TTC par dossier</p>',
'<p>80 € TTC par dossier</p>',
NOW(), NOW(), 2);

-- Produit 5: SCPI FONCIA CAPITAL REGIES
INSERT INTO `mc_produit` (`id`, `name`, `soc_gest`, `capital`, `thematique`, `capitalisation`, `nb_assoc`, `image_name`, `slug`, `is_promo`, `share_price`, `share_nbr`, `share_sub_min`, `fruition_delay`, `withdrawal_value`, `immvable_nbr`, `surface`, `tenant_nbr`, `top`, `tof`, `life_insurance_avaible`, `reserve_ran`, `works_advance`, `invest_strat`, `info_trim`, `life_asset_trim`, `subscription_com`, `manage_com`, `arb_mov_com`, `pilot_works_com`, `wit_cession_com`, `share_muta_com`, `created_at`, `updated_at`, `categorie_id`) VALUES
(14, 'SCPI FONCIA CAPITAL REGIES', 'Foncia Pierre Gestion', 'Variable', 'Murs de boutiques', 1.2, 12500, NULL, 'scpi-foncia-capital-regies', 0, 950, 1263157, 8, '1er jour du 6ème mois', 920, 218, 125000, 412, 97, 96, 1, 'RAN par part : 4,25 €', 4500000,
'<p>Foncia Capital Régies est spécialisée dans l\'acquisition de murs commerciaux de petite et moyenne taille, situés dans les centres-villes et zones commerciales dynamiques. La SCPI privilégie la diversification par le nombre d\'actifs plutôt que par leur taille, répartissant ainsi les risques locatifs. Les emplacements numéro 1 et 1bis sont privilégiés.</p>',
'<p>La SCPI bénéficie d\'un patrimoine très atomisé avec 218 actifs et 412 locataires, offrant une excellente mutualisation des risques. Le taux d\'occupation de 96% témoigne de la qualité des emplacements. Le dernier trimestre a vu 15 nouveaux baux signés ou renouvelés, la plupart avec indexation positive.</p>',
'<p>Foncia Capital Régies a acquis 8 nouveaux murs commerciaux au cours du trimestre pour un total de 5,2 millions d\'euros, incluant des boutiques à Paris, Lyon et Marseille. Les locataires incluent des enseignes de prêt-à-porter, restauration et services. Trois actifs non stratégiques ont été cédés pour optimiser le patrimoine.</p>',
'<p>10 % TTC du prix de souscription</p>',
'<p>10 % HT des loyers encaissés</p>',
'<p>1 % HT du prix de cession</p>',
'<p>2,5 % HT des travaux</p>',
'<p>75 € TTC par dossier</p>',
'<p>75 € TTC pour cessions, 180 € TTC pour mutations</p>',
NOW(), NOW(), 1);

-- Produit 6: SCPI EUROVALYS
INSERT INTO `mc_produit` (`id`, `name`, `soc_gest`, `capital`, `thematique`, `capitalisation`, `nb_assoc`, `image_name`, `slug`, `is_promo`, `share_price`, `share_nbr`, `share_sub_min`, `fruition_delay`, `withdrawal_value`, `immvable_nbr`, `surface`, `tenant_nbr`, `top`, `tof`, `life_insurance_avaible`, `reserve_ran`, `works_advance`, `invest_strat`, `info_trim`, `life_asset_trim`, `subscription_com`, `manage_com`, `arb_mov_com`, `pilot_works_com`, `wit_cession_com`, `share_muta_com`, `created_at`, `updated_at`, `categorie_id`) VALUES
(15, 'SCPI EUROVALYS', 'Euryale Asset Management', 'Variable', 'Immobilier tertiaire européen', 2.1, 15800, NULL, 'scpi-eurovalys', 1, 1150, 1826086, 5, '1er jour du 4ème mois', 1120, 78, 285000, 165, 93, 91, 1, 'Réserves : 1 850 000 €', 7800000,
'<p>Eurovalys investit dans l\'immobilier tertiaire européen de qualité, principalement des bureaux et de la logistique. La stratégie se concentre sur les grandes métropoles européennes offrant une forte liquidité et des perspectives de croissance attractives. La SCPI privilégie les actifs certifiés environnementaux répondant aux nouveaux standards du marché.</p>',
'<p>Eurovalys poursuit son développement européen avec des acquisitions ciblées en Allemagne et au Portugal. Le taux d\'occupation de 91% reflète une gestion active du patrimoine avec plusieurs projets de repositionnement en cours. La collecte du trimestre s\'établit à 15 millions d\'euros, témoignant de l\'intérêt des investisseurs pour l\'exposition européenne.</p>',
'<p>La SCPI a investi dans un campus de bureaux à Lisbonne pour 18 millions d\'euros et un entrepôt logistique à Hambourg pour 12 millions d\'euros. Ces actifs bénéficient de certifications environnementales BREEAM et sont loués à des locataires de premier plan. Un programme d\'amélioration énergétique a été lancé sur plusieurs actifs français.</p>',
'<p>9,75 % TTC du prix de souscription</p>',
'<p>9 % HT des produits locatifs encaissés</p>',
'<p>1,5 % HT du montant de la transaction</p>',
'<p>3 % HT des travaux</p>',
'<p>85 € TTC par dossier</p>',
'<p>85 € TTC pour cessions, 200 € TTC pour mutations</p>',
NOW(), NOW(), 1);

-- Produit 7: SCPI FAIR INVEST
INSERT INTO `mc_produit` (`id`, `name`, `soc_gest`, `capital`, `thematique`, `capitalisation`, `nb_assoc`, `image_name`, `slug`, `is_promo`, `share_price`, `share_nbr`, `share_sub_min`, `fruition_delay`, `withdrawal_value`, `immvable_nbr`, `surface`, `tenant_nbr`, `top`, `tof`, `life_insurance_avaible`, `reserve_ran`, `works_advance`, `invest_strat`, `info_trim`, `life_asset_trim`, `subscription_com`, `manage_com`, `arb_mov_com`, `pilot_works_com`, `wit_cession_com`, `share_muta_com`, `created_at`, `updated_at`, `categorie_id`) VALUES
(16, 'SCPI FAIR INVEST', 'Advenis REIM', 'Variable', 'ISR - Développement durable', 0.9, 8500, NULL, 'scpi-fair-invest', 0, 1200, 750000, 5, '1er jour du 3ème mois', 1175, 45, 125000, 98, 98, 97, 1, 'RAN par part : 8,15 €', 3200000,
'<p>Fair Invest est une SCPI labellisée ISR (Investissement Socialement Responsable) dédiée au développement durable. Elle investit exclusivement dans des actifs immobiliers à haute performance environnementale : bureaux certifiés HQE, BBC ou BREEAM, logements à basse consommation énergétique, et commerces éco-responsables. L\'impact environnemental et social est au cœur de la stratégie d\'investissement.</p>',
'<p>Fair Invest continue de démontrer que performance financière et responsabilité environnementale sont compatibles. Le patrimoine affiche un excellent taux d\'occupation de 97% et une empreinte carbone 40% inférieure à la moyenne du marché. La SCPI a obtenu le label ISR et la certification GRESB 4 étoiles, reconnaissant ses pratiques ESG exemplaires.</p>',
'<p>La SCPI a acquis un immeuble de bureaux passif à Nanterre certifié BREEAM Excellent pour 8 millions d\'euros et une résidence de logements BBC à Lyon pour 5 millions d\'euros. Ces actifs contribuent positivement aux objectifs de réduction d\'émissions carbone. Un programme de rénovation énergétique profonde a été lancé sur 3 actifs existants.</p>',
'<p>9,50 % TTC du prix de souscription</p>',
'<p>8 % HT des produits locatifs encaissés</p>',
'<p>1,5 % HT du montant de la transaction</p>',
'<p>2,5 % HT des travaux</p>',
'<p>75 € TTC par dossier</p>',
'<p>75 € TTC pour cessions, 180 € TTC pour mutations</p>',
NOW(), NOW(), 1);

-- ========================================
-- INSERTION DES PERFORMANCES (4 ans par produit)
-- ========================================

-- Performances CORUM ORIGIN
INSERT INTO `mc_performance` (`year`, `rate`, `product_id`) VALUES
(2020, 6.02, 10),
(2021, 6.15, 10),
(2022, 6.28, 10),
(2023, 6.35, 10);

-- Performances EPARGNE PIERRE
INSERT INTO `mc_performance` (`year`, `rate`, `product_id`) VALUES
(2020, 4.65, 11),
(2021, 4.72, 11),
(2022, 4.68, 11),
(2023, 4.75, 11);

-- Performances PATRIMOINE ET COMMERCE
INSERT INTO `mc_performance` (`year`, `rate`, `product_id`) VALUES
(2020, 5.12, 12),
(2021, 5.25, 12),
(2022, 5.18, 12),
(2023, 5.30, 12);

-- Performances IMMORENTE
INSERT INTO `mc_performance` (`year`, `rate`, `product_id`) VALUES
(2020, 4.85, 13),
(2021, 4.92, 13),
(2022, 4.88, 13),
(2023, 4.95, 13);

-- Performances FONCIA CAPITAL REGIES
INSERT INTO `mc_performance` (`year`, `rate`, `product_id`) VALUES
(2020, 5.45, 14),
(2021, 5.52, 14),
(2022, 5.48, 14),
(2023, 5.55, 14);

-- Performances EUROVALYS
INSERT INTO `mc_performance` (`year`, `rate`, `product_id`) VALUES
(2020, 5.75, 15),
(2021, 5.88, 15),
(2022, 5.92, 15),
(2023, 6.05, 15);

-- Performances FAIR INVEST
INSERT INTO `mc_performance` (`year`, `rate`, `product_id`) VALUES
(2020, 4.95, 16),
(2021, 5.12, 16),
(2022, 5.25, 16),
(2023, 5.38, 16);

-- ========================================
-- INSERTION DES RÉPARTITIONS GÉOGRAPHIQUES
-- ========================================

-- Répartitions géographiques CORUM ORIGIN
INSERT INTO `mc_repart_geo` (`geo_name`, `geo_value`, `produit_id`) VALUES
('France', 35.5, 10),
('Allemagne', 28.3, 10),
('Espagne', 18.2, 10),
('Italie', 12.0, 10),
('Pays-Bas', 6.0, 10);

-- Répartitions géographiques EPARGNE PIERRE
INSERT INTO `mc_repart_geo` (`geo_name`, `geo_value`, `produit_id`) VALUES
('Île-de-France', 55.0, 11),
('Auvergne-Rhône-Alpes', 20.0, 11),
('Occitanie', 12.0, 11),
('Nouvelle-Aquitaine', 8.0, 11),
('PACA', 5.0, 11);

-- Répartitions géographiques PATRIMOINE ET COMMERCE
INSERT INTO `mc_repart_geo` (`geo_name`, `geo_value`, `produit_id`) VALUES
('Paris', 25.0, 12),
('Région Parisienne', 30.0, 12),
('Grandes métropoles', 35.0, 12),
('Autres régions', 10.0, 12);

-- Répartitions géographiques IMMORENTE
INSERT INTO `mc_repart_geo` (`geo_name`, `geo_value`, `produit_id`) VALUES
('Île-de-France', 42.0, 13),
('Hauts-de-France', 18.0, 13),
('Grand Est', 15.0, 13),
('Auvergne-Rhône-Alpes', 15.0, 13),
('Autres', 10.0, 13);

-- Répartitions géographiques FONCIA CAPITAL REGIES
INSERT INTO `mc_repart_geo` (`geo_name`, `geo_value`, `produit_id`) VALUES
('Paris', 35.0, 14),
('Lyon', 18.0, 14),
('Marseille', 12.0, 14),
('Bordeaux', 10.0, 14),
('Toulouse', 10.0, 14),
('Autres villes', 15.0, 14);

-- Répartitions géographiques EUROVALYS
INSERT INTO `mc_repart_geo` (`geo_name`, `geo_value`, `produit_id`) VALUES
('France', 40.0, 15),
('Allemagne', 25.0, 15),
('Belgique', 15.0, 15),
('Portugal', 12.0, 15),
('Espagne', 8.0, 15);

-- Répartitions géographiques FAIR INVEST
INSERT INTO `mc_repart_geo` (`geo_name`, `geo_value`, `produit_id`) VALUES
('Île-de-France', 50.0, 16),
('Auvergne-Rhône-Alpes', 25.0, 16),
('Nouvelle-Aquitaine', 15.0, 16),
('Occitanie', 10.0, 16);

-- ========================================
-- INSERTION DES RÉPARTITIONS SECTORIELLES
-- ========================================

-- Répartitions sectorielles CORUM ORIGIN
INSERT INTO `mc_repart_sector` (`sector_name`, `sector_value`, `produit_id`) VALUES
('Bureaux', 45.0, 10),
('Commerces', 30.0, 10),
('Résidentiel', 15.0, 10),
('Logistique', 10.0, 10);

-- Répartitions sectorielles EPARGNE PIERRE
INSERT INTO `mc_repart_sector` (`sector_name`, `sector_value`, `produit_id`) VALUES
('Bureaux', 60.0, 11),
('Commerces', 25.0, 11),
('Entrepôts', 15.0, 11);

-- Répartitions sectorielles PATRIMOINE ET COMMERCE
INSERT INTO `mc_repart_sector` (`sector_name`, `sector_value`, `produit_id`) VALUES
('Commerces alimentaires', 45.0, 12),
('Commerces spécialisés', 35.0, 12),
('Restauration', 12.0, 12),
('Services', 8.0, 12);

-- Répartitions sectorielles IMMORENTE
INSERT INTO `mc_repart_sector` (`sector_name`, `sector_value`, `produit_id`) VALUES
('Bureaux', 55.0, 13),
('Commerces', 22.0, 13),
('Hôtels', 13.0, 13),
('Logistique', 10.0, 13);

-- Répartitions sectorielles FONCIA CAPITAL REGIES
INSERT INTO `mc_repart_sector` (`sector_name`, `sector_value`, `produit_id`) VALUES
('Murs de boutiques', 75.0, 14),
('Bureaux', 15.0, 14),
('Entrepôts', 10.0, 14);

-- Répartitions sectorielles EUROVALYS
INSERT INTO `mc_repart_sector` (`sector_name`, `sector_value`, `produit_id`) VALUES
('Bureaux', 65.0, 15),
('Logistique', 20.0, 15),
('Commerces', 15.0, 15);

-- Répartitions sectorielles FAIR INVEST
INSERT INTO `mc_repart_sector` (`sector_name`, `sector_value`, `produit_id`) VALUES
('Bureaux verts', 60.0, 16),
('Logements BBC', 25.0, 16),
('Commerces éco-responsables', 15.0, 16);

-- ========================================
-- FIN DES FIXTURES
-- ========================================

-- Affichage du résultat
SELECT 'Fixtures SCPI chargées avec succès !' AS message;
SELECT COUNT(*) AS nb_produits FROM mc_produit WHERE id >= 10;
SELECT COUNT(*) AS nb_performances FROM mc_performance WHERE product_id >= 10;
SELECT COUNT(*) AS nb_repart_geo FROM mc_repart_geo WHERE produit_id >= 10;
SELECT COUNT(*) AS nb_repart_sector FROM mc_repart_sector WHERE produit_id >= 10;
