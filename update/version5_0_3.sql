
ALTER TABLE settings
     ADD theme VARCHAR(192) DEFAULT NULL AFTER website_theme;

UPDATE settings
SET theme = 'purposeTheme'
WHERE id = 1;

     