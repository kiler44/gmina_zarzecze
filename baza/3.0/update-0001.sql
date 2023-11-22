-- Column: nazwa_przyjazna

-- ALTER TABLE cms_kategorie DROP COLUMN nazwa_przyjazna;

ALTER TABLE cms_kategorie ADD COLUMN nazwa_przyjazna text;
ALTER TABLE cms_kategorie ALTER COLUMN nazwa_przyjazna SET DEFAULT NULL::character varying;
