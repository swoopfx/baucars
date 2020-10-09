--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `name`, `abbreviation`) VALUES
(1, 'English', 'en'),
(2, 'FranÃ§ais', 'fr'),
(3, 'Deutsch', 'de'),
(4, 'EspaÃ±ol', 'es'),
(5, 'Italiano', 'it'),
(6, 'Ð‘ÑŠÐ»Ð³Ð°Ñ€Ñ�ÐºÐ¸', 'bg');

--
-- Dumping data for table `role`
--

INSERT INTO `retail_role` (`id`, `name`) VALUES
(1, 'Guest'),
(20, 'Member'),
(20, 'Guarateed'),
(30, 'Profiled');

--
-- Dumping data for table `roles_parents`
--

INSERT INTO `roles_parents` (`role_id`, `parent_id`) VALUES
(20, 1),
(3, 20);

--
-- Dumping data for table `questions`
--

INSERT INTO `question` (`id`, `question`) VALUES
(1, 'What was your childhood phone number?'),
(2, 'In what city did your mother born?'),
(3, 'In what city did your father born?'),
(4, 'In what city or town was your first job?');

--
-- Dumping data for table `questions`
--

INSERT INTO `state` (`id`, `state`) VALUES
(1, 'Disabled'),
(2, 'Enabled');
