INSERT INTO `epstore`.`Role` (`role_id`, `role_name`) VALUES ('1', 'Administrator');
INSERT INTO `epstore`.`Role` (`role_id`, `role_name`) VALUES ('2', 'Prodajalec');
INSERT INTO `epstore`.`Role` (`role_id`, `role_name`) VALUES ('3', 'Stranka');

INSERT INTO `epstore`.`Payment_option` (`payment_option_id`, `payment_option_name`) VALUES ('1', 'Gotovina ob prevzemu');
INSERT INTO `epstore`.`Payment_option` (`payment_option_id`, `payment_option_name`) VALUES ('2', 'Plačilo po predračunu');

INSERT INTO `epstore`.`Order_status` (`status_id`, `status_name`) VALUES ('1', 'Oddano');
INSERT INTO `epstore`.`Order_status` (`status_id`, `status_name`) VALUES ('2', 'Potrjeno');
INSERT INTO `epstore`.`Order_status` (`status_id`, `status_name`) VALUES ('3', 'Stornirano');

INSERT INTO `epstore`.`User` (`user_id`, `email`, `name`, `surname`, `password_digest`, `role_id`, `user_active`, `user_activation_token`, `user_activation_token_created_at`, `user_created_at`) VALUES ('1', 'admin@epstore.tk', 'Administrator', 'EP', '$2y$10$CGN3fErsAyNVeLdV8qCGF.I.Xh.WClVWbHhQio7RqHfnuPNRT1Crm', '1', '1', 'khxIPdVzCQIbb8KqLUyNJ6G4j-trvPA90_lx3DYfrJQLRebHBiqVfuLV2pB0itDB', '1000-01-01 00:00:00', '2016-01-01 00:00');
INSERT INTO `epstore`.`User` (`user_id`, `email`, `name`, `surname`, `password_digest`, `role_id`, `user_active`, `user_activation_token`, `user_activation_token_created_at`, `user_created_at`) VALUES ('2', 'prodajalec@epstore.tk', 'Prodajalec', 'Ena', '$2y$10$do/jHwmUjlY87EikzsSV8uwKi1xHHoAdPC7XXiBB3ZyDgXVAmr89O', '2', '1', 'khxIPdVzCQIbb8KqLUyNJ6G4j-trvPA90_lx3DYfrJQLRebHBiqVfuLV2pB0itDB', '1000-01-01 00:00:00', '2016-01-01 00:00');
INSERT INTO `epstore`.`User` (`user_id`, `email`, `name`, `surname`, `password_digest`, `role_id`, `user_active`, `user_activation_token`, `user_activation_token_created_at`, `user_created_at`, `phone`, `user_address`, `user_post`, `user_city`, `user_country`) VALUES ('3', 'stranka@ep.si', 'Stranka', 'Ena', '$2y$10$iXADxNZSSTiyo5S3UfZ4L.qjsd/V57jRFqWnMPOzM7RT1FkCVRRTm', '3', '1', 'khxIPdVzCQIbb8KqLUyNJ6G4j-trvPA90_lx3DYfrJQLRebHBiqVfuLV2pB0itDB', '1000-01-01 00:00:00', '2016-01-01 00:00', '070707070', 'Slovenska cesta 10', '1000', 'Ljubljana', 'Slovenija');

INSERT INTO epstore.Product(product_name, product_description, product_price) VALUE ("Sandberg DP-MiniDP 2m", "Kabel Sandberg DisplayPort v Mini DisplayPort 1.2 4K 2 m za neposredno povezavo računalnika z zaslonom, odlična rešitev če imate televizor ali zaslon, ki potrebuje na eni strani Mini DisplayPort in DisplayPort na drugi. Ponuja hitrost prenosa podatkov, do 4K vsebine.", 12.9);
INSERT INTO epstore.Product(product_name, product_description, product_price) VALUE ("LG 27UD68-P", "Monitor LG LED 27UD68-P se ponaša s 27-palčno diagonalo in Ultra HD ločljivostjo (3840×2160).", 520.0);
INSERT INTO epstore.Product(product_name, product_description, product_price) VALUE ("Armor All Tech & Screen", "Armor All robčki Tech & Screen Wipes za čiščenje ekranov", 3.42);
INSERT INTO epstore.Product(product_name, product_description, product_price) VALUE ("Philips HX6932/36", "Philips Sonicare HX6932/36 dvojno pakiranje električnih zobnih ščetk vključuje 2 glavi ščetke in 2 ročaja ter UV-čistilnik za glave ščetk. Izbirate lahko med 3 načini delovanja, opremljena pa je z intervalnim časovnikom, ter 2-minutnim časovnikom za optimalno ščetkanje. Patentirana sonična tehnologija poskrbi za edinstveno dinamično čiščenje, glava z dolgimi ter gostimi ščetinami pa poskrbi za temeljito odstranjevanje zobnih oblog globoko med zobmi. ", 134.9);
INSERT INTO `epstore`.`Image` (image_name, product_id) VALUES ('1483526307.png',1),('1483526500.jpeg',2),('1483526516.jpeg',2),('1483526525.jpeg',2),('1483526532.jpeg',2),('1483526586.jpeg',3),('1483526659.jpeg',4),('1483526669.jpeg',4);
