INSERT INTO `epstore`.`Role` (`role_id`, `role_name`) VALUES ('1', 'Administrator');
INSERT INTO `epstore`.`Role` (`role_id`, `role_name`) VALUES ('2', 'Prodajalec');
INSERT INTO `epstore`.`Role` (`role_id`, `role_name`) VALUES ('3', 'Stranka');

INSERT INTO `epstore`.`Payment_option` (`payment_option_id`, `payment_option_name`) VALUES ('1', 'Gotovina ob prevzemu');
INSERT INTO `epstore`.`Payment_option` (`payment_option_id`, `payment_option_name`) VALUES ('2', 'Plačilo po predračunu');

INSERT INTO `epstore`.`Order_status` (`status_id`, `status_name`) VALUES ('1', 'Oddano');
INSERT INTO `epstore`.`Order_status` (`status_id`, `status_name`) VALUES ('2', 'Potrjeno');
INSERT INTO `epstore`.`Order_status` (`status_id`, `status_name`) VALUES ('3', 'Preklicano');
INSERT INTO `epstore`.`Order_status` (`status_id`, `status_name`) VALUES ('4', 'Stornirano');

INSERT INTO `epstore`.`User` (`user_id`, `email`, `name`, `surname`, `password_digest`, `role_id`, `user_active`, `user_activation_token`, `user_activation_token_created_at`, `user_created_at`) VALUES ('1', 'admin@epstore.tk', 'Administrator', 'Privzet', '$2y$10$qzimTegsZMWfVD4gNF7UfewGTgS2WvSEJt3O37pw7JPWE/06g4y/e', '1', '1', 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', '2016-01-01 00:00', '2016-01-01 00:00');


INSERT INTO epstore.Product(product_name, product_description, product_price) VALUE ("Sandberg kabel DP-MiniDP 1.2 4K M-M 2m", "Kabel Sandberg DisplayPort v Mini DisplayPort 1.2 4K 2 m za neposredno povezavo računalnika z zaslonom, odlična rešitev če imate televizor ali zaslon, ki potrebuje na eni strani Mini DisplayPort in DisplayPort na drugi. Ponuja hitrost prenosa podatkov, do 4K vsebine.", 12.9)