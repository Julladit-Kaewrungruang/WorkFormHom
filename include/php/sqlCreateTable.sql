CREATE TABLE sales_account(
	id bigint IDENTITY(1,1) NOT NULL,
	sales bigint NULL DEFAULT 1,
	check_location_id bigint NULL DEFAULT 0,
	check_date bigint NULL DEFAULT 0,
	check_dateTime bigint NULL DEFAULT 0,
	check_lat nvarchar(30) NULL,
	check_long nvarchar(30) NULL,
	check_user_id bigint NULL DEFAULT 0,
	check_import bigint NULL DEFAULT 0,
	check_update bigint NULL DEFAULT 0,
	check_status bigint NULL DEFAULT 1,
	check_token nvarchar(100) NULL DEFAULT 1,
    PRIMARY KEY CLUSTERED (
        id ASC
    )
)
