-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: db-sf5
-- ------------------------------------------------------
-- Server version	8.0.37

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `answer`
--

DROP TABLE IF EXISTS `answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `answer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `votes` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `question_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DADD4A251E27F6BF` (`question_id`),
  CONSTRAINT `FK_DADD4A251E27F6BF` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer`
--

LOCK TABLES `answer` WRITE;
/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
/*!40000 ALTER TABLE `answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20200707173854','2024-06-02 13:28:04',121),('DoctrineMigrations\\Version20200707174149','2024-06-02 13:28:05',64),('DoctrineMigrations\\Version20200708195925','2024-06-02 13:28:05',45),('DoctrineMigrations\\Version20200709153558','2024-06-02 13:28:05',76),('DoctrineMigrations\\Version20230615135419','2024-06-02 13:28:05',30),('DoctrineMigrations\\Version20230618214552','2024-06-02 13:28:05',93),('DoctrineMigrations\\Version20230618221216','2024-06-02 13:28:05',299),('DoctrineMigrations\\Version20240602123034','2024-06-02 13:28:05',26);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `question` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `asked_at` datetime DEFAULT NULL,
  `votes` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B6F7494E989D9B62` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (1,'March Hare. \'Sixteenth,\' added the March Hare.','doloremque-sit-consequatur-voluptatum-sequi-aut-quae-sequi-suscipit-placeat-qui','Quidem possimus praesentium ratione qui corporis qui. Quas praesentium rerum aut sed. Autem iure perspiciatis aliquam in error ea alias. Ratione vel atque in doloremque ut aliquid neque.','2024-04-21 06:54:21',45,NULL,NULL),(2,'I don\'t think,\' Alice went on, without attending.','nesciunt-omnis-qui-tenetur-non-nostrum-rerum-dolores-iste-odio-dolorum-laboriosam-repudiandae-impedit','Consectetur at tempore sapiente dolorem eaque. Consequuntur dolores occaecati ratione amet quo ipsum. Rerum impedit voluptatibus porro explicabo nulla qui recusandae corrupti. Inventore dolor nesciunt excepturi id quod voluptates id.\n\nQuasi tenetur iure iusto quo consequatur iste. Possimus beatae nulla consequatur quo est incidunt. Reprehenderit nulla aliquid voluptatem et qui pariatur. At distinctio culpa dolores consectetur facere eius velit vel.\n\nAliquam ut explicabo id sint repellat est necessitatibus impedit. Delectus laborum debitis quis et. Omnis velit odio ad qui enim.','2024-04-30 13:26:09',16,NULL,NULL),(3,'Five! Don\'t go splashing paint over me like.','est-aut-minima-delectus-non-non-aut-quis-facilis-doloribus-sapiente-dolor','Enim quibusdam praesentium dolor dolor. Sunt necessitatibus ad blanditiis. Nulla neque dolore iusto magnam dolor.\n\nIpsam nesciunt sed ullam voluptas. Deleniti asperiores error omnis. Qui voluptas sapiente repellendus et consectetur. Est eos dolorum architecto in qui velit.\n\nSint sed non in optio tempore vel. Magni enim animi ut velit sed iusto. Autem excepturi saepe nam et reiciendis enim beatae aut. Enim asperiores eum aliquid delectus ut aperiam vero.\n\nAliquid est voluptas eos nostrum quo est saepe. Sapiente vel sit natus. Molestias suscipit totam est nulla corrupti sed et. Aut aut dolorem unde. Qui suscipit voluptatem sunt molestias.','2024-04-24 19:36:35',3,NULL,NULL),(4,'I could not help thinking there MUST be more to.','voluptas-et-ipsam-reprehenderit-delectus-harum-est-nulla-itaque-qui-saepe-commodi-nisi','Aut velit autem porro. Et incidunt provident ratione non. Et voluptatem voluptas vitae rerum sapiente.','2024-04-05 07:28:05',33,NULL,NULL),(5,'Alice. \'It goes on, you know,\' the Mock Turtle\'s.','impedit-eaque-aut-provident-quisquam-maiores-rem-quia-quia-aut','Ratione quo et voluptates et inventore commodi. Rerum minima consequatur voluptate distinctio. Excepturi ut blanditiis magnam aut est.\n\nNobis id autem non tempora minus necessitatibus possimus. Qui debitis et eum aut dolorem saepe. Quasi aut esse blanditiis esse.\n\nIusto vel hic saepe repellat temporibus hic. Et dolor ipsa eos voluptates aliquam eveniet est. Tempora aut nostrum dolores voluptatibus maxime ut.','2024-03-30 15:52:18',42,NULL,NULL),(6,'Alice went on eagerly. \'That\'s enough about.','rerum-placeat-ipsa-et-reiciendis-doloribus-consequuntur-perspiciatis-quas-illum-fugiat-fugit','Quia perferendis hic molestias ab. Dolorem architecto alias ut numquam at.','2024-05-20 02:39:25',20,NULL,NULL),(7,'Mock Turtle would be as well say,\' added the.','ut-est-nam-omnis-aut-ut-dolorem','Molestiae quibusdam tempora placeat veritatis asperiores et voluptatem. Quas recusandae veritatis quisquam doloribus blanditiis exercitationem. Nulla ut ut iste eum quidem in excepturi. Nemo accusantium aut aspernatur. Eum neque repellendus sed eum et ullam.\n\nMinima in fugit dicta quis repellat iure voluptate nisi. Aspernatur aliquam impedit tempora corrupti tenetur provident consequuntur. Quae omnis voluptatibus repellat ut aut sint harum est.\n\nPerspiciatis deleniti possimus excepturi quos ab nesciunt omnis. Sit ut necessitatibus alias reiciendis et dignissimos nihil inventore. Voluptas debitis impedit omnis ab perferendis magnam dolorem. Sed magni dignissimos dolorum corrupti alias voluptatum.','2024-05-05 09:39:02',-16,NULL,NULL),(8,'The cook threw a frying-pan after her as she.','nostrum-sed-ut-nesciunt-dolorem-esse-ut-repellendus-assumenda-saepe-dolorem-voluptatibus-ut-earum','Porro velit quia natus sint eum. Quisquam id nam iure tempora atque illum est. Eos sed amet officia fugiat totam. Necessitatibus velit dicta aut dignissimos quibusdam.\n\nCorrupti eligendi architecto odio sunt. Officiis et pariatur voluptatem in. Recusandae dolorem voluptate est eos omnis nulla iusto. Eos quod aliquid assumenda vero.\n\nEt veritatis est inventore distinctio nihil laboriosam quia. Veritatis ut voluptates est qui commodi eius suscipit. Voluptatum voluptas distinctio dolore non magnam adipisci.\n\nNobis eum cupiditate nostrum occaecati ea voluptatem. Quis et sit dolorum et velit error. Enim laborum voluptas quisquam dolorum accusamus non incidunt. Eligendi et corrupti voluptas quaerat ipsam fugiat.','2024-04-25 10:47:33',44,NULL,NULL),(9,'Alice \'without pictures or conversations?\' So.','tenetur-nesciunt-dolor-aut-ut-nostrum-consequatur','Et ratione libero veritatis eius qui. Dolores quo sit eum soluta. Sit alias est sit qui quisquam voluptatem.\n\nVelit optio voluptas repellat quam ad in rerum. Aspernatur minima voluptatem sed temporibus minus.\n\nEum molestiae dignissimos rerum corporis voluptatem unde fugiat. Possimus eum nisi eaque ut excepturi fuga. Eos aperiam asperiores quas.','2024-03-29 12:32:34',35,NULL,NULL),(10,'Hatter: and in despair she put it. She went in.','cupiditate-ad-officiis-distinctio-soluta-cum-dolorum-debitis-fuga-neque-earum','Aut asperiores nobis dolor at vero autem. Delectus et quae maxime velit. Nisi consequatur et dolores ut doloribus necessitatibus. Ut mollitia id velit et velit minima. Optio cumque quo dolorem.','2024-03-18 09:40:20',8,NULL,NULL),(11,'Rabbit\'s voice; and the soldiers remaining.','et-id-nam-quia-eius-laborum-et-est-sunt-autem-laboriosam-est-consequatur','Fuga blanditiis eum maxime esse. Impedit quis sequi ut mollitia delectus voluptate consequatur. Architecto et laboriosam eligendi rerum voluptatem. Aperiam qui beatae autem adipisci est ducimus pariatur.','2024-04-16 22:43:17',10,NULL,NULL),(12,'Queen said severely \'Who is it twelve? I--\' \'Oh.','neque-voluptatem-quia-quis-dolorem-sint-deleniti-provident-vitae-molestiae-cumque-at','Ea debitis dignissimos in harum laborum fugit laboriosam. Culpa ea tempora doloribus fugit esse quod quia. Repudiandae alias quas et natus expedita aspernatur id eligendi. Qui delectus sint non commodi fugiat illo.\n\nAt voluptatem dicta consequuntur dolorem occaecati beatae. Nemo est occaecati est aliquam sunt quisquam. Et quod mollitia rerum inventore quisquam nobis ipsam tempora.\n\nDolorem qui tempore minima neque. Voluptas laudantium in fuga ut. Qui officiis magnam sunt fuga qui inventore ratione eum.\n\nAutem qui voluptatem voluptatem fugit quam in repudiandae. Tempore iusto sit dolor doloremque. Consequatur nostrum reprehenderit explicabo dolor unde.','2024-04-18 11:07:23',40,NULL,NULL),(13,'All the time he had taken advantage of the.','perspiciatis-consequuntur-quia-omnis-esse-iste-culpa-et-beatae','Consequatur optio eum ratione molestiae. Deserunt nihil eveniet illo odio iure. Et sunt dicta omnis commodi. Repellat ut rerum perspiciatis molestiae.\n\nLibero non sapiente molestias dolorum amet neque neque incidunt. Nostrum saepe aut et debitis enim aut. Sapiente sit architecto ab aliquam sunt. Vitae eveniet magnam magni earum.','2024-05-28 08:51:18',-17,NULL,NULL),(14,'Queen,\' and she swam about, trying to invent.','culpa-sint-fugiat-ex-voluptatem-corporis-rem-maxime-sunt-ut-ut-dolor-tempore','Consequuntur commodi provident ea sint aliquid voluptas. Alias ut quam non aut a excepturi. Earum veritatis pariatur perspiciatis doloremque. Ipsum et aut inventore.\n\nEnim corporis aut nobis tempore odit. Aut suscipit dolorum qui qui autem porro eaque. Quibusdam et qui iusto qui quo perspiciatis qui.','2024-05-01 19:09:48',33,NULL,NULL),(15,'I shall have some fun now!\' thought Alice. The.','ut-culpa-aperiam-dolor-quaerat-dolorem-nihil-explicabo-qui-blanditiis-fugiat-sed-ut-rerum','Ipsam voluptatem dolor dignissimos omnis necessitatibus repudiandae tempora et. Voluptas distinctio aut accusamus quas iusto. Tempora ipsum a et odio.\n\nQuas quaerat recusandae officia dolorem dolor. Quia deleniti et occaecati fugit. Ut deserunt est tempore consequuntur expedita repellat magni. Deleniti praesentium quidem vel eveniet ut quis.\n\nDeleniti corrupti sequi mollitia. Deserunt et asperiores beatae nihil quia. Qui et magnam saepe autem sint.\n\nQui voluptate corporis eligendi non est ut rerum. Vero harum ratione omnis facilis earum cumque. Assumenda numquam exercitationem mollitia eum itaque animi. Occaecati maxime ut voluptate. A eum voluptatem impedit assumenda quia in sapiente.','2024-03-09 05:20:23',34,NULL,NULL),(16,'The Hatter shook his grey locks, \'I kept all my.','quos-consequatur-ipsam-voluptas-dolores-iste-ea-rerum-praesentium','Ut aut non ipsum quae. Sit vel voluptas nobis et aperiam rerum. Temporibus eveniet vitae qui assumenda incidunt.','2024-05-14 19:43:38',8,NULL,NULL),(17,'Alice. \'Well, then,\' the Cat said, waving its.','est-doloribus-ullam-rerum-veniam-maxime-fuga','Harum voluptatem aperiam fugit omnis consectetur atque autem. Cupiditate aspernatur natus voluptatem sequi voluptate natus rerum. Laborum quaerat sunt consequatur numquam dolores sequi.\n\nVoluptatem cum ea eligendi ipsum omnis. Numquam et delectus aliquam vel quidem sequi. Expedita voluptas cumque voluptate quia velit pariatur. Officia sint at sed fuga et est.\n\nAccusantium qui omnis veniam explicabo adipisci. A adipisci pariatur dolores dolores quos veritatis. Possimus et tempore est laboriosam deleniti blanditiis et molestiae.','2024-04-29 00:21:31',27,NULL,NULL),(18,'As she said to herself in a minute. Alice began.','magnam-consequatur-ut-autem-sed-qui-libero-voluptatem-voluptates-quis-vel-animi-quo','Temporibus aut accusamus repellendus et. Voluptates et suscipit doloribus ratione minima laboriosam tempora. Quisquam molestiae accusamus eos maxime mollitia. Ea numquam ad dignissimos distinctio ipsam sit tempora.','2024-04-08 15:20:31',26,NULL,NULL),(19,'The first question of course you know about it.','debitis-natus-delectus-aperiam-doloribus-qui-ut-laboriosam-vel-voluptas-numquam-corrupti-et','Enim dolores doloribus est asperiores. Expedita laboriosam quo voluptas est qui ad sed distinctio. Et consequatur sequi molestiae sit et. Tenetur quis est et tenetur ea. Accusantium nihil cupiditate blanditiis enim officia mollitia.\n\nQuisquam praesentium optio voluptatem porro pariatur non temporibus. Natus et labore iure itaque aut cum. Quia iusto nam nihil illum quam architecto nihil.\n\nSunt sit eius eos voluptatem. Placeat nulla sint rerum soluta. Et corporis sit voluptate sed aut sapiente.','2024-04-14 04:26:10',1,NULL,NULL),(20,'They\'re dreadfully fond of beheading people.','eius-in-nam-et-a-consequatur-in-ad-architecto-quis','Nihil quam cum sunt. Quos est maxime necessitatibus animi. Non velit veniam atque perspiciatis voluptas excepturi ullam. Ut aut aperiam accusamus rerum omnis distinctio est.\n\nVoluptatem magni mollitia ad quia neque quasi. Consequatur dolorem et voluptatum. Saepe quia eos et at.\n\nNostrum et rerum quos tempore vel aliquam voluptatem. Dolores et at perspiciatis. Nesciunt similique natus est voluptas odit natus laborum. Quidem esse eius et similique et.\n\nEaque sit odit iure alias. Sit facere et dignissimos voluptas. Ut blanditiis nulla sequi ad. Et omnis rem eius autem ad velit. Rem expedita natus sapiente accusantium repellendus blanditiis nesciunt.','2024-02-25 04:22:35',49,NULL,NULL),(21,'Alice\'s Evidence \'Here!\' cried Alice, jumping up.','doloribus-quod-labore-nemo-sapiente-doloremque-totam-saepe','Esse quia repudiandae magni provident quidem. Excepturi itaque qui autem qui et molestiae. Velit tenetur iure fugit animi aut accusamus.',NULL,23,NULL,NULL),(22,'Alice. \'I\'ve read that in the sky. Alice went.','sed-voluptas-necessitatibus-blanditiis-alias-nostrum-quo-exercitationem-commodi-ullam','Commodi provident sed laudantium incidunt. Ut aut inventore deserunt quaerat praesentium mollitia natus eum. Beatae alias enim ratione inventore rem. Totam repellat est reiciendis possimus sint.\n\nCommodi sunt est velit odit. Sequi quos repellendus esse repellat. Eius distinctio ut eveniet quidem. Dolorum quibusdam soluta nisi suscipit sunt.\n\nAnimi voluptatem sunt similique qui. Aut ut qui sed ad et. Et ut consectetur maiores. Aspernatur occaecati nulla est suscipit.',NULL,12,NULL,NULL),(23,'Then the Queen to-day?\' \'I should like it put.','excepturi-sed-et-nemo-maxime-itaque-vero-qui-earum-reiciendis-exercitationem-ipsam','Quasi explicabo aut perspiciatis quas ut nihil. Itaque illum doloribus ipsam repellat aut et. Soluta quaerat qui voluptatem. Aspernatur similique cumque mollitia distinctio.',NULL,17,NULL,NULL),(24,'Alice got up very sulkily and crossed over to.','quia-officiis-et-ut-veritatis-voluptatibus-officia-cumque-in-eum-est-voluptate-tenetur-quos','Corrupti quibusdam alias non soluta soluta. Consequatur qui et sed consequatur cum. Tempora placeat non eos optio sed molestias distinctio. Sint eveniet quidem tenetur dolorem et itaque. Dolorum officiis enim sint.\n\nNecessitatibus laborum nam doloribus velit. Cupiditate officia cum sit dicta quia voluptatibus.\n\nSit iure labore quo fuga explicabo ut expedita voluptas. Inventore aliquid nihil officia rerum rerum nemo. Et illo magnam nam voluptatum ex ipsam. Dolorem et explicabo rerum perspiciatis.',NULL,40,NULL,NULL),(25,'Duchess: you\'d better finish the story for.','et-earum-impedit-culpa-sunt-ea-rerum-ipsum-ex','Ab dolorem itaque in veritatis voluptas dignissimos. Repellendus commodi cumque eos dicta sit.\n\nPerspiciatis possimus tempore minus cumque tempore suscipit et. Et dolor veritatis dicta quos et quas quisquam. Earum quam ullam laudantium. Sunt similique est illum nemo ad consectetur sit.',NULL,-8,NULL,NULL);
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'db-sf5'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-02 17:27:31
