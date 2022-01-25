create table user (
    --フレームワークを使う場合idをprimary key,
    --id int not null auto_increment primary key,
    --varbinary(256)PSで使う理由はハッシュ化で保存するため、
    --Idで使う理由はvarcharだと大文字小文字の区別が付かないため。
    login_id varbinary(256) not null, 
    password varbinary(256) not null,
	handle varchar(64) not null,
    primary key(login_id)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*
https://zenn.dev/gallu/articles/cfefde361b6986

CREATE TABLE `ログインアカウント` (
  `login_id` varbinary(256) NOT NULL COMMENT 'ログインID',
  `password` varbinary(256) NOT NULL COMMENT 'パスワード(password_hash()使用)',
  PRIMARY KEY (`login_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='１レコードが「(１ユーザの)ログイン情報」なテーブル'
*/

-- データベース設定(投稿用)

create table messages (
	message_id SERIAL, --シリアル調べる
	message TEXT,
	login_id varbinary(256) not null, 
	created_at DATETIME,
	--
	FOREIGN KEY fk_messages_login_id(login_id) REFERENCES user(login_id));
	-- 外部キー制約を調べる
	primary key(login_id)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;