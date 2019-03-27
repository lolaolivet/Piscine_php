SELECT REVERSE(SUBSTRING(phone_number, 2, 9)) AS 'rebmunenohp'
FROM distrib WHERE LEFT(phone_number, 2) = '05';