-- 2025-07-31_add_otp_and_verification_to_dg_user.sql

ALTER TABLE `dg_user`
  ADD COLUMN `otp_code` VARCHAR(6) DEFAULT NULL AFTER `password_dg`,
  ADD COLUMN `otp_expired` DATETIME DEFAULT NULL AFTER `otp_code`,
  ADD COLUMN `is_verified` TINYINT(1) DEFAULT 0 AFTER `otp_expired`;